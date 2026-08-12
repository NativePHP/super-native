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
    'default_window' => '/renderer-batch1',
];
