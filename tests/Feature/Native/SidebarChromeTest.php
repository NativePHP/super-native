<?php

use App\Demos;
use App\NativeComponents\Counter;
use Native\Mobile\Testing\Native;
use SupaNative\Core\Edge\CallbackRegistry;
use SupaNative\Core\Edge\HostChrome;
use SupaNative\Core\Platform;
use SupaNative\Desktop\Edge\SidebarChrome;
use SupaNative\Desktop\Sidebar;

/*
 * The permanent desktop sidebar, and the core seam it rides on.
 *
 * Two invariants are worth a test each, and they pull in opposite directions.
 * The sidebar has to reach EVERY screen — that is the whole reason it stopped
 * being a Blade partial — and it must reach NO screen on a phone, where a
 * fixed 220pt column beside the content would eat two thirds of the window.
 */

beforeEach(function () {
    HostChrome::reset();
});

afterEach(function () {
    HostChrome::reset();
    Platform::set(null);
});

function demoSidebar(): SidebarChrome
{
    $chrome = new SidebarChrome;

    $chrome->set(
        Sidebar::make()
            ->header('SuperNative', 'Every demo')
            ->item('Counter', '/counter', 'plus.forwardslash.minus')
            ->group('Mini apps', fn (Sidebar $g) => $g->item('Spotify', '/spotify', 'music.note'))
    );

    return $chrome;
}

it('is absent until a host registers one', function () {
    // The seam's null case, which is also mobile's case forever: nothing calls
    // HostChrome::decorateWith() outside the desktop coordinator's run().
    expect(HostChrome::any())->toBeFalse();

    Platform::set(Platform::MACOS);

    expect(treeTypes(Native::test(Counter::class)->tree()))->not->toContain('side_nav');
});

it('puts the sidebar beside a screen that says nothing about it', function () {
    Platform::set(Platform::MACOS);
    HostChrome::decorateWith(demoSidebar());

    $tree = Native::test(Counter::class)->tree();

    // The screen's own Blade has no `<row>`, no `@desktop` block and no
    // include — the row is the decorator's, and the sidebar is its first child.
    expect($tree['type'])->toBe('row')
        ->and($tree['children'][0]['type'])->toBe('side_nav')
        ->and(treeTypes($tree))->toContain('side_nav_item', 'side_nav_group', 'side_nav_header');
});

it('never draws a sidebar on a phone, even if one is registered', function () {
    // Belt and braces: on a phone the desktop package is not installed and
    // nothing registers this decorator. Registering it anyway and asserting the
    // tree is unchanged makes that an invariant a test holds rather than a fact
    // about which packages happen to be in composer.json.
    Platform::set(Platform::IOS);
    HostChrome::decorateWith(demoSidebar());

    $phone = treeTypes(Native::test(Counter::class)->tree());

    expect($phone)->not->toContain('side_nav')
        ->and($phone)->not->toContain('side_nav_item');
});

it('marks the screen the window is showing as the active row', function () {
    $nav = Sidebar::make()
        ->item('Counter', '/counter')
        ->item('Spotify', '/spotify');

    $active = fn (string $uri) => collect($nav->build($uri)->toArray(new CallbackRegistry)['children'])
        ->filter(fn (array $row) => $row['props']['active'] ?? false)
        ->pluck('props.url')
        ->all();

    expect($active('/counter'))->toBe(['/counter'])
        ->and($active('/spotify'))->toBe(['/spotify'])
        // A window showing something not in the list highlights nothing, rather
        // than guessing at a prefix match and highlighting the wrong row.
        ->and($active('/twitter'))->toBe([]);
});

it('opens the group holding the current screen even when it was declared collapsed', function () {
    $nav = Sidebar::make()->group(
        'Mini apps',
        fn (Sidebar $g) => $g->item('Spotify', '/spotify'),
        expanded: false,
    );

    $expanded = fn (?string $uri) => $nav->build($uri)
        ->toArray(new CallbackRegistry)['children'][0]['props']['expanded'];

    expect($expanded('/spotify'))->toBeTrue()
        ->and($expanded('/counter'))->toBeFalse();
});

it('gives a second window the app-wide sidebar unless that window declares its own', function () {
    $chrome = demoSidebar();

    expect($chrome->for('main'))->not->toBeNull()
        ->and($chrome->for('settings'))->not->toBeNull();

    // An explicit null is not the same as never having been asked about: it is
    // how one window opts out of the sidebar every other window gets.
    $chrome->set(null, 'settings');

    expect($chrome->for('settings'))->toBeNull()
        ->and($chrome->for('main'))->not->toBeNull();
});

it('declares every demo the launcher screen shows, from the same list', function () {
    // The point of App\Demos: one list, two readers. If this fails, a demo has
    // been added to the sidebar or the launcher and not to the other.
    $declared = collect(Demos::groups())
        ->flatMap(fn (array $group) => collect($group['demos'])->pluck('url'))
        ->all();

    $nav = require_sidebar_urls();

    foreach ($declared as $url) {
        expect($nav)->toContain($url);
    }

    // 30 live demos across 4 groups (App\Demos also keeps a handful of retired
    // ones commented out). Asserted so a list that silently truncates — an
    // array key typo, a group that stopped being merged — fails here rather
    // than in a window where nobody notices the missing half.
    expect($declared)->toHaveCount(30);
});

/** Every url the app's real routes/desktop.php sidebar declaration points at. */
function require_sidebar_urls(): array
{
    $chrome = app(SidebarChrome::class);

    $urls = [];

    $walk = function (array $node) use (&$walk, &$urls) {
        if (isset($node['props']['url'])) {
            $urls[] = $node['props']['url'];
        }

        foreach ($node['children'] ?? [] as $child) {
            $walk($child);
        }
    };

    $walk($chrome->for('main')->build()->toArray(new CallbackRegistry));

    return $urls;
}
