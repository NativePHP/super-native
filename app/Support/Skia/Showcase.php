<?php

declare(strict_types=1);

namespace App\Support\Skia;

use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;
use Native\Mobile\Skia\Scene;

/** Original, deterministic compositions. Motion runs on the native clock. */
final class Showcase
{
    public const EXHIBITS = [
        ['title' => 'Polar lights', 'label' => 'Aurora', 'description' => 'A living sky. Curtains of light drift above a mountain silhouette.', 'technique' => 'Animated SkSL · procedural light · vector silhouettes'],
        ['title' => 'Liquid matter', 'label' => 'Chrome', 'description' => 'An impossible material. Mercury, oil and light in constant motion.', 'technique' => 'Animated SkSL · reflection field · iridescence'],
        ['title' => 'Orbital mechanics', 'label' => 'Orbit', 'description' => 'A miniature universe. Independent orbits trace a luminous instrument.', 'technique' => 'Native transforms · gradients · additive compositing'],
        ['title' => 'After hours', 'label' => 'City', 'description' => 'An electric city built from paths, with traffic threading through the night.', 'technique' => 'Isometric vectors · shadows · native animation'],
    ];

    public static function scene(int $exhibit = 0, float $intensity = 45, int $palette = 0): Scene
    {
        if (! isset(self::EXHIBITS[$exhibit])) {
            throw new \InvalidArgumentException('Unknown Skia exhibit.');
        }
        $scene = Scene::make(360, 440)->background('#060911');
        $amount = max(0, min(100, $intensity)) / 100;
        match ($exhibit) {
            0 => self::aurora($scene, $amount, $palette),
            1 => self::chrome($scene, $amount, $palette),
            2 => self::orbit($scene, $amount, $palette),
            3 => self::city($scene, $amount, $palette),
        };

        return $scene;
    }

    private static function shader(string $source, float $amount, int $palette): Paint
    {
        return Paint::fill()->runtimeShader($source, ['energy' => $amount, 'palette' => (float) ($palette % 3)], timeUniform: 'time');
    }

    private static function aurora(Scene $scene, float $amount, int $palette): void
    {
        $source = <<<'SKSL'
            uniform float time;
            uniform float energy;
            uniform float palette;
            half4 main(float2 pos) {
                float2 uv = pos / float2(360, 440);
                float t = time * 0.16;
                float3 col = mix(float3(0.013, 0.027, 0.067), float3(0.025, 0.09, 0.16), uv.y);
                for (int i = 0; i < 4; i++) {
                    float k = float(i);
                    float x = uv.x * (3.2 + energy * 1.5) + k * 0.85;
                    float fold = sin(x + t + k) * 0.10 + sin(x * 2.3 - t * 0.7) * 0.033;
                    float curve = 0.28 + k * 0.072 + fold + uv.x * 0.16;
                    float d = uv.y - curve;
                    float curtain = exp(-abs(d) * (d < 0.0 ? 7.0 : 80.0));
                    float threads = 0.56 + 0.44 * sin(x * 24.0 + sin(x * 5.0 + t) * 5.0);
                    float3 tint = 0.5 + 0.5 * cos(float3(1.5, 0.15, 0.9) + k * 0.8 + palette * 1.8);
                    col += tint * curtain * threads * 0.36;
                    col += float3(0.35, 0.9, 0.74) * exp(-abs(d) * 200.0) * 0.22;
                }
                float vignette = 1.0 - 0.45 * length((uv - 0.5) * float2(1.0, 0.7));
                return half4(col * vignette, 1);
            }
            SKSL;
        $scene->add(Node::rect(0, 0, 360, 440, self::shader($source, $amount, $palette)));
        self::stars($scene, 80, 310, '#c6e6fa');
        $scene->add(
            Node::circle(289, 104, 18, Paint::fill()->radialGradient(289, 104, 18, ['#cfeaff27', '#cfeaff00'])),
            Node::circle(289, 104, 7, Paint::fill('#dceef1')),
            Node::circle(293, 101, 7, Paint::fill('#102335')),
            Node::path('M0 357 L35 326 L52 339 L92 285 L119 323 L144 309 L181 349 L222 303 L250 331 L282 299 L321 342 L360 318 L360 440 L0 440 Z', Paint::fill('#142331')),
            Node::path('M72 313 L92 285 L108 307 L94 300 L88 308 L86 303 Z', Paint::fill('#618180')),
            Node::path('M203 323 L222 303 L239 320 L221 313 L219 317 Z', Paint::fill('#465f70')),
            Node::path('M0 378 L51 351 L85 380 L137 342 L187 374 L221 356 L273 391 L321 354 L360 373 L360 440 L0 440 Z', Paint::fill('#090f1a')),
            Node::rect(0, 354, 360, 86, Paint::fill()->linearGradient(0, 354, 0, 440, ['#06091100', '#060911'])),
        );
        self::caption($scene, '01 / ATMOSPHERE', 'POLAR', 'LIGHTS', '69.65° N  /  18.96° E', '#9dffe0');
    }

