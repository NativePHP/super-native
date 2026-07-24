<?php

use App\NativeComponents\AsyncTaskDemo;
use Native\Mobile\AsyncTask;
use Native\Mobile\Testing\Native;
use Native\Mobile\Testing\TestableComponent;

/**
 * AsyncTask::fake() runs dispatched work inline and synchronously, so the
 * finished()/failed() callbacks fire during the test with no background
 * threads involved.
 *
 * The demo's delays exist to make the async behaviour visible on device; run
 * inline they'd just make this suite sleep, so every test zeroes them via
 * [instant()].
 */
beforeEach(function () {
    AsyncTask::fake();
});

/** The demo screen with its simulated work delays removed. */
function instant(): TestableComponent
{
    return Native::test(AsyncTaskDemo::class)
        ->set('reportDelayMs', 0)
        ->set('failDelayMs', 0)
        ->set('sharedDelayMs', 0)
        ->set('parallelDelaysMs', ['orders' => 0, 'revenue' => 0, 'signups' => 0]);
}

it('renders without running anything', function () {
    Native::test(AsyncTaskDemo::class)
        ->assertSet('taps', 0)
        ->assertSee('UI stays live')
        ->assertSee('Not run yet');
});

it('lands a finished() result back on the component', function () {
    $screen = instant()
        ->call('runReport')
        ->assertSet('reportRunning', false);

    expect($screen->get('reportResult'))->toStartWith('Revenue £')
        ->and($screen->get('reportTookMs'))->toBeNumeric();
});

it('routes a thrown task to failed() with the original message and class', function () {
    instant()
        ->call('runFailing')
        ->assertSet('failRunning', false)
        ->assertSet('failMessage', 'Upstream API returned 503')
        ->assertSet('failClass', RuntimeException::class);
});

it('collects every result when several tasks are dispatched together', function () {
    $screen = instant()
        ->call('runParallel')
        ->assertSet('parallelRunning', false);

    $labels = array_column($screen->get('parallel'), 'label');

    expect($labels)->toHaveCount(3)
        ->and($labels)->toContain('orders', 'revenue', 'signups');
});

it('rejects a work closure that captures $this', function () {
    $screen = instant()
        ->call('tryBoundClosure');

    expect($screen->get('guardMessage'))->toContain('must be static');
});

it('records each dispatch on the fake', function () {
    $fake = AsyncTask::fake();

    instant()
        ->call('runReport')
        ->call('runParallel');

    // One report + three parallel tasks.
    $fake->assertDispatched()->assertDispatchedTimes(4);
});

it('dispatches the shared task under its event alias', function () {
    $fake = AsyncTask::fake();

    instant()->call('runShared');

    $fake->assertShared('demo-sync-complete');
});

it('keeps the tap counter independent of task state', function () {
    instant()
        ->call('tap')
        ->call('tap')
        ->assertSet('taps', 2)
        ->call('reset')
        ->assertSet('taps', 0);
});
