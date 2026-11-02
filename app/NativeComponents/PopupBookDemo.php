<?php

namespace App\NativeComponents;

use App\Support\PopupBook\Book;
use App\Support\PopupBook\Story;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Native\Mobile\Attributes\On;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Fold\Events\FoldChanged;
use Native\Mobile\Fold\Facades\Fold;
use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Canvas;
use Native\Mobile\Skia\Events\CanvasAction;
use Native\Mobile\Skia\Events\CanvasFailed;
use Native\Mobile\Skia\Scene;

/**
 * "The Little App", a pop-up bedtime story printed on bendy paper.
 *
 * The book follows the device, not the screen. On a foldable, closed (outer display) it
 * is the front cover; open the device and the cover swings open in 3D onto the first
 * spread on the inner display; close it and the cover swings shut on the outer display.
 * The swing is the scene value `shut`, animated natively once the window has landed on
 * the new display (the hinge flips a second or more before the new display shows
 * anything, so a swing keyed to the hinge would play unseen). Nothing on screen opens or
 * closes the cover.
 *
 * Layout comes from the window's bounds (never the idiom or orientation): a compact
 * window gets the cover full bleed (the board runs past every edge; its title and art are
 * laid out clear of the outer display's camera and status column); a wide one the
 * full-bleed spread, with the spine on the fold and the text and art clear of it when the
 * device is half open.
 *
 * Without a fold sensor (a plain iPhone) the book opens on the inside. Hidden dev
 * override, debug builds only, no UI: open /popup-book/{closed|open|half|device}
 * (e.g. `xcrun simctl openurl <udid> jump://nativephp.com/popup-book/closed`), which
 * calls Fold::simulate() / stopSimulating(), or toggles the cover without the plugin.
 * /popup-book/tour plays the whole book hands-free on the scene clock (for recordings).
 */
class PopupBookDemo extends NativeComponent
{
    /** Below this short side (points) the window is compact, like the outer display. */
    private const COMPACT = 560;

    private const POSES = ['closed', 'open', 'half', 'device', 'tour'];

    public string $status = '';

    /** Skia fit for the current window. */
    public string $fit = 'contain';

    /** @var array<string, Scene> built once per drive mode, so rerenders keep the open page */
    private static array $books = [];

    /** Without a fold sensor: the dev override's cover state. */
    private static bool $devShut = false;

    private bool $sensor = false;

    private bool $shut = false;

    private ?string $sceneKey = null;

    /** Debug tour: the scene plays cover -> open -> every spread -> close on its own clock. */
    private bool $tour = false;

    /** @var array{spine: float, gutter: float, frame: float, lane: float} */
    private array $alignment = ['spine' => 0.0, 'gutter' => 0.0, 'frame' => 1.0, 'lane' => 0.0];

    /** How far (scene units) the full-bleed shut cover runs past every window edge, so the
     *  board's rounded corners stay off-screen and only the spine groove shows at the edge. */
    private const COVER_BLEED = 18;

    public function mount(?string $pose = null): void
    {
        $state = self::fold() ? Fold::state()->toArray() : [];
        $this->sensor = (bool) ($state['supportsFold'] ?? false);

        if ($pose !== null && in_array($pose, self::POSES, true) && config('app.debug')) {
            $this->tour = $pose === 'tour';
            $state = $this->tour ? $state : $this->override($pose, $state);
        }

        $this->shut = $this->sensor ? self::closed($state) : self::$devShut;
        $this->apply($state);
        Log::info('PopupBook mount: '.json_encode(['pose' => $pose, 'sensor' => $this->sensor, 'shut' => $this->shut, 'fit' => $this->fit, 'layout' => $this->alignment, 'state' => $state]));
    }

    public function render(): View
    {
        // Keyed once per screen by the state it starts in: later folds, rotations and resizes only
        // change shared values, so the live canvas is never reloaded (and swings rather than snaps).
        $this->sceneKey ??= json_encode([$this->sensor, $this->shut, $this->alignment, $this->tour]);

        return view('native.popup-book-demo', ['tour' => $this->tour, 'scene' => self::$books[$this->sceneKey] ??= (new Book(
            Story::spreads(),
            // Not bound to fold.isClosed: see folded().
            null,
            shut: $this->shut ? 1 : 0,
            alignment: $this->alignment,
            tour: $this->tour,
        ))->scene()]);
    }

