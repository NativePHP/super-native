<?php

namespace App\NativeComponents\Layouts;

use App\Icons\Android;
use App\Icons\Ios;
use Native\Mobile\Edge\Layouts\Builders\NavAction;
use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\Builders\Tab;
use Native\Mobile\Edge\Layouts\Builders\TabBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

/**
 * Layout for the SyncUp messaging demo's three tab roots
 * (/syncup, /syncup/friends, /syncup/profile).
 *
 * The chains below intentionally exercise *every* public method on the
 * NavBar / TabBar / Tab builders so each one can be eyeballed in the
 * running app — call it the verification matrix. Anything that doesn't
 * paint pixels after this is a renderer gap, not a builder gap.
 *
 * The visible empty space below the bottom-nav icons is the home-indicator
 * safe area (~34pt on iPhones with one). It comes from `wrapWithChrome()`
 * applying `safeArea()` to the wrapper column. The bar's content is inset
 * above the indicator while the bar's background extends to the screen
 * edge — same pattern as iOS UITabBar. Without `dark()` the bg is
 * transparent so the inset is invisible; once a bg is set the inset
 * becomes obvious.
 */
class SyncUpTabsLayout extends NativeLayout
{
    public function navBar(NativeComponent $screen): ?NavBar
    {
        return NavBar::make()
            ->title($screen->navTitle())                            // "SyncUp"
            ->subtitle('All caught up')                             // small line under the title
            ->back()                                                // chevron + system back
            ->backgroundColor('#0891b2')                            // bar bg
            ->textColor('#FFFFFF')                                  // title + icon tint
            ->elevation(8)                                          // subtle shadow under bar
            ->action(NavAction::make('search')
                ->icon(ios: Ios::Magnifyingglass, android: Android::Search)
                ->a11yLabel('Search')
                ->press('openSearch'));
    }

    public function tabBar(NativeComponent $screen): ?TabBar
    {
        return TabBar::make()
            ->backgroundColor('#0891b2')
            ->activeColor('#FFFFFF')
            ->textColor('#FFFFFF')
            ->labelVisibility('labeled') // try 'selected' / 'unlabeled' to test
            ->add(Tab::link('Chats',   '/syncup',         ios: Ios::Message, android: Android::ChatBubble)->badge('2'))
            ->add(Tab::link('Friends', '/syncup/friends', ios: Ios::Person3, android: Android::Group)->news())
            ->add(Tab::link('Profile', '/syncup/profile', ios: Ios::Person,  android: Android::Person));
    }
}
