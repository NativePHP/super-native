<?php

namespace App\Support\PopupBook;

use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Filter;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;
use Native\Mobile\Skia\TextStyle;

/** "The Little App": a bedtime story about building native apps with Laravel. */
final class Story
{
    /** @return list<Spread> */
    public static function spreads(): array
    {
        return [
            new Spread('A Dream in the Dark',
                "Once upon a time,\nby the light of one lamp,\na PHP developer\ndreamed of an app.\nNot a website this time,\nbut a thing she could hold,\nwith buttons to tap\nand a story to be told.",
                self::rgb('#f8efdc'), self::rgb('#1f2447'), '#2f2747', '#d9534f', self::dream(...)),
            new Spread('Building Blocks',
                "So she opened her laptop\nand called on her friends:\nRoutes laid the roads\nand Blade drew the ends.\nBlock upon block,\nwith a click and a clack,\na little phone grew\nfrom a Laravel stack.",
                self::rgb('#fbf1e1'), self::rgb('#fbe2c4'), '#5a3a2e', '#e0533d', self::blocks(...)),
            new Spread('The Phone Wakes Up',
                "Then the little phone yawned\nand opened its eyes.\nIts buttons sprang up,\nto its own great surprise!\nA list rolled out\nand a tab bar glowed bright:\ntruly native, my dear,\nfrom pixel to light.",
                self::rgb('#f6f3e6'), self::rgb('#d8eee4'), '#1f4d4a', '#2a9d8f', self::wakes(...)),
            new Spread('The Bridge',
                "But PHP lived\non one side of the stream,\nand the phone on the other,\nas shy as a dream.\nSo a bridge unfolded,\nplank after plank,\nand a packet skipped over.\nAnd nobody sank.",
                self::rgb('#f8efe8'), self::rgb('#f3dde3'), '#3d2f5b', '#7b5ea7', self::bridge(...)),
            new Spread('To the Stars',
                "Up through the clouds\nand the deep velvet sky,\nthe app took off\nwith a whoosh and a sigh.\nThe stars kept a store for it,\nshining and new,\nand a thousand small phones\nwhispered, \"Me too!\"",
                self::rgb('#f4f1fa'), self::rgb('#141838'), '#2b2350', '#6c5ce7', self::stars(...)),
            new Spread('Goodnight',
                "Now the developer sleeps\nand the moon softly glows.\nThe app on the nightstand\nkeeps watch as it goes.\nSweet dreams, little coder.\nTomorrow, you'll see,\nit all starts again\nwith one line. Maybe three:",
                self::rgb('#f7f0e2'), self::rgb('#24224a'), '#2f2747', '#8a7cd8', self::goodnight(...), code: 'php artisan native:run'),
        ];
    }

    /** The left page: chapter, title and the rhyme. */
    public static function text(Spread $spread, int $index): array
    {
        $ink = Paint::fill($spread->ink);
        $nodes = [
            Node::paragraph('THE LITTLE APP  ·  '.['I', 'II', 'III', 'IV', 'V', 'VI'][$index], 56, 72, 400, 14, Paint::fill($spread->accent), font: 'josefin')
                ->textStyle(TextStyle::make()->font('josefin')->size(14)->paint(Paint::fill($spread->accent))->letterSpacing(3)),
            Node::text($spread->title, 54, 156, 50, $ink, 'lobster'),
            Node::path('M56 186 H150 M214 186 H308', Paint::stroke($spread->accent.'99', 2)->cap('round')),
            Node::path('M182 178 L190 186 L182 194 L174 186 Z', Paint::fill($spread->accent)),
            Node::paragraph($spread->story, 56, 220, 400, 23, $ink, font: 'josefin')
                ->textStyle(TextStyle::make()->font('josefin')->size(23)->paint($ink)->height(1.42)),
            Node::paragraph((string) ($index * 2 + 1), 0, 652, 500, 15, Paint::fill($spread->ink.'99'), font: 'josefin', align: 'center'),
        ];
        if ($spread->code !== null) {
            $nodes[] = Node::rect(56, 520, 388, 66, Paint::fill('#2b2350')->filters(Filter::shadow(4, 6, 6, '#2b235055')), 16);
            $nodes[] = Node::text('$', 80, 562, 24, Paint::fill('#7ee3b3'), 'josefin');
            $nodes[] = Node::text($spread->code, 104, 562, 24, Paint::fill('#e8e4ff'), 'josefin');
        }

        return $nodes;
    }

