<?php

namespace App\Support\Skia;

use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Filter;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;
use Native\Mobile\Skia\Scene;

final class SpatialGallery
{
    public const DEMOS = [
        ['label' => 'Tilt', 'title' => 'A pass with presence', 'description' => 'A premium membership card tilts on two axes. Its highlight and shadow follow the same native value.', 'api' => 'transform3d · origin · bindings · glow'],
        ['label' => 'Flip', 'title' => 'Two sides. One surface.', 'description' => 'An event ticket turns over to reveal its admission code. Back-face culling keeps both sides readable.', 'api' => 'twoSided · backfaceVisible · spring'],
        ['label' => 'Cube', 'title' => 'Built from six surfaces', 'description' => 'Six ordinary Skia panels form a rotating cube. Nested transforms preserve the depth of every face.', 'api' => 'nested transforms · rotateX/Y/Z · culling'],
        ['label' => 'Layers', 'title' => 'Pull an interface apart', 'description' => 'Separate a dashboard into floating layers, then bring it back together. Depth scale controls the entire stack.', 'api' => 'translateZ · scaleZ · depth · compositing'],
        ['label' => 'Parallax', 'title' => 'A window into the wild', 'description' => 'Mountains, sun and foreground move at different rates. Drag sideways to explore the landscape.', 'api' => 'parallax · native pan · clipping'],
        ['label' => 'Orbit', 'title' => 'An orbit of album art', 'description' => 'Move the pivot behind a surface and a rotation becomes an orbit. These covers share a single rotating stage.', 'api' => 'originZ · rotateY · perspective'],
        ['label' => 'Fold', 'title' => 'Made to unfold', 'description' => 'A travel guide opens around its spine. The cover and printed interior are separate sides of the same panel.', 'api' => 'edge origin · twoSided · shared values'],
        ['label' => 'Paper', 'title' => 'Paper you can feel', 'description' => 'Grab a corner, peel diagonally, or flick a page. The flexible sheet follows your finger and springs into place.', 'api' => 'pageCurl · corner peel · velocity · native spring'],
        ['label' => 'Light', 'title' => 'Depth you can see', 'description' => 'A floating activity tile rises toward the camera as its shadow softens and its halo expands.', 'api' => 'bound shadow · glow · opacity · translateZ'],
        ['label' => 'Ink', 'title' => 'Draw in perspective', 'description' => 'Sign the tilted notebook. Pointer coordinates map back through the full projection before drawing native ink.', 'api' => 'projective hit testing · ink · capture'],
        ['label' => 'Touch', 'title' => 'Put your hands on it', 'description' => 'Drag, pinch and rotate the card. All gesture values stay on the native rendering thread.', 'api' => 'pan · pinch · rotation · clamped bindings'],
        ['label' => 'Sources', 'title' => 'Follow the device', 'description' => 'A native fold source drives this panel when available. Scrub the slider to try the same motion on any phone.', 'api' => 'native value source · easing · fallback'],
        ['label' => 'Camera', 'title' => 'Choose your perspective', 'description' => 'The left card stays orthographic. The right uses an animated local camera to exaggerate the same rotation.', 'api' => 'orthographic · local perspective · camera distance'],
        ['label' => 'Pivot', 'title' => 'Every axis. Every pivot.', 'description' => 'The cyan point marks the pivot. Watch the card switch from a central spin to an edge hinge as the origin moves.', 'api' => 'originX/Y/Z · rotateZ · additive bindings'],
    ];

    public static function scene(int $demo): Scene
    {
        if (! isset(self::DEMOS[$demo])) {
            throw new \InvalidArgumentException('Unknown spatial demo.');
        }
        $scene = Scene::make(400, 440)->background('#f0f2fb')
            ->asset('display', file_get_contents(resource_path('fonts/Geist-Regular.ttf')), 'font')
            ->value('phase', 0.35, $demo === 7 || $demo === 9 || $demo === 10 || $demo === 11 ? null : Animation::between(0, 1, 5, 'easeInOut', 'mirror'))
            ->value('pan', 0)->value('panY', 0)->value('zoom', 1)->value('spin', 0);
        if ($demo !== 12) {
            $scene->perspective(1000, 200, 190);
        }
        $scene->add(Node::circle(345, 35, 125, Paint::fill('#e5dfff')), Node::circle(20, 355, 115, Paint::fill('#d8f2ef')));
        match ($demo) {
            0 => self::tilt($scene),
            1 => self::flip($scene),
            2 => self::cube($scene),
            3 => self::layers($scene),
            4 => self::landscape($scene),
            5 => self::orbit($scene),
            6 => self::fold($scene),
            7 => self::paper($scene),
            8 => self::light($scene),
            9 => self::ink($scene),
            10 => self::touch($scene),
            11 => self::sources($scene),
            12 => self::camera($scene),
            13 => self::pivot($scene),
        };

        $scene->add(
            Node::rect(0, 374, 400, 66, Paint::fill('#e9e6f8')),
            self::text('DRAG TO EXPLORE', 40, 395, 12, '#40355d'),
            Node::group([Node::group([
                Node::rect(-0.06, -20, 1.12, 40, Paint::fill('#00000000')),
                Node::rect(0, -2, 1, 4, Paint::fill('#c9c1e8')),
                Node::rect(0, -2, 1, 4, Paint::fill('#6744cb'))->bind('scaleX', 'phase', min: 0, max: 1),
                Node::oval(-0.04, -12, 0.08, 24, Paint::fill('#ffffff'))->bind('translateX', 'phase', min: 0, max: 1),
            ])->id('native-scrubber')->draggable(x: 'phase')->dragLimits(0, 1, 0, 0)
                ->accessible('Animation position. Drag horizontally to scrub.')])->transform(40, 416, scaleX: 320)->depth(1e7),
        );

        return $scene;
    }

