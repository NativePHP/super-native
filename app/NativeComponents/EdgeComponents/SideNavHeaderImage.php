<?php

declare(strict_types=1);

namespace App\NativeComponents\EdgeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\UI\Builders\Drawer;
use Native\Mobile\UI\Concerns\InteractsWithDrawer;

final class SideNavHeaderImage extends NativeComponent
{
    use InteractsWithDrawer;

    public function navTitle(): string
    {
        return 'Side Nav Header Image';
    }

    public function drawerOverride(): ?Drawer
    {
        return Drawer::make(view('native.edge-components.side-nav-header-image'));
    }

    public function render(): View
    {
        return view('native.edge-components.side-nav-body');
    }
}
