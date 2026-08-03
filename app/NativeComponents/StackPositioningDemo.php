<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Testbed for the `stack` z-overlay + two-point anchor/origin work
 * (mobile-air PR #226, branch `feat/stack-positioning`).
 *
 * Every section is a *visual assertion* — each stack carries a visible
 * border so you can see the box it actually measured to, which is the
 * only way to tell wrap-content from fill-parent on device.
 *
 * Read this screen side by side on iOS and Android. The sections flagged
 * ⚠️ are the ones expected to differ today; see the notes on each.
 */
class StackPositioningDemo extends NativeComponent
{
    /** Outline every stack + anchored child so the measured boxes are visible. */
    public bool $showBounds = true;

    /**
     * Which sections to render. Empty shows all; set e.g. [3] to isolate the
     * anchor grid when capturing a screenshot on a device.
     *
     * @var array<int, int>
     */
    public array $show = [11];

    /**
     * The nine anchor/origin points, in wire-enum order. Drives the anchor
     * and origin grids so the blade stays declarative and we exercise the
     * bound-attribute path (`:anchor="$point"`) as well as the literal one.
     *
     * @var array<int, array{name: string, enum: int}>
     */
    public array $points = [
        ['name' => 'top-left', 'enum' => 1],
        ['name' => 'top', 'enum' => 2],
        ['name' => 'top-right', 'enum' => 3],
        ['name' => 'left', 'enum' => 4],
        ['name' => 'center', 'enum' => 0],
        ['name' => 'right', 'enum' => 5],
        ['name' => 'bottom-left', 'enum' => 6],
        ['name' => 'bottom', 'enum' => 7],
        ['name' => 'bottom-right', 'enum' => 8],
    ];

    public function navTitle(): string
    {
        return 'Stack & Positioning';
    }

    public function toggleBounds(): void
    {
        $this->showBounds = ! $this->showBounds;
    }

    /** Rows of three, so the 9-point grids lay out as a 3x3. */
    public function pointRows(): array
    {
        return array_chunk($this->points, 3);
    }

    public function render(): View
    {
        return view('native.stack-positioning-demo');
    }
}