    /**
     * Folding, unfolding, rotating or resizing re-lays the book out without rebuilding the
     * scene: only shared values change, so a resize mid-swing just retargets. The cover
     * swings when the window arrives on the other display (this event comes from the
     * window's layout pass), together with the cover's resize, so it plays on a lit screen.
     */
    #[On(FoldChanged::class)]
    public function folded(string $display = 'inner', string $posture = 'flat', float $windowWidth = 0, float $windowHeight = 0, ?array $foldRegion = null, bool $supportsFold = true, bool $simulated = false): void
    {
        $state = compact('display', 'posture', 'windowWidth', 'windowHeight', 'foldRegion', 'supportsFold', 'simulated');
        $this->sensor = $this->sensor || $supportsFold;
        $was = $this->shut;
        $this->shut = self::closed($state);
        $this->apply($state);
        Log::info(sprintf('PopupBook FoldChanged posture=%s display=%s %.0fx%.0f fold=%s -> %s, fit %s, layout %s', $posture, $display, $windowWidth, $windowHeight, json_encode($foldRegion), $this->shut ? 'cover' : 'book', $this->fit, json_encode($this->alignment)));

        if ($this->shut !== $was) {
            self::control(fn () => Canvas::animate('popup-book', 'shut', Animation::between($this->value('shut'), $this->shut ? 1 : 0, Book::SWING_SECONDS, 'easeInOut', 'once')));
        }

        if ($this->shut && ! $was) {
            // Once the cover is down, rewind to the first spread so the next opening starts the story.
            usleep((int) (Book::SWING_SECONDS * 1e6) + 100_000);
            if ($this->shut) {
                self::control(fn () => Canvas::values('popup-book', ['turn' => 0]));
            }
        }
    }

    #[On(CanvasAction::class)]
    public function action(string $canvasId, string $shapeId, string $action): void
    {
        if ($canvasId !== 'popup-book' || $this->value('shut') > 0.01) {
            return;
        }
        $turn = $this->value('turn');
        $target = max(0, min(count(Story::spreads()) - 1, round($turn) + ($action === 'previous' ? -1 : 1)));

        try {
            Canvas::animate('popup-book', 'turn', Animation::spring($turn, $target, stiffness: 120, damping: 22));
        } catch (\RuntimeException $e) {
            Log::warning('PopupBook page turn failed: '.$e->getMessage());
        }
    }

    #[On(CanvasFailed::class)]
    public function failed(string $canvasId, string $message): void
    {
        $this->status = $message;
    }

    /** Debug-only: pose the book without a UI control. */
    private function override(string $pose, array $state): array
    {
        if ($this->sensor) {
            $pose === 'device' ? Fold::stopSimulating() : Fold::simulate($pose);

            return Fold::state()->toArray();
        }
        $shut = $pose === 'closed';
        if ($shut !== self::$devShut) {
            self::$devShut = $shut;
            // The no-sensor scene is shared across screens: swing the live canvas too.
            self::control(fn () => Canvas::animate('popup-book', 'shut', Animation::between($shut ? 0 : 1, $shut ? 1 : 0, Book::SWING_SECONDS, 'easeInOut', 'once')));
        }

        return $state;
    }

    /** Fit, cover placement and fold alignment for the current window; layout changes glide with the swing. */
    private function apply(array $state): void
    {
        $w = (float) ($state['windowWidth'] ?? 0);
        $h = (float) ($state['windowHeight'] ?? 0);
        $this->fit = self::fitFor($w, $h, $this->shut);
        $layout = self::foldAlignment($state, $this->fit) + self::coverPlacement($state, $this->fit, $this->shut);
        $previous = $this->alignment;
        $this->alignment = $layout;
        foreach ($layout as $name => $target) {
            if (abs($target - ($previous[$name] ?? 0)) > 0.001) {
                $seconds = in_array($name, ['frame', 'lane'], true) ? Book::SWING_SECONDS : 0.35;
                self::control(fn () => Canvas::animate('popup-book', $name, Animation::between($this->value($name), $target, $seconds, 'easeInOut', 'once')));
            }
        }
    }

