<?php

use App\NativeComponents\Desktop\Dashboard;
use App\NativeComponents\Desktop\RendererBatch1;
use App\NativeComponents\Desktop\Settings;
use App\NativeComponents\EventChannelTest;
use App\NativeComponents\ExploreButtons;
use App\NativeComponents\FacebookFeed;
use App\NativeComponents\IkeaCart;
use App\NativeComponents\TestLayout;
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

/*
 * Two more mobile demo screens, borrowed the same way and for the same reason —
 * this time to prove the plugin mechanism rather than a renderer the shell owns.
 *
 * Neither screen's text inputs are drawn by anything in this repo or in the
 * shell. `outlined_text_input` is defined by nativephp/mobile-ui, and the Swift
 * that draws it is mobile-ui's own — copied into the shell's Xcode project from
 * the `macos` section of its nativephp.json and registered from its `components`
 * table. So what appears here is the package's renderer, unmodified, compiled
 * for macOS: the same file an iPhone gets.
 *
 * Chosen because a text input was each one's *only* unrenderable element type,
 * verified by scanning their tags against NodeRenderer's cases. Between them:
 *
 *  - **event-channel-test** carries a `label` and, crucially, is uncontrolled —
 *    `@change` only. Every keystroke ships the whole field to PHP, which counts
 *    the bytes and renders the count back, so the number on screen IS the proof
 *    that the value arrived. A screen that merely echoed the field back could be
 *    showing local state.
 *  - **test-layout** is a chat composer: `placeholder`, an initial `value`, and
 *    `multiline`, sharing a row with icons so the field's flex sizing is visible.
 *
 * Still not a general registry bridge, and still not the start of one.
 */
Window::screen('/inputs/event-channel', EventChannelTest::class);
Window::screen('/inputs/composer', TestLayout::class);
