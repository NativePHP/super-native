<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\AsyncTask;
use Native\Mobile\Attributes\On;
use Native\Mobile\Edge\NativeComponent;

/**
 * Async tasks — background PHP work with UI completion callbacks.
 *
 * Each card exercises one part of the API:
 *   1. finished()   — a slow task whose result lands back on this component
 *   2. failed()     — a task that throws, surfaced as an AsyncTaskException
 *   3. concurrency  — three tasks in flight at once, each landing independently
 *   4. shared()     — result delivered as a named event via #[On] instead of a
 *                     screen-scoped callback
 *   5. the static-closure guard — a $this-bound closure is rejected at dispatch
 *
 * The tap counter at the top is the important one: it proves the UI thread is
 * never blocked. Hammer it while tasks are running — it keeps counting.
 */
class AsyncTaskDemo extends NativeComponent
{
    /** Proof the runloop stays responsive — tap while tasks are in flight. */
    public int $taps = 0;

    /**
     * How long each simulated task "works" for, in milliseconds. Long enough
     * on device to watch the spinners and prove the UI never blocks; tests
     * override these to 0 so the inline fake (which runs work synchronously
     * on the test thread) doesn't spend 20s sleeping.
     */
    public int $reportDelayMs = 2000;

    public int $failDelayMs = 800;

    public int $sharedDelayMs = 2500;

    /** label => delay(ms). Staggered so results land out of dispatch order. */
    public array $parallelDelaysMs = ['orders' => 3000, 'revenue' => 1000, 'signups' => 2000];

    // 1. finished()
    public bool $reportRunning = false;

    public ?string $reportResult = null;

    public ?float $reportStartedAt = null;

    public ?float $reportTookMs = null;

    // 2. failed()
    public bool $failRunning = false;

    public ?string $failMessage = null;

    public ?string $failClass = null;

    // 3. concurrency — three independent tasks
    public array $parallel = [];

    public bool $parallelRunning = false;

    public ?float $parallelStartedAt = null;

    // 4. shared()
    public ?string $sharedResult = null;

    public bool $sharedRunning = false;

    // 5. static-closure guard
    public ?string $guardMessage = null;

    public function navTitle(): string
    {
        return 'Async Tasks';
    }

    // ── 1. finished() ───────────────────────────────

    public function runReport(): void
    {
        $this->reportRunning = true;
        $this->reportResult = null;
        $this->reportTookMs = null;
        $this->reportStartedAt = microtime(true);

        $delayMs = $this->reportDelayMs;

        AsyncTask::dispatch(static function () use ($delayMs) {
            // Pretend this is an expensive build — a real report, an image
            // resize, a slow upstream API. Runs on its own PHP interpreter.
            usleep($delayMs * 1000);

            return 'Revenue £'.number_format(random_int(10_000, 99_999));
        })->finished(function (string $result) {
            $this->reportResult = $result;
            $this->reportTookMs = round((microtime(true) - $this->reportStartedAt) * 1000);
            $this->reportRunning = false;
        })->failed(function (\Throwable $e) {
            $this->reportResult = 'Failed: '.$e->getMessage();
            $this->reportRunning = false;
        });
    }

    // ── 2. failed() ─────────────────────────────────

    public function runFailing(): void
    {
        $this->failRunning = true;
        $this->failMessage = null;
        $this->failClass = null;

        $delayMs = $this->failDelayMs;

        AsyncTask::dispatch(static function () use ($delayMs) {
            usleep($delayMs * 1000);

            throw new \RuntimeException('Upstream API returned 503');
        })->finished(function () {
            // Never reached — kept to show both callbacks can coexist.
            $this->failMessage = 'unexpectedly succeeded';
            $this->failRunning = false;
        })->failed(function (\Throwable $e) {
            $this->failMessage = $e->getMessage();
            // AsyncTaskException carries the class it was originally thrown as.
            $this->failClass = method_exists($e, 'originalClass')
                ? $e->originalClass()
                : $e::class;
            $this->failRunning = false;
        });
    }

    // ── 3. Concurrency ──────────────────────────────

    public function runParallel(): void
    {
        $this->parallelRunning = true;
        $this->parallelStartedAt = microtime(true);
        $this->parallel = [];

        // Deliberately staggered sleeps: results should land in duration order
        // (fast → slow), NOT dispatch order — that's the proof they ran
        // concurrently rather than queueing behind each other.
        foreach ($this->parallelDelaysMs as $label => $delayMs) {
            AsyncTask::dispatch(static function () use ($label, $delayMs) {
                usleep($delayMs * 1000);

                return ucfirst($label).': '.random_int(100, 999);
            })->finished(function (string $result) use ($label) {
                $this->parallel[] = [
                    'label' => $label,
                    'result' => $result,
                    'at' => round((microtime(true) - $this->parallelStartedAt) * 1000),
                ];

                if (count($this->parallel) === 3) {
                    $this->parallelRunning = false;
                }
            });
        }
    }

    // ── 4. shared() ─────────────────────────────────

    /**
     * `shared()` delivers the result as a NAMED EVENT rather than a
     * screen-scoped callback, so it fires no matter which screen is showing.
     * Navigate away mid-flight and back — with a plain finished() the result
     * would be dropped; this one still arrives.
     */
    public function runShared(): void
    {
        $this->sharedRunning = true;
        $this->sharedResult = null;

        $delayMs = $this->sharedDelayMs;

        AsyncTask::dispatch(static function () use ($delayMs) {
            usleep($delayMs * 1000);

            return 'synced at '.now()->format('H:i:s');
        })->shared('demo-sync-complete');
    }

    #[On('demo-sync-complete')]
    public function syncComplete($event): void
    {
        $this->sharedResult = ($event->status ?? 'finished') === 'failed'
            ? 'failed: '.($event->message ?? 'unknown')
            : (string) ($event->result ?? '—');
        $this->sharedRunning = false;
    }

    // ── 5. Static-closure guard ─────────────────────

    /**
     * The work closure runs in another interpreter, so it can't capture $this.
     * A non-static closure is rejected at dispatch time — in the handler, where
     * you can see it — rather than failing silently in a background log.
     */
    public function tryBoundClosure(): void
    {
        try {
            // NOT static — captures $this. This is the mistake the guard catches.
            AsyncTask::dispatch(function () {
                return $this->taps;
            });

            $this->guardMessage = 'No exception — the guard did not fire!';
        } catch (\InvalidArgumentException $e) {
            $this->guardMessage = $e->getMessage();
        }
    }

    // ── UI ──────────────────────────────────────────

    public function tap(): void
    {
        $this->taps++;
    }

    public function reset(): void
    {
        $this->taps = 0;
        $this->reportResult = null;
        $this->reportTookMs = null;
        $this->failMessage = null;
        $this->failClass = null;
        $this->parallel = [];
        $this->sharedResult = null;
        $this->guardMessage = null;
    }

    public function render(): View
    {
        return view('native.async-task-demo');
    }
}
