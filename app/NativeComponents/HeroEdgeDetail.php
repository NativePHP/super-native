<?php

namespace App\NativeComponents;

use App\Support\HeroDemoData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Destination for the edge-case screen. One component covers every case; the
 * `case` param decides which pathology the destination exhibits.
 *
 *  - `matched`     — the control. Name present on both sides; it morphs.
 *  - `unmatched`   — the source tagged an element, this screen tags nothing.
 *                    Nothing to pair with, so the element is left to the
 *                    screen-level cross-fade. Degradation, not breakage.
 *  - `duplicate`   — the SAME name used twice on one screen. Only one pairing
 *                    can win; which one is not contractual, and the demo says
 *                    so rather than pretending otherwise.
 *  - `offscreen`   — the partner is far down a scroll view and has never been
 *                    laid out, so it has no frame to travel from.
 *  - `resized`     — matched, but the two ends have wildly different aspect
 *                    ratios; shows what the morph does with a shape change.
 */
class HeroEdgeDetail extends NativeComponent
{
    public string $case = 'matched';

    public array $photo = [];

    public function mount(): void
    {
        $this->case = (string) $this->param('case', 'matched');
        $this->photo = HeroDemoData::photo(1);
    }

    public function render(): View
    {
        return view('native.hero.edge-detail', [
            'case' => $this->case,
            'photo' => $this->photo,
        ]);
    }
}