    private static function text(string $text, float $x, float $y, float $size = 20, string $color = '#172039'): Node
    {
        return Node::text($text, $x, $y, $size, Paint::fill($color), 'display');
    }

    private static function card(string $title = 'NATIVE', string $subtitle = 'MEMBERS CLUB', string $color = '#5541cb', float $width = 280, float $height = 176): Node
    {
        return Node::group([
            Node::rect(0, 0, $width, $height, Paint::fill()->linearGradient(0, 0, $width, $height, [$color, '#19234c']), 18),
            Node::circle($width - 30, 28, 65, Paint::fill('#ffffff16')),
            Node::circle($width - 30, 28, 40, Paint::stroke('#ffffff50', 2)),
            self::text($subtitle, 22, 36, 12, '#e3e7ff'),
            self::text($title, 22, $height / 2 + 14, min(30, ($width - 44) / (strlen($title) * 0.65)), '#ffffff'),
            self::text('SKIA / 001', 22, $height - 23, 13, '#e3e7ff'),
            Node::line($width - 48, $height - 26, $width - 24, $height - 26, Paint::stroke('#70f4da', 4))->bind('opacity', 'phase', scale: 0, offset: $width >= 200 ? 1 : 0),
        ])->clip(sprintf('M18 0 H%1$s Q%2$s 0 %2$s 18 V%3$s Q%2$s %4$s %1$s %4$s H18 Q0 %4$s 0 %3$s V18 Q0 0 18 0 Z', $width - 18, $width, $height - 18, $height));
    }

    private static function tilt(Scene $scene): void
    {
        $shadow = Filter::shadow(0, 14, 14, '#22204f55')->bind('y', 'phase', 16, 8)->bind('sigma', 'phase', 12, 8);
        $scene->add(Node::group([self::card('ALL ACCESS'), Node::line(22, 55, 240, 55, Paint::stroke('#9cfff0', 2)->filters(Filter::glow(4, '#50ffe0')))], Paint::fill()->filters($shadow))
            ->transform(60, 98)->origin(140, 88)->bind('rotateY', 'phase', 60, -30)->bind('rotateX', 'phase', -28, 14)->id('hero')->accessible('Tilting membership pass'));
    }

    private static function flip(Scene $scene): void
    {
        $back = [Node::rect(0, 0, 280, 176, Paint::fill('#ffffff'), 18), self::text('YOU ARE IN.', 22, 42, 27), self::text('FRIDAY / 20:00', 22, 73, 16)];
        for ($i = 0; $i < 36; $i++) {
            $back[] = Node::rect(24 + $i * 6.3, 102, $i % 3 === 0 ? 4 : 2, 42, Paint::fill('#172039'));
        }
        $scene->add(Node::twoSided(self::card('AFTER HOURS', 'ADMIT ONE'), Node::group($back), 280, 176)
            ->transform(60, 98)->origin(140, 88)->bind('rotateY', 'phase', 180)->id('ticket')->accessible('Two-sided event ticket'));
    }

    private static function cube(Scene $scene): void
    {
        $faces = [];
        foreach ([[0, 0, '#6045de', 'N'], [0, 90, '#138b90', 'A'], [0, 180, '#ed7658', 'T'], [0, -90, '#d64883', 'I'], [90, 0, '#f4bb54', 'V'], [-90, 0, '#426de0', 'E']] as [$x, $y, $color, $letter]) {
            $art = Node::group([Node::rect(-70, -70, 140, 140, Paint::fill($color)), Node::rect(-57, -57, 114, 114, Paint::stroke('#ffffff70', 2), 16), self::text($letter, -24, 23, 68, '#ffffff')])
                ->transform3d(translateZ: 70)->backfaceVisible(false);
            $faces[] = Node::group([$art])->transform3d(rotateX: $x, rotateY: $y);
        }
        $scene->add(Node::oval(108, 286, 184, 24, Paint::fill('#26244130')->filters(Filter::blur(12))))
            ->add(Node::group($faces)->transform(200, 183)->transform3d(rotateX: -22, rotateZ: -8)->bind('rotateY', 'phase', 320, 20)->id('cube'));
    }

