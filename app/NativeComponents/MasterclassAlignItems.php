<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * mobile-air #309 — "iOS: items-start and items-stretch behave inverted on
 * <native:column> compared to Android".
 *
 * Cause: `FlexContainer.placeSubviews` had its two cross-axis branches
 * transposed. The `AlignItems.stretch` case measured the child at its
 * NATURAL cross size (that's `start` behaviour), while the `default:` /
 * `start` case reused `childCrosses[i]` — the Phase 3 measurement taken
 * against `crossAvail`, i.e. the full container cross (that's `stretch`).
 * Android's ComposeFlexLayout was already right: STRETCH adds
 * `fillMaxWidth()`, START omits it.
 *
 * The catch: a naive swap ALSO moves the default. `align_items` is absent
 * from the wire unless an `items-*` class is present, so it arrived as 0 —
 * the same value as `items-start`. Nothing downstream could tell "the author
 * wrote items-start" apart from "the author wrote nothing", so fixing the
 * former flipped every unclassed column on iOS from fill to hug. (It did.
 * It emptied the demo app.)
 *
 * Fix: give explicit start its own wire value. 0 now means UNSET, and Start
 * moved to 4 on both `AlignItems` and `AlignSelf`:
 *
 *   0 = unset   → each renderer's own default. iOS fills (CSS's default and
 *                 what it always did); Android content-sizes. UNCHANGED on
 *                 both platforms — this is what keeps existing apps still.
 *   3 = stretch → fills. Was hugging on iOS; now matches Android.
 *   4 = start   → hugs. Was filling on iOS; now matches Android.
 *
 * Android needed no behavioural change at all — 4 falls through the same
 * `else` branches 0 always did. Free bonus: `self-start` used to be a silent
 * no-op, because both renderers resolve `alignSelf > 0 ? alignSelf : align`
 * and Start was 0. Section 5 covers that.
 *
 * Still open (section 3): the two platforms disagree on what UNSET means.
 * That is a real parity bug, but fixing it moves every unclassed Android
 * container, so it is a separate decision.
 */
class MasterclassAlignItems extends NativeComponent
{
    public function navTitle(): string
    {
        return '#309 · items-start vs items-stretch';
    }

    public function render(): View
    {
        return view('native.masterclass.align-items');
    }
}
