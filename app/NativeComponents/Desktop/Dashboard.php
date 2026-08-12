<?php

namespace App\NativeComponents\Desktop;

use SupaNative\Core\Edge\Element;
use SupaNative\Core\Edge\Elements\Column;
use SupaNative\Core\Edge\Elements\Pressable;
use SupaNative\Core\Edge\Elements\Row;
use SupaNative\Core\Edge\Elements\Spacer;
use SupaNative\Core\Edge\Elements\Text;
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
 * Built with the element builders rather than a Blade view on purpose: the
 * `<native:*>` Blade precompiler is registered by nativephp/mobile's service
 * provider against mobile's own collector, so a core-based component's Blade
 * render collects into the wrong place and publishes an empty tree. Programmatic
 * elements go through core's own path and are unaffected. Blade for desktop
 * screens needs that registration to move into core (or mobile's core-based
 * refactor to land) first.
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

    public function render(): Element
    {
        return Column::make(
            Column::make(
                Text::make(config('app.name').' — desktop')->class('text-2xl font-bold text-white'),
                Text::make(sprintf(
                    'Laravel %s on PHP %s, %d surface(s) live.',
                    app()->version(),
                    PHP_VERSION,
                    // Guarded so the screen can also be rendered by a plain
                    // `php artisan` process, where there is no extension.
                    function_exists('nativephp_surface_count') ? nativephp_surface_count() : 0,
                ))->class('text-sm text-slate-400'),
            )->class('gap-1'),

            $this->card('COUNTER — this window\'s own state', [
                Text::make((string) $this->count)->class('text-5xl font-bold text-indigo-400'),
                Row::make(
                    $this->button('−', 'decrement', 'bg-slate-800'),
                    $this->button('+', 'increment', 'bg-indigo-600'),
                )->class('gap-3'),
            ]),

            $this->card('WINDOWS — one process, one event loop', [
                Row::make(
                    $this->button('Open settings window', 'openSettings', 'bg-emerald-600'),
                    $this->button('Close it', 'closeSettings', 'bg-slate-800'),
                )->class('gap-3'),
                ...array_map(
                    fn (string $key, int $surface) => Text::make("{$key} → surface {$surface}")
                        ->class('text-xs text-slate-400'),
                    array_keys(Window::all()),
                    array_values(Window::all()),
                ),
            ]),

            Spacer::make(),

            Row::make(
                $this->button('Quit', 'quit', 'bg-rose-700'),
                Text::make('Last action: '.$this->last)->class('text-xs text-slate-500'),
            )->class('gap-3 items-center'),
        )->class('w-full h-full bg-slate-950 p-8 gap-6');
    }

    /** @param  Element[]  $children */
    protected function card(string $heading, array $children): Element
    {
        return Column::make(
            Text::make($heading)->class('text-xs font-semibold text-slate-400'),
            ...$children,
        )->class('w-full bg-slate-900 rounded-xl p-6 gap-4');
    }

    protected function button(string $label, string $method, string $background): Element
    {
        return Pressable::make(
            Text::make($label)->class('text-base font-semibold text-white'),
        )->class("px-5 py-2 rounded {$background}")->onPress($method);
    }
}
