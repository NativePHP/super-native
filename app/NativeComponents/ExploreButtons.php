<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class ExploreButtons extends NativeComponent
{
    public int $count = 0;

    public function navTitle(): string
    {
        return 'Buttons';
    }

    public function increment(): void { $this->count++; }
    public function decrement(): void { $this->count--; }

    public function render(): Element
    {
        return $this->view('explore.buttons');
    }
}
