<?php

use App\NativeComponents\Counter;
use Native\Mobile\Events\Camera\PhotoTaken;
use Native\Mobile\Testing\Native;

/**
 * The ramp, as PHP sees it: the five `speed` values a `@hold` event can carry
 * and how many events carry each one over the first eleven seconds. The
 * renderer owns the cadence — this is only what arrives.
 *
 * A list of pairs rather than a `speed => events` map on purpose: PHP casts a
 * float array key to an int, so all five would collapse onto 0.
 *
 * @return list<array{float, int}>
 */
function holdRamp(): array
{
    return [[0.0625, 5], [0.125, 4], [0.25, 8], [0.5, 16], [1.0, 1]];
}

it('starts at zero with the Counter nav title', function () {
    Native::visit('/counter')
        ->assertScreen(Counter::class)
        ->assertSet('count', 0)
        ->assertSet('photo', '')
        ->assertSet('holding', null)
        ->assertNavTitle('Counter');
});

it('renders the count with the numeric content transition', function () {
    $screen = Native::test(Counter::class);

    expect(json_encode($screen->tree()))->toContain('"content_transition":"numeric"');
});

it('publishes on_hold and on_release on both buttons', function () {
    // The wire half of the contract: `@hold` / `@release` reach the renderer as
    // props, alongside nothing else new — no wire-format change was needed.
    $wire = json_encode(Native::test(Counter::class)->tree());

    expect($wire)->toContain('"on_hold"')->toContain('"on_release"');

    // One per button, and the two holds are distinct because their expressions
    // differ ('up' vs 'down'); the two releases are the same expression and so
    // deliberately the same callback id.
    expect(substr_count($wire, '"on_hold"'))->toBe(2);
    expect(substr_count($wire, '"on_release"'))->toBe(2);
});

it('steps once on a quick tap, in both directions', function () {
    // A tap is one `@hold` at stage 1's speed followed by `@release` — which is
    // the whole reason the first event fires on contact rather than on the first
    // tick of the timer.
    Native::test(Counter::class)
        ->call('hold', 'up', 0.0625)
        ->call('release')
        ->assertSet('count', 1)
        ->assertSet('holding', null)
        ->call('hold', 'down', 0.0625)
        ->call('release')
        ->assertSet('count', 0);
});

it('marks the held button and clears it on release', function () {
    Native::test(Counter::class)
        ->call('hold', 'up', 0.0625)
        ->assertSet('holding', 'up')
        ->call('release')
        ->assertSet('holding', null)
        ->call('hold', 'down', 0.0625)
        ->assertSet('holding', 'down')
        ->call('release')
        ->assertSet('holding', null);
});

it('steps 1, 2, 4, 8, 16 as speed ramps', function () {
    $screen = Native::test(Counter::class);

    foreach ([[0.0625, 1], [0.125, 3], [0.25, 7], [0.5, 15], [1.0, 31]] as [$speed, $running]) {
        $screen->call('hold', 'up', $speed)->assertSet('count', $running);
    }
});

it('counts down at the same speeds', function () {
    $screen = Native::test(Counter::class);

    foreach (holdRamp() as [$speed]) {
        $screen->call('hold', 'down', $speed);
    }

    $screen->assertSet('count', -(1 + 2 + 4 + 8 + 16));
});

it('reaches 189 over an eleven-second hold', function () {
    // The event sequence the renderer posts in the first 11 seconds, asserted
    // against the same figure tests/hold_ramp.swift asserts in the shell: 5
    // events at 1/16, 4 at 1/8, 8 at 1/4, 16 at 1/2, then the one that opens
    // full speed. The two halves of the contract agree on the number.
    $screen = Native::test(Counter::class);

    foreach (holdRamp() as [$speed, $events]) {
        foreach (range(1, $events) as $ignored) {
            $screen->call('hold', 'up', $speed);
        }
    }

    $screen->assertSet('count', 189);
});

it('stops counting once released', function () {
    // Nothing to disarm — a released hold simply stops arriving. What this
    // proves is the inverse: no poll is left running to keep stepping.
    $screen = Native::test(Counter::class)
        ->call('hold', 'up', 1.0)
        ->call('release')
        ->assertSet('count', 16);

    $screen->assertSet('count', 16);
});

it('receives speed as a float through the wire event', function () {
    // The real dispatch path rather than a direct method call. A `@hold` rides
    // the SLIDER_CHANGE event (type 9), whose payload is the one f32 the
    // extension exposes as `value`, and core's dispatch hands that to the
    // handler as its next argument — which is what makes `speed` work with no
    // change to the C extension at all.
    Native::test(Counter::class)
        ->fireEvent("hold('up')", 9, ['value' => 0.5])
        ->assertSet('count', 8)
        ->assertSet('holding', 'up')
        ->fireEvent('release', 0)
        ->assertSet('holding', null)
        ->assertSet('count', 8);
});

it('calls a hold handler that declares no speed parameter', function () {
    // Half the contract is that a handler may ignore `speed` entirely and just
    // count events. `release()` takes no parameter, so firing a hold-shaped
    // event (type 9, carrying a float) at its callback id is the precise test of
    // that: PHP ignores surplus positional arguments to a userland function, so
    // the handler runs rather than raising ArgumentCountError.
    Native::test(Counter::class)
        ->call('hold', 'up', 1.0)
        ->assertSet('holding', 'up')
        ->fireEvent('release', 9, ['value' => 0.5])
        ->assertSet('holding', null);
});

it('captures a photo through the camera bridge', function () {
    Native::test(Counter::class)
        ->call('testCamera')
        ->assertNativeCalled('Camera.GetPhoto')
        ->assertAwaitingNativeEvent(PhotoTaken::class)
        ->emitNative(PhotoTaken::class, ['path' => '/tmp/photo.jpg'])
        ->assertSet('photo', '/tmp/photo.jpg')
        ->assertNotAwaitingNativeEvent(PhotoTaken::class);
});
