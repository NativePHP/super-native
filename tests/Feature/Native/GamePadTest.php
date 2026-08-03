<?php

use App\NativeComponents\GamePad;
use Native\Mobile\Testing\Native;

it('boots centered and idle with the Game Pad nav title', function () {
    Native::visit('/game-pad')
        ->assertScreen(GamePad::class)
        ->assertSet('x', 0.0)
        ->assertSet('y', 0.0)
        ->assertSet('moving', null)
        ->assertSet('shieldRaised', false)
        ->assertSet('firing', false)
        ->assertNavTitle('Game Pad');
});

it('moves while a d-pad button is held and stops when it lifts', function () {
    $screen = Native::test(GamePad::class)
        ->pressDown("startMove('right')")
        ->assertSet('moving', 'right')
        ->assertSet('facing', 'right')
        ->call('tick')
        ->call('tick');

    $heldX = $screen->get('x');
    expect($heldX)->toBeGreaterThan(0.0);

    $screen->pressUp('stopMove')
        ->assertSet('moving', null)
        ->call('tick')
        ->assertSet('x', $heldX);
});

it('clamps the character at the arena wall', function () {
    $screen = Native::test(GamePad::class)->pressDown("startMove('down')");

    foreach (range(1, 40) as $i) {
        $screen->call('tick');
    }

    $screen->assertSet('y', (GamePad::ARENA - GamePad::PLAYER_SIZE) / 2);
});

it('raises the shield only while the button is held', function () {
    Native::test(GamePad::class)
        ->pressDown('raiseShield')
        ->assertSet('shieldRaised', true)
        ->pressUp('lowerShield')
        ->assertSet('shieldRaised', false);
});

it('auto-fires while the fire button is held', function () {
    $screen = Native::test(GamePad::class)
        ->pressDown('startFire')
        ->assertSet('firing', true);

    expect($screen->get('shots'))->toHaveCount(1);

    // Three ticks = one cooldown cycle → a second shot spawns.
    $screen->call('tick')->call('tick')->call('tick');
    expect($screen->get('nextShotId'))->toBe(3);

    $screen->pressUp('stopFire')->assertSet('firing', false);
});

it('shots fly to the facing wall, score a hit, and the flash decays', function () {
    $screen = Native::test(GamePad::class)
        ->pressDown('startFire')
        ->pressUp('stopFire');

    // Default facing is up — tick until the shot crosses the top wall.
    foreach (range(1, 10) as $i) {
        $screen->call('tick');
    }

    $screen->assertSet('shots', [])
        ->assertSet('wallHits', 1)
        ->assertSet('flashingWall', null);
});

it('flags the hit wall for a few ticks before clearing', function () {
    $screen = Native::test(GamePad::class)
        ->pressDown("startMove('left')")
        ->pressUp('stopMove')
        ->pressDown('startFire')
        ->pressUp('stopFire');

    // 26pt per tick from just left of center → left wall inside 7 ticks.
    $flashed = false;
    foreach (range(1, 10) as $i) {
        $screen->call('tick');
        if ($screen->get('flashingWall') === 'left') {
            $flashed = true;
        }
    }

    expect($flashed)->toBeTrue();
    $screen->assertSet('flashingWall', null)->assertSet('wallHits', 1);
});