    private static function layers(Scene $scene): void
    {
        $layers = [];
        foreach ([['BASE', '#253251'], ['ACTIVITY', '#5a45d1'], ['INSIGHTS', '#117c83']] as $i => [$label, $color]) {
            $children = [Node::rect(-100, -76, 200, 152, Paint::fill($color), 16), self::text($label, -80, -38, 17, '#ffffff')];
            for ($j = 0; $j < 5; $j++) {
                $children[] = Node::rect(-78 + $j * 31, 27 - $j * 10, 20, 31 + $j * 10, Paint::fill('#ffffffb0'), 4);
            }
            $layers[] = Node::group($children)->transform3d(translateZ: $i * 72)->depth($i)->bind('translateY', 'phase', -$i * 17);
        }
        $scene->add(Node::group($layers)->transform(165, 230)->transform3d(rotateX: 38, rotateY: -28)->bind('scaleZ', 'phase', 0.85, 0.1)->id('dashboard'));
    }

    private static function landscape(Scene $scene): void
    {
        $scene->gestures(panX: 'pan');
        $art = [Node::rect(0, 0, 320, 260, Paint::fill()->linearGradient(0, 0, 0, 260, ['#eed8fa', '#b9dfe7'])),
            Node::circle(225, 65, 31, Paint::fill('#fff4b9'))->parallax('pan', 1, 0.03),
            Node::path('M-60 190 L50 48 L165 190 L260 74 L390 230 V290 H-60 Z', Paint::fill('#7867ba'))->parallax('pan', 2, 0.06),
            Node::path('M-60 230 L65 116 L182 219 L266 160 L400 270 V310 H-60 Z', Paint::fill('#385e89'))->parallax('pan', 3, 0.08),
            Node::path('M-80 250 Q40 170 130 246 T410 220 V340 H-80 Z', Paint::fill('#164c59'))->parallax('pan', 4, 0.1),
            self::text('TAKE THE LONG WAY.', 24, 232, 21, '#ffffff')->depth(5)];
        $scene->add(Node::group($art)->clip('M0 0 H320 V260 H0 Z')->transform(40, 60)->origin(160, 130)->bind('rotateY', 'phase', 16, -8)->id('landscape'));
    }

    private static function orbit(Scene $scene): void
    {
        $albums = [];
        foreach (['MIDNIGHT', 'DAYBREAK', 'OFFLINE'] as $i => $title) {
            $color = ['#5940ca', '#d06b38', '#168480'][$i];
            $albums[] = self::card($title, 'NOW PLAYING', $color, 160, 180)->transform(-80, -90)
                ->origin(80, 90, -85)->transform3d(rotateY: $i * 120)->backfaceVisible(false);
        }
        $scene->add(Node::group($albums)->transform(200, 190)->origin(0, 0, -85)->bind('rotateY', 'phase', 360)->id('albums'));
    }

    private static function fold(Scene $scene): void
    {
        $left = Node::group([Node::rect(0, 0, 148, 220, Paint::fill('#fffaf0'), 7), self::text('GO', 18, 64, 42), self::text('SOMEWHERE', 18, 94, 14), self::text('NEW.', 18, 133, 38), Node::path('M20 190 Q60 120 120 182', Paint::stroke('#5a45d1', 5))]);
        $right = Node::group([Node::rect(0, 0, 148, 220, Paint::fill('#d6efe9'), 7), Node::circle(108, 45, 21, Paint::fill('#ffbc6c')), Node::path('M0 200 L60 76 L148 200 V220 H0 Z', Paint::fill('#158479')), self::text('FIELD NOTES', 15, 203, 14, '#ffffff')]);
        $cover = self::card('GO.', 'FIELD GUIDE', '#5142bf', 148, 220);
        $scene->add($left->transform(52, 78), Node::twoSided($right, $cover, 148, 220)->transform(200, 78)->origin(0, 110)->bind('rotateY', 'phase', 175, -175)->depth(1)->id('guide'));
    }

