<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * mobile-air #311 — "Per-corner and per-side border radius classes are
 * ignored (both platforms)".
 *
 * Cause: `TailwindParser::parseRounded` only ever looked its argument up in
 * the BORDER_RADIUS scale. `rounded-br-none` arrived as the string
 * `br-none`, missed, and returned null — so the class was dropped rather
 * than mismapped. That is why a per-corner class neither applied its own
 * radius NOR overrode a uniform one, exactly as the issue described.
 * `rounded-br-[4px]` failed separately, in `parseArbitrary`, for want of a
 * prefix.
 *
 * The interesting part is the wire. The packed binary node carries a SINGLE
 * `border_radius` float at offset 134 with no room for four, and widening it
 * would mean a format-version bump in lockstep with the embedded PHP binary.
 * So the corners ride the generic prop bag instead (`radius_tl` … `radius_bl`),
 * the same escape hatch gradients use for their variable-length stop list.
 * No format bump; renderers that don't know the props just ignore them.
 *
 * PHP resolves all four corners at collection time — each per-corner value
 * if authored, else the uniform `rounded-*`, else 0 — and emits all four
 * whenever ANY is authored. So the native side needs no per-corner presence
 * checks: `radius_tl` existing IS the switch. It also makes the result
 * independent of class ORDER, matching Tailwind (whose generated stylesheet
 * always puts the longhand after the shorthand, so the corner always wins).
 *
 * iOS uses `UnevenRoundedRectangle`, Android `RoundedCornerShape(topStart:…)`,
 * applied consistently to the clip, the border overlay and the glass shape.
 *
 * Not supported on purpose: Tailwind's LOGICAL spellings (`rounded-s-*`,
 * `rounded-ee-*`, …). They resolve against writing direction and neither
 * renderer flips corners for RTL, so accepting them would quietly render
 * LTR geometry in an RTL layout. They stay unparsed and surface in the
 * dropped-class diagnostics. Section 6 shows this.
 */
class MasterclassCornerRadius extends NativeComponent
{
    public function navTitle(): string
    {
        return '#311 · Per-corner radius';
    }

    public function render(): View
    {
        return view('native.masterclass.corner-radius');
    }
}
