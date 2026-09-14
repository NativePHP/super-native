<?php

namespace App\NativeComponents;

use App\Support\HeroDemoData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Destination for the canonical grid → detail morph. Chrome-less on purpose
 * (see HeroPhotoGrid) so the swap rides the router-level path.
 *
 * The image here carries the SAME `ref` as its thumbnail on the
 * grid — that shared name is the entire coupling between the two screens.
 */
class HeroPhotoDetail extends NativeComponent
{
    public int $id = 1;

    public array $photo = [];

    public function mount(): void
    {
        $this->id = (int) $this->param('id', 1);
        $this->photo = HeroDemoData::photo($this->id);
    }

    public function render(): View
    {
        return view('native.hero.photo-detail', [
            'photo' => $this->photo,
        ]);
    }
}
