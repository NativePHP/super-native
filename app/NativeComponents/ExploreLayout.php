<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

class ExploreLayout extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Layout & Canvas';
    }

    public function render(): \Illuminate\View\View
    {
        return view('explore.layout');
    }
}
