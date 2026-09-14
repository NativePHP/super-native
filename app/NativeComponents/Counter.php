<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class Counter extends NativeComponent
{
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }

    public function decrement(): void
    {
        $this->count--;
    }

    public function render(): View
    {
        //        dd($this->view('counter')->toArray($this->nativeCallbacks));
        return view('native.counter');
    }
}
