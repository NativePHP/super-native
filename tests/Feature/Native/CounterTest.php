<?php

use App\NativeComponents\Counter;
use Native\Mobile\Testing\Native;

it('starts at zero with the Counter nav title', function () {
    Native::visit('/counter')
        ->assertScreen(Counter::class)
        ->assertSet('count', 0)
        ->assertNavTitle('Counter');
});

it('increments and decrements through the pressable icons', function () {
    Native::test(Counter::class)
        ->press('increment')
        ->assertSet('count', 1)
        ->press('increment')
        ->assertSet('count', 2)
        ->press('decrement')
        ->assertSet('count', 1);
});

it('increments via the long-press binding too', function () {
    Native::test(Counter::class)
        ->longPress('increment')
        ->assertSet('count', 1);
});
