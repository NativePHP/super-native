<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Showcase for `content-transition` on <native:text> — the "number
 * switcher": digits roll in place as the value changes (SwiftUI
 * numericText on iOS, directional slide + fade on Android) instead of
 * swapping cold. The side-by-side row renders the same value through
 * each mode so the difference is visible at a glance.
 */
class NumberSwitcherDemo extends NativeComponent
{
    public int $value = 1024;

    public function increment(): void
    {
        $this->value++;
    }

    public function decrement(): void
    {
        $this->value = max(0, $this->value - 1);
    }

    public function jump(): void
    {
        $this->value += 111;
    }

    public function randomize(): void
    {
        $this->value = random_int(0, 99999);
    }

    public function navTitle(): string
    {
        return 'Number Switcher';
    }

    public function render(): View
    {
        return view('native.number-switcher');
    }
}
