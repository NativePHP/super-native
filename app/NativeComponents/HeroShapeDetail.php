<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class HeroShapeDetail extends NativeComponent
{
    public string $variant = 'banner';

    public function mount(): void
    {
        $this->variant = (string) $this->param('variant', 'banner');
    }

    public function render(): View
    {
        return view('native.hero.shape-detail', ['variant' => $this->variant]);
    }
}
