<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class HeroStylesDetail extends NativeComponent
{
    public string $mode = 'frame';

    /** Kept in step with the tints on the index so each pair reads as one object. */
    public function tint(): string
    {
        return match ($this->mode) {
            'position' => '#0891B2',
            'size' => '#DB2777',
            default => '#6366F1',
        };
    }

    public function mount(): void
    {
        $this->mode = (string) $this->param('mode', 'frame');
    }

    public function render(): View
    {
        return view('native.hero.styles-detail', [
            'mode' => $this->mode,
            'tint' => $this->tint(),
        ]);
    }
}
