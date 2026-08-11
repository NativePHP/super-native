<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * mobile-air #310 — "max-w-* is ignored on all elements (both platforms)".
 *
 * Cause: the class was dropped in four separate places, which is why it
 * looked like a total no-op rather than a mismapping:
 *
 *   1. TailwindParser had no `max-w-` / `min-w-` / `max-h-` / `min-h-`
 *      branch at all, and `parseArbitrary` had no prefix for them, so
 *      `max-w-sm` AND `max-w-[280px]` both parsed to null.
 *   2. NativeElementCollector never mapped the attrs onto the layout array.
 *   3. iOS `NodeLayoutModifier.resolvedMaxWidth` only consulted `maxWidth`
 *      when NO width mode was set, so `w-full max-w-*` ignored the bound.
 *   4. Android read min/max off the wire into NativeUINode and then never
 *      applied them to a modifier.
 *
 * The packed node already carried min/max at offsets 78–93, so no wire
 * format bump was needed — only the plumbing at each end.
 *
 * Note on `max-w-full` / `max-w-screen`: min and max ride the wire as bare
 * floats with no companion size mode, so there is nowhere to encode "100%
 * of the parent". Those keywords are deliberately left unparsed so they
 * show up in the dropped-class diagnostics rather than silently doing
 * nothing. Section 5 demonstrates that.
 */
class MasterclassMaxWidth extends NativeComponent
{
    public function navTitle(): string
    {
        return '#310 · max-w-*';
    }

    /** The long line from the issue — needs to be wide enough to wrap. */
    public string $longText = 'This is a longer line of text that will run as wide as it is allowed to run before wrapping.';

    public function render(): View
    {
        return view('native.masterclass.max-width');
    }
}
