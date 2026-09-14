<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\Concerns\HasVirtualListWindow;
use Native\Mobile\Edge\NativeComponent;

/**
 * Performance stress demo: ~20,000 image cells in a windowed virtual list.
 *
 * Blade never unrolls 20k nodes. Native owns `count` logical slots; PHP only
 * materializes the rows inside [$virtualWindowFrom..$virtualWindowTo] via
 * `<virtual-list item=…>`, the same pattern as ExploreIcons.
 *
 * Boot strategy (native-direct 10s watchdog):
 *  1. First publish stays ExploreIcons-scale so NativeUI activates.
 *  2. A one-shot `native:poll` then grows the PHP window + overscan so the
 *     first fling feels preloaded — never on the first tree.
 *
 * After that the window SLIDES with `setVirtualWindow`. Rows keep
 * `native:key="s20k-{index}"`. Vendor `Element::toArray` FULL-serializes
 * virtual_list children (no per-row REUSE) so sliding windows cannot
 * splice-miss and truncate the child list. Chromed ancestors can still
 * memoize.
 *
 * Cells cycle a small pool of real photographic JPEGs under
 * public/images/scroll20k. Absolute filesystem srcs are required by
 * NativeUI's local UIImage loader.
 */
class HeroScroll20k extends NativeComponent
{
    use HasVirtualListWindow;

    /**
     * Not required after the vendor virtual_list child-FULL fix. Left
     * false so chrome/ancestors can still emit REUSE markers; list rows
     * themselves never REUSE (see Element::toArray).
     */
    protected bool $forceFullFrames = false;

    /** ~20k cells (not rows). Keep total fixed when widening. */
    public const CELL_COUNT = 20_000;

    /** Cells per virtual-list row — keep in sync with scroll-20k-row.blade.php. */
    private const PER_ROW = 5;

    /**
     * Initial PHP window (inclusive). ExploreIcons-scale so first paint
     * activates NativeUI before the native-direct boot watchdog.
     */
    private const INITIAL_WINDOW_TO = 79;

    /** Overscan on the boot frame. */
    private const INITIAL_OVERSCAN = 40;

    /**
     * Post-boot window (inclusive). Large enough that the first fling
     * still hits real rows, small enough that a slide republish stays
     * well under the watchdog.
     */
    private const RAMP_WINDOW_TO = 279;

    /**
     * Overscan once NativeUI is alive. Trigger ≈ overscan/3 on native.
     * Paired with MAX_WINDOW_SPAN so a visible page + both overscans
     * always fits the clamped publish.
     */
    private const RAMP_OVERSCAN = 120;

    /** Inclusive max span (~280 rows / 1.4k cells) — covers visible + 2× overscan. */
    private const MAX_WINDOW_SPAN = 279;

    /**
     * Local real-photo JPEG pool (a–h). Sourced from the iOS Simulator
     * Photo Library sample set (device Media/DCIM) plus two Picsum fills —
     * not the installed media-player plugin (A/V only) and not camera
     * gallery picking (interactive; camera plugin not installed).
     *
     * @var list<string>
     */
    public const IMAGE_NAMES = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    /** @var list<string>|null */
    private static ?array $resolvedSrcs = null;

    /** Live overscan passed into the blade (ramps after first paint). */
    public int $overscan = self::INITIAL_OVERSCAN;

    /** True after the first render() has returned (first tree published). */
    private bool $firstPaintDone = false;

    /** True once the post-boot window/overscan has been applied. */
    public bool $preloaded = false;

    public function mount(): void
    {
        $this->setVirtualWindow(0, self::INITIAL_WINDOW_TO);
        $this->overscan = self::INITIAL_OVERSCAN;
        $this->preloaded = false;
        $this->firstPaintDone = false;
    }

    /**
     * Bound the span so a fast fling cannot ask PHP for thousands of rows.
     * Center the clamped window on the requested midpoint so the visible
     * range (middle of native's from..to) stays covered — keeping `from`
     * and chopping `to` blanks the screen on a downward fling when
     * overscan is large.
     */
    public function setVirtualWindow(int $from, int $to): void
    {
        $from = max(0, $from);
        $to = max($from, $to);
        if (($to - $from) > self::MAX_WINDOW_SPAN) {
            $mid = intdiv($from + $to, 2);
            $half = intdiv(self::MAX_WINDOW_SPAN, 2);
            $from = max(0, $mid - $half);
            $to = $from + self::MAX_WINDOW_SPAN;
        }

        $this->virtualWindowFrom = $from;
        $this->virtualWindowTo = $to;
    }

    public function navTitle(): string
    {
        return '20k Scroll';
    }

    /**
     * Absolute filesystem paths for the real-photo JPEG pool. NativeUI
     * loads `/…` and `file://…` via UIImage; http(s) would go through
     * AsyncImage. The pool is small so the native image cache reuses the
     * same decoded bitmaps across all 20k cells.
     *
     * @return list<string>
     */
    public static function localImageSrcs(): array
    {
        return self::$resolvedSrcs ??= array_map(
            static fn (string $name): string => public_path('images/scroll20k/'.$name.'.jpg'),
            self::IMAGE_NAMES
        );
    }

    public function render(): View
    {
        // Second+ render (one-shot native:poll): grow overscan (and the
        // boot window if native has not already slid it) now that NativeUI
        // is alive. Never clobber a range native already asked for.
        if ($this->firstPaintDone && ! $this->preloaded) {
            $this->preloaded = true;
            $this->overscan = self::RAMP_OVERSCAN;
            if ($this->virtualWindowFrom === 0 && $this->virtualWindowTo <= self::INITIAL_WINDOW_TO) {
                $this->setVirtualWindow(0, self::RAMP_WINDOW_TO);
            }
        }

        $rowCount = (int) ceil(self::CELL_COUNT / self::PER_ROW);
        $from = max(0, min($this->virtualWindowFrom, max(0, $rowCount - 1)));
        $to = min(max(0, $rowCount - 1), max($from, $this->virtualWindowTo));

        // Item views only receive ['index']; share cheap lookups for the row.
        view()->share('scroll20kSrcs', self::localImageSrcs());
        view()->share('scroll20kPerRow', self::PER_ROW);
        view()->share('scroll20kCellCount', self::CELL_COUNT);

        $view = view('native.hero.scroll-20k', [
            'cellCount' => self::CELL_COUNT,
            'rowCount' => $rowCount,
            'from' => $from,
            'to' => $to,
            'overscan' => $this->overscan,
            'preloaded' => $this->preloaded,
        ]);

        // Mark after building the first tree so the boot publish stays small.
        $this->firstPaintDone = true;

        return $view;
    }
}
