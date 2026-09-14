<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * The seam, made deliberately visible.
 *
 * One badge is built from two halves sitting flush against each other. The
 * left half is tagged; the right half is identical in every other respect and
 * is not. On navigate the tagged half flies to the destination while its twin
 * stays put and cross-fades, so the join between "morphed" and "merely
 * cross-faded" content tears open in the middle of a single object.
 *
 * Every other demo hides this seam by tagging whole, self-contained elements.
 * This one exists to show exactly where the mechanism stops.
 */
class HeroSeam extends NativeComponent
{
    public function navTitle(): string
    {
        return 'The Seam';
    }

    public function render(): View
    {
        return view('native.hero.seam');
    }
}
