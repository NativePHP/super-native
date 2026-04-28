<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class Browse extends NativeComponent
{
    public array $categories = ['Music', 'Movies', 'Books', 'Games', 'Photos', 'Apps'];

    public function navTitle(): string
    {
        return 'Browse';
    }

    public function render(): Element
    {
        return $this->view('browse');
    }
}
