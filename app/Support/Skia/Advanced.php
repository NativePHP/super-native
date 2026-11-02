<?php

declare(strict_types=1);

namespace App\Support\Skia;

use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Filter;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;
use Native\Mobile\Skia\Scene;

final class Advanced
{
    public const CHAPTERS = [
        ['title' => 'Motion with weight', 'label' => 'Physics', 'description' => 'Analytical springs, decay and sequences run on the native clock. Replay with the live control API.'],
        ['title' => 'Reshape the possibilities', 'label' => 'PathOps', 'description' => 'Boolean subtraction, path trimming and compatible path morphing.'],
        ['title' => 'Color between the points', 'label' => 'Meshes', 'description' => 'Colored triangle meshes with exact triangle hit regions.'],
        ['title' => 'One image, many instances', 'label' => 'Atlas', 'description' => 'Image shaders and batched atlas sprites share one decoded image.'],
        ['title' => 'Words follow your curves', 'label' => 'Text path', 'description' => 'Native font shaping places glyph outlines along a path.'],
        ['title' => 'Effects in order', 'label' => 'Chains', 'description' => 'Ordered blur, offset, shadow, morphology and color-matrix filters.'],
        ['title' => 'Graphics everyone can use', 'label' => 'Access', 'description' => 'VoiceOver and TalkBack expose labeled shapes and actions. Shaped Arabic, Hebrew, CJK and emoji use platform fallback.'],
        ['title' => 'Record once, draw again', 'label' => 'Cache', 'description' => 'Three thousand static shapes in a recorded group. The group animates without rebuilding its children.'],
        ['title' => 'Change only what changed', 'label' => 'Live API', 'description' => 'Update one identified shape atomically, animate shared values, and capture the mounted canvas.'],
        ['title' => 'Make a poster, your way', 'label' => 'Poster', 'description' => 'Drag the rings and headline separately. Release to snap; rotate, reset and export the live composition.'],
        ['title' => 'Explore your portfolio', 'label' => 'Chart', 'description' => 'Drag the chart cursor natively. Inspect the selected position in PHP after release, with accessible earlier/later actions.'],
        ['title' => 'A proper drawing pad', 'label' => 'Draw', 'description' => 'Pressure-sensitive native ink, independent stroke colors, undo, clear and live export.'],
        ['title' => 'A field you can touch', 'label' => 'Particles', 'description' => 'Nine hundred colored particles. Drag the field and release with inertia while its native rotation continues.'],
    ];

