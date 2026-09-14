<?php

namespace App\NativeComponents;

use App\Support\HeroDemoData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Destination for the multi-element morph: the avatar and the name each carry
 * their own `ref`, so a single navigation moves TWO elements
 * along independent paths at once.
 */
class HeroProfileDetail extends NativeComponent
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
        return view('native.hero.profile-detail', ['person' => $this->person]);
    }
}
