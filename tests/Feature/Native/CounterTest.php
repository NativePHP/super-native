<?php

use App\NativeComponents\Counter;
use Native\Mobile\Testing\Native;

it('starts at zero with the Counter nav title', function () {
    Native::visit('/counter')
        ->assertScreen(Counter::class)
        ->assertSet('count', 0)
        ->assertNavTitle('Counter');
});

it('renders the count with the numeric content transition', function () {
    $screen = Native::test(Counter::class);

    expect(json_encode($screen->tree()))->toContain('"content_transition":"numeric"');
});

it('steps once per tap in both directions', function () {
    Native::test(Counter::class)
        ->call('startHold', 'up')
        ->call('stopHold')
        ->assertSet('count', 1)
        ->call('startHold', 'up')
        ->call('stopHold')
        ->assertSet('count', 2)
        ->call('startHold', 'down')
        ->call('stopHold')
        ->assertSet('count', 1)
        ->assertSet('holding', null);
});

it('repeats while held and stops on release', function () {
    $screen = Native::test(Counter::class)
        ->call('startHold', 'up')
        ->assertSet('count', 1)
        ->assertSet('holding', 'up');

    foreach (range(1, 5) as $i) {
        $screen->call('holdTick');
    }

    $screen->assertSet('count', 6)
        ->call('stopHold')
        ->call('holdTick')
        ->call('holdTick')
        ->assertSet('count', 6);
});

it('accelerates the longer the hold runs', function () {
    $screen = Native::test(Counter::class)->call('startHold', 'up');

    foreach (range(1, 30) as $i) {
        $screen->call('holdTick');
    }

    // 8 ticks × 1 + 17 ticks × 2 + 5 ticks × 5 + the initial press step
    $screen->assertSet('count', 1 + 8 + 34 + 25);
});

it('ignores hold ticks when nothing is held', function () {
    Native::test(Counter::class)
        ->call('holdTick')
        ->call('holdTick')
        ->assertSet('count', 0);
});
