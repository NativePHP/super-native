<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Forty rows, every one tagged. Scroll to any of them and tap.
 *
 * The morph has to start from wherever that row physically is at the moment
 * of the tap — near the top, half off the bottom edge, anywhere. Nothing about
 * the start frame is known ahead of time, which is the point: the geometry is
 * read live rather than assumed from the element's position in the list.
 */
class HeroDeepList extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Deep Scroll';
    }

    public function render(): View
    {
        return view('native.hero.deep-list');
    }
}
