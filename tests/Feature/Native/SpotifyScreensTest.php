<?php

use App\NativeComponents\SpotifyArtist;
use App\NativeComponents\SpotifyHome;
use App\NativeComponents\SpotifyPlaylist;
use App\NativeComponents\SpotifySearch;
use Native\Mobile\Testing\Native;

/**
 * Guards the four Spotify demo screens. Besides render + interaction
 * coverage, screens are swept for the stack renderer inset trap: both
 * native stack renderers read a zero bottom/right inset as "unset" and
 * pin the child to the top/left, so an absolute overlay must never
 * position itself with only zero insets.
 */
it('renders the home screen and navigates to search', function () {
    Native::visit('/spotify')
        ->assertScreen(SpotifyHome::class)
        ->assertSee('Made For You')
        ->press('viewSearch')
        ->assertNavigatedTo('/spotify/search');
});

it('navigates from home to a playlist and an artist', function () {
    Native::visit('/spotify')
        ->press('viewPlaylist(0)')
        ->assertNavigatedTo('/spotify/playlist/0');

    Native::visit('/spotify')
        ->press('viewArtist(1)')
        ->assertNavigatedTo('/spotify/artist/1');
});

it('renders the playlist page with its tracks', function () {
    Native::visit('/spotify/playlist/0')
        ->assertScreen(SpotifyPlaylist::class)
        ->assertSee('songs')
        ->press('back')
        ->assertWentBack();
});

it('renders the artist page and toggles follow', function () {
    Native::visit('/spotify/artist/0')
        ->assertScreen(SpotifyArtist::class)
        ->assertSee('monthly listeners')
        ->assertSee('Popular')
        ->press('toggleFollow')
        ->assertSet('isFollowing', true)
        ->assertSee('Following');
});

it('navigates back from the home top bar', function () {
    Native::visit('/spotify')
        ->press('back')
        ->assertWentBack();
});

it('navigates back from the artist floating back button', function () {
    Native::visit('/spotify/artist/0')
        ->press('back')
        ->assertWentBack();
});

it('renders the search screen with genres and artists', function () {
    Native::visit('/spotify/search')
        ->assertScreen(SpotifySearch::class)
        ->assertSee('Browse all')
        ->assertSee('Popular artists');
});

it('never pins an absolute overlay with only zero insets', function (string $uri) {
    $tree = Native::visit($uri)->tree();

    $absolutes = [];
    $walk = function (array $node) use (&$walk, &$absolutes): void {
        if (($node['layout']['position_type'] ?? 0) === 1) {
            $absolutes[] = $node;
        }
        foreach ($node['children'] ?? [] as $child) {
            $walk($child);
        }
    };
    $walk($tree);

    foreach ($absolutes as $node) {
        // position = [top, right, bottom, left]
        $position = $node['layout']['position'] ?? [0, 0, 0, 0];
        expect(array_sum(array_map('abs', $position)))->toBeGreaterThan(
            0,
            "Absolute {$node['type']} on {$uri} has all-zero insets — the stack renderers will pin it to the top-left."
        );
    }

    expect(true)->toBeTrue();
})->with([
    '/spotify',
    '/spotify/playlist/0',
    '/spotify/artist/0',
    '/spotify/search',
]);
