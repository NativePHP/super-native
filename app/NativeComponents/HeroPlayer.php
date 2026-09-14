<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Mini-player → full-player: the shared-element pattern people recognise
 * without being told what it is.
 *
 * Three names travel at once and along wildly different paths — the artwork
 * crosses the screen and quadruples in size, the title slides up out of a
 * cramped bar into a centred headline, and the bar's own surface grows from a
 * 64pt strip into the entire screen. Nothing coordinates them; they share only
 * the navigation and one animation curve.
 */
class HeroPlayer extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Now Playing';
    }

    public function render(): View
    {
        return view('native.hero.player');
    }
}
