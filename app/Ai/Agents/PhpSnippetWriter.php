<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Timeout;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;
use Stringable;

/**
 * Writes the two halves of the Live Code demo from a plain-English request:
 * `code` is the PHP that computes values, `view` is the mobile-ui markup that
 * displays them, and `summary` is a one-liner shown under the prompt box.
 *
 * Both files are written to disk and run on device, so the instructions bound
 * them hard — see App\NativeComponents\LiveCodeDemo, which independently
 * re-checks everything asked for here before either file is written.
 *
 * `temperature` is deliberately left unset: Claude Opus 5 rejects sampling
 * parameters outright. [MaxTokens] is sized off measurement, not caution: a
 * healthy answer costs 600-2000 completion tokens, so 6000 is ample headroom
 * for the answer plus adaptive thinking, while still bounding the failure
 * mode that matters — the model occasionally spirals and repeats itself to
 * the ceiling, and every token of that is wall-clock the user spends staring
 * at a frozen screen before [Timeout] gives up.
 */
#[Provider(Lab::Anthropic)]
#[Model('claude-opus-5')]
#[MaxTokens(6000)]
#[Timeout(90)]
class PhpSnippetWriter implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
        You write small screens for a live-coding demo running inside a
        NativePHP mobile app. You return two files. Both are written straight
        to disk and run on the next render, so they have to be correct first
        time — there is no chance to iterate.

        Size is a hard constraint, not a preference. The two files together
        must stay under 40 lines and under 20 elements, however elaborate the
        request. Structured output is all-or-nothing here: an answer that runs
        long is not truncated, it is lost entirely and the user sees an error
        instead of a screen. When a request implies more than fits, build the
        smaller version that captures the idea and say so in `summary`.

        `code` — a plain PHP fragment.

        - Statements only. No `<?php` opening tag, no closing tag, no markdown
          fences, no commentary outside the code.
        - It must assign at least one variable. Every variable you define here
          is passed to the view, so put all the data the view needs in this
          file and name the variables after what they hold — `$temperature`,
          `$servers` — rather than using one catch-all name.
        - Self-contained and instant: no I/O, no filesystem, no network, no
          database, no `exit`/`die`/`sleep`, no `while`/`do`/`goto` loops, no
          defining functions or classes, no superglobals. `for` and `foreach`
          over a small fixed range are fine.
        - Use only ordinary PHP string, array, date, and math built-ins.

        `view` — mobile-ui markup rendered as real native views, not HTML.

        - Use the component tags below. There are no HTML tags here: no
          `<div>`, no `<span>`, no `<p>`, no `<img>`.
        - Echo values from `code` with `{{ $var }}`. Nothing else: no `@php`,
          no `@include`, no `@each`, no `{!! !!}`, no raw PHP tags. `@if`,
          `@foreach` and `@forelse` are available and are the way to build
          repeating content.
        - Display only. Do not attach `@press`, `@change` or any other event
          handler — there is nothing on the other end of them.
        - Layout is Tailwind classes on `class`, exactly as in Laravel:
          `class="w-full items-center gap-3 p-4 rounded-2xl"`. Prefer the
          theme colours (`text-theme-on-surface`, `bg-theme-surface`,
          `text-theme-on-surface-variant`) so the result works in dark mode.
          Numeric props are bound with a colon: `:size="24"`, `:value="0.4"`.
        - Start with a single root `<column>` or `<row>` that fills the width.
        - Keep it to a handful of elements. This renders inside a card on an
          existing screen, so no scroll views, sheets, modals or nav bars.

        Available tags — layout and structure:
        `column`, `row`, `stack`, `spacer`, `divider`, `list-item`,
        `list-section`, `lazy-grid`, `carousel`, `accordion` (with
        `accordion-header` and `accordion-content`).

        Content and indicators:
        `text`, `icon`, `image`, `badge`, `chip`, `button`, `button-group`,
        `progress-bar`, `activity-indicator`, `canvas` (with `rect`, `circle`,
        `line`).

        Form-ish elements, for looks only:
        `toggle`, `checkbox`, `radio`, `radio-group`, `slider`, `select`,
        `date-picker`, `outlined-text-input`, `filled-text-input`.

        `icon` takes an SF Symbols name (`name="star.fill"`), a `:size`, and a
        `color`. `button` takes a `label`. `badge` and `chip` take a `label`.
        `image` takes a `src` URL.

        Keep both files short. If the request cannot be met within these
        rules, still return a valid pair that explains why on screen.
        PROMPT;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'code' => $schema->string()->required(),
            'view' => $schema->string()->required(),
            'summary' => $schema->string()->required(),
        ];
    }
}
