<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Camera;

class Counter extends NativeComponent
{
    public $count = 0;

    public $photo = '';

    /**
     * Which button is being held ('up' / 'down'), or null when nothing is.
     *
     * Set by `@hold` and cleared by `@release`, and the template dims the held
     * button from it — which is what makes a `@release` that never arrived
     * visible instead of silent.
     */
    public ?string $holding = null;

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
     * `@hold` — press-and-hold, timed natively.
     *
     * Fires once the instant the button is touched (so a plain tap is one
     * step), then repeatedly for as long as it stays held: 2, 4, 8 and finally
     * 16 events a second, reaching full speed at 9s. `$speed` steps with the
     * cadence (0.125, 0.25, 0.5, 1.0) and is the whole reason this method needs
     * no timer, no tick counter and no `#[Poll]`. What it used to take is in
     * this file's history: a poll armed by `@pressDown`, waking every 110ms
     * whether or not anything was held, so that PHP could time a gesture it
     * cannot see.
     *
     * Reading `$speed` is the point of the contract. Multiplying by 8 turns the
     * four stages into whole steps of 1, 2, 4, 8, so the count accelerates
     * twice over: more events per second AND more counted per event, 2/sec at
     * the start and 128/sec once the ramp tops out. 8 rather than 16 because
     * the first event carries the first stage's speed, and a plain tap should
     * add one. Ignoring `$speed` and adding 1 per event would work as well; it
     * would just ramp 2 → 16 per second instead.
     */
    public function hold(string $direction, float $speed): void
    {
        $this->holding = $direction === 'down' ? 'down' : 'up';

        $step = (int) round($speed * 8);

        $this->count += $this->holding === 'down' ? -$step : $step;
    }

    /**
     * `@release` — the hold ended, whether by letting go, dragging off the
     * button, or the screen going away underneath it. Nothing to disarm: the
     * repeat lives in the renderer, and all this clears is the held state the
     * template draws with.
     */
    public function release(): void
    {
        $this->holding = null;
    }

    public function testCamera()
    {
        Camera::getPhoto()->photoTaken(function ($photo) {
            $this->photo = $photo->path;
        });
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
