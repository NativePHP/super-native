<?php

use App\Ai\Agents\PhpSnippetWriter;
use App\NativeComponents\LiveCodeDemo;
use Laravel\Ai\Prompts\AgentPrompt;
use Native\Mobile\Testing\Native;

// The demo edits two real files in the repo, so every test puts them back.
beforeEach(function () {
    $this->scriptPath = base_path('resources/scripts/greeting.php');
    $this->previewPath = resource_path('views/native/live-code-preview.blade.php');
    $this->originalScript = file_get_contents($this->scriptPath);
    $this->originalView = file_get_contents($this->previewPath);
});

afterEach(function () {
    file_put_contents($this->scriptPath, $this->originalScript);
    file_put_contents($this->previewPath, $this->originalView);
});

/** Shape of one faked structured response from the agent. */
function generated(string $code, string $view, string $summary = 'Wrote a screen.'): array
{
    return ['code' => $code, 'view' => $view, 'summary' => $summary];
}

it('runs the script and renders the generated view', function () {
    Native::test(LiveCodeDemo::class)
        ->assertSee('Hello World')
        ->assertSee('resources/scripts/greeting.php')
        ->assertSee('Ask Claude for a screen')
        ->assertSet('error', null);
});

it('compiles the generated markup into real native elements', function () {
    PhpSnippetWriter::fake([
        generated(
            "\$var = 'Shipping';\n\$percent = 0.4;",
            '<column class="w-full gap-2">'
                .'<badge label="{{ $var }}" />'
                .'<progress-bar :value="$percent" class="w-full" />'
                .'</column>',
            'Progress with a badge.',
        ),
    ]);

    $screen = Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'a progress bar with a badge')
        ->call('generate')
        ->assertSet('error', null)
        ->assertSet('summary', 'Progress with a badge.');

    // The payoff: the model's markup is in the wire tree as native nodes
    // carrying real props, not as a string inside a <text>.
    $screen->assertElement('badge', fn ($node) => ($node['props']['label'] ?? null) === 'Shipping')
        ->assertElement('progress_bar', fn ($node) => ($node['props']['value'] ?? null) === 0.4);

    PhpSnippetWriter::assertPrompted(fn (AgentPrompt $prompt) => $prompt->contains('progress bar'));
});

it('hands every variable the script defined to the view', function () {
    PhpSnippetWriter::fake([
        generated(
            "\$var = 'Crew';\n\$names = ['Ada', 'Grace', 'Katherine'];",
            '<column class="w-full gap-1">@foreach ($names as $name)<chip label="{{ $name }}" />@endforeach</column>',
        ),
    ]);

    Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'list the crew')
        ->call('generate')
        ->assertSee('Ada')
        ->assertSee('Grace')
        ->assertSee('Katherine')
        ->assertSet('error', null);
});

it('strips markdown fences from both files', function () {
    PhpSnippetWriter::fake([
        generated(
            "```php\n<?php\n\$var = 'Fenced';\n```",
            "```blade\n<column><text>{{ \$var }}</text></column>\n```",
        ),
    ]);

    Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'anything')
        ->call('generate')
        ->assertSee('Fenced')
        ->assertSet('error', null);

    expect(substr_count(file_get_contents($this->scriptPath), '<?php'))->toBe(1);
    expect(file_get_contents($this->previewPath))->not->toContain('`');
});

it('refuses a script that leaves the view with no data', function () {
    // Valid PHP, but it defines nothing for the view to render.
    PhpSnippetWriter::fake([generated("strtoupper('nope');", '<column><text>x</text></column>')]);

    Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'anything')
        ->call('generate')
        ->assertSet('error', 'The generated code never assigns a variable for the view to render.')
        ->assertSee('Hello World');

    expect(file_get_contents($this->scriptPath))->toBe($this->originalScript);
});

it('accepts a script that names its variables after the subject', function () {
    // The demo used to insist on `$var`; any assignment is enough now.
    PhpSnippetWriter::fake([
        generated("\$city = 'Lisbon';\n\$temperature = 24;",
            '<column class="w-full gap-1"><text>{{ $city }}</text><badge label="{{ $temperature }}°" /></column>'),
    ]);

    Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'weather for Lisbon')
        ->call('generate')
        ->assertSet('error', null)
        ->assertSee('Lisbon')
        ->assertElement('badge', fn ($node) => ($node['props']['label'] ?? null) === '24°');
});

it('refuses a script that does not parse', function () {
    PhpSnippetWriter::fake([generated("\$var = 'unterminated", '<column><text>x</text></column>')]);

    $screen = Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'anything')
        ->call('generate')
        ->assertSee('Hello World');

    expect($screen->get('error'))->toStartWith('Claude wrote code that does not parse');
    expect(file_get_contents($this->scriptPath))->toBe($this->originalScript);
});

