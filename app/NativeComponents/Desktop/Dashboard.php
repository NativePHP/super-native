<?php

namespace App\NativeComponents\Desktop;

use Illuminate\View\View;
use SupaNative\Core\Edge\NativeComponent;
use SupaNative\Desktop\Exceptions\SurfaceLimitExceeded;
use SupaNative\Desktop\Facades\Window;

/**
 * The main window. A real Laravel component, rendered as native macOS views.
 *
 * Extends core's NativeComponent, not mobile's. Mobile's subclass adds chrome —
 * nav bars, tab bars, the hardware back button — which a desktop window doesn't
 * have, and the macOS renderer would lay those nodes out as plain columns.
 *
 * Rendered from a Blade view — `resources/views/native/desktop/dashboard.blade.php`
 * — with the same `<native:*>` tags a mobile screen uses. That works because the
 * precompiler is registered by supanative/core's provider, so the compiled view
 * calls core's collector, which is the one this component reads. It used to be
 * mobile's registration against mobile's own collector, and a core-based screen
 * published an empty tree.
 */
class Dashboard extends NativeComponent
{
    public int $count = 0;

    public string $last = 'nothing yet';

    public function mount(): void
    {
        //
    }

    public function increment(): void
    {
        $this->count++;
        $this->last = 'increment on surface '.$this->surfaceId();
    }

    public function decrement(): void
    {
        $this->count--;
        $this->last = 'decrement on surface '.$this->surfaceId();
    }

    public function openSettings(): void
    {
        try {
            $this->last = 'opened settings on surface '.Window::open('settings');
        } catch (SurfaceLimitExceeded $e) {
            // Which is what the exception is for: the app decides what happens
            // next rather than the window silently not appearing.
            $this->last = 'no free surface — '.$e->getMessage();
        }
    }

    public function closeSettings(): void
    {
        $this->last = Window::close('settings') ? 'closed settings' : 'settings was not open';
    }

    public function quit(): void
    {
        $this->stop();
    }

    public function render(): View
    {
        return view('native.desktop.dashboard', [
            'windows' => Window::all(),
            // Guarded so the screen can also be rendered by a plain
            // `php artisan` process, where there is no extension.
            'surfaces' => function_exists('nativephp_surface_count') ? nativephp_surface_count() : 0,
        ]);
    }
}