    /** I. A developer, a laptop, a lantern and an elephant, late at night. */
    private static function dream(Pop $pop): array
    {
        $moonGlow = Filter::glow(10, '#ffe7a0', spread: 3)->bind('sigma', 'pulse', scale: 10, offset: 8);
        $lampGlow = Filter::glow(8, '#ffb347', spread: 2)->bind('sigma', 'pulse', scale: 12, offset: 6);

        return [
            Node::rect(0, 640, 500, 64, Paint::fill('#2a2346')),
            $pop(Node::group([
                Node::rect(108, 78, 284, 254, Paint::fill('#e9dcc0'), 10),
                Node::rect(122, 92, 256, 226, Paint::fill()->runtimeShader(Shaders::STARS, ['top' => self::rgb('#0d1130'), 'bottom' => self::rgb('#3b2f6b'), 'height' => 330], 'time')),
                Node::circle(318, 150, 26, Paint::fill('#fff3c4')->filters($moonGlow)),
                Node::rect(247, 92, 6, 226, Paint::fill('#e9dcc0')),
                Node::rect(122, 202, 256, 6, Paint::fill('#e9dcc0')),
            ]), depth: 1, base: 332),
            $pop(Node::group([
                self::cloud(54, 132, 1.5, '#f4ecff'),
                Node::rect(100, 92, 36, 62, Paint::stroke('#d9534f', 3), 8),
                Node::circle(118, 144, 3, Paint::fill('#d9534f')),
                Node::circle(160, 236, 9, Paint::fill('#f4ecff')),
                Node::circle(184, 268, 6, Paint::fill('#f4ecff')),
                Node::circle(204, 296, 4, Paint::fill('#f4ecff')),
            ])->animate('translateY', Animation::between(0, -9, 2.2, 'easeInOut', 'mirror')), depth: 4, delay: 0.45, base: 300),
            $pop(Node::group([
                Node::path('M160 504 Q166 420 250 416 Q334 420 340 504 Z', Paint::fill('#5b6bb5')),
                Node::circle(250, 330, 20, Paint::fill('#3a2a4a')),
                Node::circle(250, 372, 44, Paint::fill('#f2c9a5')),
                Node::path('M206 366 Q210 324 250 324 Q290 324 294 366 Q270 346 250 350 Q228 346 206 366 Z', Paint::fill('#3a2a4a')),
                Node::circle(232, 378, 11, Paint::stroke('#3a2a4a', 3)),
                Node::circle(268, 378, 11, Paint::stroke('#3a2a4a', 3)),
                Node::path('M243 378 H257', Paint::stroke('#3a2a4a', 3)),
                Node::path('M240 400 Q250 406 260 400', Paint::stroke('#b5654a', 2.5)->cap('round')),
                Node::oval(196, 360, 108, 70, Paint::fill('#bfe6ff'))->animate('opacity', Animation::between(0.12, 0.3, 1.3, 'easeInOut', 'mirror')),
            ]), depth: 1.6, delay: 0.15, base: 504),
            $pop(Node::group([
                Node::path('M172 504 L188 424 H312 L328 504 Z', Paint::fill('#c9ced8')),
                Node::path('M172 504 L188 424 H312 L328 504 Z', Paint::stroke('#9aa1b2', 2)),
                Node::path('M250 452 C243 444 232 452 250 468 C268 452 257 444 250 452 Z', Paint::fill('#ff2d20')),
            ]), depth: 2.4, delay: 0.22, base: 504),
            $pop(self::elephant(352, 438, 1, '#8892bf'), depth: 2.8, delay: 0.3, base: 504),
            $pop(Node::group([
                Node::rect(36, 500, 428, 22, Paint::fill('#8a5a3c'), 5),
                Node::rect(66, 520, 18, 130, Paint::fill('#6e4630')),
                Node::rect(416, 520, 18, 130, Paint::fill('#6e4630')),
            ]), depth: 2, delay: 0.08, base: 650),
            $pop(Node::group([
                Node::line(430, 0, 430, 222, Paint::stroke('#c9b48a', 2)),
                Node::rect(416, 214, 28, 10, Paint::fill('#3a2a4a'), 3),
                Node::rect(408, 222, 44, 60, Paint::fill('#ff2d20'), 12),
                Node::rect(418, 234, 24, 36, Paint::fill('#ffd27a')->filters($lampGlow), 6),
                Node::rect(416, 280, 28, 8, Paint::fill('#3a2a4a'), 3),
            ])->origin(430, 0)->animate('rotation', Animation::between(-7, 7, 2.6, 'easeInOut', 'mirror')), depth: 3, delay: 0.3, base: 0),
        ];
    }

