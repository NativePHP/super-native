<?php

namespace App\Support\PopupBook;

use Native\Mobile\Skia\Filter;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;

/**
 * Turns a paper cut-out into a pop-up piece for one spread: it stands up from its
 * base as the page opens (staggered by $delay), lifts toward the camera by $depth,
 * drifts with the room's gentle sway, and folds flat again as the page turns away.
 */
final readonly class Pop
{
    public function __construct(public int $spread) {}

    public function __invoke(Node $piece, float $depth = 1, float $delay = 0, float $base = 640, bool $shadow = true): Node
    {
        $s = $this->spread;
        $center = Book::PAGE / 2;

        $foldsAway = Book::follow(Node::group([$piece])->origin($center, $base), 'scaleY', $s + 0.05, $s + 0.4, 1, 0.02);

        $standsUp = Node::group([$foldsAway], $shadow ? Paint::fill()->filters(Filter::shadow(5, 8, 5, '#2b17305c')) : null)
            ->origin($center, $base)
            ->parallax('sway', $depth, x: 2.5);

        if ($s === 0) {
            // The first spread pops up as the cover swings open.
            return $standsUp
                ->bind('scaleY', 'shut', ...Book::open(scale: 2.4, offset: -1.1 - 1.5 * $delay, min: 0, max: 1))
                ->bind('translateZ', 'shut', ...Book::open(scale: $depth * 8, min: 0, max: $depth * 8));
        }

        $delay = min($delay, 0.12);
        Book::follow($standsUp, 'scaleY', $s - 0.7 + $delay, $s - 0.12 + $delay, 0.02, 1);

        return Book::follow($standsUp, 'translateZ', $s - 0.7, $s, 0, $depth * 8);
    }
}
