<?php

namespace App\Support\PopupBook;

use Closure;
use Native\Mobile\Skia\Node;

/** One open spread: story text on the left page, a pop-up scene on the right. */
final readonly class Spread
{
    /**
     * @param  list<float>  $paperColor  left page paper, RGB 0–1
     * @param  list<float>  $sceneColor  right page backing paper, RGB 0–1
     * @param  Closure(Pop): list<Node>  $scene
     */
    public function __construct(
        public string $title,
        public string $story,
        public array $paperColor,
        public array $sceneColor,
        public string $ink,
        public string $accent,
        public Closure $scene,
        public ?string $code = null,
    ) {}
}
