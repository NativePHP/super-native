<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * The three `morph` styles, pushed from identical starting geometry into an
 * identical destination so the only variable is the style itself.
 *
 *   frame    — travels AND resizes (the default)
 *   position — travels but keeps its own size
 *   size     — resizes in place without travelling
 *
 * Seeing them back to back is the point: described in prose they sound like
 * shades of the same thing, and on screen they read as three quite different
 * animations.
 */
class HeroStyles extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Morph Styles';
    }

    public function render(): View
    {
        return view('native.hero.styles');
    }
}
