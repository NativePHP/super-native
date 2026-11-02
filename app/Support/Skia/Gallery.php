<?php

declare(strict_types=1);

namespace App\Support\Skia;

use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;
use Native\Mobile\Skia\Path;
use Native\Mobile\Skia\Scene;
use Native\Mobile\Skia\TextSpan;
use Native\Mobile\Skia\TextStyle;

/** Deterministic scenes shared by the demo and renderer acceptance tests. */
final class Gallery
{
    public const CHAPTERS = [
        ['title' => 'First impressions', 'label' => 'Gallery', 'description' => 'A complete composition: gradients, typography, paths, rounded shapes and soft shadows.'],
        ['title' => 'The building blocks', 'label' => 'Shapes', 'description' => 'Rectangles, rounded corners, circles, ovals, lines, stroke widths, caps and joins.'],
        ['title' => 'Follow the curve', 'label' => 'Paths', 'description' => 'SVG path strings and the fluent path builder, with cubic curves, arcs, dashes and even-odd fills.'],
        ['title' => 'Color in every direction', 'label' => 'Gradients', 'description' => 'Linear, radial and sweep gradients with alpha, color stops and repeating tiles.'],
        ['title' => 'A little atmosphere', 'label' => 'Filters', 'description' => 'Native Skia blur, drop shadows and color matrices. Move the intensity slider to change the blur.'],
        ['title' => 'Better together', 'label' => 'Layers', 'description' => 'Isolated layers, blend modes, clipping and group opacity. The overlapping shapes share one compositing layer.'],
        ['title' => 'Pictures, your way', 'label' => 'Images', 'description' => 'An embedded image drawn with contain, cover and fill. No network request is needed.'],
        ['title' => 'Words have shape', 'label' => 'Text', 'description' => 'Baseline text and SkParagraph: wrapped lines, alignment, shaping, direction and system-font fallback.'],
        ['title' => 'Made of mathematics', 'label' => 'SkSL', 'description' => 'A SkSL runtime shader runs in the native Skia renderer. The slider changes its float uniform.'],
        ['title' => 'Keep things moving', 'label' => 'Motion', 'description' => 'Rotation, translation, scale and opacity animate on the native clock. Pause freezes the scene.'],
        ['title' => 'Make your mark', 'label' => 'Touch', 'description' => 'Tap the canvas. Coordinates are mapped back into its drawing space and delivered to the PHP component.'],
        ['title' => 'A thousand little things', 'label' => 'Density', 'description' => 'A deterministic field of shapes. Increase density to explore raster rendering cost; this is not an FPS benchmark.'],
        ['title' => 'Vectors without limits', 'label' => 'SVG', 'description' => 'A complete SVG document: gradients, reusable symbols, clipping and paths. Change the palette or fit mode.'],
        ['title' => 'A motion identity', 'label' => 'Lottie', 'description' => 'An original Lottie composition rendered by Skottie. Native playback, looping and adjustable speed.'],
        ['title' => 'An editorial voice', 'label' => 'Typography', 'description' => 'Rich text runs, an embedded font, weight, italic, tracking, line height and decoration in one shaped paragraph.'],
        ['title' => 'One value, many pixels', 'label' => 'Values', 'description' => 'A shared native value drives a shader uniform and the scale of three objects. No PHP calls happen per frame.'],
        ['title' => 'Put your hands on it', 'label' => 'Gestures', 'description' => 'Drag the pass, pinch to zoom and twist to rotate. Tap the stamp, planet or pass to identify the shape.'],
        ['title' => 'Take it with you', 'label' => 'Export', 'description' => 'Export this composition at 1080 × 900 as PNG, JPEG, WebP or a PDF preserving vector paths and text outlines. Files stay in app storage.'],
        ...Advanced::CHAPTERS,
    ];

