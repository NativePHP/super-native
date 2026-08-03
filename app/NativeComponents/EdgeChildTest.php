<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Minimal SCREEN that mounts a tappable child component
 * (<native:edge-child-test-card>) — a regression fixture for child-owned
 * callback dispatch. Tapping the child's button must run
 * EdgeChildTestCard::childTapped(), which emits back here and increments
 * $childEvents (screen state, so it persists via the sealed snapshot).
 */
class EdgeChildTest extends NativeComponent
{
    public int $childEvents = 0;

    public function navTitle(): string
    {
        return 'Edge Child Test';
    }

    public function recordChildTap(int $taps = 0): void
    {
        $this->childEvents++;
    }

    public function render(): View
    {
        return view('native.edge-child-test');
    }
}
