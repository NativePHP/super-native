<?php

namespace App\NativeComponents;

use App\Ai\Agents\PhpSnippetWriter;
use Illuminate\View\View;
use Laravel\Ai\Responses\AgentResponse;
use Laravel\Ai\Responses\StructuredAgentResponse;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\Elements\Text;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\NativeElementCollector;
use Native\Mobile\Edge\NativeTagPrecompiler;
use ParseError;
use RuntimeException;
use Throwable;

/**
 * The app writing — and running — its own source at runtime.
 *
 * Claude is asked for two files and both are written to disk:
 *
 *  - `resources/scripts/greeting.php` — plain PHP. Whatever variables it
 *    defines are handed to the view below; `$var` is the conventional one.
 *  - `resources/views/native/live-code-preview.blade.php` — the generated
 *    *view*, written in mobile-ui's native component syntax.
 *
 * [preview] runs the script, renders the view against the variables it
 * defined, and returns the resulting Element. The screen's own Blade attaches
 * that Element inline, so the generated markup becomes real native views —
 * `<column>`, `<badge>`, `<progress-bar>` — not a string in a `<text>`.
 *
 * Everything between the model and the render is the interesting part. The
 * agent's instructions bound what it may write; [compileScript] and
 * [compileView] then assume the model ignored them and re-check
 * independently, and [preview] captures the render into a detached subtree so
 * a broken generation shows up as a red line rather than taking down the
 * screen. These are demo-grade guards on our own model's output, not a
 * sandbox — generated code runs in-process like any other code here.
 *
 * This works on device because NativePHP unpacks the Laravel app into a
 * writable directory (`Documents/app` on iOS), so `base_path()` is not the
 * read-only bundle.
 */
class LiveCodeDemo extends NativeComponent
{
    /** Restored by [resetScript]; also what ships in the repo. */
    private const ORIGINAL_SCRIPT = <<<'PHP'
        <?php

        // Run by App\NativeComponents\LiveCodeDemo on every render. Every variable
        // defined here is handed to native/live-code-preview.blade.php.
        $var = 'Hello World';

        PHP;

    /** @see self::ORIGINAL_SCRIPT */
    private const ORIGINAL_VIEW = <<<'BLADE'
        <column class="w-full items-center gap-2">
            <text class="text-2xl font-extrabold text-center text-theme-on-surface">{{ $var }}</text>
        </column>

        BLADE;

    /** The offline preset, for demoing the loop without an API key. */
    private const JELLO_SCRIPT = "<?php\n\n\$var = 'Jello World!';\n";

    /**
     * The script exists to give the view data, so it has to assign something.
     * Deliberately not `$var` specifically: that was the whole output back
     * when the screen was one line of text, but the view now reads whatever
     * the script defines, and holding the model to one magic name rejects
     * perfectly good answers that named their variables after the subject.
     */
    private const ASSIGNS_A_VARIABLE = '/\$[a-zA-Z_]\w*\s*=(?!=)/';

    /** Mirrors the `#[MaxTokens]` on the agent; used to explain truncation. */
    private const MAX_OUTPUT_TOKENS = 6000;

    /**
     * Calls neither file may make. Not a security boundary — generated code
     * runs in-process with everything else — but it keeps a hallucinated
     * `unlink()` or a blocking `sleep()` from wrecking the demo.
     *
     * @var array<int, string>
     */
    private const FORBIDDEN_CALLS = [
        'exec', 'shell_exec', 'system', 'passthru', 'proc_open', 'popen',
        'file', 'file_get_contents', 'file_put_contents', 'fopen', 'unlink',
        'mkdir', 'rmdir', 'curl_init', 'sleep', 'usleep', 'header', 'dd', 'dump',
    ];

    /**
     * Constructs the script may not use. `while`/`do`/`goto` are here because
     * code that never returns hangs the render loop for good; `foreach` and
     * `for` are left alone so "count to ten" still works.
     *
     * @var array<int, int>
     */
    private const FORBIDDEN_TOKENS = [
        T_EXIT, T_EVAL, T_INCLUDE, T_INCLUDE_ONCE, T_REQUIRE, T_REQUIRE_ONCE,
        T_FUNCTION, T_CLASS, T_WHILE, T_DO, T_GOTO,
    ];

    /**
     * Blade escape hatches the generated view may not use. Each one compiles
     * to arbitrary PHP that would sidestep the script's token checks
     * entirely, so the view is held to plain tags plus `{{ }}` echoes.
     *
     * @var array<string, string>
     */
    private const FORBIDDEN_DIRECTIVES = [
        '<?php' => 'a raw PHP tag',
        '@php' => '@php',
        '@include' => '@include',
        '@each' => '@each',
        '{!!' => 'an unescaped {!! !!} echo',
    ];

    /** Text currently in the prompt box, mirrored from the native input. */
    public string $promptText = '';

    /** The model's one-line description of what it last wrote. */
    public ?string $summary = null;

    /** Set when generation, validation, or the write fails. */
    public ?string $error = null;

    /** md5 of the preview source this instance last handed to Blade. */
    private ?string $compiledSignature = null;