    /** II. Routes, Blade and friends stack up into a phone; a crane brings the last block. */
    private static function blocks(Pop $pop): array
    {
        $blocks = [['Route', '#e0533d'], ['Blade', '#f2a541'], ['Model', '#3fa7a3'], ['Event', '#8b7fd1'], ['Queue', '#5b8def']];
        $nodes = [
            Node::path(self::rays(250, 380, 14, 420), Paint::fill('#f9d6a5'))->origin(250, 380)
                ->animate('rotation', Animation::between(0, 360, 90, 'linear', 'loop')),
            Node::path('M0 604 Q250 560 500 604 V704 H0 Z', Paint::fill('#e7b98a')),
            $pop(Node::group([
                Node::rect(140, 150, 220, 420, Paint::fill('#fff8ec'), 34),
                Node::rect(140, 150, 220, 420, Paint::stroke('#3b2a5a', 8), 34),
                Node::rect(220, 168, 60, 8, Paint::fill('#3b2a5a'), 4),
            ]), depth: 1, base: 570),
        ];
        foreach ($blocks as $k => [$label, $color]) {
            [$x, $y] = [164 + ($k % 2) * 92, 196 + intdiv($k, 2) * 118];
            $nodes[] = $pop(self::block($x, $y, $label, $color), depth: 2, delay: 0.02 * $k, base: $y + 104);
        }
        $drop = Animation::sequence(
            Animation::between(-160, 0, 1.3, 'easeOut', 'once'),
            Animation::between(0, 0, 1.6, 'linear', 'once'),
            Animation::between(0, -160, 1.1, 'easeInOut', 'once'),
            Animation::between(-160, -160, 0.5, 'linear', 'once'),
        )->repeat('loop');
        $nodes[] = $pop(Node::group([
            Node::rect(446, 34, 12, 570, Paint::fill('#f2a541')),
            Node::path('M446 60 L458 80 M446 120 L458 140 M446 180 L458 200 M446 240 L458 260', Paint::stroke('#b4741f', 3)),
            Node::rect(290, 30, 176, 14, Paint::fill('#f2a541'), 3),
            Node::rect(304, 44, 2, 268, Paint::fill('#5a3a2e'))->animate('height', Animation::sequence(
                Animation::between(108, 268, 1.3, 'easeOut', 'once'), Animation::between(268, 268, 1.6, 'linear', 'once'),
                Animation::between(268, 108, 1.1, 'easeInOut', 'once'), Animation::between(108, 108, 0.5, 'linear', 'once'),
            )->repeat('loop')),
            Node::group([self::block(256, 432, 'View', '#e86a92')])->animate('translateY', $drop),
        ]), depth: 3, delay: 0.12, base: 604);
        foreach ([[70, 120, 1.1], [420, 330, 1.6], [90, 470, 1.3], [380, 640, 0.9]] as [$x, $y, $speed]) {
            $nodes[] = self::sparkle($x, $y, 12, '#ffffff', $speed);
        }

        return $nodes;
    }