    private static function chrome(Scene $scene, float $amount, int $palette): void
    {
        $source = <<<'SKSL'
            uniform float time;
            uniform float energy;
            uniform float palette;
            half4 main(float2 pos) {
                float2 p = (pos - float2(180, 224)) / 130.0;
                float t = time * 0.35;
                float a = atan(p.y, p.x);
                float radius = 0.91 + 0.05 * sin(a * 3.0 + t) + 0.035 * sin(a * 5.0 - t * 1.3);
                float r = length(p) / radius;
                float3 bg = float3(0.018, 0.023, 0.035);
                bg += float3(0.12, 0.055, 0.22) * exp(-abs(r - 1.0) * 9.0) * 0.24;
                if (r > 1.0) return half4(bg, 1);
                float z = sqrt(max(0.0, 1.0 - r * r));
                float ripple = sin(p.x * 6.0 + p.y * 3.0 + t) * (0.12 + energy * 0.20);
                float reflection = p.y * 0.7 + z * 0.65 + ripple;
                float bands = 0.5 + 0.5 * sin(reflection * 11.0 - t * 0.3);
                float metal = 0.06 + pow(bands, 8.0) * 0.85 + pow(1.0 - z, 4.0) * 0.65;
                float3 rainbow = 0.5 + 0.5 * cos(float3(0, 2, 4) + reflection * 5.0 + palette * 1.6 + a * 0.7);
                float3 col = float3(metal) * 0.70 + rainbow * (0.15 + metal * 0.4);
                float streak = exp(-pow((reflection - 0.42) * 26.0, 2.0));
                col += float3(0.77, 0.91, 1.0) * streak * 0.7;
                float mask = 1.0 - smoothstep(0.986, 1.0, r);
                return half4(mix(bg, col, mask), 1);
            }
            SKSL;
        $scene->add(Node::rect(0, 0, 360, 440, self::shader($source, $amount, $palette)));
        for ($i = 0; $i < 9; $i++) {
            $scene->add(Node::line(24, 139 + $i * 24, 30, 139 + $i * 24, Paint::stroke('#738090', 0.6)), Node::line(330, 139 + $i * 24, 336, 139 + $i * 24, Paint::stroke('#738090', 0.6)));
        }
        $scene->add(Node::text('Hg', 271, 349, 17, Paint::fill('#e2e1f7')), Node::text('80', 293, 334, 9, Paint::fill('#8f9da9')));
        self::caption($scene, '02 / MATERIAL STUDY', 'LIQUID', 'MATTER', 'MERCURY / IMPOSSIBLE SURFACES', '#d1b5ff');
    }

    private static function orbit(Scene $scene, float $amount, int $palette): void
    {
        $accent = ['#f6ca7c', '#ad9cff', '#6df4d4'][$palette % 3];
        self::stars($scene, 125, 440, '#b5c3df');
        $scene->add(Node::circle(180, 244, 169, Paint::fill()->radialGradient(180, 244, 169, [$accent.'25', '#070b1200'])));
        for ($i = 0; $i < 60; $i++) {
            $angle = $i * M_PI / 30;
            $inner = $i % 5 === 0 ? 155 : 160;
            $scene->add(Node::line(180 + cos($angle) * $inner, 244 + sin($angle) * $inner, 180 + cos($angle) * 164, 244 + sin($angle) * 164, Paint::stroke($i % 5 === 0 ? '#617280' : '#293544', 0.7)));
        }
        for ($i = 0; $i < 5; $i++) {
            $r = 64 + $i * 19;
            $ring = [Node::oval(-$r, -$r * 0.42, $r * 2, $r * 0.84, Paint::stroke($accent.'75', 0.8))];
            for ($j = 0; $j < 18; $j++) {
                $a = -$j * 0.025;
                $ring[] = Node::circle(cos($a) * $r, sin($a) * $r * 0.42, max(0.35, 2.5 - $j * 0.12), Paint::fill($accent)->opacity(1 - $j / 18));
            }
            $ring[] = Node::circle($r, 0, 4, Paint::fill('#ffffed')->shadow(0, 0, 5, $accent));
            $scene->add(Node::group($ring)->transform(180, 244, $i * 36)->animate('rotation', Animation::between($i * 36, 360 + $i * 36, (22 + $i * 7) / (0.6 + $amount))));
        }
        $scene->add(
            Node::circle(180, 244, 41, Paint::fill()->radialGradient(180, 244, 41, [$accent.'cc', $accent.'00'])),
            Node::circle(180, 244, 19, Paint::fill()->radialGradient(174, 237, 27, ['#fffbee', $accent, '#4e322b'])),
            Node::line(180, 93, 180, 122, Paint::stroke('#8797a5', 0.6)),
            Node::text('N', 176, 86, 9, Paint::fill('#8e9fae')),
        );
        self::caption($scene, '03 / CELESTIAL INSTRUMENT', 'ORBITAL', 'MECHANICS', 'FIVE BODIES / ONE NATIVE CLOCK', $accent);
    }

