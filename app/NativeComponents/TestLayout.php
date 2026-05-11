<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

class TestLayout extends NativeComponent
{
    public function render(): \Illuminate\View\View
    {
        return view('test-layout');
    }
}