<?php

use App\NativeComponents\Desktop\Dashboard;
use App\NativeComponents\Desktop\RendererBatch1;
use App\NativeComponents\Desktop\Settings;
use SupaNative\Desktop\Facades\Window;

/*
 * Desktop screens. Declared with Window::screen() rather than Route::native():
 * that macro belongs to nativephp/mobile and builds an HTTP route around
 * mobile's runloop, and there is no HTTP server here. Both end up in the same
 * path→component registry in supanative/core.
 */

Window::screen('/', Dashboard::class);
Window::screen('/settings', Settings::class);
Window::screen('/renderer-batch1', RendererBatch1::class);
