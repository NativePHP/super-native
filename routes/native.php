<?php

use App\NativeComponents\Counter;
use Illuminate\Support\Facades\Route;

/*
 * Screens shared by every surface this app is built for. Loaded by
 * supanative/core, so it is read whether the checkout has nativephp/mobile,
 * supanative/desktop, or both.
 *
 * Deliberately almost empty. The app's 88 screens stay in routes/web.php, and
 * the point being made here is that they did not have to move: `Route::native()`
 * is core's macro, so declaring a screen anywhere makes it a mobile route and a
 * desktop window at once. If moving them were the price of desktop seeing them,
 * nothing would have been fixed.
 *
 * One screen, then, to show the file works — the counter, at a second path. On
 * mobile /shared/counter is an HTTP route into the runloop like any other; on
 * desktop it is `Window::open('main', '/shared/counter')`. Same component, same
 * declaration, neither platform mentioned.
 */

Route::native('/shared/counter', Counter::class)->name('shared.counter');