    public function navTitle(): string
    {
        return 'Live Code';
    }

    public function scriptPath(): string
    {
        return base_path('resources/scripts/greeting.php');
    }

    public function previewPath(): string
    {
        return resource_path('views/native/live-code-preview.blade.php');
    }

    /** The generated PHP, for the first code card. */
    public function scriptSource(): string
    {
        return trim((string) @file_get_contents($this->scriptPath()));
    }

    /** The generated markup, for the second code card. */
    public function viewSource(): string
    {
        return trim((string) @file_get_contents($this->previewPath()));
    }

    /**
     * Run the script, render the generated view against whatever it defined,
     * and hand back the Element for the screen's Blade to attach.
     *
     * Both halves are guarded. A script that throws never reaches the view; a
     * view that throws — undefined variable, unknown tag, no root element —
     * is reported in place. Either way the surrounding screen survives, which
     * matters when the code on disk was written by a model thirty seconds ago.
     */
    public function preview(): Element
    {
        try {
            $variables = $this->runScript();
        } catch (Throwable $e) {
            return $this->notice('Script failed — '.$e->getMessage());
        }

        // The precompiler is normally already on — preview() is called from
        // inside the screen's own native render — but turning it on here too
        // means the generated tags compile to elements no matter who calls.
        $wasActive = NativeTagPrecompiler::setActive(true);

        try {
            $view = view('native.live-code-preview', $variables);
            $this->recompileIfStale($view->getPath());

            // capture() swaps the collector's working state out and back, so
            // the generated view builds a detached subtree instead of
            // emitting into — or resetting — the screen's live tree.
            return NativeElementCollector::capture(fn () => $view->render());
        } catch (Throwable $e) {
            return $this->notice('View failed — '.$e->getMessage());
        } finally {
            NativeTagPrecompiler::setActive($wasActive);
        }
    }

    /**
     * Compile the generated view whenever its contents differ from the last
     * compile this instance made.
     *
     * Neither of Blade's own staleness mechanisms works for a template the
     * user rewrites mid-session. `CompilerEngine` memoizes "this path is
     * compiled and current" for the life of the process, so it stops checking
     * after the first render. And the check it memoizes is an mtime
     * comparison, which has one-second resolution — regenerate twice inside
     * the same second, or land a write in the second before the compile, and
     * Blade concludes the cached copy is current. Either way the screen keeps
     * rendering the previous generation, which reads as "the model ignored
     * me" rather than as a caching bug.
     *
     * Hashing the source instead is exact and costs one read of a file we
     * already have in the page cache. `compiledFileIsNative` additionally
     * catches a copy compiled as plain HTML by a web render or `view:cache`,
     * which would collect zero elements.
     */
    private function recompileIfStale(string $bladePath): void
    {
        $compiler = app('blade.compiler');
        $compiledPath = $compiler->getCompiledPath($bladePath);

        clearstatcache(true, $bladePath);
        $signature = md5((string) @file_get_contents($bladePath));

        if ($signature === $this->compiledSignature
            && is_file($compiledPath)
            && NativeTagPrecompiler::compiledFileIsNative($compiledPath)) {
            return;
        }

        $compiler->compile($bladePath);
        $this->compiledSignature = $signature;
    }

    /** `@change` handler for the prompt box. */
    public function updatePrompt(string $value): void
    {
        $this->promptText = $value;
    }

    /**
     * Ask Claude for a script and a view, vet both, then write both. The
     * runloop renders again straight after this returns, so the generated
     * code runs without this component holding any of its output.
     */
    public function generate(): void
    {
        $this->error = null;
        $request = trim($this->promptText);

        if ($request === '') {
            $this->error = 'Type what the script should do first.';

            return;
        }

        try {
            $fields = $this->fieldsFrom((new PhpSnippetWriter)->prompt($request));
            $script = $this->compileScript($fields['code']);
            $markup = $this->compileView($fields['view']);
        } catch (ParseError $e) {
            $this->error = 'Claude wrote code that does not parse — '.$e->getMessage();

            return;
        } catch (RuntimeException $e) {
            $this->error = $e->getMessage();

            return;
        } catch (Throwable $e) {
            $this->error = 'Could not reach Claude — '.$e->getMessage();

            return;
        }

        $this->summary = $fields['summary'];
        $this->write($script, $markup);
    }

    /**
     * Pull the three fields out of the agent's structured reply, or explain
     * why they are not there.
     *
     * Structured output is all-or-nothing: if the model runs out of output
     * tokens mid-JSON, nothing parses and `toArray()` comes back empty rather
     * than partially filled. Reading the keys directly turns that into
     * "Undefined array key" — a PHP warning promoted to an exception, caught
     * by the generic handler, and shown to the user as "Could not reach
     * Claude", which is both wrong and unactionable. Usage tells us which of
     * the two it actually was.
     *
     * @return array{code: string, view: string, summary: string}
     *
     * @throws RuntimeException when the reply is missing or empty
     */
    private function fieldsFrom(mixed $response): array
    {
        $fields = $response instanceof StructuredAgentResponse ? $response->toArray() : [];

        foreach (['code', 'view', 'summary'] as $key) {
            if (! is_string($fields[$key] ?? null) || trim($fields[$key]) === '') {
                throw new RuntimeException($this->incompleteReply($response));
            }
        }

        return $fields;
    }

