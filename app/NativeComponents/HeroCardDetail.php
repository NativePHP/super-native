<?php

namespace App\NativeComponents;

use App\Support\HeroDemoData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Destination for the card → page morph. The morphing element is the CARD
 * CONTAINER, and the content inside it differs between the two screens (a
 * one-line summary on the list, full body copy here). That mismatch is the
 * interesting part: the box has to travel while its contents change.
 */
class HeroCardDetail extends NativeComponent
{
    public int $id = 1;

    public array $card = [];

    public function mount(): void
    {
        $this->id = (int) $this->param('id', 1);
        $this->card = HeroDemoData::card($this->id);
    }

    public function render(): View
    {
        return view('native.hero.card-detail', ['card' => $this->card]);
    }
}