    /** III. The phone blinks awake; buttons, a list and a glowing tab bar spring in. */
    private static function wakes(Pop $pop): array
    {
        $blink = fn () => Animation::sequence(
            Animation::between(1, 1, 2.6, 'linear', 'once'),
            Animation::between(1, 0.1, 0.08, 'easeIn', 'once'),
            Animation::between(0.1, 1, 0.12, 'easeOut', 'once'),
        )->repeat('loop');
        $tabGlow = Filter::glow(6, '#5eead4', spread: 2)->bind('sigma', 'pulse', scale: 12, offset: 4)->bind('opacity', 'pulse', scale: 0.6, offset: 0.4);

        $nodes = [
            Node::circle(250, 360, 230, Paint::fill('#cfe8dc')),
            Node::circle(250, 360, 160, Paint::fill('#c4e2d4')),
            $pop(Node::group([
                Node::rect(116, 84, 268, 556, Paint::fill('#263159'), 42),
                Node::rect(132, 124, 236, 476, Paint::fill('#fff8ec'), 28),
                Node::rect(214, 100, 72, 10, Paint::fill('#11173a'), 5),
            ]), depth: 1, base: 640),
            $pop(Node::group([
                Node::oval(-8, -11, 16, 22, Paint::fill('#263159'))->transform(212, 176)->animate('scaleY', $blink()),
                Node::oval(-8, -11, 16, 22, Paint::fill('#263159'))->transform(288, 176)->animate('scaleY', $blink()),
                Node::path('M230 204 Q250 222 270 204', Paint::stroke('#263159', 4)->cap('round')),
                Node::circle(196, 204, 9, Paint::fill('#f6a6b2aa')),
                Node::circle(304, 204, 9, Paint::fill('#f6a6b2aa')),
            ]), depth: 1.6, delay: 0.03, base: 226),
            $pop(Node::group([
                Node::rect(152, 244, 196, 48, Paint::fill('#2a9d8f'), 24),
                Node::paragraph('Hello, native!', 152, 258, 196, 19, Paint::fill('#ffffff'), font: 'josefin', align: 'center'),
            ]), depth: 2.2, delay: 0.05, base: 292),
            $pop(Node::group([
                Node::rect(152, 302, 196, 40, Paint::stroke('#2a9d8f', 3), 20),
                Node::paragraph('Tap me', 152, 313, 196, 17, Paint::fill('#2a9d8f'), font: 'josefin', align: 'center'),
            ]), depth: 2, delay: 0.07, base: 342),
        ];
        foreach ([['#e0533d', 120], ['#f2a541', 84], ['#8b7fd1', 104]] as $k => [$color, $bar]) {
            $y = 360 + $k * 56;
            $nodes[] = $pop(Node::group([
                Node::rect(152, $y, 196, 46, Paint::fill('#f1e6d6'), 14),
                Node::circle(176, $y + 23, 12, Paint::fill($color)),
                Node::rect(198, $y + 13, $bar, 8, Paint::fill('#263159cc'), 4),
                Node::rect(198, $y + 27, $bar * 0.6, 6, Paint::fill('#26315966'), 3),
            ]), depth: 1.8, delay: 0.08 + 0.015 * $k, base: $y + 46);
        }
        $nodes[] = $pop(Node::group([
            Node::rect(146, 540, 208, 46, Paint::fill('#263159')->filters($tabGlow), 23),
            Node::circle(184, 563, 7, Paint::fill('#5eead4')),
            Node::circle(228, 563, 6, Paint::fill('#fff8ec99')),
            Node::circle(272, 563, 6, Paint::fill('#fff8ec99')),
            Node::circle(316, 563, 6, Paint::fill('#fff8ec99')),
        ]), depth: 2.6, delay: 0.12, base: 586);
        foreach ([[70, 140, 1.2], [440, 200, 0.9], [60, 520, 1.5], [440, 560, 1.1], [420, 90, 1.7]] as [$x, $y, $speed]) {
            $nodes[] = self::sparkle($x, $y, 11, '#2a9d8f', $speed);
        }

        return $nodes;
    }