    private static function paper(Scene $scene): void
    {
        $scene->value('phase', 0);
        $front = Node::group([Node::rect(0, 0, 170, 250, Paint::fill('#fff9ed')), self::text('A NEW', 18, 45, 26), self::text('CHAPTER.', 18, 77, 26), Node::circle(85, 143, 43, Paint::fill('#e27650')), Node::path('M20 220 L85 116 L155 220 Z', Paint::fill('#654abc')), self::text('PULL THE CORNER', 16, 239, 12)]);
        $back = Node::group([Node::rect(0, 0, 170, 250, Paint::fill('#e0f4ec')), self::text('KEEP', 20, 67, 33), self::text('EXPLORING.', 20, 104, 20), Node::circle(85, 170, 43, Paint::stroke('#15776b', 5))]);
        $scene->add(Node::rect(25, 58, 350, 260, Paint::fill('#d3c8bb'), 9), Node::rect(30, 63, 170, 250, Paint::fill('#fff9ed')), self::text('01', 53, 294, 18),
            Node::pageCurl($front, $back, 170, 250, 'phase', radius: 25, flutter: 0.015)->transform(200, 63)->id('paper')->accessible('Page. Drag or tap to turn'));
    }

    private static function light(Scene $scene): void
    {
        $shadow = Filter::shadow(0, 10, 8, '#34235c60')->bind('y', 'phase', 20, 8)->bind('sigma', 'phase', 18, 4);
        $glow = Filter::glow(5, '#43cbb8', 1)->bind('sigma', 'phase', 12, 2)->bind('opacity', 'phase', 0.65, 0.15);
        $tile = Node::group([Node::rect(-90, -85, 180, 170, Paint::fill('#ffffff'), 24), Node::circle(0, -7, 49, Paint::stroke('#ddedef', 12)), Node::path('M0 -56 A49 49 0 1 1 -46 10', Paint::stroke('#157f80', 12)->filters($glow)), self::text('84', -28, 6, 40), self::text('DAILY ENERGY', -61, 64, 14)], Paint::fill()->filters($shadow));
        $scene->add($tile->transform(190, 200)->transform3d(rotateX: 22, rotateY: -18)->bind('translateZ', 'phase', 100)->id('energy'));
    }

    private static function ink(Scene $scene): void
    {
        $scene->add(Node::group([Node::rect(0, 0, 270, 215, Paint::fill('#ffffff'), 14)->ink('#6744cb', 4)->id('signature')->accessible('Signature pad'), self::text('Make your mark.', 22, 39, 24), Node::line(24, 173, 246, 173, Paint::stroke('#c8cbdc', 1)), self::text('SIGN HERE', 24, 198, 13, '#47526b')])->transform(65, 80)->origin(135, 107)->transform3d(rotateX: 14, rotateY: -24)->id('notebook'));
    }

    private static function touch(Scene $scene): void
    {
        $scene->gestures(panX: 'pan', panY: 'panY', scale: 'zoom', rotation: 'spin');
        $scene->add(self::card('MAKE IT MOVE', 'DRAG / PINCH / ROTATE')->transform(60, 98)->origin(140, 88)
            ->bind('translateX', 'pan', 1, 60, -20, 140)->bind('translateY', 'panY', 1, 98, 20, 200)
            ->bind('scaleX', 'zoom', min: 0.55, max: 1.15)->bind('scaleY', 'zoom', min: 0.55, max: 1.15)
            ->bind('rotation', 'spin')->bind('rotateY', 'pan', 0.2, min: -35, max: 35)->id('touch-card')->accessible('Interactive membership card'));
    }

    private static function sources(Scene $scene): void
    {
        $scene->value('phase', 0.45, source: 'fold.openAmount', ease: 0.8);
        self::fold($scene);
    }

    private static function camera(Scene $scene): void
    {
        foreach ([false, true] as $i => $projected) {
            $card = self::card($projected ? 'DEPTH' : 'FLAT', 'PROJECTION', $projected ? '#176e83' : '#5541cb', 146, 190)
                ->transform(30 + $i * 194, 88)->origin(73, 95)->bind('rotateY', 'phase', 70, -35);
            if ($projected) {
                $card->bind('perspective', 'phase', -500, 800, 300, 800);
            }
            $scene->add($card, self::text($projected ? 'PERSPECTIVE' : 'ORTHOGRAPHIC', 30 + $i * 194, 314, 14));
        }
    }

    private static function pivot(Scene $scene): void
    {
        $scene->add(self::card('ON POINT', 'TRANSFORM ORIGIN', '#247b87', 220, 150)->transform(90, 110)
            ->bind('originX', 'phase', 110)->origin(0, 75, -20)->bind('rotateZ', 'phase', 44, -22)->bind('rotateY', 'phase', 55, -25)->id('pivot-card'),
            Node::circle(90, 185, 7, Paint::fill('#00a795'))->bind('translateX', 'phase', 110)->depth(10));
    }
}
