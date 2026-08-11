<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * The realistic full-screen case behind mobile-air #303 — the exact pattern
 * the issue described: "a short screen (like a login screen) whose content
 * sits centred on the page but can still scroll when the keyboard appears or
 * the content grows".
 *
 * Chrome-less on purpose, so the scroll view really is the full viewport and
 * the keyboard-avoidance behaviour is the honest one. See
 * [MasterclassScrollCenter] for the boxed, side-by-side version.
 */
class MasterclassScrollCenterLogin extends NativeComponent
{
    public string $email = '';

    public string $password = '';

    public function navTitle(): string
    {
        return 'Login — #303';
    }

    public function render(): View
    {
        return view('native.masterclass.scroll-center-login');
    }
}
