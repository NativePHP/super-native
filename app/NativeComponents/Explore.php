<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class Explore extends NativeComponent
{
    public int $count = 0;

    public function mount(): void
    {
        nativephp_call('UI.SetBackground', json_encode(['color' => '#FFFFFF']));
    }

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function render(): Element
    {
        return $this->view('explore');
    }
}
