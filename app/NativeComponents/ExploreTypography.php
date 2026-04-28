<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class ExploreTypography extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Typography & Colors';
    }

    public function render(): Element
    {
        return $this->view('explore.typography');
    }
}
