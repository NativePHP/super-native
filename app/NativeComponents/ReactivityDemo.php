<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Attributes\Computed;
use Native\Mobile\Attributes\Lazy;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\NativeRouter;

#[Lazy]
class ReactivityDemo extends NativeComponent
{
    public int $count = 0;

    public function navTitle(): string
    {
        return 'Reactivity';
    }

    public function mount(): void
    {
        sleep(2);
    }

    protected function placeholder(): View
    {
        return view('native.reactivity-demo-placeholder');
    }

    /** #[Computed] — derived from $count, recomputed when state changes. */
    #[Computed]
    public function doubled(): int
    {
        return $this->count * 2;
    }

    public function increment(): void
    {
        // TEMPORARY diagnostic: is increment() invoked twice per tap, or once
        // and applied twice? One line per tap in storage/logs/edge-nav.log
        // means the event is fine and state is being double-applied; two lines
        // mean the press is being dispatched twice. Remove once answered.
        NativeRouter::debugLog(
            'increment() count='.$this->count.' obj='.spl_object_id($this)
        );

        $this->count++;
    }

    public function decrement(): void
    {
        NativeRouter::debugLog(
            'decrement() count='.$this->count.' obj='.spl_object_id($this)
        );

        $this->count--;
    }

    public function render(): View
    {
        return view('native.reactivity-demo');
    }
}