    /**
     * The shut cover on a compact window, full bleed: scaled until the board overshoots every
     * edge of the window by COVER_BLEED, centred. The art inside the board keeps itself clear
     * of the outer display's camera and status column (see Cover). Scene units.
     *
     * @return array{frame: float, lane: float}
     */
    private static function coverPlacement(array $state, string $fit, bool $shut): array
    {
        $w = (float) ($state['windowWidth'] ?? 0);
        $h = (float) ($state['windowHeight'] ?? 0);
        if (! $shut || $w <= 0 || $h <= 0 || min($w, $h) >= self::COMPACT) {
            return ['frame' => 1.0, 'lane' => 0.0];
        }
        $scale = $fit === 'cover' ? max($w / Book::WIDTH, $h / Book::HEIGHT) : min($w / Book::WIDTH, $h / Book::HEIGHT);
        $zoom = max(
            ($w / $scale + 2 * self::COVER_BLEED) / Book::PAGE,
            ($h / $scale + 2 * self::COVER_BLEED) / Book::HEIGHT,
        );

        return ['frame' => round($zoom / Book::SHUT_ZOOM, 4), 'lane' => 0.0];
    }

    /** Canvas commands fail before the canvas exists (first mount); the scene starts from the same state. */
    private static function control(callable $command): void
    {
        try {
            $command();
        } catch (\RuntimeException $e) {
            Log::debug('PopupBook canvas command skipped: '.$e->getMessage());
        }
    }

    /**
     * Wide windows fill with the spread. A tall window fills with the shut cover when it fits
     * (the closed outer display); otherwise the whole spread is shown, letterboxed.
     */
    private static function fitFor(float $w, float $h, bool $shut): string
    {
        // Window size comes from the fold plugin: without it, show the whole spread.
        if ($w <= 0 || $h <= 0) {
            return 'contain';
        }
        if ($w >= $h) {
            return 'cover';
        }
        $scale = max($w / Book::WIDTH, $h / Book::HEIGHT);
        $visible = $w / $scale;

        return $shut && $visible >= Book::PAGE * Book::SHUT_ZOOM + 24 ? 'cover' : 'contain';
    }

    /**
     * Half open with a vertical fold: move the spine onto the fold, and the page content
     * off it. Window points map to scene units through the canvas fit.
     *
     * @return array{spine: float, gutter: float}
     */
    private static function foldAlignment(array $state, string $fit): array
    {
        $w = (float) ($state['windowWidth'] ?? 0);
        $h = (float) ($state['windowHeight'] ?? 0);
        $region = $state['foldRegion'] ?? null;
        if ($w <= 0 || $h <= 0 || ! is_array($region) || ! ($region['active'] ?? false) || ($region['orientation'] ?? '') !== 'vertical') {
            return ['spine' => 0.0, 'gutter' => 0.0];
        }
        $scale = $fit === 'cover' ? max($w / Book::WIDTH, $h / Book::HEIGHT) : min($w / Book::WIDTH, $h / Book::HEIGHT);
        $left = ($w - Book::WIDTH * $scale) / 2;
        $center = ((float) $region['x'] + (float) $region['width'] / 2 - $left) / $scale;
        $half = (float) $region['width'] / 2 / $scale;

        return [
            'spine' => round($center - Book::PAGE, 2),
            // Text starts 44 units from the spine; keep it at least 12 units clear of the fold.
            'gutter' => round(max(0, $half + 12 - 44), 2),
        ];
    }

    /**
     * The cover belongs to the closed device. On a foldable that is read from the window
     * (a compact window is the outer display), so the state flips when the window lands on
     * the other display rather than when the hinge moves; the posture is the fallback.
     */
    private static function closed(array $state): bool
    {
        if ($state['simulated'] ?? false) {
            return ($state['posture'] ?? '') === 'closed';
        }
        $w = (float) ($state['windowWidth'] ?? 0);
        $h = (float) ($state['windowHeight'] ?? 0);
        if (($state['supportsFold'] ?? false) && $w > 0 && $h > 0) {
            return min($w, $h) < self::COMPACT;
        }

        return ($state['posture'] ?? '') === 'closed';
    }

    protected function value(string $name): float
    {
        try {
            return (float) (Canvas::state('popup-book')['values'][$name] ?? 0);
        } catch (\RuntimeException) {
            return (float) ($this->alignment[$name] ?? 0);
        }
    }

    /** The fold plugin is optional: without it the book is always open. */
    protected static function fold(): bool
    {
        return class_exists(Fold::class) && function_exists('nativephp_call');
    }
}
