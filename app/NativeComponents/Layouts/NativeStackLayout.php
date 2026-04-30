<?php

namespace App\NativeComponents\Layouts;

use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

/**
 * `StackLayout` clone that flips `usesNativeChrome()` to `true`. Routes
 * attached to this layout get their NavBar rendered via SwiftUI's
 * `NavigationStack` instead of the custom HStack-based `TopBar` element.
 *
 * On iOS 26+ this enables Liquid Glass material on the bar by default.
 * On older iOS, it gives a standard `UINavigationBar` look.
 *
 * Routes that don't need this can keep using the existing `StackLayout`.
 */
class NativeStackLayout extends NativeLayout
{
    public function usesNativeChrome(): bool
    {
        return true;
    }

    public function navBar(NativeComponent $screen): ?NavBar
    {
        // Screens may opt out of the system back chevron by exposing a
        // `showsNavBack(): bool` method that returns false. Useful for root
        // screens (e.g. the demo launcher) where there's nothing to pop back
        // to and the empty stub looks awkward.
        $showBack = ! method_exists($screen, 'showsNavBack')
            || $screen->showsNavBack();

        return NavBar::make()
            ->back($showBack)
            ->title($screen->navTitle());
    }
}
