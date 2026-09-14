<?php

namespace App\NativeComponents;

use App\Support\DemoSession;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Where DemoAuth's redirect lands. The middleware returns
 * `redirect('/middleware-demo/login')`; because that path IS a native route,
 * the guard turns it into an in-app REPLACE rather than dropping the user out
 * to the WebView.
 */
class MiddlewareDemoLogin extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Sign In';
    }

    public function mount(): void
    {
        DemoSession::record('Redirected to login');
    }

    public function signIn(): void
    {
        DemoSession::signIn();
        $this->replace('/middleware-demo/secret');
    }

    public function render(): View
    {
        return view('native.middleware-demo-login', [
            'log' => DemoSession::log(),
        ]);
    }
}