    /** IV. A paper bridge unfolds plank by plank and a packet hops across it. */
    private static function bridge(Pop $pop): array
    {
        $nodes = [
            Node::rect(0, 0, 500, 540, Paint::fill()->linearGradient(0, 0, 0, 540, ['#b9a3d9', '#f6c9a8'])),
            Node::circle(250, 300, 46, Paint::fill('#ffd29a')->filters(Filter::glow(12, '#ffb38a', spread: 4)->bind('sigma', 'pulse', scale: 10, offset: 10))),
            Node::path('M0 430 Q120 360 250 410 T500 400 V560 H0 Z', Paint::fill('#c9a6c9')),
            Node::rect(0, 520, 500, 184, Paint::fill('#5b8fc7')),
            Node::path(self::waves(-60, 560, 620, 12), Paint::stroke('#8dbbe6', 4)->cap('round'))
                ->animate('translateX', Animation::between(0, 40, 2.8, 'easeInOut', 'mirror')),
            Node::path(self::waves(-60, 620, 620, 14), Paint::stroke('#4a7bb4', 5)->cap('round'))
                ->animate('translateX', Animation::between(30, -10, 3.4, 'easeInOut', 'mirror')),
            $pop(Node::group([
                Node::path('M0 388 Q70 372 154 392 L176 704 H0 Z', Paint::fill('#8c6f9e')),
                Node::path('M0 388 Q70 372 154 392 L156 404 Q70 386 0 402 Z', Paint::fill('#7fb38f')),
                Node::rect(36, 300, 8, 92, Paint::fill('#6e4630')),
                Node::rect(10, 290, 70, 34, Paint::fill('#7b5ea7'), 6),
                Node::paragraph('PHP', 10, 298, 70, 18, Paint::fill('#ffffff'), font: 'josefin', align: 'center'),
                self::elephant(84, 350, 0.55, '#8892bf'),
            ]), depth: 1.5, base: 704),
            $pop(Node::group([
                Node::path('M346 392 Q430 372 500 380 V704 H326 Z', Paint::fill('#8c6f9e')),
                Node::path('M346 392 Q430 372 500 380 V394 Q430 386 346 404 Z', Paint::fill('#7fb38f')),
                Node::rect(406, 300, 48, 84, Paint::fill('#263159'), 12),
                Node::rect(412, 310, 36, 62, Paint::fill('#fff8ec'), 8),
                Node::circle(422, 334, 3.5, Paint::fill('#263159')),
                Node::circle(438, 334, 3.5, Paint::fill('#263159')),
                Node::path('M424 346 Q430 352 436 346', Paint::stroke('#263159', 2)->cap('round')),
            ]), depth: 1.5, delay: 0.03, base: 704),
            $pop(Node::path('M150 368 Q250 330 350 368', Paint::stroke('#6e4630', 3)), depth: 2.2, delay: 0.04, base: 400, shadow: false),
        ];
        foreach (range(0, 8) as $k) {
            $x = 152 + $k * 22;
            $y = 392 - 20 * sin(M_PI * ($k + 0.5) / 9);
            $nodes[] = $pop(Node::group([
                Node::line($x + 9, 368 - 38 * sin(M_PI * ($k + 0.5) / 9) + 10, $x + 9, $y, Paint::stroke('#6e463099', 1.5)),
                Node::rect($x, $y, 19, 12, Paint::fill('#c58b5a'), 2),
            ]), depth: 2.2, delay: 0.012 * $k, base: $y + 12);
        }
        $nodes[] = $pop(Node::group([
            Node::group([
                Node::rect(-15, -11, 30, 22, Paint::fill('#fff7e0')->filters(Filter::glow(4, '#ffe08a', spread: 2)), 4),
                Node::path('M-15 -9 L0 3 L15 -9', Paint::stroke('#d9a441', 2)->join('round')),
            ])->transform(0, 0)
                ->animate('translateX', Animation::between(166, 334, 2.6, 'easeInOut', 'mirror'))
                ->animate('translateY', Animation::between(368, 346, 0.325, 'easeOut', 'mirror')),
        ]), depth: 3.2, delay: 0.1, base: 392);
        foreach ([[40, 250], [300, 230], [470, 280], [200, 470]] as $k => [$x, $y]) {
            $nodes[] = Node::circle($x, $y, 3, Paint::fill('#fff3b0')->filters(Filter::glow(3, '#fff3b0', spread: 1)))
                ->animate('opacity', Animation::between(0.15, 1, 0.9 + 0.35 * $k, 'easeInOut', 'mirror'));
        }

        return $nodes;
    }

