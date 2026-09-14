<?php

namespace App\NativeComponents;

use App\Support\DemoSession;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * SCREEN demonstrating that `Route::native()->middleware()` runs on in-app
 * navigation, not just cold start (mobile-air#252).
 *
 * This screen is UNGUARDED — it's the hub you navigate from. `/middleware-demo/secret`
 * sits behind DemoAuth. Tap through while signed out and the middleware
 * redirects you to the login screen; sign in and the same tap lands on the
 * secret screen. Before the fix, the tap always went straight through.
 */
class MiddlewareDemo extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Route Middleware';
    }

    public function signOut(): void
    {
        DemoSession::signOut();
    }

    public function clearLog(): void
    {
        DemoSession::clearLog();
    }

    public function render(): View
    {
        return view('native.middleware-demo', [
            'signedIn' => DemoSession::signedIn(),
            'log' => DemoSession::log(),
        ]);
    }
}
