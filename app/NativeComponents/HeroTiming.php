<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Four elements morphing in one navigation, each with its own duration and
 * easing — including a spring, which is what most native hero animations
 * actually use.
 *
 * Without `morph-duration` / `morph-easing` every hero rides one shared
 * 350ms ease-in-out and they all land together. Here they deliberately do not,
 * which is what makes a stagger possible.
 */
class HeroTiming extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Timing';
    }

    public function render(): View
    {
        return view('native.hero.timing');
    }
}
