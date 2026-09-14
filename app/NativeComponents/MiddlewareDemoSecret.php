<?php

namespace App\NativeComponents;

use App\Support\DemoSession;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * The GUARDED screen. Its route carries ->middleware(DemoAuth::class).
 *
 * mount() records that it ran, which is the load-bearing part of the demo:
 * when the middleware refuses, this line must never appear in the log. The
 * guard runs before mount(), so a refused screen does none of its data
 * loading and paints no frame.
 */
class MiddlewareDemoSecret extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Members Only';
    }

    public function mount(): void
    {
        DemoSession::record('MiddlewareDemoSecret::mount() ran');
    }

    public function render(): View
    {
        return view('native.middleware-demo-secret', [
            'log' => DemoSession::log(),
        ]);
    }
}
