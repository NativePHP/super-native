<?php

namespace App\NativeComponents\Layouts;

use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\Builders\Tab;
use Native\Mobile\Edge\Layouts\Builders\TabBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

/**
 * Layout for the three root tab screens (Home / Browse / Profile).
 * Provides a simple title bar plus a bottom tab bar shared across them.
 */
class TabsLayout extends NativeLayout
{
    public function navBar(NativeComponent $screen): ?NavBar
    {
        return NavBar::make()
            ->title($screen->navTitle());
    }

    public function tabBar(NativeComponent $screen): ?TabBar
    {
        return TabBar::make()
            ->add(Tab::link('Home',    '/tabs',         icon: 'home'))
            ->add(Tab::link('Browse',  '/tabs/browse',  icon: 'search'))
            ->add(Tab::link('Profile', '/tabs/profile', icon: 'person'));
    }
}
