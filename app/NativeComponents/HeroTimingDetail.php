<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class HeroTimingDetail extends NativeComponent
{
    public function render(): View
    {
        return view('native.hero.timing-detail');
    }
}
