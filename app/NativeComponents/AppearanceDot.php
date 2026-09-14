<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Attributes\On;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Events\System\AppearanceChanged;
use Native\Mobile\Facades\System;

/**
 * GRANDCHILD component (auto-discovered as <native:appearance-dot>), mounted
 * by AppearanceBadge. Its listener proves delivery walks the whole component
 * tree rather than stopping at the screen's direct children.
 */
class AppearanceDot extends NativeComponent
{
    public string $mode = 'light';

    /** How many times THIS grandchild received the event. */
    public int $received = 0;

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
        return view('native.appearance-dot');
    }
}
