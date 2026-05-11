<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

class Checkbox extends NativeComponent
{
    public function render(): \Illuminate\View\View
    {
        return view('checkbox');
    }
}