<?php

namespace App\NativeComponents\Desktop;

use SupaNative\Core\Edge\Element;
use SupaNative\Core\Edge\Elements\Column;
use SupaNative\Core\Edge\Elements\Pressable;
use SupaNative\Core\Edge\Elements\Spacer;
use SupaNative\Core\Edge\Elements\Text;
use SupaNative\Core\Edge\NativeComponent;

/**
 * A second window with its own component instance and its own state.
 *
 * Nothing here knows it isn't the main window. That is the point: the surface a
 * component publishes to is bound from outside, so a screen is written the same
 * way whichever window ends up showing it.
 */
class Settings extends NativeComponent
{
    public int $clicks = 0;

    public bool $dark = true;

    public function bump(): void
    {
        $this->clicks++;
    }

    public function toggleTheme(): void
    {
        $this->dark = ! $this->dark;
    }

    /**
     * Ask to be closed rather than closing the window directly — the coordinator
     * notices the component has stopped and takes its window with it, which is
     * the same path the main window's Quit button uses.
     */
    public function close(): void
    {
        $this->stop();
    }

    public function render(): Element
    {
        $heading = $this->dark ? 'text-white' : 'text-slate-900';
        $muted = $this->dark ? 'text-slate-400' : 'text-slate-500';

        return Column::make(
            Column::make(
                Text::make('Settings')->class("text-xl font-bold {$heading}"),
                Text::make('A separate surface, on surface '.$this->surfaceId().'.')->class("text-xs {$muted}"),
            )->class('gap-1'),

            Column::make(
                Text::make('CLICKS IN THIS WINDOW')->class("text-xs font-semibold {$muted}"),
                Text::make((string) $this->clicks)->class('text-4xl font-bold text-emerald-400'),
                Pressable::make(
                    Text::make('Click me')->class('text-sm font-semibold text-white'),
                )->class('px-4 py-2 rounded bg-emerald-600')->onPress('bump'),
            )->class('w-full rounded-xl p-5 gap-3 '.($this->dark ? 'bg-slate-900' : 'bg-white')),

            Pressable::make(
                Text::make($this->dark ? 'Switch to light' : 'Switch to dark')
                    ->class("text-sm font-semibold {$heading}"),
            )->class('px-4 py-2 rounded '.($this->dark ? 'bg-slate-800' : 'bg-slate-300'))
                ->onPress('toggleTheme'),

            Spacer::make(),

            Pressable::make(
                Text::make('Close this window')->class('text-sm font-semibold text-white'),
            )->class('px-4 py-2 rounded bg-rose-700')->onPress('close'),
        )->class('w-full h-full p-7 gap-5 '.($this->dark ? 'bg-slate-950' : 'bg-slate-100'));
    }
}
