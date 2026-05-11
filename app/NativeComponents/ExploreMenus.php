<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

/**
 * Showcase for tap-to-open dropdown menus attached via `:menu` (on
 * Pressable / Button) and `:trailing-menu` (on ListItem). Reuses the
 * `NavAction` builder that NavBar / TopBar actions already use, so the
 * vocabulary (`->divider()`, `->destructive()`, `->icon(sf:, material:)`)
 * is the same across nav-chrome menus and in-content menus.
 *
 * Each handler logs the selection into `$lastAction`, echoed at the
 * bottom of the screen so you can see which item fired without bouncing
 * to logcat / Console.
 */
class ExploreMenus extends NativeComponent
{
    public string $lastAction = '';

    public function navTitle(): string
    {
        return 'Menus';
    }

    // ── Pressable menu items ──

    public function logRecord(): void   { $this->lastAction = 'Pressable menu → Record audio'; }
    public function logUpload(): void   { $this->lastAction = 'Pressable menu → Upload file'; }
    public function logSettings(): void { $this->lastAction = 'Pressable menu → Audio settings'; }

    // ── Button menu items ──

    public function logExportPdf(): void { $this->lastAction = 'Button menu → Export as PDF'; }
    public function logExportCsv(): void { $this->lastAction = 'Button menu → Export as CSV'; }
    public function logPrint(): void     { $this->lastAction = 'Button menu → Print'; }

    // ── ListItem trailing-menu items ──

    public function logMarkRead(): void { $this->lastAction = 'List row menu → Mark as read'; }
    public function logMute(): void     { $this->lastAction = 'List row menu → Mute notifications'; }
    public function logArchive(): void  { $this->lastAction = 'List row menu → Archive'; }
    public function logDelete(): void   { $this->lastAction = 'List row menu → Delete'; }

    public function render(): \Illuminate\View\View
    {
        return view('explore.menus');
    }
}
