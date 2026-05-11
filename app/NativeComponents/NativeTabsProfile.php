<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

class NativeTabsProfile extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Profile';
    }

    public function render(): \Illuminate\View\View
    {
        return view('native-tabs-profile');
    }
}
