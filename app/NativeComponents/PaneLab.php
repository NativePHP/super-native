<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Pane Lab — one screen exercising the in-flight sheet work:
 *
 *  - PR #37 background layer: the layout mounts `pane-lab-backdrop`
 *    beneath this screen (its corner badges also prove the merged
 *    zero-inset anchoring on both platforms).
 *  - PR #38 sheet pane: an always-on draggable pane snapping between
 *    detents, reporting each settle through @change.
 *  - PR #38 permanent bottom sheet: can't be swiped away or (Android)
 *    back-pressed — only the button inside closes it.
 */
class PaneLab extends NativeComponent
{
    /** Last detent the pane settled on, as reported by @change. */
    public string $lastDetent = '—';

    /** How many times @change fired — proves the same-detent guard. */
    public int $changeCount = 0;

    public bool $showPermanentSheet = false;

    public function navTitle(): string
    {
        return 'Pane Lab';
    }

    public function paneMoved(string $detent): void
    {
        $this->lastDetent = $detent;
        $this->changeCount++;
    }

    public function openPermanentSheet(): void
    {
        $this->showPermanentSheet = true;
    }

    public function closePermanentSheet(): void
    {
        $this->showPermanentSheet = false;
    }

    public function render(): View
    {
        return view('native.pane-lab');
    }
}