    /** V. The app launches through the clouds under an aurora. */
    private static function stars(Pop $pop): array
    {
        $flame = Animation::between(0.75, 1.2, 0.14, 'easeInOut', 'mirror');

        return [
            Node::rect(0, 0, 500, 704, Paint::fill()->runtimeShader(Shaders::AURORA, ['size' => [500, 704]], 'time')),
            Node::path('M250 60 L272 122 L338 124 L286 162 L304 226 L250 188 L196 226 L214 162 L162 124 L228 122 Z',
                Paint::stroke('#fff3c4cc', 2)->join('round'))
                ->animate('trimEnd', Animation::between(0, 1, 4, 'easeInOut', 'mirror')),
            $pop(Node::group([
                self::cloud(-30, 560, 2.0, '#8f86c9'), self::cloud(150, 580, 1.6, '#8f86c9'), self::cloud(330, 556, 2.1, '#8f86c9'),
            ])->animate('translateX', Animation::between(-18, 18, 9, 'easeInOut', 'mirror')), depth: 1, base: 704),
            $pop(Node::group([
                Node::path('M-8 92 Q0 150 8 92 Z', Paint::fill('#ffd27a'))->origin(0, 92)->animate('scaleY', $flame),
                Node::path('M-14 84 Q0 124 14 84 Z', Paint::fill('#ff7b54'))->origin(0, 84)->animate('scaleY', Animation::between(0.8, 1.15, 0.11, 'easeInOut', 'mirror')),
                Node::path('M-34 40 L-58 86 L-30 76 Z M34 40 L58 86 L30 76 Z', Paint::fill('#6c5ce7')),
                Node::rect(-36, -76, 72, 160, Paint::fill('#f4ecff'), 18),
                Node::rect(-28, -60, 56, 124, Paint::fill('#9be7ff'), 10),
                Node::circle(-10, -12, 4, Paint::fill('#2b2350')),
                Node::circle(10, -12, 4, Paint::fill('#2b2350')),
                Node::path('M-10 6 Q0 16 10 6', Paint::stroke('#2b2350', 3)->cap('round')),
            ])->transform(250, 330, 22)->animate('translateY', Animation::between(338, 316, 1.7, 'easeInOut', 'mirror')), depth: 3, delay: 0.05, base: 520),
            $pop(Node::group([
                self::cloud(-50, 640, 2.4, '#f6f1ff'), self::cloud(200, 660, 2.0, '#efe8ff'), self::cloud(380, 636, 2.3, '#f6f1ff'),
            ])->animate('translateX', Animation::between(20, -20, 7, 'easeInOut', 'mirror')), depth: 2, delay: 0.08, base: 704),
            $pop(Node::group([
                self::miniPhone(80, 300, '#ff8fab'), self::miniPhone(400, 260, '#7ee3b3'), self::miniPhone(430, 420, '#ffd27a'),
            ])->animate('translateY', Animation::between(0, -10, 2.4, 'easeInOut', 'mirror')), depth: 1.6, delay: 0.1, base: 460),
        ];
    }

