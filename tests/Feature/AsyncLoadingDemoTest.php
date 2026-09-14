<?php

use App\Jobs\DemoApiLogin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Native\Mobile\Testing\Native;

/**
 * Guards the /async-loading demo — the three ways to show a loading state
 * around a slow request.
 *
 * The point of the screen is WHEN state is visible relative to a publish,
 * which is exactly what these assert: the deferred handler leaves the
 * component in its busy state (so the loop can publish a spinner frame),
 * the blocking handler never does.
 */
beforeEach(function () {
    Http::fake([
        'jsonplaceholder.typicode.com/*' => Http::response(['name' => 'Leanne Graham']),
    ]);
});

it('renders the three patterns', function () {
    Native::visit('/async-loading')
        ->assertSee('1 · Blocking')
        ->assertSee('2 · Deferred')
        ->assertSee('3 · Queued');
});

it('never exposes a busy frame for the blocking handler', function () {
    Native::visit('/async-loading')
        ->call('signInBlocking')
        ->assertSet('blockingBusy', false)
        ->assertSet('blockingOk', true)
        ->assertSee('Signed in as Leanne Graham');
});

it('stays busy after the deferred handler returns, and resolves on the tick', function () {
    $screen = Native::visit('/async-loading')->call('signInDeferred');

    // The handler returned with the flag still set — this is the frame the
    // loop publishes, and the frame that carries the spinner.
    $screen->assertSet('deferredBusy', true)
        ->assertSee('Signing in…');

    // The next idle tick does the actual request.
    $screen->firePoll('tick')
        ->assertSet('deferredBusy', false)
        ->assertSee('Signed in as Leanne Graham');
});

it('queues the job and picks the result up from shared state', function () {
    Queue::fake();

    $screen = Native::visit('/async-loading')->call('signInQueued');

    $screen->assertSet('queuedBusy', true);

    Queue::assertPushed(DemoApiLogin::class, function (DemoApiLogin $job) {
        // Stand in for the worker runtime: the ONLY thing that crosses back
        // is what the job leaves in the shared cache.
        Cache::put($job->resultKey, ['ok' => true, 'message' => 'Signed in as Leanne Graham', 'ms' => 1400]);

        return true;
    });

    $screen->firePoll('tick')
        ->assertSet('queuedBusy', false)
        ->assertSee('Signed in as Leanne Graham');
});

it('gives up on the queued job when no worker ever answers', function () {
    Queue::fake();

    $screen = Native::visit('/async-loading')->call('signInQueued');

    // Pretend the tap happened 40s ago — nothing has written a result.
    $screen->set('queuedWaitedMs', 0);
    (function () {
        $this->queuedStartedAt = microtime(true) - 40;
    })->call($screen->instance());

    $screen->firePoll('tick')
        ->assertSet('queuedBusy', false)
        ->assertSee('Timed out');
});