    public static function scene(int $chapter = 0, float $intensity = 45, string $accent = '#a899ff', float $touchX = 180, float $touchY = 150, ?string $fontBytes = null): Scene
    {
        if (! isset(self::CHAPTERS[$chapter])) {
            throw new \InvalidArgumentException('Unknown Skia gallery chapter.');
        }
        if ($chapter >= 18) {
            return Advanced::scene($chapter - 18, $intensity, $accent);
        }
        $amount = max(0, min(100, $intensity));
        $scene = Scene::make(360, 300)->background('#101624');
        $white = Paint::fill('#f2f4ff');
        $muted = Paint::fill('#8d9bb6');
        $color = Paint::fill($accent);
        $mint = Paint::fill('#83e2be');
        $label = fn (string $text, float $x, float $y) => Node::text($text, $x, $y, 12, $muted);
        switch ($chapter) {
            case 0:
                $scene->add(
                    Node::circle(285, 58, 105, Paint::fill()->radialGradient(285, 58, 110, [$accent.'99', '#10162400'])),
                    Node::text('DRAW SOMETHING', 25, 37, 11, $mint),
                    Node::text('Unexpected.', 23, 82, 37, $white),
                    Node::path('M26 197 C75 114 114 264 170 177 S250 120 326 166', Paint::stroke($accent, 7)->cap('round')->shadow(0, 5, 9, $accent.'66')),
                    Node::circle(170, 177, 12, $white),
                    Node::circle(170, 177, 6, $color),
                    Node::rect(24, 238, 152, 35, Paint::fill('#233a36'), 17),
                    Node::text('PHP meets pixels', 40, 261, 14, $mint),
                    $label('NATIVE SKIA / 01', 236, 262)
                );
                break;
            case 1:
                $scene->add(Node::rect(25, 25, 85, 85, $color, 22), Node::circle(180, 67, 42, $mint), Node::oval(252, 32, 84, 70, Paint::stroke('#f2bf89', 6)),
                    Node::rect(29, 152, 75, 75, Paint::stroke($accent, 3), 12), Node::circle(180, 189, 37, Paint::stroke('#83e2be', 12)),
                    Node::line(259, 164, 329, 211, Paint::stroke('#f2bf89', 12)->cap('round')),
                    $label('FILL', 51, 132), $label('CIRCLE', 158, 132), $label('OVAL', 278, 132), $label('STROKE', 38, 258), $label('RING', 164, 258), $label('ROUND CAP', 260, 258));
                break;
            case 2:
                $curve = Path::make()->moveTo(25, 84)->cubicTo(100, -40, 230, 210, 335, 68);
                $scene->add(Node::path($curve, Paint::stroke($accent, 7)->cap('round')),
                    Node::path('M25 144 Q180 65 335 144', Paint::stroke('#83e2be', 3)->dash([8, 6])),
                    Node::path('M78 190 A38 38 0 1 1 77.9 190 Z M78 207 A21 21 0 1 1 77.9 207 Z', $color, 'evenOdd'),
                    Node::path(Path::make()->moveTo(165, 254)->lineTo(208, 179)->lineTo(251, 254)->close(), Paint::stroke('#f2bf89', 5)->join('round')),
                    $label('CUBIC + QUADRATIC', 24, 31), $label('EVEN-ODD', 40, 283), $label('CLOSED PATH', 164, 283));
                break;
            case 3:
                $scene->add(Node::rect(25, 24, 310, 65, Paint::fill()->linearGradient(25, 24, 335, 24, [$accent, '#f2bf89', '#83e2be'], [0, 0.6, 1]), 16),
                    Node::circle(93, 183, 66, Paint::fill()->radialGradient(75, 163, 80, ['#ffffff', $accent, '#222d47'])),
                    Node::circle(267, 183, 66, Paint::fill()->sweepGradient(267, 183, [$accent, '#83e2be', '#f2bf89', $accent])),
                    $label('LINEAR / COLOR STOPS', 25, 108), $label('RADIAL', 65, 279), $label('SWEEP', 247, 279));
                break;
            case 4:
                $scene->add(Node::circle(89, 90, 43, Paint::fill($accent)->blur($amount / 5)),
                    Node::rect(202, 47, 102, 86, Paint::fill('#83e2be')->shadow(0, 12, 12, '#000000cc'), 22),
                    Node::rect(30, 185, 300, 75, Paint::fill()->linearGradient(30, 185, 330, 185, [$accent, '#83e2be', '#f2bf89'])->colorMatrix([0.2126, 0.7152, 0.0722, 0, 0, 0.2126, 0.7152, 0.0722, 0, 0, 0.2126, 0.7152, 0.0722, 0, 0, 0, 0, 0, 1, 0]), 12),
                    $label('BLUR', 66, 156), $label('SHADOW', 224, 156), $label('GRAYSCALE COLOR MATRIX', 77, 284));
                break;
            case 5:
                foreach (['screen', 'multiply', 'difference'] as $i => $mode) {
                    $scene->add(Node::group([Node::rect(0, 0, 94, 104, Paint::fill('#e9edf6'), 14), Node::circle(35, 49, 28, $color), Node::circle(61, 59, 28, Paint::fill('#83e2be')->blend($mode))], Paint::fill('#ffffff'))->transform(22 + $i * 112, 34), $label(strtoupper($mode), 23 + $i * 112, 163));
                }
                $scene->add(Node::group([Node::rect(0, 0, 260, 90, $color), Node::circle(165, 35, 60, $mint)], Paint::fill('#ffffff')->opacity(0.7))->clip('M0 0 L260 0 L220 90 L40 90 Z')->transform(50, 186), $label('CLIP + GROUP OPACITY', 96, 292));
                break;
            case 6:
                $scene->asset('landscape', file_get_contents(resource_path('images/skia/landscape.png')));
                foreach (['contain', 'cover', 'fill'] as $i => $fit) {
                    $x = 20 + $i * 112;
                    $scene->add(Node::rect($x, 35, 96, 204, Paint::fill('#263149'), 0), Node::image('landscape', $x, 35, 96, 204, $fit), $label(strtoupper($fit), $x + 19, 267));
                }
                break;
            case 7:
                $scene->add(Node::text('Type with personality.', 22, 48, 26, $white),
                    Node::paragraph('A paragraph wraps naturally. Ligatures, line breaks and alignment are handled by SkParagraph.', 24, 78, 312, 19, $color),
                    Node::paragraph("Native on both platforms.\nOne expressive PHP API.", 24, 194, 312, 16, $mint, align: 'center'),
                    $label('BASELINE TEXT + SHAPED PARAGRAPHS', 23, 278));
                break;
            case 8:
                $source = 'uniform float frequency; half4 main(float2 p) { float v = 0.5 + 0.5 * sin(p.x * frequency + sin(p.y * 0.045) * 3.0); return half4(mix(float3(0.13,0.22,0.35), float3(0.64,0.56,0.98), v), 1.0); }';
                $scene->add(Node::rect(20, 20, 320, 240, Paint::fill()->runtimeShader($source, ['frequency' => 0.015 + $amount / 1000]), 24), $label('SKSL / PROCEDURAL WAVES', 86, 283));
                break;
            case 9:
                $satellites = [Node::circle(0, 0, 68, Paint::stroke('#35415a', 1)), Node::circle(68, 0, 12, $mint), Node::circle(-68, 0, 8, $color)];
                $scene->add(Node::group($satellites)->transform(180, 130)->animate('rotation', Animation::between(0, 360, 7)),
                    Node::circle(0, 0, 24, Paint::fill($accent)->shadow(0, 0, 15, $accent.'77'))->transform(180, 130)->animate('scaleX', Animation::between(0.7, 1.3, 1.5, 'easeInOut', 'mirror'))->animate('scaleY', Animation::between(0.7, 1.3, 1.5, 'easeInOut', 'mirror')),
                    Node::rect(0, 245, 44, 7, $mint, 4)->animate('translateX', Animation::between(30, 286, 2.5, 'easeInOut', 'mirror')),
                    $label('ROTATE / PULSE / TRANSLATE', 83, 285));
                break;
            case 10:
                for ($x = 0; $x <= 360; $x += 30) {
                    $scene->add(Node::line($x, 0, $x, 300, Paint::stroke('#243047')));
                }
                for ($y = 0; $y <= 300; $y += 30) {
                    $scene->add(Node::line(0, $y, 360, $y, Paint::stroke('#243047')));
                }
                $scene->add(Node::circle($touchX, $touchY, 25, Paint::stroke($accent, 2)), Node::circle($touchX, $touchY, 5, $mint),
                    Node::line($touchX - 38, $touchY, $touchX + 38, $touchY, Paint::stroke('#83e2be', 1)), Node::line($touchX, $touchY - 38, $touchX, $touchY + 38, Paint::stroke('#83e2be', 1)),
                    Node::rect(16, 254, 328, 30, Paint::fill('#101624'), 10), Node::text(sprintf('x %.1f    y %.1f', $touchX, $touchY), 30, 275, 14, $white));
                break;
            case 11:
                $count = 50 + (int) ($amount * 9.5);
                for ($i = 0; $i < $count; $i++) {
                    $x = 15 + fmod($i * 137.508, 330);
                    $y = 15 + fmod($i * 83.17, 245);
                    $scene->add(Node::circle($x, $y, 1.5 + ($i % 5), Paint::fill([$accent, '#83e2be', '#f2bf89'][$i % 3])->opacity(0.6)));
                }
                $scene->add(Node::rect(15, 263, 330, 30, Paint::fill('#101624')), Node::text($count.' shapes / one native canvas', 35, 283, 14, $white));
                break;
            case 12:
                $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="360" height="300" viewBox="0 0 360 300">
<defs>
  <linearGradient id="sky" x2="0" y2="1"><stop stop-color="#172b49"/><stop offset="1" stop-color="#101624"/></linearGradient>
  <linearGradient id="sun" x2="0" y2="1"><stop stop-color="#f2bf89"/><stop offset="1" stop-color="$accent"/></linearGradient>
  <clipPath id="portal"><rect x="55" y="30" width="250" height="232" rx="118"/></clipPath>
  <path id="ridge" d="M-30 260 L75 99 L137 197 L198 111 L327 273 Z"/>
</defs>
<g clip-path="url(#portal)">
  <rect width="360" height="300" fill="url(#sky)"/>
  <circle cx="232" cy="90" r="44" fill="url(#sun)"/>
  <g fill="#53617e"><use href="#ridge"/></g>
  <path d="M-20 280 L93 151 L134 199 L166 173 L300 300 Z" fill="$accent"/>
  <path d="M-20 300 L91 207 L162 253 L257 176 L387 300 Z" fill="#18233c"/>
  <path d="M100 290 Q194 264 202 232 Q180 215 231 193" fill="none" stroke="#83e2be" stroke-width="3"/>
  <g fill="#f2f4ff"><circle cx="101" cy="61" r="1.5"/><circle cx="139" cy="44" r="1"/><circle cx="171" cy="82" r="1.5"/></g>
</g>
<rect x="55" y="30" width="250" height="232" rx="118" fill="none" stroke="#8393b0" stroke-width="1"/>
</svg>
SVG;
                $scene->add(Node::svg($svg, 0, 0, 360, 300), $label('THE GREAT OUTSIDE / SVG', 94, 284));
                break;
            case 13:
                $scene->add(Node::lottie(self::motionIdentity($accent), 35, 5, 290, 260, speed: 0.25 + $amount / 40),
                    $label('SKOTTIE / SIX INDEPENDENT LAYERS', 64, 284));
                break;
            case 14:
                $headline = TextStyle::make()->size(39)->weight(700)->paint($white)->height(1.02)->letterSpacing(-1);
                if ($fontBytes !== null) {
                    $scene->asset('editorial', $fontBytes, 'font');
                    $headline->font('editorial');
                }
                $scene->add(Node::text('THE TYPE DEPARTMENT', 25, 31, 10, $mint),
                    Node::richText([
                        TextSpan::make("Beautiful\n"),
                        TextSpan::make('by design.', TextStyle::make()->paint($color)->decoration(['underline'], 'wavy', $accent)),
                    ], 23, 49, 314, $headline),
                    Node::richText([
                        TextSpan::make('One paragraph. ', TextStyle::make()->weight(700)),
                        TextSpan::make('Many voices. ', TextStyle::make()->slant('italic')->paint($mint)),
                        TextSpan::make('Type is texture, rhythm and contrast. ', TextStyle::make()->letterSpacing(0.4)),
                        TextSpan::make('Make it yours.', TextStyle::make()->background('#36415a')->decoration()),
                    ], 25, 158, 308, TextStyle::make()->size(17)->paint($white)->height(1.35)->features(['liga' => 1])),
                    $label('RUNS / FONT ASSET / SHAPING', 25, 285));
                break;
            case 15:
                $scene->value('pulse', 0.4, Animation::between(0.3, 1, 1.8, 'easeInOut', 'mirror'));
                $shader = Paint::fill()->runtimeShader('uniform float pulse; half4 main(float2 p) { float rings = .5 + .5 * cos(length(p - float2(180,130)) * .12 - pulse * 8); return half4(mix(float3(.04,.07,.13),float3(.23,.18,.48),rings*pulse),1); }', ['pulse' => 0.4])->bindUniform('pulse', 'pulse');
                $scene->add(Node::rect(15, 15, 330, 240, $shader, 22));
                foreach ([[$accent, 90, 124], ['#83e2be', 180, 124], ['#f2bf89', 270, 124]] as [$c, $x, $y]) {
                    $scene->add(Node::group([Node::circle(0, 0, 32, Paint::fill($c)->shadow(0, 0, 10, $c.'66'))->bind('scaleX', 'pulse')->bind('scaleY', 'pulse')])->transform($x, $y));
                }
                $scene->add(Node::text('ONE VALUE. PERFECT SYNC.', 44, 229, 16, $white), $label('SHADER + THREE TRANSFORMS', 79, 284));
                break;
            case 16:
                $scene->value('passX', 180)->value('passY', 145)->value('zoom', 1)->value('angle', -8)->gestures('passX', 'passY', 'zoom', 'angle');
                $scene->add(Node::group([
                    Node::rect(-119, -76, 238, 152, Paint::fill()->linearGradient(-119, -76, 119, 76, ['#2d3957', '#17223b']), 18),
                    Node::text('SKIA / ALL ACCESS', -100, -48, 12, $mint),
                    Node::text('CREATE', -100, -12, 31, $white), Node::text('WITHOUT LIMITS.', -99, 11, 12, $color),
                    Node::circle(76, -2, 24, Paint::fill($accent))->id('planet'),
                    Node::path('M-95 31 L-80 45 L-95 59 L-110 45 Z', $mint)->id('stamp'),
                    Node::text('NATIVE / 001', -64, 50, 12, $muted),
                ])->id('pass')->bind('translateX', 'passX')->bind('translateY', 'passY')->bind('scaleX', 'zoom')->bind('scaleY', 'zoom')->bind('rotation', 'angle'),
                    $label('DRAG / PINCH / ROTATE / TAP', 82, 283));
                break;
            case 17:
                $scene->add(Node::rect(18, 18, 324, 264, Paint::fill()->linearGradient(18, 18, 342, 282, ['#25304a', '#121c31']), 22),
                    Node::text('A SMALL WORK OF ART', 39, 51, 10, $mint),
                    Node::text('Yours to keep.', 37, 91, 31, $white),
                    Node::circle(252, 147, 38, Paint::fill()->linearGradient(225, 107, 279, 187, [$accent, '#f2bf89'])),
                    Node::path('M18 247 L118 131 L205 247 Z', Paint::fill('#83e2be')),
                    Node::path('M126 253 L229 153 L342 260 L342 282 L126 282 Z', Paint::fill($accent)),
                    Node::rect(18, 249, 324, 33, Paint::fill('#101624'), 0),
                    Node::text('MADE WITH SKIA', 39, 271, 10, $white), Node::text('001 / 018', 275, 271, 10, $muted));
                break;
        }

        return $scene;
    }

