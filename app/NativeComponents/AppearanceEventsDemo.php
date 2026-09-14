<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Attributes\On;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Events\System\AppearanceChanged;
use Native\Mobile\Facades\System;

/**
 * SCREEN demonstrating that a native system event reaches #[On] listeners on
 * nested child components, not just the screen that owns the runloop
 * (mobile-air#341).
 *
 * The screen, its child (<native:appearance-badge>), and the grandchild that
 * child mounts each declare their own #[On(AppearanceChanged::class)]. Flip
 * the simulator between light and dark — every row must move together. Before
 * the fix only this screen's row updated.
 */
class AppearanceEventsDemo extends NativeComponent
{
    public string $mode = 'light';

    /** How many times this screen received the event. */
    public int $received = 0;

    public function navTitle(): string
    {
        return 'Appearance Events';
    }

    public function mount(): void
    {
        $this->mode = System::appearance();
    }

    #[On(AppearanceChanged::class)]
    public function onAppearanceChanged(string $mode): void
    {
        $this->mode = $mode;
        $this->received++;
    }

    public function render(): View
    {
        return view('native.appearance-events-demo');
    }
}
