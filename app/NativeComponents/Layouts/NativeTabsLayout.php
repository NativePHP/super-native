<?php

namespace App\NativeComponents\Layouts;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\Elements\Icon;
use Native\Mobile\Edge\Elements\Row;
use Native\Mobile\Edge\Elements\Text;
use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\Builders\Tab;
use Native\Mobile\Edge\Layouts\Builders\TabBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

/**
 * `TabsLayout` clone that flips `usesNativeChrome()` to `true`. Routes
 * attached to this layout get their bottom bar rendered via SwiftUI's
 * `TabView` instead of the custom HStack-based `BottomNav` element.
 *
 * No `backgroundColor` set on the bar → on iOS 26+ the bar picks up
 * Liquid Glass material automatically. Set one to get the opaque-bar
 * behavior (X / Instagram pattern).
 */
class NativeTabsLayout extends NativeLayout
{
    public function usesNativeChrome(): bool
    {
        return true;
    }

    public function navBar(NativeComponent $screen): ?NavBar
    {
        return NavBar::make()
            ->back()
            ->title($screen->navTitle());
    }

    public function tabBar(NativeComponent $screen): ?TabBar
    {
        // The search tab's corpus comes from the active screen via
        // `searchItems()` (static) or `onSearchQuery($q)` (dynamic).
        // Screens that don't override either are hidden from the search
        // tab automatically. No URL on the search tab — it's an
        // iOS-side overlay, not a navigation destination.
        return TabBar::make()
            ->activeColor('#A855F7')
            ->minimizeOnScroll()
            ->add(Tab::link('Home', '/native-tabs', icon: 'house')->badge('3'))
            ->add(Tab::search(
                'Search',
                icon: 'search',
                placeholder: 'Search articles, songs, people…',
            ))
            ->add(Tab::link('Profile', '/native-tabs/profile', icon: 'person'));
    }

    /**
     * Persistent MiniPlayer-style accessory pinned above the tab bar.
     * On iOS 26+ it inhabits the new `tabViewBottomAccessory` slot and
     * tucks inline with the active tab on scroll-down (paired with the
     * `minimizeOnScroll()` flag above). On older iOS this returns null
     * so nothing renders.
     */
    public function tabBarAccessory(NativeComponent $screen): ?Element
    {
        $row = Row::make()->center()->gap(8);
        $row->addChild(Icon::make('music.note'));
        $row->addChild(Text::make('Liquid Glass demo — scroll to minimize'));

        return $row;
    }
}
