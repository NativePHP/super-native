<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Attributes\Poll;
use Native\Mobile\Edge\NativeComponent;

class JustifyRepro extends NativeComponent
{
    public bool $long = false;

    public function navTitle(): string
    {
        return 'Justify Repro';
    }

    public function toggle()
    {
        $this->long = ! $this->long;
    }

    #[Poll(3000)]
    public function tick()
    {
        $this->toggle();
    }

    public function render(): View
    {
        return view('native.justify-repro');
    }
}
