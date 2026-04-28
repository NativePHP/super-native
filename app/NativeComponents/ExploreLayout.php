<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class ExploreLayout extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Layout & Canvas';
    }

    public function render(): Element
    {
        return $this->view('explore.layout');
    }
}
