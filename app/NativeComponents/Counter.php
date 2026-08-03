<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;

class Counter extends NativeComponent
{
    public $count = 0;

    public function navTitle(): string
    {
        return 'Counter';
    }

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()
            ->displayMode('inline')
            ->font('Audiowide-Regular');
    }

    public function render(): View
    {
        return view('native.counter');
    }
}
