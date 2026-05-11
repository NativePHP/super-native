<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

/**
 * NavigationStack + Form + Section pattern demo, scoped to the button
 * variants & sizes the native-ui plugin actually ships today
 * (primary / secondary / destructive / ghost; sm / md / lg).
 *
 * The grouped-inset chrome (rounded white cards, gray gap, hairline
 * separators) is composed from existing primitives — column / card /
 * row / spacer / divider — so no new elements are needed.
 */
class ButtonsForm extends NativeComponent
{
    /** Toggle binding — when true, every demo button renders with `disabled`. */
    public bool $disabled = false;

    public int $taps = 0;

    public string $lastTapped = '';

    public function navTitle(): string
    {
        return 'Buttons';
    }

    public function tap(string $key): void
    {
        $this->taps++;
        $this->lastTapped = $key;
    }

    public function render(): \Illuminate\View\View
    {
        return view('buttons-form');
    }
}
