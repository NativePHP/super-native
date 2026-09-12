<?php

declare(strict_types=1);

namespace App\NativeComponents\EdgeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

final class TopBar extends NativeComponent
{
    public function openSearch(): void {}

    public function render(): View
    {
        return view('native.edge-components.top-bar');
    }
}
