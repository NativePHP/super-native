<?php

namespace App\Support\PopupBook;

use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;
use Native\Mobile\Skia\Scene;

/**
 * A full-bleed pop-up book made of real-feeling paper.
 *
 * The whole book is one shared value, `turn` (0 = first spread, 1 = second, …).
 * Each leaf is a native page curl: grab a corner and it peels diagonally, grab an
 * edge and it rolls, flick and it springs over. Pop-ups, fades and shadows are
 * bindings of `turn`, evaluated natively every frame: PHP never sees a move event.
 *
 * A second value, `shut` (1 = closed, 0 = open), swings the front cover about the
 * spine; bindings are written in terms of open = 1 - shut (see open()). On a foldable it
 * can be bound to a native value with an ease (e.g. `fold.isClosed`); the demo instead
 * animates it when the window lands on the other display, so the swing is seen.
 */
final class Book
{
    public const WIDTH = 1000;

    public const HEIGHT = 704;

    public const PAGE = 500;

    /** The shut book is drawn at this scale, so the cover sits inside the window with a margin. */
    public const SHUT_ZOOM = 0.8;

    public const SWING_SECONDS = 1.3;

    /**
     * @param  list<Spread>  $spreads
     * @param  ?string  $shutSource  native value bus key that drives `shut`, e.g. 'fold.isClosed'
     * @param  array{spine?: float, gutter?: float, frame?: float, lane?: float}  $alignment  starting layout values
     */
    public function __construct(private array $spreads, private ?string $shutSource = null, private float $shut = 0, private array $alignment = [], private bool $tour = false) {}

    /**
     * Debug tour on the scene clock (no PHP timing): the cover opens, every spread is shown, the
     * cover closes. Used for recordings; `shut` is then driven by the tour, not the device.
     *
     * @return array{shut: Animation, turn: Animation}
     */
    private function tourAnimations(): array
    {
        $turns = count($this->spreads) - 1;
        [$cover, $swing, $first, $turn, $hold, $end] = [2.5, self::SWING_SECONDS, 4.0, 1.1, 3.4, 3.0];
        $open = $first + $turns * ($turn + $hold) + $end;
        $steps = [Animation::between(0, 0, $cover + $swing + $first)];
        foreach (range(0, $turns - 1) as $i) {
            $steps[] = Animation::between($i, $i + 1, $turn, 'easeInOut');
            $steps[] = Animation::between($i + 1, $i + 1, $hold);
        }
        // Back to the first spread under the shut cover.
        $steps[] = Animation::between($turns, $turns, $end + $swing + 0.3);
        $steps[] = Animation::between($turns, 0, 0.01);
        $steps[] = Animation::between(0, 0, 2.7);

        return [
            'shut' => Animation::sequence(
                Animation::between(1, 1, $cover),
                Animation::between(1, 0, $swing, 'easeInOut'),
                Animation::between(0, 0, $open),
                Animation::between(0, 1, $swing, 'easeInOut'),
                Animation::between(1, 1, 3),
            )->repeat('once'),
            'turn' => Animation::sequence(...$steps)->repeat('once'),
        ];
    }

    /**
     * Binding arguments for a property written against open (0 shut … 1 open) but bound to `shut`:
     * scale·open + offset = -scale·shut + (scale + offset).
     *
     * @return array{scale: float, offset: float, min: ?float, max: ?float}
     */
    public static function open(float $scale = 1, float $offset = 0, ?float $min = null, ?float $max = null): array
    {
        return ['scale' => -$scale, 'offset' => $scale + $offset, 'min' => $min, 'max' => $max];
    }

