<?php

use App\NativeComponents\Desktop\Dashboard;
use App\NativeComponents\Desktop\RendererBatch1;
use App\NativeComponents\Desktop\Settings;
use App\NativeComponents\ExploreButtons;
use App\NativeComponents\FacebookFeed;
use App\NativeComponents\IkeaCart;
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

/*
 * Three of the mobile demo screens, borrowed to prove the `icon` renderer.
 *
 * These are ordinary `Route::native()` screens in routes/web.php — which desktop
 * does not read, deliberately, since that macro builds an HTTP route around
 * mobile's runloop. Registering them here by hand is the whole bridge: the
 * component classes are unmodified, so what draws is the same tree an iPhone
 * gets, which is the only way to tell whether the icon mapping is right rather
 * than merely present.
 *
 * Chosen because `icon` was their *only* unrenderable element type — verified by
 * scanning each view's tags against NodeRenderer's cases — so anything missing
 * on screen is this renderer's doing and not a second gap standing in for it.
 * Between them they cover the three resolution paths: shared Material names
 * (`arrow_back`, `delete_outline`, `photo_library`, `mood`), a name already in SF
 * form (`arrow.right`), and the icon *slots* on another element (a button's
 * leading and trailing icons, which resolve through `SymbolIcon`).
 *
 * Not a general registry bridge, and not the start of one — mobile's 85 screens
 * reaching desktop is its own design question.
 */
Window::screen('/icons/ikea-cart', IkeaCart::class);
Window::screen('/icons/facebook', FacebookFeed::class);
Window::screen('/icons/buttons', ExploreButtons::class);
