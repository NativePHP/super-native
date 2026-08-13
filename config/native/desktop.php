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
     * routes/desktop.php.
     *
     * Deliberately NOT `/`. That path is the demo launcher: a scrolling list of
     * every demo, which is the right front door on a phone and redundant on a
     * Mac, where routes/desktop.php declares the same list as a permanent
     * sidebar. Opening it here would mean a window whose sidebar and whose
     * content were the same list, twice.
     *
     * /counter because a first screen should be the simplest thing that proves
     * the app is alive, and it is also the screen the newest work needs a human
     * for: `@hold` / `@release`, whose whole point is a ramp only a real press
     * produces, and the padded ± buttons, where a click landing anywhere but on
     * the icon proves the hit area covers the padding. Every other demo is one
     * click away in the sidebar.
     */
    'default_window' => '/counter',

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
     * The dark-on-dark screens are fixed, and this setting was never the cause.
     * The shell was painting a hardcoded near-black (#0B0B11) behind any tree that
     * did not paint its own background — in a window whose declared appearance is
     * 'light', from which PHP had already resolved every `theme-*` colour on the
     * screen. So navy-on-near-black text was the light theme sitting on a dark
     * page, and no theme could have agreed with a background nothing had told it
     * about. The shell now uses the platform's own window background, which
     * follows the appearance the app declared. /explore/forms was the clearest
     * case and reads correctly at either setting now.
     */
    'appearance' => 'light',
];
