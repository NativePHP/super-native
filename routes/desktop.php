<?php

use App\Demos;
use App\NativeComponents\Desktop\Dashboard;
use App\NativeComponents\Desktop\RendererBatch1;
use App\NativeComponents\Desktop\Settings;
use SupaNative\Desktop\Facades\Window;
use SupaNative\Desktop\Sidebar;

/*
 * Desktop-only screens, and the sidebar every window draws beside them.
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
 * app's front door on the phone, where a phone-sized list of demos is the right
 * front door. On a Mac the sidebar below is that list, permanently, so the
 * launcher screen is never opened here.
 */

Window::screen('/desktop', Dashboard::class);
Window::screen('/settings', Settings::class);
Window::screen('/renderer-batch1', RendererBatch1::class);

/*
 * The sidebar.
 *
 * Declared once, here, and drawn beside every screen in every window — see
 * SupaNative\Desktop\Edge\SidebarChrome for how, and for what it replaced (a
 * Blade partial each screen had to include, which reached 2 of 84 screens
 * before it became obvious that was the wrong shape).
 *
 * The list is App\Demos, which is also what the phone's launcher screen reads,
 * so there is exactly one place a new demo has to be added. Groups match the
 * launcher's sections and start expanded — a collapsed sidebar on a machine
 * with a 220pt column to spare is a click in the way of every navigation.
 */

Window::sidebar(
    collect(Demos::groups())
        ->reduce(
            fn (Sidebar $nav, array $group) => $nav->group(
                $group['title'],
                fn (Sidebar $section) => collect($group['demos'])->each(
                    fn (array $demo) => $section->item($demo['title'], $demo['url'], $demo['icon'])
                ),
            ),
            Sidebar::make()->header(config('app.name'), 'Every demo', 'square.grid.3x3')
        )
        ->divider()
        ->group('Desktop only', fn (Sidebar $section) => collect(Demos::desktopScreens())->each(
            fn (array $screen) => $section->item($screen['title'], $screen['url'], $screen['icon'])
        ))
);