it('refuses a script that reaches outside the snippet', function (string $code, string $needle) {
    PhpSnippetWriter::fake([generated($code, '<column><text>x</text></column>')]);

    $screen = Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'anything')
        ->call('generate')
        ->assertSee('Hello World');

    expect($screen->get('error'))->toContain($needle);
    expect(file_get_contents($this->scriptPath))->toBe($this->originalScript);
})->with([
    'filesystem' => ["\$var = file_get_contents('/etc/passwd');", 'file_get_contents'],
    'unbounded loop' => ["while (true) {}\n\$var = 'never';", 'while'],
    'process' => ["\$var = shell_exec('ls');", 'shell_exec'],
    'declaration' => ["function boom() {}\n\$var = 'x';", 'function'],
]);

it('refuses a view that escapes into raw PHP', function (string $view, string $needle) {
    PhpSnippetWriter::fake([generated("\$var = 'x';", $view)]);

    $screen = Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'anything')
        ->call('generate')
        ->assertSee('Hello World');

    expect($screen->get('error'))->toContain($needle);
    // Neither file is written when either half fails validation.
    expect(file_get_contents($this->scriptPath))->toBe($this->originalScript);
    expect(file_get_contents($this->previewPath))->toBe($this->originalView);
})->with([
    'php block' => ['<column>@php(unlink("x"))@endphp<text>hi</text></column>', '@php'],
    'raw tag' => ['<column><text><?php echo 1; ?></text></column>', 'raw PHP tag'],
    'unescaped echo' => ['<column><text>{!! $var !!}</text></column>', 'unescaped'],
    'banned call' => ['<column><text>{{ file_get_contents("/etc/passwd") }}</text></column>', 'file_get_contents'],
    'no components' => ['Just a sentence, no tags at all.', 'no native components'],
]);

it('explains an incomplete reply instead of crashing on a missing key', function () {
    // What a truncated structured response actually looks like: the JSON
    // never closed, so nothing parsed and the fields are simply absent.
    PhpSnippetWriter::fake([['summary' => 'Ran out of room.']]);

    $screen = Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'a dashboard with fifty widgets')
        ->call('generate')
        ->assertSee('Hello World');

    expect($screen->get('error'))
        ->toContain('without a script and a view')
        ->not->toContain('Undefined array key');
});

it('surfaces a provider failure instead of throwing', function () {
    PhpSnippetWriter::fake(function () {
        throw new RuntimeException('connect timeout');
    });

    $screen = Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'anything')
        ->call('generate')
        ->assertSee('Hello World');

    expect($screen->get('error'))->toContain('connect timeout');
});

it('asks for a prompt before calling the model', function () {
    PhpSnippetWriter::fake()->preventStrayPrompts();

    Native::test(LiveCodeDemo::class)
        ->call('generate')
        ->assertSet('error', 'Type what the script should do first.');

    PhpSnippetWriter::assertNeverPrompted();
});

it('reports a script that fails at runtime without taking the screen down', function () {
    // Passes compileScript() — it parses and assigns $var — but blows up when run.
    PhpSnippetWriter::fake([generated("\$var = 'x';\n\$var = 1 % 0;", '<column><text>{{ $var }}</text></column>')]);

    Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'anything')
        ->call('generate')
        ->assertSee('Script failed')
        ->assertSee('Generate & run');
});

it('reports a view that fails to render without taking the screen down', function () {
    // Passes compileView() — native tags, no escape hatches — but throws the
    // moment Blade evaluates the echo, because $var is a string.
    PhpSnippetWriter::fake([generated("\$var = 'x';", '<column><text>{{ $var->nope() }}</text></column>')]);

    Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'anything')
        ->call('generate')
        ->assertSee('View failed')
        ->assertSee('Generate & run');
});

it('restores the original pair', function () {
    PhpSnippetWriter::fake([generated("\$var = 'Temporary';", '<column><badge label="{{ $var }}" /></column>')]);

    Native::test(LiveCodeDemo::class)
        ->call('updatePrompt', 'anything')
        ->call('generate')
        ->assertElement('badge')
        ->call('resetScript')
        ->assertSee('Hello World')
        ->assertMissingElement('badge')
        ->assertSet('summary', null)
        ->assertSet('promptText', '');
});

it('keeps a model-free path through the demo', function () {
    PhpSnippetWriter::fake()->preventStrayPrompts();

    Native::test(LiveCodeDemo::class)
        ->call('jello')
        ->assertSee('Jello World!')
        ->assertSet('error', null);

    expect(file_get_contents($this->scriptPath))->toContain("\$var = 'Jello World!';");
    PhpSnippetWriter::assertNeverPrompted();
});
