<?php

namespace App\Support\PopupBook;

use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Filter;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;

/**
 * The front cover of "The Little App": cloth board, foil-stamped title, and a
 * paper-craft night (the little phone asleep on a cloud, a glowing moon and
 * twinkling paper stars) in an arched window.
 *
 * It hinges on the spine, and only the device's fold opens it (see PopupBookDemo). `open` (0 = shut, 1 = flat open) swings it through
 * rotateY with perspective; the inside of the board is the first left page,
 * so the swing lands exactly on the first spread. Everything here is evaluated
 * natively from `open`, `pulse` and the clock.
 */
final class Cover
{
    private const W = Book::PAGE;

    private const H = Book::HEIGHT;

    /** Gold foil with a brushed grain and a slow specular sweep. */
    public const FOIL = <<<'SKSL'
        uniform float time;
        uniform float2 size;
        half4 main(float2 p) {
            float2 uv = p / size;
            float3 deep = float3(0.60, 0.43, 0.17);
            float3 mid = float3(0.95, 0.80, 0.45);
            float3 high = float3(1.0, 0.97, 0.84);
            float grain = 0.5 + 0.5 * sin(uv.y * 340.0 + sin(uv.x * 40.0) * 2.0);
            float band = 0.5 + 0.5 * sin(uv.y * 11.0 + uv.x * 4.0);
            float3 c = mix(deep, mid, 0.45 + 0.4 * band + 0.08 * grain);
            float sweep = fract(time * 0.16) * 2.6 - 0.8;
            float x = uv.x * 0.8 - uv.y * 0.45 - sweep;
            c = mix(c, high, 0.85 * exp(-x * x * 140.0));
            return half4(half3(c), 1.0);
        }
        SKSL;

    /** Just the moving highlight of the foil, transparent elsewhere. */
    public const SHINE = <<<'SKSL'
        uniform float time;
        uniform float2 size;
        half4 main(float2 p) {
            float2 uv = p / size;
            float sweep = fract(time * 0.16) * 2.6 - 0.8;
            float x = uv.x * 0.8 - uv.y * 0.45 - sweep;
            float a = 0.9 * exp(-x * x * 140.0);
            return half4(half3(1.0, 0.97, 0.84) * a, a);
        }
        SKSL;

    /** The whole swinging cover, spine at local x = 0. */
    public static function node(Node $inside): Node
    {
        $front = Node::group([
            ...self::art(),
            // The board darkens as it lifts away from the light.
            Node::rect(0, 0, self::W, self::H, Paint::fill('#05030f'))->bind('opacity', 'shut', ...Book::open(scale: 1.3, min: 0, max: 0.6)),
        ])->backfaceVisible(false);

        // The inside of the board, pre-mirrored so it reads correctly once the cover lies open on the left.
        $back = Node::group([
            $inside,
            Node::rect(0, 0, self::W, self::H, Paint::fill('#05030f'))->bind('opacity', 'shut', ...Book::open(scale: -1.1, offset: 1.1, min: 0, max: 0.5)),
        ])->origin(self::W / 2, self::H / 2)->transform3d(rotateY: 180)->backfaceVisible(false);

        return Node::group([$front, $back])
            ->id('cover')
            ->transform(Book::PAGE, 0)
            ->origin(0, self::H / 2)
            ->bind('rotateY', 'shut', ...Book::open(scale: -180))
            // Hidden once flat, so the real first page (and its curl) takes over.
            ->bind('opacity', 'shut', ...Book::open(scale: -1000, offset: 1000, min: 0, max: 1))
            ->depth(2_000_000)
            // Not interactive: only unfolding the device opens the book.
            ->accessible('The Little App, a bedtime story about building native apps with Laravel', 'image', 'Unfold the phone to open the book');
    }

    /** Soft shadow the closed book casts on the desk, and the shadow the lifting board throws on the first page. */
    public static function shadows(): array
    {
        $desk = Node::rect(Book::PAGE + 10, 16, self::W, self::H - 8, Paint::fill('#000000b0')->blur(16), 16)
            ->bind('opacity', 'shut', ...Book::open(scale: -2.5, offset: 1, min: 0, max: 1))
            ->depth(1_300_000);

        // Rises as the board lifts, fades as it passes over: two ramps multiplied through nested groups.
        $cast = Node::group([
            Node::group([
                Node::rect(Book::PAGE, 0, self::W, self::H, Paint::fill()->linearGradient(Book::PAGE, 0, Book::PAGE + self::W, 0, ['#000000b8', '#00000055', '#00000000'], [0, 0.35, 1])),
            ])->bind('opacity', 'shut', ...Book::open(scale: -2.2, offset: 2.2, min: 0, max: 1)),
        ])->bind('opacity', 'shut', ...Book::open(scale: 4, min: 0, max: 1))->depth(1_500_000);

        return [$desk, $cast];
    }

