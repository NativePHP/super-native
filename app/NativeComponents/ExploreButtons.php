<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

class ExploreButtons extends NativeComponent
{
    public int $count = 10;

    public function navTitle(): string
    {
        return 'Buttons';
    }

    public function increment(): void { $this->count++; }
    public function decrement(): void { $this->count--; }

    public function render(): \Illuminate\View\View
    {
        return view('explore.buttons');
    }
}
