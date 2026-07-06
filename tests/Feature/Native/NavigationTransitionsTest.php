<?php

use App\NativeComponents\IkeaHome;
use Native\Mobile\Edge\Transition;
use Native\Mobile\Testing\Native;

// ── Named-route resolution + programmatic transitions (IkeaHome) ──

it('resolves a named route and carries a transition when opening a product', function () {
    Native::visit('/ikea')
        ->assertScreen(IkeaHome::class)
        ->assertNoNavigation()
        ->call('viewProduct', 3)
        ->assertNavigatedTo('/ikea/product/3')
        ->assertTransition(Transition::SlideFromRight);
});

it('resolves parameter-less named routes for the cart and search', function () {
    Native::visit('/ikea')
        ->call('viewCart')
        ->assertNavigatedTo('/ikea/cart')
        ->assertTransition(Transition::SlideFromRight);

    Native::visit('/ikea')
        ->call('viewSearch')
        ->assertNavigatedTo('/ikea/search')
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
