<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class ExploreIcons extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Icons';
    }

    public function render(): Element
    {
        return $this->view('explore.icons');
    }
}