    /** Covers whatever lies left of the spine while the book is shut. */
    public static function desk(string $color): Node
    {
        return Node::rect(0, 0, Book::PAGE, self::H, Paint::fill($color))
            ->bind('opacity', 'shut', ...Book::open(scale: -1000, offset: 1000, min: 0, max: 1))
            ->depth(1_200_000);
    }

    /**
     * The full-bleed board. The shut cover overshoots the outer display by ~18 units on every
     * side (about 1 pt per unit there), so the board edge, its rounded corners and most of the
     * spine never show. Everything that matters sits inside a foil frame inset from the
     * display's rounded corners, and the frame steps around the trailing top corner where the
     * Duo's outer display has its camera and status column (window x ≥ ~395 pt, y ≤ ~150 pt):
     * the title goes below the arched night scene, whose apex rises beside that notch.
     *
     * Board units: frame 64…448 × 34…670, notch x > 394 and y < 184 (inner line 384 / 194).
     *
     * @return list<Node>
     */
    private static function art(): array
    {
        $foil = fn () => Paint::fill()->runtimeShader(self::FOIL, ['size' => [self::W, self::H]], 'time');
        $foilStroke = fn (float $width) => Paint::stroke('#e8c77a', $width)->runtimeShader(self::FOIL, ['size' => [self::W, self::H]], 'time');
        $title = fn (Paint $paint) => Node::paragraph('The Little App', 74, 498, 364, 56, $paint, font: 'lobster', align: 'center');

        return [
            // Cloth-bound board with a hinge groove along the spine.
            Node::group([
                Node::rect(0, 0, self::W, self::H, Paint::fill()->runtimeShader(Shaders::PAPER, ['paper' => [0.125, 0.14, 0.33], 'seed' => 91])),
                Node::rect(0, 0, self::W, self::H, Paint::fill()->radialGradient(256, 330, 540, ['#ffe7a018', '#00000000', '#00000055'], [0, 0.6, 1])),
                Node::rect(0, 0, 40, self::H, Paint::fill()->linearGradient(0, 0, 40, 0, ['#00000090', '#00000030'])),
                Node::line(42, 0, 42, self::H, Paint::stroke('#00000070', 3)),
                Node::line(45, 0, 45, self::H, Paint::stroke('#ffffff1c', 1.5)),
            ])->clip('M0 0 H484 Q500 0 500 16 V688 Q500 704 484 704 H0 Z'),

            // Foil frame, notched around the camera and status column, with corner diamonds.
            Node::path('M76 34 H382 Q394 34 394 46 V172 Q394 184 406 184 H436 Q448 184 448 196 V658 Q448 670 436 670 H76 Q64 670 64 658 V46 Q64 34 76 34 Z', $foilStroke(3)),
            Node::path('M82 44 H376 Q384 44 384 52 V186 Q384 194 392 194 H430 Q438 194 438 202 V652 Q438 660 430 660 H82 Q74 660 74 652 V52 Q74 44 82 44 Z', $foilStroke(1.2)),
            ...array_map(fn (array $c) => Node::path(sprintf('M%1$d %2$d l8 -8 l8 8 l-8 8 Z', $c[0] - 8, $c[1]), $foil()), [[74, 44], [384, 44], [438, 194], [74, 660], [438, 660]]),

            Node::paragraph('A SUPERNATIVE PICTURE BOOK', 116, 62, 280, 13, Paint::fill('#d9bf80'), font: 'josefin', align: 'center'),

            // The arched night scene, its apex beside the notch.
            Node::group([self::window()])->transform(13, -20.4, 0, 0.9, 0.9),

            // Foil-stamped, debossed title: a shadow pressed into the cloth, a lit lower lip, then the foil.
            $title(Paint::fill('#04021099')->blur(1.6))->transform(1.5, 3),
            $title(Paint::fill('#ffffff30'))->transform(-1, -1.2),
            // Foil letters, with the light sweep composited onto the letters only (srcATop in an isolated layer).
            Node::group([
                $title(Paint::fill()->runtimeShader(self::FOIL, ['size' => [self::W, self::H], 'time' => 0])),
                Node::rect(74, 490, 364, 84, Paint::fill()->runtimeShader(self::SHINE, ['size' => [self::W, self::H]], 'time')->blend('srcATop')),
            ], Paint::fill()),

            Node::paragraph("A bedtime story about building\nnative apps with Laravel", 74, 574, 364, 18, Paint::fill('#ece0c4'), font: 'josefin-light', align: 'center'),
            Node::path('M196 640 H246 M266 640 H316', $foilStroke(1.5)),
            Node::path('M256 632 l8 8 l-8 8 l-8 -8 Z', $foil()),
        ];
    }

