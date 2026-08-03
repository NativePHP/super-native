<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Date & time picker demo — every mode, style, bound, and i18n knob on one
 * screen, plus a live readout of the raw wire value so the wall-clock ISO
 * contract is visible rather than implied.
 */
class ExplorePickers extends NativeComponent
{
    /** Pre-filled so the trigger renders a value on first paint. */
    public string $date = '2026-07-25';

    public string $time = '09:30';

    public string $datetime = '2026-07-25T09:30';

    /** Starts empty to exercise the placeholder path on both platforms. */
    public string $empty = '';

    /** Bounded to a single month — tests min/max clamping. */
    public string $bounded = '2026-07-15';

    /** Business timezone + German display, to prove locale never moves the value. */
    public string $berlin = '2026-07-25T14:00';

    public string $inlineDate = '2026-07-25';

    public string $wheelTime = '18:45';

    public string $disabled = '2026-01-01';

    /** Last @change payload, echoed back verbatim. */
    public string $lastEvent = '—';

    public function navTitle(): string
    {
        return 'Date & Time Pickers';
    }

    public function noteChange(string $value): void
    {
        $this->lastEvent = $value === '' ? '(cleared)' : $value;
    }

    public function render(): View
    {
        return view('native.explore.pickers');
    }
}
