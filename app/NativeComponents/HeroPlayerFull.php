<?php

namespace App\NativeComponents;

use App\Support\HeroDemoData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class HeroPlayerFull extends NativeComponent
{
    public int $id = 1;

    public array $track = [];

    public function mount(): void
    {
        $this->id = (int) $this->param('id', 1);
        $this->track = HeroDemoData::track($this->id);
    }

    public function render(): View
    {
        return view('native.hero.player-full', ['track' => $this->track]);
    }
}