    /** VI. Sleep: the moon pulses, the blanket breathes, the app keeps watch. */
    private static function goodnight(Pop $pop): array
    {
        $nodes = [
            Node::rect(0, 600, 500, 104, Paint::fill('#1a1838')),
            $pop(Node::group([
                Node::rect(256, 60, 200, 210, Paint::fill('#e9dcc0'), 10),
                Node::rect(268, 72, 176, 186, Paint::fill()->runtimeShader(Shaders::STARS, ['top' => self::rgb('#0b0f2c'), 'bottom' => self::rgb('#2c2660'), 'height' => 270], 'time')),
                Node::combine('M392 96 a34 34 0 1 0 0.1 0 Z', 'M408 88 a30 30 0 1 0 0.1 0 Z', 'difference',
                    Paint::fill('#fff3c4')->filters(Filter::glow(10, '#ffe7a0', spread: 2)->bind('sigma', 'pulse', scale: 14, offset: 6))),
                Node::rect(353, 72, 6, 186, Paint::fill('#e9dcc0')),
            ]), depth: 1, base: 270),
            $pop(Node::group([
                Node::rect(24, 380, 26, 230, Paint::fill('#8a5a3c'), 8),
                Node::rect(24, 520, 330, 58, Paint::fill('#e9e2f5'), 10),
                Node::rect(36, 578, 14, 30, Paint::fill('#6e4630')),
                Node::rect(326, 578, 14, 30, Paint::fill('#6e4630')),
                Node::oval(52, 462, 120, 54, Paint::fill('#ffffff')),
                Node::circle(112, 478, 30, Paint::fill('#f2c9a5')),
                Node::path('M82 470 Q86 440 116 446 Q142 448 140 474 Q120 456 100 462 Q90 466 82 470 Z', Paint::fill('#3a2a4a')),
                Node::path('M100 484 Q106 490 112 484 M120 484 Q126 490 132 484', Paint::stroke('#3a2a4a', 2.5)->cap('round')),
                Node::path('M138 524 Q156 452 250 460 Q330 466 354 524 Z', Paint::fill('#7fb38f'))->origin(246, 524)
                    ->animate('scaleY', Animation::between(1, 1.06, 2.4, 'easeInOut', 'mirror')),
                Node::path('M170 500 l8 8 M210 482 l8 8 M260 478 l8 8 M300 492 l8 8', Paint::stroke('#5f9470', 3)->cap('round')),
            ]), depth: 2, delay: 0.04, base: 610),
            $pop(Node::group([
                Node::rect(376, 520, 100, 90, Paint::fill('#8a5a3c'), 8),
                Node::rect(386, 548, 80, 6, Paint::fill('#6e4630'), 3),
                Node::rect(408, 462, 38, 58, Paint::fill('#263159'), 9),
                Node::rect(413, 469, 28, 44, Paint::fill('#9be7ff')->filters(Filter::glow(6, '#9be7ff', spread: 2)->bind('sigma', 'pulse', scale: 10, offset: 4)), 5),
                Node::path('M427 486 C423 482 418 486 427 494 C436 486 431 482 427 486 Z', Paint::fill('#ff2d20')),
            ]), depth: 2.4, delay: 0.08, base: 610),
        ];
        foreach ([['z', 186, 430, 26, 3.2], ['z', 214, 396, 32, 3.8], ['Z', 246, 356, 40, 4.4]] as [$letter, $x, $y, $size, $period]) {
            $nodes[] = $pop(Node::text($letter, $x, $y, $size, Paint::fill('#e8e4ff'), 'lobster')
                ->animate('translateY', Animation::between(0, -26, $period, 'easeInOut', 'mirror'))
                ->animate('opacity', Animation::between(1, 0.25, $period, 'easeInOut', 'mirror')), depth: 3, delay: 0.1, base: 440, shadow: false);
        }

        return $nodes;
    }

    // Paper cut-out helpers.

