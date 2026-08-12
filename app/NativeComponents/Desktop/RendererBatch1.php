<?php

namespace App\NativeComponents\Desktop;

use Illuminate\View\View;
use SupaNative\Core\Edge\EdgeLog;
use SupaNative\Core\Edge\NativeComponent;
use SupaNative\Core\Edge\SharedValue;

/**
 * One window that renders every element type in the macOS renderer's first
 * batch, each labelled with the wire type it exercises.
 *
 * The three interactive ones all report back into component state — `presses`,
 * `flag`, `typed` — because the point of the screen is not only that the types
 * draw: it is that a press, a toggle and a keystroke each reach PHP and cause
 * the window to be republished. Anything visible on screen that changed after
 * an interaction is a round trip that happened.
 */
class RendererBatch1 extends NativeComponent
{
    public int $presses = 0;

    public bool $flag = true;

    public string $typed = '';

    public string $lastNav = 'nothing yet';

    /**
     * Every handler names itself in the Edge trace, which lands in the same
     * `logs/edge-nav.log` the coordinator writes its publishes to. Without it
     * the log proves only that publishes happened, not what caused them —
     * "published surface 0" looks identical whichever control was touched.
     */
    public function press(): void
    {
        $this->presses++;

        EdgeLog::debug("demo: BUTTON press → presses={$this->presses}");
    }

    /** TOGGLE_CHANGE delivers the new value as a bool argument. */
    public function flip(bool $value): void
    {
        $this->flag = $value;

        EdgeLog::debug('demo: TOGGLE change → flag='.var_export($value, true));
    }

    /** TEXT_CHANGE and SUBMIT both deliver the field's text as a string. */
    public function typing(string $text): void
    {
        $this->typed = $text;

        EdgeLog::debug("demo: TEXT_INPUT change → \"{$text}\"");
    }

    public function submitted(string $text): void
    {
        $this->typed = $text.' (submitted)';

        EdgeLog::debug("demo: TEXT_INPUT submit → \"{$text}\"");
    }

    public function pick(string $label = ''): void
    {
        $this->lastNav = $label !== '' ? $label : 'a side_nav_item';

        EdgeLog::debug("demo: SIDE_NAV_ITEM press → {$this->lastNav}");
    }

    public function tapped(): void
    {
        $this->lastNav = 'gesture_area tap';

        EdgeLog::debug('demo: GESTURE_AREA tap');
    }

    public function held(): void
    {
        $this->lastNav = 'gesture_area long press';

        EdgeLog::debug('demo: GESTURE_AREA long press');
    }

    public function render(): View
    {
        return view('native.desktop.renderer-batch1', [
            // Bound to the gesture area's `pan-y`, which is what makes the
            // renderer take the drag path rather than tap/long-press only.
            'drag' => SharedValue::make(),
            'cells' => range(1, 8),
        ]);
    }
}