    private static function city(Scene $scene, float $amount, int $palette): void
    {
        $accent = ['#fa6fce', '#80aaff', '#7dffc2'][$palette % 3];
        $scene->add(Node::rect(0, 0, 360, 440, Paint::fill()->linearGradient(0, 0, 0, 440, ['#060b1b', '#281638', '#080f21'])));
        self::stars($scene, 50, 195, '#b8a3cc');
        $scene->add(
            Node::circle(281, 142, 87, Paint::fill()->radialGradient(281, 142, 87, [$accent.'35', $accent.'00'])),
            Node::circle(281, 142, 29, Paint::fill()->linearGradient(253, 112, 305, 170, ['#ffc0c6', '#ab5dba'])),
        );
        for ($i = 0; $i < 6; $i++) {
            $scene->add(Node::rect(250, 148 + $i * 4, 63, 1 + $i * 0.4, Paint::fill('#23142f')));
        }
        // A distant silhouette separates the sky from the miniature city.
        for ($i = 0; $i < 28; $i++) {
            $h = 10 + ($i * 17) % 45;
            $scene->add(Node::rect($i * 14 - 10, 231 - $h, 11, $h, Paint::fill('#19182f')));
        }
        $scene->add(Node::oval(-50, 196, 450, 135, Paint::fill()->radialGradient(180, 240, 220, ['#7952b33d', '#13132500'])));
        $grid = [];
        for ($i = -8; $i < 12; $i++) {
            $grid[] = Node::line(-100, 278 + $i * 24, 450, 3 + $i * 24, Paint::stroke('#54497150', 0.4));
            $grid[] = Node::line(-100, 30 + $i * 24, 450, 305 + $i * 24, Paint::stroke('#54497150', 0.4));
        }
        $scene->add(Node::group($grid)->clip('M0 215 H360 V440 H0 Z'));
        // Wet, crossing boulevards. Vehicles are drawn before the buildings,
        // so the towers correctly occlude the traffic behind them.
        foreach ([[5, 243, 382, 431.5], [324, 228.5, -53, 417]] as $road) {
            $scene->add(Node::line(...[...$road, Paint::stroke('#91b9f026', 23)->blur(9)]),
                Node::line(...[...$road, Paint::stroke('#080d1d', 15)]),
                Node::line(...[...$road, Paint::stroke('#a3c9f540', 0.7)->dash([3, 6])]));
        }
        for ($i = 0; $i < 8; $i++) {
            $east = $i % 2 === 0;
            $x = $east ? -40 - $i * 26 : 400 + $i * 26;
            $y = $east ? 240.5 + $x / 2 : 390.5 - $x / 2;
            $dx = $east ? 500 : -500;
            $trail = Node::group([
                Node::line(-13, 0, 0, 0, Paint::stroke($east ? $accent : '#8ae8ff', 2)->cap('round')->shadow(0, 0, 3, $east ? $accent : '#59cfff')),
                Node::line(-16, 2, -4, 2, Paint::stroke($east ? $accent.'35' : '#8ae8ff35', 4)->blur(2)),
                Node::circle(0, 0, 1.3, Paint::fill('#ffffff')),
            ])->transform(0, 0, $east ? 26.565 : 153.435);
            $seconds = 9 / (0.6 + $amount);
            $scene->add(Node::group([$trail])->animate('translateX', Animation::between($x, $x + $dx, $seconds))->animate('translateY', Animation::between($y, $y + 250, $seconds)));
        }
        $heights = [[32, 42, 0, 57, 80, 24], [55, 91, 0, 46, 132, 48], [36, 58, 0, 73, 51, 64], [0, 0, 0, 0, 0, 0], [48, 32, 0, 90, 47, 30], [30, 65, 0, 36, 56, 79], [19, 38, 0, 26, 39, 30]];
        for ($row = 0; $row < 7; $row++) {
            for ($col = 0; $col < 6; $col++) {
                $height = $heights[$row][$col];
                if ($height === 0) {
                    continue;
                }
                $x = 179 + ($col - $row) * 29;
                $y = 243 + ($col + $row) * 14.5;
                $w = 11;
                $top = $y - $height;
                $glass = $height > 70;
                $scene->add(
                    Node::path("M$x $top l$w 6 v$height l-$w -6 Z", Paint::fill()->linearGradient($x, $top, $x, $y, [$glass ? '#393353' : '#252238', '#141427'])),
                    Node::path('M'.$x.' '.$top.' l-'.$w.' 6 v'.$height.' l'.$w.' -6 Z', Paint::fill()->linearGradient($x, $top, $x, $y, ['#253346', '#0b1627'])),
                    Node::path('M'.$x.' '.($top - 6).' l'.$w.' 6 l-'.$w.' 6 l-'.$w.' -6 Z', Paint::fill($glass ? '#69758b' : '#3c425a')),
                    Node::path('M'.($x - $w).' '.$top.' l'.$w.' 6 l'.$w.' -6', Paint::stroke($glass ? '#aedcfaaa' : $accent.'80', 0.7)),
                    Node::line($x, $top + 6, $x, $y + 6, Paint::stroke('#91a5c230', 0.6)),
                );
                for ($floor = 10; $floor < $height - 3; $floor += 5) {
                    for ($window = 0; $window < 3; $window++) {
                        if (($floor + $row * 7 + $col * 3 + $window * 11) % 7 < 2) {
                            continue;
                        }
                        $offset = 2 + $window * 3;
                        $light = ($floor + $row + $col) % 3 === 0 ? '#ffd5aeb0' : $accent.'9a';
                        $scene->add(Node::line($x + $offset, $top + $floor + $offset / 2, $x + $offset + 1.5, $top + $floor + ($offset + 1.5) / 2, Paint::stroke($light, 1.5)),
                            Node::line($x - $offset, $top + $floor + $offset / 2, $x - $offset - 1.5, $top + $floor + ($offset + 1.5) / 2, Paint::stroke('#78d5eaa0', 1.5)));
                    }
                }
                if ($height > 88) {
                    $scene->add(Node::path('M'.$x.' '.($top - 17).' l6 3 v9 l-6 3 l-6 -3 v-9 Z', Paint::fill('#58617a')),
                        Node::line($x, $top - 18, $x, $top - 34, Paint::stroke('#b4cbdd', 0.8)),
                        Node::circle($x, $top - 34, 1.6, Paint::fill('#ff95c3')->shadow(0, 0, 4, '#ff58aa')));
                }
                if ($row === 4 && $col === 1) {
                    $sign = [];
                    foreach (str_split('HOTEL') as $i => $letter) {
                        $sign[] = Node::text($letter, $x - 15, $top + 9 + $i * 7, 6, Paint::fill('#ffc9ed')->shadow(0, 0, 2, $accent));
                    }
                    $scene->add(Node::rect($x - 18, $top + 1, 10, 39, Paint::fill('#391c42'), 2), ...$sign);
                }
                // Street-level pools of light anchor the towers to the ground.
                $scene->add(Node::oval($x - 6, $y + 3, 12, 4, Paint::fill($accent.'35')->blur(2)));
            }
        }
        $rain = [];
        for ($i = 0; $i < 40; $i++) {
            $x = ($i * 83) % 390;
            $y = ($i * 137) % 570 - 140;
            $rain[] = Node::line($x, $y, $x - 3, $y + 12, Paint::stroke('#c8dfff20', 0.5));
        }
        $scene->add(Node::group($rain)->animate('translateY', Animation::between(0, 140, 1.8))->animate('translateX', Animation::between(0, -35, 1.8))->clip('M0 110 H395 V440 H0 Z'),
            Node::rect(0, 362, 360, 78, Paint::fill()->linearGradient(0, 362, 0, 440, ['#06091100', '#060911'])));
        self::caption($scene, '04 / NOCTURNE', 'AFTER', 'HOURS', '02:41 / RAIN IN THE NEON DISTRICT', $accent);
    }

    private static function stars(Scene $scene, int $count, int $height, string $color): void
    {
        for ($i = 0; $i < $count; $i++) {
            $x = ($i * 137 + 23) % 360;
            $y = ($i * 83 + 11) % $height;
            $scene->add(Node::circle($x, $y, $i % 7 === 0 ? 1 : 0.45, Paint::fill($color)->opacity(0.2 + ($i % 5) * 0.12)));
        }
    }

    private static function caption(Scene $scene, string $eyebrow, string $first, string $second, string $footer, string $accent): void
    {
        $scene->add(
            Node::text($eyebrow, 23, 28, 9, Paint::fill($accent)),
            Node::text($first, 21, 66, 36, Paint::fill('#f4f5fa')),
            Node::text($second, 21, 101, 36, Paint::fill('#f4f5fa')),
            Node::line(24, 405, 336, 405, Paint::stroke('#69758560', 0.5)),
            Node::circle(27, 421, 2, Paint::fill($accent)),
            Node::text($footer, 36, 424, 8, Paint::fill('#afbacb')),
            Node::text('SKIA', 311, 424, 8, Paint::fill($accent)),
        );
    }
}