    private function incompleteReply(mixed $response): string
    {
        $spent = $response instanceof AgentResponse ? $response->usage->completionTokens : 0;

        return $spent >= self::MAX_OUTPUT_TOKENS
            ? 'Claude hit its '.number_format(self::MAX_OUTPUT_TOKENS).'-token budget before finishing, so the reply arrived truncated. Ask for something smaller.'
            : 'Claude replied without a script and a view. Try rephrasing the prompt.';
    }

    /** Put the repo's own pair back, for when a generated one gets silly. */
    public function resetScript(): void
    {
        $this->summary = null;
        $this->promptText = '';
        $this->write(self::ORIGINAL_SCRIPT, self::ORIGINAL_VIEW);
    }

    /** The original hardcoded edit, kept as an API-key-free path through the demo. */
    public function jello(): void
    {
        $this->summary = 'Hardcoded preset — no model involved.';
        $this->write(self::JELLO_SCRIPT, self::ORIGINAL_VIEW);
    }

    /**
     * Execute the script in a scope of its own and return every variable it
     * defined. The closure binds only `$path`, which is unset before the
     * capture, so nothing of this component's leaks into the generated view.
     *
     * @return array<string, mixed>
     */
    private function runScript(): array
    {
        $path = $this->scriptPath();

        if (! is_file($path)) {
            throw new RuntimeException('the script is missing.');
        }

        // The runloop re-renders inside the same PHP process that just
        // rewrote the file, so a warm opcache would happily replay the old
        // opcodes and the screen would never change.
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($path, true);
        }
        clearstatcache(true, $path);

        return (static function () use ($path): array {
            include $path;
            unset($path);

            return get_defined_vars();
        })();
    }

    /**
     * Turn the model's PHP fragment into a file worth executing, or throw.
     *
     * @throws RuntimeException when the snippet breaks the demo's rules
     * @throws ParseError when the snippet is not valid PHP
     */
    private function compileScript(string $code): string
    {
        $code = $this->unfence($code);
        $code = preg_replace('/\A<\?php\b|\?>\z/', '', trim($code));

        $file = "<?php\n\n".trim((string) $code)."\n";

        if (! preg_match(self::ASSIGNS_A_VARIABLE, $file)) {
            throw new RuntimeException('The generated code never assigns a variable for the view to render.');
        }

        // TOKEN_PARSE makes this a full parse, so a syntax error surfaces
        // here — before the file is written — rather than as a fatal inside
        // the render loop with a half-written script already on disk.
        foreach (token_get_all($file, TOKEN_PARSE) as $token) {
            if (! is_array($token)) {
                continue;
            }

            [$id, $text] = $token;

            if (in_array($id, self::FORBIDDEN_TOKENS, true)) {
                throw new RuntimeException("The generated code uses `{$text}`, which this demo does not allow.");
            }

            if ($id === T_STRING && in_array(strtolower($text), self::FORBIDDEN_CALLS, true)) {
                throw new RuntimeException("The generated code calls `{$text}()`, which this demo does not allow.");
            }
        }

        return $file;
    }

    /**
     * Vet the model's native markup. It cannot be parsed the way the script
     * can — Blade compiles to PHP only once, at render time — so this is a
     * textual check: no escape hatch into raw PHP, no banned call inside a
     * `{{ }}` echo, and at least one tag to render.
     *
     * @throws RuntimeException when the markup breaks the demo's rules
     */
    private function compileView(string $markup): string
    {
        $markup = trim($this->unfence($markup));

        if (! preg_match('/<[a-z][a-z0-9-]*[\s\/>]/i', $markup)) {
            throw new RuntimeException('The generated view contains no native components.');
        }

        foreach (self::FORBIDDEN_DIRECTIVES as $needle => $label) {
            if (str_contains($markup, $needle)) {
                throw new RuntimeException("The generated view uses {$label}, which this demo does not allow.");
            }
        }

        foreach (self::FORBIDDEN_CALLS as $call) {
            if (preg_match('/\b'.preg_quote($call, '/').'\s*\(/i', $markup)) {
                throw new RuntimeException("The generated view calls `{$call}()`, which this demo does not allow.");
            }
        }

        return $markup."\n";
    }

    /** Strip the markdown fence the model still wraps things in occasionally. */
    private function unfence(string $text): string
    {
        return (string) preg_replace('/\A```[a-z]*\R?|\R?```\z/i', '', trim($text));
    }

    private function notice(string $message): Element
    {
        return Text::make($message)->color('#EF4444');
    }

    private function write(string $script, string $markup): void
    {
        $wrote = @file_put_contents($this->scriptPath(), $script) !== false
            && @file_put_contents($this->previewPath(), $markup) !== false;

        $this->error = $wrote
            ? null
            : 'Could not write the generated files — this filesystem is read-only.';
    }

    public function render(): View
    {
        return view('native.live-code-demo');
    }
}
