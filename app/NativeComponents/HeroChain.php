<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * A three-hop chain carrying ONE element the whole way.
 *
 * `chain-token` is tagged on all three screens, so it is re-paired at every
 * hop rather than persisting as a single long-lived view. Each step parks it
 * somewhere quite different — small in the top-left, mid-size and centred,
 * then wide across the bottom — which makes the re-pairing visible: the token
 * takes a fresh path on each leg instead of one smooth arc across all three.
 *
 * Back navigation is tagged `@navigate.back.viewTransition`, so the return
 * leg morphs in reverse instead of cutting.
 */
class HeroChain extends NativeComponent
{
    public int $step = 1;

    public function mount(): void
    {
        $this->step = max(1, min(3, (int) $this->param('step', 1)));
    }

    public function navTitle(): string
    {
        return 'Chain — step '.$this->step;
    }

    public function render(): View
    {
        return view('native.hero.chain', ['step' => $this->step]);
    }
}
