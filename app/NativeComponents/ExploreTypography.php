<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

class ExploreTypography extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Typography & Colors';
    }

    public function render(): \Illuminate\View\View
    {
        return view('explore.typography');
    }
}