    /** Original procedural Lottie fixture, with no remote assets. */
    private static function motionIdentity(string $accent): string
    {
        $layers = [];
        foreach ([$accent, '#83e2be', '#f2bf89', '#f2f4ff', $accent, '#83e2be'] as $i => $hex) {
            $rgb = array_map(fn ($offset) => hexdec(substr($hex, $offset, 2)) / 255, [1, 3, 5]);
            $layers[] = [
                'ddd' => 0, 'ind' => $i + 1, 'ty' => 4, 'nm' => 'Orbit '.($i + 1), 'ip' => 0, 'op' => 180, 'st' => 0, 'sr' => 1,
                'ks' => ['o' => ['a' => 0, 'k' => 100], 'p' => ['a' => 0, 'k' => [150, 135, 0]], 'a' => ['a' => 0, 'k' => [0, 0, 0]], 's' => ['a' => 0, 'k' => [100, 100, 100]],
                    'r' => ['a' => 1, 'k' => [['t' => 0, 's' => [$i * 60], 'e' => [$i * 60 + 360], 'o' => ['x' => 0.333, 'y' => 0.333], 'i' => ['x' => 0.667, 'y' => 0.667]], ['t' => 180, 's' => [$i * 60 + 360]]]]],
                'shapes' => [['ty' => 'el', 'p' => ['a' => 0, 'k' => [55, 0]], 's' => ['a' => 0, 'k' => [68, 68]], 'd' => 1], ['ty' => 'fl', 'c' => ['a' => 0, 'k' => [...$rgb, 1]], 'o' => ['a' => 0, 'k' => 82], 'r' => 1]],
            ];
        }

        return json_encode(['v' => '5.7.4', 'fr' => 60, 'ip' => 0, 'op' => 180, 'w' => 300, 'h' => 270, 'nm' => 'Skia motion identity', 'ddd' => 0, 'assets' => [], 'layers' => $layers], JSON_THROW_ON_ERROR);
    }
}