    /** The arched window: twinkling sky, glowing moon, paper stars, clouds and the little phone asleep. */
    private static function window(): Node
    {
        $arch = 'M96 566 V350 A174 174 0 0 1 444 350 V566 Z';
        $paper = Paint::fill()->filters(Filter::shadow(3, 6, 4, '#0a061a80'));

        $stars = [];
        foreach ([[150, 300, 13, 2.6], [404, 420, 9, 3.4], [196, 236, 8, 2.1], [130, 420, 7, 3.9], [312, 250, 6, 2.9], [424, 330, 7, 2.3]] as $i => [$x, $y, $r, $period]) {
            $stars[] = Node::path(self::star($x, $y, $r), Paint::fill($i % 2 ? '#fff3c4' : '#ffd27a'))
                ->origin($x, $y)
                ->animate('scaleX', Animation::between(0.55, 1.15, $period, 'easeInOut', 'mirror'))
                ->animate('scaleY', Animation::between(0.55, 1.15, $period, 'easeInOut', 'mirror'))
                ->animate('opacity', Animation::between(0.55, 1, $period * 0.7, 'easeInOut', 'mirror'));
        }

        return Node::group([
            Node::group([
                Node::rect(96, 176, 348, 390, Paint::fill()->runtimeShader(Shaders::STARS, ['top' => [0.03, 0.05, 0.17], 'bottom' => [0.2, 0.16, 0.42], 'height' => 566], 'time')),
                // Gentle glow around the moon, breathing with `pulse`.
                Node::circle(352, 282, 120, Paint::fill()->radialGradient(352, 282, 120, ['#ffe7a066', '#ffe7a000']))->bind('opacity', 'pulse', scale: 0.6, offset: 0.4),
                Node::combine('M352 236 a46 46 0 1 0 0.1 0 Z', 'M372 224 a40 40 0 1 0 0.1 0 Z', 'difference',
                    Paint::fill('#fff3c4')->filters(Filter::glow(10, '#ffe7a0', spread: 2)->bind('sigma', 'pulse', scale: 12, offset: 6))),
                ...$stars,
                // Paper hills and clouds, layered like a pop-up.
                Node::group([Node::path('M96 520 Q190 452 300 498 T444 470 V566 H96 Z', Paint::fill('#3a3474'))], $paper),
                Node::group([self::cloud(110, 478, 1.3, '#8f86c9'), self::cloud(330, 492, 1.1, '#8f86c9')], $paper)
                    ->animate('translateX', Animation::between(-8, 8, 7, 'easeInOut', 'mirror')),
                Node::group([self::phone()], $paper)->animate('translateY', Animation::between(0, -7, 2.6, 'easeInOut', 'mirror')),
                Node::group([self::cloud(150, 540, 2.2, '#f1eaff'), self::cloud(290, 548, 1.8, '#e6dcff')], $paper),
            ])->clip($arch),
            Node::path($arch, Paint::stroke('#e8c77a', 2.5)->runtimeShader(self::FOIL, ['size' => [self::W, self::H]], 'time')),
        ]);
    }

    /** The little phone, asleep and smiling. */
    private static function phone(): Node
    {
        return Node::group([
            Node::rect(-44, -78, 88, 156, Paint::fill('#f4ecff'), 20),
            Node::rect(-36, -66, 72, 126, Paint::fill('#9be7ff'), 12),
            Node::rect(-12, -73, 24, 4, Paint::fill('#c9bfe6'), 2),
            Node::path('M-20 -8 q7 7 14 0 M6 -8 q7 7 14 0', Paint::stroke('#2b2350', 3.2)->cap('round')),
            Node::circle(-22, 8, 6, Paint::fill('#ff8fab88')),
            Node::circle(22, 8, 6, Paint::fill('#ff8fab88')),
            Node::path('M-8 14 Q0 22 8 14', Paint::stroke('#2b2350', 3)->cap('round')),
            Node::path('M0 40 C-4 36 -9 40 0 48 C9 40 4 36 0 40 Z', Paint::fill('#ff2d20')),
        ])->transform(270, 446, -8);
    }

    private static function cloud(float $x, float $y, float $s, string $color): Node
    {
        return Node::group([
            Node::circle(22, 22, 22, Paint::fill($color)),
            Node::circle(50, 14, 28, Paint::fill($color)),
            Node::circle(80, 24, 20, Paint::fill($color)),
            Node::rect(0, 22, 100, 22, Paint::fill($color), 11),
        ])->transform($x, $y, 0, $s, $s);
    }

    private static function star(float $x, float $y, float $r): string
    {
        $points = [];
        foreach (range(0, 9) as $k) {
            $a = -M_PI / 2 + $k * M_PI / 5;
            $d = $k % 2 ? $r * 0.45 : $r;
            $points[] = sprintf('%.1f %.1f', $x + $d * cos($a), $y + $d * sin($a));
        }

        return 'M'.implode(' L', $points).' Z';
    }
}
