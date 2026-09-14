<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\Concerns\HasVirtualListWindow;
use Native\Mobile\Edge\NativeComponent;

/**
 * Performance demo — measurable numbers that map to what RN / native
 * benchmarks publish, so you can compare directly.
 *
 * Each render measures:
 *  - PHP tree-build time (ms)
 *  - Element count
 *  - Time PHP spent per element (μs)
 *  - Time between user action and PHP finishing the build (ms)
 *
 * For context inline: React Native's published 2026 numbers (New
 * Architecture, Fabric + TurboModules, Hermes) — see notes in the
 * blade for comparison context.
 */
class PerfDemo extends NativeComponent
{
    use HasVirtualListWindow;

    public int $renderCount = 0;

    public int $rowCount = 200;

    /** ms — PHP time to build the LAST tree. */
    public float $lastBuildMs = 0.0;

    /** ms — wall-clock from `tap`/`setRows` entering PHP to `render`
     *  finishing. Closer to user-perceived latency than `lastBuildMs`
     *  alone (which excludes handler execution before render). */
    public float $lastActionToRenderMs = 0.0;

    /** count of native elements in the last tree (rows + chrome + …). */
    public int $lastElementCount = 0;

    /** `now()->format(H:i:s.v)` for display. */
    public string $lastRenderAt = '';

    /** Set when a user-initiated handler enters PHP (tap, setRows).
     *  Cleared after render so subsequent un-tracked renders don't
     *  show stale wall-clock numbers. */
    private float $actionStartMicro = 0.0;

    public function navTitle(): string
    {
        return 'Performance';
    }

    public function tap(): void
    {
        $this->actionStartMicro = microtime(true);
    }

    public function setRows(int $count): void
    {
        $this->actionStartMicro = microtime(true);
        $this->rowCount = $count;
        // Reset the window when the count changes so we don't try to emit
        // rows above the new total. Native will report the real visible
        // range on first scroll/appear.
        $this->virtualWindowFrom = 0;
        $this->virtualWindowTo = min(79, $count - 1);
    }

    public function reset(): void
    {
        $this->actionStartMicro = microtime(true);
        $this->renderCount = 0;
        $this->lastBuildMs = 0.0;
        $this->lastActionToRenderMs = 0.0;
        $this->lastElementCount = 0;
    }

    public function render(): View
    {
        $buildStart = microtime(true);

        $this->renderCount++;
        $this->lastRenderAt = now()->format('H:i:s.v');

        // Element count is deterministic from the tree we're about to
        // render — header chrome + N list-items + 5 row-count buttons.
        // Hardcoding the chrome (8 elements) keeps the count honest;
        // it's the rowCount that dominates anyway.
        // Element count is now bounded by the visible window — that's the
        // whole point of <virtual-list>. The full `rowCount` is a
        // logical total ridden by the native LazyColumn, not a tree size.
        $chromeElementCount = 8;
        $buttonElementCount = 6;
        $windowSize = max(0, $this->virtualWindowTo - $this->virtualWindowFrom + 1);
        $this->lastElementCount = $chromeElementCount + $buttonElementCount + $windowSize;

        $view = view('native.perf-demo');

        $this->lastBuildMs = round((microtime(true) - $buildStart) * 1000, 2);

        if ($this->actionStartMicro > 0) {
            $this->lastActionToRenderMs = round((microtime(true) - $this->actionStartMicro) * 1000, 2);
            $this->actionStartMicro = 0.0;
        }

        return $view;
    }
}
