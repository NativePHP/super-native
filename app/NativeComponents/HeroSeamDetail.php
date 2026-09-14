<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class HeroSeamDetail extends NativeComponent
{
    public function render(): View
    {
        return view('native.hero.seam-detail');
    }
}
