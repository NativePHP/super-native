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
     * The window opened at boot. Resolved through supanative/core's shared screen
     * registry, so this is any path the app declared — a Route::native() one from
     * routes/web.php or routes/native.php, or a Window::screen() one from
     * routes/desktop.php. `/` is the demo launcher, declared in routes/web.php
     * for the phone build and opened here without a desktop registration.
     */
    'default_window' => '/',

    /*
     * Pinned rather than 'system' so a screenshot of a demo screen shows the same
     * thing on any Mac.
     *
     * 'light' because every screen now reachable as a window was authored for a
     * phone, and there are 80 of them: no single value suits them all. Roughly
     * half paint their own background — the Spotify, Twitter and X-style screens
     * are near-black by design — and those look right in either setting because
     * they never ask AppKit for a colour. What breaks under 'dark' is the other
     * half, which leave the background to the host and expect dark ink on it.
     *
     * The screens with their own dark background *and* `theme-*` text are the ones
     * that read badly whichever way this is set: their labels resolve
     * light-by-default from config/native-ui.php while sitting on their own
     * near-black, so the text is dark-on-dark. /explore/forms is the clearest
     * case. Fixing it means pushing a theme to the plugin's renderers on desktop,
     * which nothing does yet — `NativeUI.Theme.Set` is an iOS registration, and
     * the desktop plugin mechanism carries renderers only.
     */
    'appearance' => 'light',
];
