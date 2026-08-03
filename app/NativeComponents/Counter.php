<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Attributes\Poll;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;

class Counter extends NativeComponent
{
    public $count = 0;

    /** Direction of an active press-and-hold: 'up', 'down', or null. */
    public ?string $holding = null;

    /** Ticks elapsed in the current hold — drives step acceleration. */
    public int $holdTicks = 0;

    public function navTitle(): string
    {
        return 'Counter';
    }

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    /**
     * `@pressDown` — steps once immediately (so a plain tap counts), then
     * arms the poll-driven repeat below for as long as the press is held.
     */
    public function startHold(string $direction): void
    {
        $this->holding = $direction === 'down' ? 'down' : 'up';
        $this->holdTicks = 0;
        $this->step();
    }

    /** `@pressUp` — fires on release or cancel; disarms the repeat. */
    public function stopHold(): void
    {
        $this->holding = null;
        $this->holdTicks = 0;
    }

    /**
     * Repeat engine. The poll wakes every tick regardless of hold state,
     * but idle ticks re-render an identical tree, which the shadow compare
     * drops before it reaches the wire — only held ticks cost anything.
     * The tick cap auto-releases a hold whose pressUp never arrived.
     */
    #[Poll(110)]
    public function holdTick(): void
    {
        if ($this->holding === null) {
            return;
        }

        if (++$this->holdTicks > 130) {
            $this->stopHold();

            return;
        }

        $this->step();
    }

    /** Accelerates the longer the hold: ±1, then ±2, then ±5 per tick. */
    protected function step(): void
    {
        $delta = $this->holdTicks > 25 ? 5 : ($this->holdTicks > 8 ? 2 : 1);
        $this->count += $this->holding === 'down' ? -$delta : $delta;
    }

    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()
            ->displayMode('inline')
            ->font('Audiowide-Regular');
    }

    public function render(): View
    {
        return view('native.counter');
    }
}
