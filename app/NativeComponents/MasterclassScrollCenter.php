<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * mobile-air #303 — "Cannot vertically center content inside <scroll-view>".
 *
 * Cause, and it is the same shape on both platforms: a scroll view's content
 * is measured against an UNBOUNDED main axis — that is what makes it
 * scrollable — so nothing inside it knows the viewport height. A `fill` /
 * `h-full` child therefore has nothing to fill and reports its own content
 * height, leaving `justify-center` no slack to distribute. The child hugs and
 * the content stays pinned to the top.
 *
 * It is exactly the CSS problem `min-height: 100%` exists to solve, and the
 * fix is the same idea on both platforms: measure the viewport OUTSIDE the
 * scroll view and hand that height to the filling child as a MINIMUM.
 *
 *   iOS      GeometryReader around the ScrollView; the height is applied per
 *            CHILD, not to the LazyVStack. A lazy stack sizes children to
 *            their ideal height and does not redistribute slack the way a
 *            plain VStack does, so a minimum on the stack would grow the
 *            stack and leave the child hugging anyway.
 *
 *   Android  BoxWithConstraints supplies the viewport; the filling child is
 *            wrapped in `Modifier.heightIn(min = viewport)`. The min
 *            constraint passes through, so Compose measures the child at
 *            max(contentHeight, viewport) without relying on fillMaxHeight
 *            resolving against an unbounded parent.
 *
 * A MINIMUM, not an exact height — content taller than the viewport must
 * still grow and scroll. Section 3 is the check for that.
 *
 * Both paths are gated on a direct child actually asking for fill height, so
 * every existing scroll view keeps its original measurement. On iOS that
 * matters: GeometryReader is greedy, and wrapping every scroll view in one
 * would change how content-sized scroll views measure.
 */
class MasterclassScrollCenter extends NativeComponent
{
    public function navTitle(): string
    {
        return '#303 · Centering in scroll-view';
    }

    public function render(): View
    {
        return view('native.masterclass.scroll-center');
    }
}
