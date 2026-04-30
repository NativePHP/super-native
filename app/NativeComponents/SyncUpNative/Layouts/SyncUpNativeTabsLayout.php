<?php

namespace App\NativeComponents\SyncUpNative\Layouts;

use Native\Mobile\Edge\Layouts\Builders\NavAction;
use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\Builders\Tab;
use Native\Mobile\Edge\Layouts\Builders\TabBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

/**
 * Native-chrome variant of SyncUp's tabs layout. Same shape as the
 * original `SyncUpTabsLayout` — three tab roots with a NavBar — except
 * `usesNativeChrome()` is `true`, so iOS routes through SwiftUI's
 * `TabView` + per-tab `NavigationStack` instead of the custom HStack
 * `TopBar` / `BottomNav` elements.
 *
 * Tab URLs all point under `/syncup-native/...` so this demo runs in
 * parallel with the original `/syncup/...` flow for side-by-side
 * comparison from the launcher.
 */
class SyncUpNativeTabsLayout extends NativeLayout
{
    public function usesNativeChrome(): bool
    {
        return true;
    }

    public function navBar(NativeComponent $screen): ?NavBar
    {
        return NavBar::make()
            ->title($screen->navTitle())
            ->subtitle('All caught up')
            ->back()
            ->backgroundColor('#0891b2')
            ->textColor('#FFFFFF')
            ->action(NavAction::make('search')->icon('search')->press('openSearch'));
    }

    public function tabBar(NativeComponent $screen): ?TabBar
    {
        return TabBar::make()
            ->dark()
            ->activeColor('#0891b2')
            ->labelVisibility('labeled')
            ->add(Tab::link('Chats',   '/syncup-native',         icon: 'chat_bubble')->badge('2'))
            ->add(Tab::link('Friends', '/syncup-native/friends', icon: 'person.3.fill')->news())
            ->add(Tab::link('Profile', '/syncup-native/profile', icon: 'person'));
    }
}
