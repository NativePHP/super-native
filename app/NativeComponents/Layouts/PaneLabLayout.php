<?php

namespace App\NativeComponents\Layouts;

use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\UI\Builders\BackgroundLayer;
use Native\Mobile\UI\Concerns\HasBackgroundLayer;

/**
 * Layout for the Pane Lab demo: declares a persistent background layer
 * (the fake "map") that mounts once beneath the screen — the PR #37
 * surface under test.
 *
 * Deliberately CHROME-LESS: core folds root hosts around the whole tree,
 * OUTSIDE the NavigationStack, so nav chrome's opaque system background
 * would sit on top of the layer and hide it (the known iOS transparency
 * gap on PR #37). The screen carries its own back button instead.
 */
class PaneLabLayout extends NativeLayout
{
    use HasBackgroundLayer;

    public function usesNativeChrome(): bool
    {
        return false;
    }

    public function navBar(NativeComponent $screen): ?NavBar
    {
        return null;
    }

    public function backgroundLayer(NativeComponent $screen): ?BackgroundLayer
    {
        return BackgroundLayer::make(view('native.pane-lab-backdrop'));
    }
}
