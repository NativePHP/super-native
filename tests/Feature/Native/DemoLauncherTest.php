<?php

use App\NativeComponents\DemoLauncher;
use Native\Mobile\Testing\Native;

it('shows every demo group on mount', function () {
    $screen = Native::visit('/')
        ->assertScreen(DemoLauncher::class)
        ->assertNavTitle('SuperNative Demo')
        ->assertSee('Counter')
        ->assertSee('Webview')
        ->assertSee('Twitter / X');

    expect($screen->get('groups'))->toHaveCount(4);
});

it('filters the demo list by search query', function () {
    $screen = Native::test(DemoLauncher::class)
        ->call('findADemo', 'counter')
        ->assertSee('Counter')
        ->assertDontSee('Twitter / X');

    expect(array_column($screen->get('groups'), 'title'))
        ->toContain('Fundamentals')
        ->not->toContain('Mini Apps');
});

it('drops groups with no matching demos', function () {
    $screen = Native::test(DemoLauncher::class)
        ->call('findADemo', 'spotify');

    expect(array_column($screen->get('groups'), 'title'))->toBe(['Mini Apps']);
});

it('restores the full list when the query is cleared', function () {
    $screen = Native::test(DemoLauncher::class)
        ->call('findADemo', 'spotify')
        ->call('findADemo', '');

    expect($screen->get('groups'))->toHaveCount(4);
});

it('restores the full list when resuming from a pushed demo', function () {
    $screen = Native::test(DemoLauncher::class)
        ->call('findADemo', 'counter')
        ->call('onResume');

    expect($screen->get('groups'))->toHaveCount(4);
});
