<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * mobile-air #308 — "iOS: Tapping outside a text field does not dismiss the
 * keyboard on screens with native chrome".
 *
 * Cause: exactly what the issue's own note guessed. In
 * `SwiftUINodeRenderer.rootContent` the tap-to-dismiss gesture was attached
 * only to the chrome-LESS branch — the `else` that renders a plain root. The
 * `native_root_tabs` and `native_root_stack` branches return their renderers
 * directly and never got it, so every screen inside a tab or stack layout was
 * born without the gesture. Dragging still dismissed because that is SwiftUI's
 * own `scrollDismissesKeyboard`, which is unrelated.
 *
 * Fix: extract the gesture as `View.dismissesKeyboardOnTap()` and attach it in
 * all three places.
 *
 * On the two chrome renderers it is attached to the SCREEN CONTENT rather than
 * to the TabView / NavigationStack root, for two reasons:
 *
 *   1. `rootContent` deliberately bypasses NodeView's wrappers for those
 *      sentinels — the comment there records that cumulative wrapping breaks
 *      iOS 26's `Tab(role: .search)` capsule activation. A gesture recognizer
 *      spanning the tab bar risks the same class of problem.
 *   2. It is the correct scope anyway. A tap on the tab bar or a toolbar
 *      button is that control's business, not a dismiss.
 *
 * It uses `simultaneousGesture`, not `onTapGesture`, so it runs ALONGSIDE
 * whatever it lands on — buttons, pressables and list rows keep receiving
 * their own taps rather than having them swallowed. Section 2 is the check
 * for that.
 *
 * This screen is registered INSIDE the StackLayout group, so it has native
 * chrome and is the failing case. `/masterclass/keyboard-dismiss-plain` is the
 * same screen with no chrome — the case that always worked — for comparison.
 */
class MasterclassKeyboardDismiss extends NativeComponent
{
    /** Set from the route so one component can serve both the chrome and no-chrome variants. */
    public bool $chrome = true;

    public string $message = '';

    public int $taps = 0;

    public function navTitle(): string
    {
        return '#308 · Keyboard dismiss';
    }

    public function countTap(): void
    {
        $this->taps++;
    }

    public function resetTaps(): void
    {
        $this->taps = 0;
    }

    public function render(): View
    {
        return view('native.masterclass.keyboard-dismiss');
    }
}
