<?php

declare(strict_types=1);

namespace App\Support\Skia;

use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;
use Native\Mobile\Skia\Scene;

/** Original product compositions, rendered by the same native scene API as the gallery. */
final class Products
{
    public static function chart(bool $interactive = false): Scene
    {
        $scene = Scene::make(600, 440)->background('#101724')->value('cursor', 300);
        $scene->add(Node::text('PORTFOLIO', 34, 43, 12, Paint::fill('#93a2b9')),
            Node::text('$48,592.80', 30, 99, 48, Paint::fill('#f4f8ff')),
            Node::rect(425, 61, 140, 34, Paint::fill('#183c34'), 17),
            Node::text('+18.42%', 445, 84, 19, Paint::fill('#a8ffe1')));
        foreach (range(0, 3) as $i) {
            $y = 155 + $i * 54;
            $scene->add(Node::line(32, $y, 565, $y, Paint::stroke('#263249', 1)));
        }
        $curve = 'M32 315 C55 315 63 248 90 259 S126 300 156 245 S188 283 220 236 S250 213 281 240 S304 142 342 174 S385 211 417 149 S450 180 479 127 S526 162 564 116';
        $scene->add(Node::path($curve.' L564 345 L32 345 Z', Paint::fill()->linearGradient(0, 120, 0, 345, ['#a8ffe146', '#a8ffe100'])),
            Node::path($curve, Paint::stroke('#a8ffe1', 4)->cap('round')->shadow(0, 0, 9, '#a8ffe166')),
            ($interactive ? Node::line(0, 137, 0, 345, Paint::stroke('#eef7ff88', 1)->dash([4, 5]))->bind('translateX', 'cursor') : Node::line(0, 137, 0, 345, Paint::stroke('#eef7ff88', 1)->dash([4, 5]))->animate('translateX', Animation::between(90, 510, 2.8, 'easeInOut', 'mirror'))),
            Node::rect(32, 375, 532, 1, Paint::fill('#263249')));
        foreach (['1D', '1W', '1M', '3M', '1Y', 'ALL'] as $i => $label) {
            $scene->add(Node::text($label, 48 + $i * 91, 412, 14, Paint::fill($i === 3 ? '#a8ffe1' : '#8292ad')));
        }

        if ($interactive) {
            $scene->add(Node::rect(32, 120, 532, 225, Paint::fill('#ffffff01'))->id('chart-cursor')->draggable('cursor')->dragLimits(32, 564, 0, 440)->accessible('Portfolio price chart', 'image', 'Drag to inspect a date', ['earlier', 'later']));
        }

        return $scene;
    }

    public static function poster(): Scene
    {
        $scene = Scene::make(600, 440)->background('#eedfc8')->value('x', 0)->value('y', 0)->value('zoom', 1)->value('angle', 0)->value('titleX', 0)->value('titleY', 0);
        $scene->add(Node::text('FIELD NOTES / VOL. 026', 30, 36, 12, Paint::fill('#292522')),
            Node::line(30, 51, 570, 51, Paint::stroke('#a49b8c', 1)));
        $graphic = [];
        for ($i = 0; $i < 17; $i++) {
            $graphic[] = Node::oval(-170 + $i * 6, -105 + $i * 3, 340 - $i * 12, 210 - $i * 6, Paint::stroke($i % 2 ? '#352448' : '#df502f', 7));
        }
        $scene->add(Node::group($graphic)->id('poster-art')->transform(370, 211, -27)->bind('translateX', 'x')->bind('translateY', 'y')->bind('scaleX', 'zoom')->bind('scaleY', 'zoom')->bind('rotation', 'angle')->draggable('x', 'y', 10, true)->dragLimits(100, 500, 80, 330)->accessible('Poster rings', 'image', 'Drag to arrange. Release to snap to the grid.', ['rotate', 'reset']));
        // Shared values are absolute transforms, so initialize the design's intended pose.
        $scene->value('x', 370)->value('y', 211)->value('angle', -27);
        $scene->add(Node::group([
            Node::text('MAKE', 28, 146, 76, Paint::fill('#242126')),
            Node::text('YOUR', 28, 222, 76, Paint::fill('#242126')),
            Node::text('MARK.', 28, 298, 76, Paint::fill('#242126')),
        ])->id('poster-title')->bind('translateX', 'titleX')->bind('translateY', 'titleY')->draggable('titleX', 'titleY', 10)->dragLimits(-20, 260, -60, 50)->accessible('Make your mark headline', 'text', 'Drag the headline to rearrange the poster'),
            Node::rect(30, 358, 111, 41, Paint::fill('#dc512f')),
            Node::text('CREATE', 46, 385, 18, Paint::fill('#fff4de')),
            Node::text('DRAG. ARRANGE. EXPORT.', 280, 388, 14, Paint::fill('#352448')));

        return $scene;
    }

    public static function drawing(bool $interactive = false): Scene
    {
        $scene = Scene::make(600, 440)->background('#fbf7ef')->add(
            Node::text('A space to think.', 30, 48, 26, Paint::fill('#302a42')),
            Node::text('DRAW / NOTE / SIGN', 387, 45, 12, Paint::fill('#8f879d')),
            ($interactive ? Node::rect(24, 70, 552, 275, Paint::fill('#fbf7ef'))->id('ink-surface')->ink('#5f44b3', 9)->accessible('Drawing paper', 'image', 'Draw with a finger or pressure-sensitive stylus', ['undo', 'clear']) : Node::path('M50 255 C75 180 84 105 132 119 S164 318 208 260 S220 148 275 180 S286 306 335 215 S403 165 450 210 S496 285 552 164', Paint::stroke('#5f44b3', 9)->cap('round')->join('round'))->id('ink')),
            Node::circle(46, 387, 14, Paint::fill('#5f44b3')),
            Node::circle(90, 387, 14, Paint::fill('#dd5947')),
            Node::circle(134, 387, 14, Paint::fill('#3b9a89')),
            Node::line(194, 386, 263, 386, Paint::stroke('#302a42', 5)->cap('round')),
            Node::text('Your ideas. Your canvas.', 351, 393, 15, Paint::fill('#8f879d'))
        );

        return $scene;
    }

    public static function particles(): Scene
    {
        $scene = Scene::make(600, 440)->background('#080d1c')->value('fieldX', 300)->value('fieldY', 229);
        $dots = [];
        for ($i = 0; $i < 900; $i++) {
            $angle = $i * 2.39996323;
            $radius = 5.7 * sqrt($i);
            $dots[] = Node::circle(cos($angle) * $radius, sin($angle) * $radius, 1.2 + ($i % 5) * .38, Paint::fill(['#a8ffe1', '#778cff', '#ff86d9'][$i % 3])->opacity(.3 + ($i % 7) / 10));
        }
        $scene->add(Node::group($dots)->cache()->id('particle-field')->bind('translateX', 'fieldX')->bind('translateY', 'fieldY')->animate('rotation', Animation::between(0, 360, 16))->draggable('fieldX', 'fieldY', 0, true)->dragLimits(150, 450, 100, 330)->accessible('Nine hundred animated particles', 'image', 'Drag to move the field'),
            Node::text('900 INDIVIDUAL SHAPES', 28, 35, 12, Paint::fill('#a8ffe1')),
            Node::text('Find your flow.', 28, 413, 29, Paint::fill('#f2f5ff')));

        return $scene;
    }
}
