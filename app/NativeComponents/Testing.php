<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class Testing extends NativeComponent
{
    public function render(): View
    {
        return view('native.testing');
    }
}
