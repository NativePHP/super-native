<?php

use App\NativeComponents\SpotifyHome;
use Native\Mobile\Edge\Transition;
use Native\Mobile\Testing\Native;

// ── Named-route resolution + programmatic transitions (SpotifyHome) ──

it('resolves a named route and carries a transition when opening a playlist', function () {
    Native::visit('/spotify')
        ->assertScreen(SpotifyHome::class)
        ->assertNoNavigation()
        ->call('viewPlaylist', 3)
        ->assertNavigatedTo('/spotify/playlist/3')
        ->assertTransition(Transition::SlideFromRight);
});

it('resolves parameter-less named routes for search', function () {
    Native::visit('/spotify')
        ->call('viewSearch')
        ->assertNavigatedTo('/spotify/search')
        ->assertTransition(Transition::SlideFromRight);
});

// ── @navigate.<transition> directive path (TransitionsDemo) ──

it('pushes with the slide-from-bottom transition via @navigate', function () {
    Native::visit('/transitions')
        ->tap('Slide from Bottom')
        ->assertNavigatedTo('/transitions/detail')
        ->assertTransition(Transition::SlideFromBottom);
});

it('pushes with the parallax transition via @navigate', function () {
    Native::visit('/transitions')
        ->tap('Parallax Push')
        ->assertNavigatedTo('/transitions/detail')
        ->assertTransition(Transition::ParallaxPush);
});
