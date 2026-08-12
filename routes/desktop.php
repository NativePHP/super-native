<?php

use App\NativeComponents\Desktop\Dashboard;
use App\NativeComponents\Desktop\RendererBatch1;
use App\NativeComponents\Desktop\Settings;
use SupaNative\Desktop\Facades\Window;

/*
 * Desktop-only screens.
 *
 * The interesting thing about this file now is how short it is. Every screen in
 * routes/web.php — all 88 of them — is already a desktop window's contents,
 * because `Route::native()` is supanative/core's macro and writes into the same
 * registry Window::screen() does. So the borrowed registrations that used to
 * live here (five mobile demo screens re-declared under /icons/* and /inputs/*
 * so desktop could see them at all) are gone: /ikea/cart, /facebook,
 * /explore/buttons, /event-channel-test and /layout-test open as themselves.
 *
 * What is left is the three screens that only exist for desktop.
 *
 * Dashboard is at /desktop rather than / on purpose: routes/web.php declares /
 * as the demo launcher, and two declarations of one path re-point it — last one
 * wins, and the Edge log says so. Keeping them apart means the launcher is the
 * app's front door on both platforms.
 */

Window::screen('/desktop', Dashboard::class);
Window::screen('/settings', Settings::class);
Window::screen('/renderer-batch1', RendererBatch1::class);
