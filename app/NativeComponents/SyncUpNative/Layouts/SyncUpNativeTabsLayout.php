<?php

namespace App\NativeComponents\SyncUpNative\Layouts;

use App\Icons\Android;
use App\Icons\Ios;
use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\Builders\Tab;
use Native\Mobile\Edge\Layouts\Builders\TabBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;
use Nativephp\NativeUi\Builders\FloatingOverlay;
use Nativephp\NativeUi\Concerns\HasFloatingOverlay;

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
            ->back();
    }

    public function tabBar(NativeComponent $screen): ?TabBar
    {
        return TabBar::make()
            ->add(Tab::link('Messages', '/syncup-native', ios: Ios::Message, android: Android::ChatBubble)
                ->badge($this->getUnreadMessageCount()))
            ->add(Tab::link('Friends', '/syncup-native/friends', ios: Ios::Person3, android: Android::Group)->news($this->showNewsIndicator()))
            ->add(Tab::link('Profile', '/syncup-native/profile', ios: Ios::Person, android: Android::Person));
    }

    private function getUnreadMessageCount()
    {
        return 3;
    }

    private function showNewsIndicator()
    {
        return true;
    }
}
