<?php

namespace App\NativeComponents;

use App\Jobs\DemoApiLogin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Native\Mobile\Attributes\Poll;
use Native\Mobile\Edge\NativeComponent;

/**
 * Loading states around a slow API call — three ways, side by side.
 *
 * The whole screen is one PHP thread running one loop:
 *
 *     render() -> publish -> wait_event() -> your @tap handler -> repeat
 *
 * Everything the user sees is painted by that `publish`, which happens at
 * the TOP of the loop. So a handler that sets `$busy = true` and then blocks
 * never shows the spinner: `publish` for that frame only runs after the
 * handler returns, by which point `$busy` is false again.
 *
 * The fix is to let the handler return so a frame goes out, then do the work
 * on the next tick. `#[Poll]` is that tick — it fires on an idle loop pass,
 * i.e. strictly after the spinner frame has been published.
 */
class AsyncLoadingDemo extends NativeComponent
{
    public string $email = 'demo@nativephp.com';

    // ── 1. Blocking (the trap) ──
    public bool $blockingBusy = false;

    public string $blockingResult = '';

    public bool $blockingOk = false;

    // ── 2. Deferred action (recommended for login) ──
    public bool $deferredBusy = false;

    public string $deferredResult = '';

    public bool $deferredOk = false;

    /** Set by the tap handler, consumed by the next tick(). */
    private bool $deferredPending = false;

    // ── 3. Queued job + polled result ──
    public bool $queuedBusy = false;

    public string $queuedResult = '';

    public bool $queuedOk = false;

    /** Live tap -> result wall clock, so the worker's pickup cost is visible. */
    public int $queuedWaitedMs = 0;

    private ?string $queuedKey = null;

    private float $queuedStartedAt = 0.0;

    public function navTitle(): string
    {
        return 'Async & Loading';
    }

    /**
     * The loop's tick. Runs on an idle pass — after the current frame has
     * been published, before the loop blocks again.
     *
     * 100ms keeps the deferred request feeling instant. If you are only
     * waiting on a queue job, 500ms-1s is plenty: every tick re-renders the
     * screen, and there is no point re-rendering faster than the worker
     * (which idles for 3s between polls).
     */
    #[Poll(100)]
    public function tick(): void
    {
        $this->runDeferredRequest();
        $this->collectQueuedResult();
    }

    // ── 1. Blocking — the behaviour being reported ──

    /**
     * Sets the flag and blocks in the same handler. The loop cannot publish
     * mid-handler, so `$blockingBusy` is true only for frames that never
     * exist. The button stays idle for ~1.4s, then the result appears.
     */
    public function signInBlocking(): void
    {
        $this->blockingBusy = true;

        $result = DemoApiLogin::perform($this->email);

        $this->blockingOk = $result['ok'];
        $this->blockingResult = $result['message'].' · '.$result['ms'].'ms';
        $this->blockingBusy = false;
    }

    // ── 2. Deferred action — spinner renders, no queue involved ──

    /**
     * Flip the flag and get out. The loop publishes the spinner frame, then
     * tick() picks the work up ~100ms later.
     */
    public function signInDeferred(): void
    {
        $this->deferredResult = '';
        $this->deferredBusy = true;
        $this->deferredPending = true;
    }

    private function runDeferredRequest(): void
    {
        if (! $this->deferredPending) {
            return;
        }

        // Clear first — this method blocks, and a second tick must not
        // fire the same request again.
        $this->deferredPending = false;

        $result = DemoApiLogin::perform($this->email);

        $this->deferredOk = $result['ok'];
        $this->deferredResult = $result['message'].' · '.$result['ms'].'ms';
        $this->deferredBusy = false;
    }

    // ── 3. Queued job — UI stays interactive, result arrives via the cache ──

    public function signInQueued(): void
    {
        $this->queuedKey = 'demo:login:'.Str::uuid()->toString();
        $this->queuedStartedAt = microtime(true);
        $this->queuedWaitedMs = 0;
        $this->queuedResult = '';
        $this->queuedBusy = true;

        DemoApiLogin::dispatch($this->queuedKey, $this->email);
    }

    /**
     * Poll the shared cache for the worker's result. This is the ONLY thing
     * that works — an event dispatched inside the job fires on the worker
     * runtime's dispatcher and never reaches this component.
     */
    private function collectQueuedResult(): void
    {
        if (! $this->queuedBusy || $this->queuedKey === null) {
            return;
        }

        $this->queuedWaitedMs = (int) round((microtime(true) - $this->queuedStartedAt) * 1000);

        $result = Cache::pull($this->queuedKey);

        if ($result === null) {
            // No worker means the job sits in the `jobs` table forever.
            // Fail loudly rather than spinning for the rest of the session.
            if ($this->queuedWaitedMs > 30_000) {
                $this->queuedOk = false;
                $this->queuedResult = 'Timed out. Is QUEUE_CONNECTION=database and the worker running?';
                $this->queuedBusy = false;
                $this->queuedKey = null;
            }

            return;
        }

        $this->queuedOk = $result['ok'];
        $this->queuedResult = $result['message'].' · request '.$result['ms'].'ms';
        $this->queuedBusy = false;
        $this->queuedKey = null;
    }

    public function render(): View
    {
        return view('native.async-loading-demo');
    }
}