    public static function scene(int $chapter, float $amount = 45, string $accent = '#a899ff'): Scene
    {
        if ($chapter >= 9) {
            return match ($chapter) {
                9 => Products::poster(),10 => Products::chart(true),11 => Products::drawing(true),12 => Products::particles(),default => throw new \InvalidArgumentException('Unknown advanced chapter')
            };
        }
        $s = Scene::make(360, 300)->background('#101624');
        $white = Paint::fill('#f2f4ff');
        $mint = Paint::fill('#83e2be');
        switch ($chapter) {
            case 0:
                $s->value('spring', 35, Animation::spring(35, 285, seconds: 3)->repeat('mirror'))->value('decay', 35, Animation::decay(35, 900, 4, 3)->repeat('loop'))->value('sequence', 35, Animation::sequence(Animation::between(35, 280, 1, 'easeInOut', 'once'), Animation::spring(280, 100, seconds: 2))->repeat('mirror'));
                foreach (['spring', 'decay', 'sequence'] as $i => $value) {
                    $y = 60 + $i * 85;
                    $s->add(Node::line(35, $y, 320, $y, Paint::stroke('#34415c', 2)), Node::circle(0, $y, 14, $i === 1 ? $mint : Paint::fill($accent))->bind('x', $value), Node::text(strtoupper($value), 24, $y + 39, 12, $white));
                }break;
            case 1:
                $s->add(Node::combine('M25 25 H150 V145 H25 Z', 'M72 12 H165 V95 H72 Z', 'difference', Paint::fill($accent)), Node::path('M205 125 C145 5 360 5 305 125', Paint::stroke('#83e2be', 7)->cap('round'))->trim()->animate('trimEnd', Animation::between(.05, 1, 2, 'easeInOut', 'mirror')), Node::path('M65 190 L135 180 L120 260 L45 245 Z', Paint::fill('#f2bf89'))->morphTo('M110 160 L175 220 L110 280 L45 220 Z')->animate('morph', Animation::between(0, 1, 2, 'easeInOut', 'mirror')), Node::text('SUBTRACT / TRIM / MORPH', 182, 228, 10, $white));
                break;
            case 2:
                $s->add(Node::mesh([[35, 230], [180, 35], [325, 230], [180, 280]], ['#a899ff', '#83e2be', '#ff86d9', '#f2bf89'], [0, 1, 2, 0, 2, 3])->id('mesh')->accessible('Four-color triangle mesh'), Node::text('VERTEX COLOR / TWO TRIANGLES', 33, 20, 12, $white));
                break;
            case 3:
                $s->asset('photo', file_get_contents(resource_path('images/skia/landscape.png')));
                $s->add(Node::rect(20, 20, 145, 260, Paint::fill()->imageShader('photo', scaleX: .25, scaleY: .25), 12));
                $sprites = [];
                for ($i = 0; $i < 12; $i++) {
                    $sprites[] = ['source' => [0, 0, 80, 80], 'transform' => [.42 * cos($i * .2), .42 * sin($i * .2), 205 + ($i % 3) * 50, 35 + intdiv($i, 3) * 65]];
                }
                $s->add(Node::sprites('photo', $sprites), Node::text('TILE / ATLAS', 200, 284, 12, $white));
                break;
            case 4:
                $curve = 'M25 185 C75 20 285 20 335 185';
                $s->add(Node::path($curve, Paint::stroke('#34415c', 2)), Node::textOnPath('FOLLOW YOUR OWN CURVE', $curve, 21, Paint::fill($accent)), Node::textOnPath('Made with NativePHP + Skia', 'M25 250 Q180 150 335 250', 15, $mint));
                break;
            case 5:
                $s->add(Node::circle(90, 115, 42, Paint::fill($accent)->filters(Filter::blur($amount / 12), Filter::shadow(5, 15, 8, '#000000aa'))), Node::circle(255, 115, 40, Paint::fill('#83e2be')->filters(Filter::morphology(5, 5), Filter::offset(0, 12))), Node::text('BLUR → SHADOW', 22, 225, 13, $white), Node::text('DILATE → OFFSET', 190, 225, 13, $white));
                break;
            case 6:
                $s->add(Node::paragraph('مرحبا بالعالم', 25, 24, 310, 30, $white, direction: 'rtl'), Node::paragraph('שלום עולם', 25, 80, 310, 27, Paint::fill($accent), direction: 'rtl'), Node::paragraph('你好世界  👋 🌈', 25, 137, 310, 27, $mint), Node::rect(25, 220, 310, 50, Paint::fill('#44338b'), 16)->id('accessible-button')->accessible('Celebrate native graphics', 'button', 'Activates the PHP event', ['celebrate']), Node::text('Accessible action', 96, 252, 19, $white));
                break;
            case 7:
                $dots = [];
                for ($i = 0; $i < 3000; $i++) {
                    $dots[] = Node::circle(($i % 75) * 4 - 148, intdiv($i, 75) * 4 - 78, 1.3, Paint::fill($i % 2 ? $accent : '#83e2be'));
                }
                $s->add(Node::group($dots)->cache()->transform(180, 150)->animate('rotation', Animation::between(0, 360, 20)), Node::text('3,000 RECORDED SHAPES', 72, 30, 14, $white));
                break;
            case 8:
                $s->value('liveX', 180)->add(Node::circle(0, 140, 50, Paint::fill($accent))->id('live-shape')->bind('x', 'liveX')->accessible('Live-updated shape'), Node::text('UPDATE / SPRING / CAPTURE', 60, 265, 14, $white));
                break;
        }

        return $s;
    }
}
