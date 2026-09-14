<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * mobile-air #316 — "Bottom-pinned scroll view does not re-pin when the
 * keyboard hides".
 *
 * Cause: `NativeUIScrollViewRenderer` observed
 * `keyboardWillShowNotification` and nothing else. The keyboard resizes the
 * scroll viewport in BOTH directions — it shrinks on the way in and grows
 * back on the way out — so handling only the show left the list stranded
 * mid-screen with empty space beneath it once the keyboard closed. Half the
 * bug was invisible because the half that worked looked correct.
 *
 * Fix: observe `keyboardWillHideNotification` too, sharing the show handler's
 * animation so both transitions travel in step with the keyboard.
 *
 * The dismiss is GUARDED though, and that guard is the interesting part.
 * `scrollDismissesKeyboard(.interactively)` means dragging the list toward
 * older messages is itself how you dismiss the keyboard. Re-pinning
 * unconditionally would yank the reader straight back to the bottom and undo
 * the scroll that dismissed it — trading this bug for a worse one. So the
 * hide handler only re-pins when the list was actually still sitting at the
 * bottom, tracked by whether the bottom anchor is on screen.
 *
 * Section 2 is the check for that guard; section 1 is the reported bug.
 */
class MasterclassChatRepin extends NativeComponent
{
    public string $draft = '';

    /** @var array<int, string> */
    public array $messages = [];

    public function mount(): void
    {
        $this->messages = array_map(
            fn (int $i): string => "Message {$i}",
            range(1, 40),
        );
    }

    public function navTitle(): string
    {
        return '#316 · Bottom-pinned re-pin';
    }

    public function send(): void
    {
        if (trim($this->draft) === '') {
            return;
        }

        $this->messages[] = $this->draft;
        $this->draft = '';
    }

    public function render(): View
    {
        return view('native.masterclass.chat-repin');
    }
}
