<?php

namespace App\NativeComponents;

use App\Support\HeroDemoData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class HeroNestedDetail extends NativeComponent
{
    public int $id = 1;

    public array $person = [];

    public function mount(): void
    {
        $this->id = (int) $this->param('id', 1);
        $this->person = HeroDemoData::person($this->id);
    }

    public function render(): View
    {
        return view('native.hero.nested-detail', ['person' => $this->person]);
    }
}
