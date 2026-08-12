<?php

return [
    /*
     * Published to config/native/desktop.php — NOT config/nativephp.php.
     *
     * The old name collides with nativephp/mobile, which publishes the same
     * filename, so an app could never install both. Namespacing per platform
     * is what makes a single package covering web, mobile and desktop
     * possible. Keys read as config('native.desktop.*').
     */

    'app_id' => env('NATIVEPHP_APP_ID', 'com.nativephp.desktop'),

    'version' => env('NATIVEPHP_APP_VERSION', '1.0.0'),

    /*
     * Which route file declares this app's windows. Loaded by the service
     * provider so a new convention doesn't become a manual bootstrap step.
     */
    'routes' => base_path('routes/desktop.php'),

    /*
     * The window opened at boot. Resolved through NativeRouter, so this is a
     * Route::native() path — the same string Window::url() takes.
     */
    'default_window' => '/inputs/event-channel',

    /*
     * Pinned rather than 'system' so a screenshot of a demo screen shows the same
     * thing on any Mac. Which value depends on what `default_window` points at,
     * because these screens are authored for one appearance each and nothing
     * repaints them for the other:
     *
     *  - The icon screens (/icons/*) paint themselves slate-900/950 and need
     *    'dark', or every AppKit-drawn control on a light-mode Mac comes out
     *    light on top of them: a dark-on-dark activity indicator, a white
     *    text_input.
     *  - The input screens (/inputs/*) use `theme-*` classes, which resolve
     *    light-by-default in config/native-ui.php, so they need 'light'. In
     *    'dark' they are legible except for the one thing being demonstrated:
     *    nativephp/mobile-ui's renderers colour their own text from
     *    `NativeUITheme.shared`, and nothing pushes a theme to it on desktop yet
     *    — its `NativeUI.Theme.Set` bridge function is an iOS registration, and
     *    the desktop plugin mechanism carries renderers only. So the store holds
     *    its light fallback while the surrounding tree is dark, and typed text
     *    comes out near-black on near-black.
     */
    'appearance' => 'light',
];
