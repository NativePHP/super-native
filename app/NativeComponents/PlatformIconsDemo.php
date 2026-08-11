<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class PlatformIconsDemo extends NativeComponent
{
    public int $taps = 0;

    public int $selectedTab = 0;

    public bool $wifiChip = true;

    public bool $nfcChip = false;

    public function navTitle(): string
    {
        return 'Platform Icons';
    }

    public function tapped(): void
    {
        $this->taps++;
    }

    public function selectTab(int $index): void
    {
        $this->selectedTab = $index;
    }

    public function render(): View
    {
        return view('native.platform-icons-demo');
    }
}
