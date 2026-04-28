<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;

class Counter extends NativeComponent
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function navTitle(): string
    {
        return 'Counter';
    }

    public function render(): Element
    {
        return $this->view('counter');
    }
}
