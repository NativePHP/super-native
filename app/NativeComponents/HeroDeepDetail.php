<?php

namespace App\NativeComponents;

use App\Support\HeroDemoData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class HeroDeepDetail extends NativeComponent
{
    public int $id = 1;

    public array $row = [];

    public function mount(): void
    {
        $this->id = (int) $this->param('id', 1);
        $this->row = HeroDemoData::deepRow($this->id);
    }

    public function render(): View
    {
        return view('native.hero.deep-detail', ['row' => $this->row]);
    }
}
