<?php

declare(strict_types=1);

namespace App\NativeComponents\EdgeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

final class BottomNavSearchItem extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Bottom Nav Search Item';
    }

    public function render(): View
    {
        return view('native.edge-components.bottom-nav-search-item');
    }
}
