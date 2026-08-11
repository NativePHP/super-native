<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class SelectionDemo extends NativeComponent
{
    /** Pre-filled so Android's caret-at-end-on-mount behavior is visible. */
    public string $message = 'Hello from NativePHP — try selecting this, or type @ja to mention someone.';

    public int $caretStart = 0;

    public int $caretEnd = 0;

    public string $selectedText = '';

    /** Selection events received for the main input — shows the debounce cadence. */
    public int $eventCount = 0;

    /** Would stay 0 forever: @selectionChange is never emitted for secure inputs. */
    public int $secureEventCount = 0;

    public string $secret = 'hunter2';

    public string $frozen = 'Read-only: selection reports on Android, not on iOS.';

    /** Mention handles matching the "@..." fragment under the caret. */
    public array $suggestions = [];

    protected array $people = ['jane', 'jacob', 'james', 'shane', 'simon', 'martin'];

    public function navTitle(): string
    {
        return 'Caret & Selection';
    }

    public function onCaretMove(string $text, int $start, int $end): void
    {
        $this->eventCount++;
        $this->caretStart = $start;
        $this->caretEnd = $end;
        $this->selectedText = $start === $end ? '' : mb_substr($text, $start, $end - $start, 'UTF-8');

        // Look backwards from the caret for an "@mention" trigger.
        $before = mb_substr($text, 0, $start, 'UTF-8');

        if (preg_match('/@(\w*)$/u', $before, $m)) {
            $this->suggestions = array_values(array_filter(
                $this->people,
                fn ($p) => str_starts_with($p, strtolower($m[1])),
            ));
        } else {
            $this->suggestions = [];
        }
    }

    /**
     * Rewrites the bound model from PHP — exercises the programmatic-push
     * contract: both platforms should answer with one (text, len, len) event.
     */
    public function applyMention(string $handle): void
    {
        $before = mb_substr($this->message, 0, $this->caretStart, 'UTF-8');
        $after = mb_substr($this->message, $this->caretStart, null, 'UTF-8');

        $this->message = preg_replace('/@\w*$/u', "@{$handle} ", $before).$after;
        $this->suggestions = [];
    }

    public function onSecureCaretMove(string $text, int $start, int $end): void
    {
        $this->secureEventCount++;
    }

    public function resetCounters(): void
    {
        $this->eventCount = 0;
        $this->secureEventCount = 0;
    }

    public function render(): View
    {
        return view('native.selection-demo');
    }
}
