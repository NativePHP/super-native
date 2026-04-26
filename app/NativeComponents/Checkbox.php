<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class Checkbox extends NativeComponent
{
    public function render(): Element
    {
        return $this->view('checkbox');
    }
}