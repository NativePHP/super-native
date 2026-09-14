<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Shape-shift: the same name on two elements whose GEOMETRY disagrees about
 * almost everything — a small circle on one side, a wide square-cornered
 * banner on the other.
 *
 * Corner radius, aspect ratio and size all interpolate together, so this is
 * the demo that shows what the morph does when the two ends are not simply
 * scaled versions of each other.
 */
class HeroShape extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Shape Shift';
    }

    public function render(): View
    {
        return view('native.hero.shape');
    }
}
