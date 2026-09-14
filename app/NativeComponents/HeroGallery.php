<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Index screen for the shared-element showcase. Gets native chrome via
 * StackLayout; every DESTINATION it pushes is deliberately chrome-less so the
 * navigation is a full tree replace on the router-level path — which is the
 * only path a `ref` morph rides. A chrome-to-chrome push uses
 * NavigationStack's own animation instead and would show nothing.
 */
class HeroGallery extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Shared Elements';
    }

    public function render(): View
    {
        return view('native.hero.gallery');
    }
}
