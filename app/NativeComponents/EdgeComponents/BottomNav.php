<?php

declare(strict_types=1);

namespace App\NativeComponents\EdgeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

final class BottomNav extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Bottom Nav';
    }

    public function render(): View
    {
        return view('native.edge-components.bottom-nav');
    }
}