    private static function block(float $x, float $y, string $label, string $color): Node
    {
        return Node::group([
            Node::circle($x + 24, $y, 9, Paint::fill($color)),
            Node::circle($x + 60, $y, 9, Paint::fill($color)),
            Node::rect($x, $y, 84, 104, Paint::fill($color), 12),
            Node::rect($x + 6, $y + 6, 72, 4, Paint::fill('#ffffff40'), 2),
            Node::paragraph($label, $x, $y + 42, 84, 18, Paint::fill('#ffffff'), font: 'josefin', align: 'center'),
        ]);
    }

    private static function elephant(float $x, float $y, float $s, string $color): Node
    {
        return Node::group([
            Node::rect(12, 46, 16, 22, Paint::fill($color), 5),
            Node::rect(54, 46, 16, 22, Paint::fill($color), 5),
            Node::oval(0, 0, 84, 60, Paint::fill($color)),
            Node::path('M86 34 Q108 46 100 68', Paint::stroke($color, 10)->cap('round')),
            Node::circle(78, 20, 26, Paint::fill($color)),
            Node::oval(52, 2, 26, 34, Paint::fill('#7a84b3'))->origin(64, 2)->animate('rotation', Animation::between(-10, 8, 1.3, 'easeInOut', 'mirror')),
            Node::circle(88, 14, 3, Paint::fill('#2f2747')),
            Node::paragraph('php', 4, 22, 70, 15, Paint::fill('#ffffffcc'), font: 'josefin', align: 'center'),
        ])->transform($x, $y, 0, $s, $s);
    }

    private static function miniPhone(float $x, float $y, string $color): Node
    {
        return Node::group([
            Node::rect($x - 14, $y - 22, 28, 44, Paint::fill('#f4ecff'), 7),
            Node::rect($x - 10, $y - 17, 20, 32, Paint::fill($color), 4),
        ]);
    }

    private static function cloud(float $x, float $y, float $s, string $color): Node
    {
        $paper = Paint::fill($color);

        return Node::group([
            Node::circle($x + 22 * $s, $y, 22 * $s, $paper),
            Node::circle($x + 50 * $s, $y - 14 * $s, 28 * $s, $paper),
            Node::circle($x + 80 * $s, $y, 22 * $s, $paper),
            Node::rect($x + 22 * $s, $y, 58 * $s, 22 * $s, $paper),
        ]);
    }

    private static function sparkle(float $x, float $y, float $r, string $color, float $period): Node
    {
        return Node::path("M0 -$r Q0 0 $r 0 Q0 0 0 $r Q0 0 -$r 0 Q0 0 0 -$r Z", Paint::fill($color))
            ->transform($x, $y)
            ->animate('scaleX', Animation::between(0.3, 1, $period, 'easeInOut', 'mirror'))
            ->animate('scaleY', Animation::between(0.3, 1, $period, 'easeInOut', 'mirror'));
    }

    private static function rays(float $cx, float $cy, int $count, float $radius): string
    {
        $path = '';
        foreach (range(0, $count - 1) as $k) {
            $a = 2 * M_PI * $k / $count;
            $b = $a + M_PI / $count;
            $path .= sprintf('M%.1f %.1f L%.1f %.1f L%.1f %.1f Z ', $cx, $cy, $cx + $radius * cos($a), $cy + $radius * sin($a), $cx + $radius * cos($b), $cy + $radius * sin($b));
        }

        return $path;
    }

    private static function waves(float $x, float $y, float $width, float $amplitude): string
    {
        $path = sprintf('M%.1f %.1f', $x, $y);
        for ($k = 0; $k * 40 < $width; $k++) {
            $path .= sprintf(' q20 %.1f 40 0', $k % 2 ? $amplitude : -$amplitude);
        }

        return $path;
    }

    /** @return list<float> */
    private static function rgb(string $hex): array
    {
        return array_map(fn (string $pair) => round(hexdec($pair) / 255, 4), str_split(ltrim($hex, '#'), 2));
    }
}
