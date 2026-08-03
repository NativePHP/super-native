<?php

use App\NativeComponents\NumberSwitcherDemo;
use Native\Mobile\Testing\Native;

it('mounts with the seed value and numeric transition props', function () {
    $screen = Native::test(NumberSwitcherDemo::class)
        ->assertSet('value', 1024)
        ->assertSee('1,024');

    $tree = json_encode($screen->tree());

    expect($tree)->toContain('"content_transition":"numeric"')
        ->toContain('"content_transition":"opacity"');
});

it('steps and jumps the value', function () {
    Native::test(NumberSwitcherDemo::class)
        ->call('increment')
        ->assertSet('value', 1025)
        ->call('decrement')
        ->call('decrement')
        ->assertSet('value', 1023)
        ->call('jump')
        ->assertSet('value', 1134);
});

it('never decrements below zero', function () {
    $screen = Native::test(NumberSwitcherDemo::class);
    $screen->set('value', 0);
    $screen->call('decrement')->assertSet('value', 0);
});
