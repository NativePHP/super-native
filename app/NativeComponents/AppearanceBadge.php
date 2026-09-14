<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Attributes\On;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Events\System\AppearanceChanged;
use Native\Mobile\Facades\System;

/**
 * CHILD component (auto-discovered as <native:appearance-badge>) with its own
 * #[On(AppearanceChanged::class)]. Mounts <native:appearance-dot> so the same
 * delivery is proven a second level down.
 */
class AppearanceBadge extends NativeComponent
{
    /** Prop assigned from the mounting tag. */
    public string $label = 'Child';

    public string $mode = 'light';

    /** How many times THIS child received the event. */
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
        return view('native.appearance-badge');
    }
}