    public function scene(): Scene
    {
        $last = count($this->spreads) - 1;

        $scene = Scene::make(self::WIDTH, self::HEIGHT)
            ->background('#1b1626')
            ->perspective(2600)
            ->value('turn', 0, $this->tour ? $this->tourAnimations()['turn'] : null)
            ->value('shut', $this->shut, ...($this->tour
                ? ['animation' => $this->tourAnimations()['shut']]
                : ['source' => $this->shutSource, 'ease' => $this->shutSource ? self::SWING_SECONDS : null]))
            // iPhone Duo half-open: `spine` moves the spine onto the fold, `gutter` pushes page content off it.
            ->value('spine', $this->alignment['spine'] ?? 0)
            ->value('gutter', $this->alignment['gutter'] ?? 0)
            // How large the shut cover sits in the window (outer display: full bleed).
            ->value('frame', $this->alignment['frame'] ?? 1)
            ->value('lane', $this->alignment['lane'] ?? 0)
            ->value('sway', 0, Animation::between(-1, 1, 5, 'easeInOut', 'mirror'))
            ->value('pulse', 0, Animation::between(0, 1, 2.2, 'easeInOut', 'mirror'));

        Fonts::register($scene);

        return $scene->add(...[
            // The shut book sits centred and a little smaller; it slides right and grows as the cover swings open.
            Node::group([Node::group([Node::group([Node::group([Node::group([
                // The first left page and the last right page never move.
                self::follow($this->page(0, right: false), 'opacity', 0.999, 1, 1, 0),
                self::follow($this->page($last, right: true)->transform(self::PAGE, 0), 'opacity', $last - 1.001, $last - 1, 0, 1),
                ...array_map($this->leaf(...), range(0, $last - 1)),
                Cover::desk('#1b1626'),
                ...Cover::shadows(),
                Cover::node($this->page(0, right: false)),
            ])->bind('translateX', 'shut', ...self::open(scale: self::PAGE / 2, offset: -self::PAGE / 2))])
                ->origin(self::WIDTH / 2, self::HEIGHT / 2)
                ->bind('scaleX', 'shut', ...self::open(scale: 1 - self::SHUT_ZOOM, offset: self::SHUT_ZOOM))
                ->bind('scaleY', 'shut', ...self::open(scale: 1 - self::SHUT_ZOOM, offset: self::SHUT_ZOOM)),
            ])->bind('translateX', 'spine')])
                ->origin(self::WIDTH / 2, self::HEIGHT / 2)
                ->bind('scaleX', 'frame')
                ->bind('scaleY', 'frame')])
                ->bind('translateX', 'lane'),
            Node::rect(0, 0, self::WIDTH, self::HEIGHT, Paint::fill('#00000000'))->id('book')
                ->accessible('The Little App, a pop-up book', 'button', 'Drag a page corner, or tap a page edge, to turn the page', ['next', 'previous']),
        ]);
    }

    /**
     * Bind a property so it moves from $from at $fromTurn to $to at $toTurn,
     * clamped outside that window.
     */
    public static function follow(Node $node, string $property, float $fromTurn, float $toTurn, float $from, float $to): Node
    {
        $slope = ($to - $from) / ($toTurn - $fromTurn);

        return $node->bind($property, 'turn', scale: $slope, offset: $from - $slope * $fromTurn, min: min($from, $to), max: max($from, $to));
    }

    /** Leaf i: spread i's right page on the front, spread i+1's left page on the back. */
    private function leaf(int $i): Node
    {
        // Faces buried under other leaves are skipped.
        $front = self::follow($this->page($i, right: true), 'opacity', $i - 1.001, $i - 1, 0, 1);
        $back = self::follow($this->page($i + 1, right: false), 'opacity', $i + 1.999, $i + 2, 1, 0);

        return Node::pageCurl($front, $back, self::PAGE, self::HEIGHT, 'turn', index: $i, radius: 48, flutter: 0.014)
            ->id("leaf-{$i}")
            ->transform(self::PAGE, 0);
    }

    /** One page in its own 500 × 704 coordinates, clipped, with paper, gutter and content. */
    private function page(int $index, bool $right): Node
    {
        $spread = $this->spreads[$index];
        $content = $right
            ? ($spread->scene)(new Pop($index))
            : Story::text($spread, $index);

        return Node::group([
            Node::rect(0, 0, self::PAGE, self::HEIGHT, Paint::fill()->runtimeShader(Shaders::PAPER, [
                'paper' => $right ? $spread->sceneColor : $spread->paperColor, 'seed' => $index * 2 + ($right ? 1 : 0),
            ])),
            Node::group($content)->bind('translateX', 'gutter', scale: $right ? 1 : -1),
            // Gutter shading toward the spine.
            $right
                ? Node::rect(0, 0, 60, self::HEIGHT, Paint::fill()->linearGradient(0, 0, 60, 0, ['#0000004d', '#00000000']))
                : Node::rect(self::PAGE - 60, 0, 60, self::HEIGHT, Paint::fill()->linearGradient(self::PAGE - 60, 0, self::PAGE, 0, ['#00000000', '#00000040'])),
        ])->clip($right
            // Outer corners rounded like the cover board (radius 16), so a shut cover hides the page exactly.
            ? 'M0 0 H484 Q500 0 500 16 V688 Q500 704 484 704 H0 Z'
            : 'M16 0 H500 V704 H16 Q0 704 0 688 V16 Q0 0 16 0 Z');
    }
}
