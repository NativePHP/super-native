<?php

declare(strict_types=1);

namespace App\Support\Skia;

use InvalidArgumentException;
use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;
use Native\Mobile\Skia\Scene;

/** The native product artwork used in the Skia launch film. */
final class Commercial
{
    public const DEMOS = [
        ['id' => 'stride', 'title' => 'STRIDE workout', 'label' => 'Workout', 'description' => 'An animated training dashboard with a gradient distance ring and a drawn pace graph.'],
        ['id' => 'activity', 'title' => 'Activity rings', 'label' => 'Activity', 'description' => 'Layered progress rings with native path trimming.'],
        ['id' => 'dial', 'title' => 'Precision gauge', 'label' => 'Gauge', 'description' => 'An instrument dial with an animated needle and fine vector markings.'],
        ['id' => 'weather', 'title' => 'Weather card', 'label' => 'Weather', 'description' => 'A composed weather card with animated illustrations and a forecast.'],
        ['id' => 'route', 'title' => 'Custom map', 'label' => 'Map', 'description' => 'A route drawn over a custom map, with a moving location marker.'],
        ['id' => 'candles', 'title' => 'Market chart', 'label' => 'Markets', 'description' => 'Animated candlesticks and a custom financial dashboard.'],
        ['id' => 'audio', 'title' => 'Audio visualizer', 'label' => 'Audio', 'description' => 'Animated bars and a player composition, driven entirely by the native clock.'],
        ['id' => 'upload', 'title' => 'Liquid progress', 'label' => 'Progress', 'description' => 'A liquid fill built with an animated SkSL shader.'],
        ['id' => 'habits', 'title' => 'Habit tracker', 'label' => 'Habits', 'description' => 'A calendar of progress with animated completion graphics.'],
        ['id' => 'seats', 'title' => 'Seat selection', 'label' => 'Seats', 'description' => 'A flight seat map with a highlighted seat, ready for a booking interface.'],
        ['id' => 'ticket', 'title' => 'Boarding pass', 'label' => 'Ticket', 'description' => 'A flight ticket with vector perforations, barcode, and destination details.'],
        ['id' => 'camera', 'title' => 'Product card', 'label' => 'Product', 'description' => 'A camera product card assembled from native vector shapes.'],
        ['id' => 'budget', 'title' => 'Spending dashboard', 'label' => 'Budget', 'description' => 'A spending breakdown with animated progress and category graphics.'],
        ['id' => 'delivery', 'title' => 'Delivery tracking', 'label' => 'Delivery', 'description' => 'A delivery map and tracking card with native motion.'],
        ['id' => 'sphere', 'title' => 'Gradient sphere', 'label' => 'Gradient', 'description' => 'A radial gradient creates depth from one native circle.'],
        ['id' => 'shader', 'title' => 'Liquid material', 'label' => 'Shader', 'description' => 'A SkSL material animated with a native time uniform.'],
        ['id' => 'mesh', 'title' => 'Color mesh', 'label' => 'Mesh', 'description' => 'Interpolated vertex colors form a native triangle mesh.'],
        ['id' => 'lottie', 'title' => 'Motion identity', 'label' => 'Lottie', 'description' => 'A Lottie composition playing through native Skottie.'],
    ];

    public static function scene(int $index = 0): Scene
    {
        if (! isset(self::DEMOS[$index])) {
            throw new InvalidArgumentException('Unknown commercial demo.');
        }

        return match (self::DEMOS[$index]['id']) {
            'stride' => self::stride(),
            'activity' => self::activity(),
            'dial' => self::dial(),
            'weather' => self::weather(),
            'route' => self::route(),
            'candles' => self::candles(),
            'audio' => self::audio(),
            'upload' => self::upload(),
            'habits' => self::habits(),
            'seats' => self::seats(),
            'ticket' => self::ticket(),
            'camera' => self::camera(),
            'budget' => self::budget(),
            'delivery' => self::delivery(),
            'sphere' => self::sphere(),
            'shader' => self::shader(),
            'mesh' => self::mesh(),
            'lottie' => self::lottie(),
        };
    }

    private static function stride(): Scene
    {
        return Scene::make(600, 650)->background('#fffaf5')->add(
            Node::text('STRIDE', 34, 46, 23, Paint::fill('#30242a'), ''),
            Node::rect(454, 22, 113, 34, Paint::fill('#ffe9dd'), 17),
            Node::circle(472, 39, 4, Paint::fill('#f66b45')),
            Node::text('LIVE RUN', 484, 44, 12, Paint::fill('#f66b45'), ''),
            Node::text('Find your next gear.', 34, 91, 30, Paint::fill('#30242a'), ''),
            Node::circle(300, 285, 145, Paint::stroke('#f7e4da', 22)->cap('round')->join('round')),
            Node::path('M300 140 A145 145 0 1 1 169 223', Paint::stroke('#f66b45', 22)->cap('round')->join('round')->linearGradient(158, 140, 415, 411, ['#ffba65', '#fa754c', '#f14b6d'], null, 'clamp'))->trim(0, 1)->animate('trimEnd', Animation::between(0.14, 1, 2.7, 'easeInOut', 'once')),
            Node::circle(300, 285, 110, Paint::fill('#fff6ee')),
            Node::text('4.82', 203, 296, 80, Paint::fill('#30242a'), ''),
            Node::text('KILOMETERS', 243, 326, 15, Paint::fill('#9a8587'), ''),
            Node::rect(244, 348, 112, 29, Paint::fill('#ffe5d4'), 14),
            Node::text('PERSONAL BEST', 255, 367, 10, Paint::fill('#c77048'), ''),
            Node::rect(34, 459, 172, 80, Paint::fill('#ffffff'), 16),
            Node::text('DURATION', 51, 484, 10, Paint::fill('#9a8587'), ''),
            Node::text('24:08', 51, 519, 29, Paint::fill('#30242a'), ''),
            Node::rect(222, 459, 172, 80, Paint::fill('#ffffff'), 16),
            Node::text('AVG. PACE', 239, 484, 10, Paint::fill('#9a8587'), ''),
            Node::text('5:00', 239, 519, 29, Paint::fill('#30242a'), ''),
            Node::rect(410, 459, 172, 80, Paint::fill('#ffffff'), 16),
            Node::text('HEART RATE', 427, 484, 10, Paint::fill('#9a8587'), ''),
            Node::text('148', 427, 519, 29, Paint::fill('#30242a'), ''),
            Node::text('YOUR PACE', 34, 574, 11, Paint::fill('#9a8587'), ''),
            Node::text('STRONG FINISH', 450, 574, 11, Paint::fill('#f66b45'), ''),
            Node::path('M35 617L40.28 608.94L45.56 604.38L50.84 600.76L56.12 598.36L61.40 597.28L66.68 597.41L71.96 598.49L77.24 600.08L82.52 601.70L87.80 602.89L93.08 603.24L98.36 602.53L103.64 600.70L108.92 597.91L114.20 594.47L119.48 590.84L124.76 587.51L130.04 584.97L135.32 583.60L140.60 583.61L145.88 585.02L151.16 587.67L156.44 591.21L161.72 595.17L167.00 599.04L172.28 602.35L177.56 604.74L182.84 605.99L188.12 606.09L193.40 605.24L198.68 603.79L203.96 602.18L209.24 600.90L214.52 600.40L219.80 600.99L225.08 602.84L230.36 605.89L235.64 609.91L240.92 614.49L246.20 619.15L251.48 623.38L256.76 626.72L262.04 628.84L267.32 629.59L272.60 629.03L277.88 627.39L283.16 625.06L288.44 622.53L293.72 620.29L299.00 618.75L304.28 618.20L309.56 618.76L314.84 620.33L320.12 622.63L325.40 625.26L330.68 627.72L335.96 629.52L341.24 630.26L346.52 629.68L351.80 627.70L357.08 624.45L362.36 620.25L367.64 615.52L372.92 610.79L378.20 606.54L383.48 603.20L388.76 601.00L394.04 600.02L399.32 600.12L404.60 601.00L409.88 602.22L415.16 603.30L420.44 603.78L425.72 603.30L431.00 601.65L436.28 598.83L441.56 595.02L446.84 590.58L452.12 585.97L457.40 581.72L462.68 578.29L467.96 576.04L473.24 575.19L478.52 575.72L483.80 577.43L489.08 579.97L494.36 582.88L499.64 585.64L504.92 587.80L510.20 589.04L515.48 589.18L520.76 588.25L526.04 586.48L531.32 584.25L536.60 582.03L541.88 580.31L547.16 579.51L552.44 579.95L557.72 581.74L563.00 584.80', Paint::stroke('#f7e4da', 5)->cap('round')->join('round')),
            Node::path('M35 617L40.28 608.94L45.56 604.38L50.84 600.76L56.12 598.36L61.40 597.28L66.68 597.41L71.96 598.49L77.24 600.08L82.52 601.70L87.80 602.89L93.08 603.24L98.36 602.53L103.64 600.70L108.92 597.91L114.20 594.47L119.48 590.84L124.76 587.51L130.04 584.97L135.32 583.60L140.60 583.61L145.88 585.02L151.16 587.67L156.44 591.21L161.72 595.17L167.00 599.04L172.28 602.35L177.56 604.74L182.84 605.99L188.12 606.09L193.40 605.24L198.68 603.79L203.96 602.18L209.24 600.90L214.52 600.40L219.80 600.99L225.08 602.84L230.36 605.89L235.64 609.91L240.92 614.49L246.20 619.15L251.48 623.38L256.76 626.72L262.04 628.84L267.32 629.59L272.60 629.03L277.88 627.39L283.16 625.06L288.44 622.53L293.72 620.29L299.00 618.75L304.28 618.20L309.56 618.76L314.84 620.33L320.12 622.63L325.40 625.26L330.68 627.72L335.96 629.52L341.24 630.26L346.52 629.68L351.80 627.70L357.08 624.45L362.36 620.25L367.64 615.52L372.92 610.79L378.20 606.54L383.48 603.20L388.76 601.00L394.04 600.02L399.32 600.12L404.60 601.00L409.88 602.22L415.16 603.30L420.44 603.78L425.72 603.30L431.00 601.65L436.28 598.83L441.56 595.02L446.84 590.58L452.12 585.97L457.40 581.72L462.68 578.29L467.96 576.04L473.24 575.19L478.52 575.72L483.80 577.43L489.08 579.97L494.36 582.88L499.64 585.64L504.92 587.80L510.20 589.04L515.48 589.18L520.76 588.25L526.04 586.48L531.32 584.25L536.60 582.03L541.88 580.31L547.16 579.51L552.44 579.95L557.72 581.74L563.00 584.80', Paint::stroke('#f66b45', 3)->cap('round')->join('round'))->trim(0, 1)->animate('trimEnd', Animation::between(0.14, 1, 2.7, 'easeInOut', 'once'))
        );
    }

    private static function activity(): Scene
    {
        return Scene::make(600, 440)->background('#ffffff')->add(
            Node::text('ACTIVITY', 35, 44, 15, Paint::fill('#88909e'), ''),
            Node::text('Make every move count.', 35, 82, 28, Paint::fill('#1c2030'), ''),
            Node::circle(198, 245, 112, Paint::stroke('#f1f1f7', 18)->cap('round')->join('round')),
            Node::path('M198 133 A112 112 0 1 1 91.60 210.28', Paint::stroke('#9d6fff', 18)->cap('round')->join('round'))->trim(0, 1)->animate('trimEnd', Animation::between(0.08, 1, 2.7, 'easeInOut', 'once')),
            Node::circle(198, 245, 85, Paint::stroke('#f1f1f7', 18)->cap('round')->join('round')),
            Node::path('M198 160 A85 85 0 1 1 117.25 218.65', Paint::stroke('#43c9a8', 18)->cap('round')->join('round'))->trim(0, 1)->animate('trimEnd', Animation::between(0.08, 1, 2.7, 'easeInOut', 'once')),
            Node::circle(198, 245, 58, Paint::stroke('#f1f1f7', 18)->cap('round')->join('round')),
            Node::path('M198 187 A58 58 0 1 1 142.90 227.02', Paint::stroke('#ffae6a', 18)->cap('round')->join('round'))->trim(0, 1)->animate('trimEnd', Animation::between(0.08, 1, 2.7, 'easeInOut', 'once')),
            Node::text('79%', 158, 253, 33, Paint::fill('#1c2030'), ''),
            Node::text('MOVE', 382, 172, 13, Paint::fill('#88909e'), ''),
            Node::text('640 kcal', 382, 208, 29, Paint::fill('#8b5cf6'), ''),
            Node::text('EXERCISE', 382, 257, 13, Paint::fill('#88909e'), ''),
            Node::text('42 min', 382, 294, 29, Paint::fill('#38b99c'), ''),
            Node::text('STAND', 382, 341, 13, Paint::fill('#88909e'), ''),
            Node::text('11 hours', 382, 377, 29, Paint::fill('#dd8a45'), '')
        );
    }

    private static function dial(): Scene
    {
        return Scene::make(600, 440)->background('#ffffff')->add(
            Node::text('IN YOUR ELEMENT', 35, 44, 15, Paint::fill('#88909e'), ''),
            Node::text('Precision. In motion.', 35, 83, 29, Paint::fill('#1c2030'), ''),
            Node::path('M179.62246887396302 344.5L196.94297694965178 334.5', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M173.01718138767848 331.53639338753624L183.97972687938972 326.65555367062666', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M167.80314423497367 317.9533622181177L179.21582243051552 314.24515828561834', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M164.037483498001 303.89972502366857L175.77525470680666 301.4047847338554', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M161.76145654381 289.52945639420386L173.6957192882293 288.275114834992', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M161.0 275.0L181.0 275.0', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M161.76145654381 260.47054360579614L173.6957192882293 261.724885165008', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M164.03748349800102 246.10027497633143L175.7752547068067 248.59521526614455', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M167.80314423497364 232.04663778188234L179.2158224305155 235.7548417143817', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M173.01718138767848 218.46360661246376L183.9797268793897 223.34444632937337', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M179.62246887396304 205.5L196.9429769496518 215.5', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M187.5466377818823 193.29784993134626L197.25484171438166 200.35127295885593', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M196.70286925864218 181.9908457161187L205.62060716437094 190.020412992425', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M206.9908457161187 171.70286925864218L215.020412992425 180.62060716437094', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M218.2978499313462 162.54663778188234L225.3512729588559 172.25484171438168', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M230.49999999999994 154.62246887396307L240.49999999999994 171.94297694965184', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M243.4636066124638 148.01718138767848L248.3444463293734 158.97972687938966', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M257.0466377818823 142.80314423497367L260.75484171438166 154.21582243051552', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M271.1002749763314 139.03748349800102L273.5952152661445 150.7752547068067', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M285.4705436057962 136.76145654381L286.724885165008 148.69571928822927', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M300.0 136.0L300.0 156.0', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M314.52945639420375 136.76145654381L313.27511483499194 148.69571928822927', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M328.89972502366857 139.03748349800102L326.4047847338554 150.7752547068067', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M342.95336221811766 142.80314423497364L339.2451582856183 154.2158224305155', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M356.5363933875362 148.01718138767845L351.65555367062655 158.97972687938966', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M369.5 154.62246887396304L359.5 171.9429769496518', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M381.70215006865374 162.54663778188228L374.64872704114407 172.25484171438166', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M393.00915428388123 171.70286925864215L384.97958700757493 180.62060716437088', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M403.2971307413578 181.9908457161187L394.37939283562906 190.020412992425', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M412.45336221811766 193.2978499313462L402.74515828561834 200.35127295885587', Paint::stroke('#8b5cf6', 3)->cap('round')->join('round')),
            Node::path('M420.37753112603696 205.49999999999994L403.05702305034816 215.49999999999994', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M426.9828186123215 218.46360661246376L416.02027312061034 223.3444463293734', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M432.1968557650263 232.04663778188228L420.7841775694845 235.75484171438166', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M435.96251650199895 246.10027497633138L424.22474529319334 248.5952152661445', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M438.23854345619 260.4705436057962L426.30428071177073 261.724885165008', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M439.0 274.99999999999994L419.0 274.99999999999994', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M438.23854345619 289.52945639420375L426.30428071177073 288.27511483499194', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M435.96251650199895 303.89972502366857L424.22474529319334 301.4047847338554', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M432.1968557650264 317.95336221811766L420.78417756948454 314.2451582856183', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M426.9828186123215 331.53639338753624L416.0202731206103 326.65555367062666', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M420.37753112603696 344.5L403.0570230503482 334.5', Paint::stroke('#dcdde7', 3)->cap('round')->join('round')),
            Node::path('M180 344 A138 138 0 1 1 420 344', Paint::stroke('#ece9f5', 14)->cap('round')->join('round')),
            Node::path('M180 344 A138 138 0 1 1 420 344', Paint::stroke('#8b5cf6', 14)->cap('round')->join('round'))->trim(0, 1)->animate('trimEnd', Animation::between(0.08, 1, 2.7, 'easeInOut', 'once')),
            Node::group([
                Node::path('M0 0 L65 -89', Paint::stroke('#1c2030', 6)->cap('round')->join('round')),
                Node::circle(0, 0, 12, Paint::fill('#8b5cf6')),
            ])->transform(300, 275, -60, 1, 1)->animate('rotation', Animation::between(-60, 50, 2.7, 'easeInOut', 'mirror')),
            Node::text('72', 262, 363, 43, Paint::fill('#1c2030'), ''),
            Node::text('KM / H', 271, 395, 12, Paint::fill('#88909e'), '')
        );
    }

    private static function weather(): Scene
    {
        return Scene::make(600, 440)->background('#eaf5fc')->add(
            Node::text('SAN FRANCISCO', 35, 45, 16, Paint::fill('#59758a'), ''),
            Node::text('A little brighter.', 35, 84, 29, Paint::fill('#1c2030'), ''),
            Node::circle(440, 157, 62, Paint::fill('#ffc768')),
            Node::circle(475, 178, 29, Paint::fill('#ffe1a9')),
            Node::text('24°', 35, 225, 104, Paint::fill('#1c2030'), ''),
            Node::text('Clear skies', 41, 262, 24, Paint::fill('#527187'), ''),
            Node::rect(40, 304, 120, 103, Paint::fill('#ffffff'), 18),
            Node::text('MON', 57, 332, 12, Paint::fill('#88909e'), ''),
            Node::circle(68, 363, 12, Paint::fill('#ffc768')),
            Node::text('24°', 97, 379, 27, Paint::fill('#1c2030'), ''),
            Node::rect(183, 304, 120, 103, Paint::fill('#ffffff'), 18),
            Node::text('TUE', 200, 332, 12, Paint::fill('#88909e'), ''),
            Node::circle(211, 363, 12, Paint::fill('#ffc768')),
            Node::text('26°', 240, 379, 27, Paint::fill('#1c2030'), ''),
            Node::rect(326, 304, 120, 103, Paint::fill('#ffffff'), 18),
            Node::text('WED', 343, 332, 12, Paint::fill('#88909e'), ''),
            Node::circle(354, 363, 12, Paint::fill('#ffc768')),
            Node::text('23°', 383, 379, 27, Paint::fill('#1c2030'), ''),
            Node::rect(469, 304, 120, 103, Paint::fill('#ffffff'), 18),
            Node::text('THU', 486, 332, 12, Paint::fill('#88909e'), ''),
            Node::circle(497, 363, 12, Paint::fill('#ffc768')),
            Node::text('25°', 526, 379, 27, Paint::fill('#1c2030'), '')
        );
    }

    private static function route(): Scene
    {
        return Scene::make(600, 440)->background('#ffffff')->add(
            Node::rect(0, 0, 600, 440, Paint::fill('#eef3ec'), 0),
            Node::path('M-150 0 L65 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M-15 0 L200 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M120 0 L335 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M255 0 L470 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M390 0 L605 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M525 0 L740 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M660 0 L875 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M795 0 L1010 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M0 -10L600 105', Paint::stroke('#ffffff', 15)->cap('round')->join('round')),
            Node::path('M0 100L600 215', Paint::stroke('#ffffff', 15)->cap('round')->join('round')),
            Node::path('M0 210L600 325', Paint::stroke('#ffffff', 15)->cap('round')->join('round')),
            Node::path('M0 320L600 435', Paint::stroke('#ffffff', 15)->cap('round')->join('round')),
            Node::path('M0 430L600 545', Paint::stroke('#ffffff', 15)->cap('round')->join('round')),
            Node::path('M460 -20 Q360 170 520 270 T590 470', Paint::stroke('#b9ddd7', 65)->cap('round')->join('round')),
            Node::rect(25, 25, 260, 75, Paint::fill('#ffffff'), 18),
            Node::text('THE SCENIC ROUTE', 45, 51, 12, Paint::fill('#88909e'), ''),
            Node::text('12 min · 2.4 km', 45, 81, 25, Paint::fill('#1c2030'), ''),
            Node::path('M105 335 L205 277 L181 223 L350 159 L315 90', Paint::stroke('#a0e8d7', 16)->cap('round')->join('round')),
            Node::path('M105 335 L205 277 L181 223 L350 159 L315 90', Paint::stroke('#087f75', 7)->cap('round')->join('round'))->trim(0, 1)->animate('trimEnd', Animation::between(0.08, 1, 2.7, 'easeInOut', 'once')),
            Node::circle(105, 335, 13, Paint::fill('#ffffff')),
            Node::circle(105, 335, 7, Paint::fill('#087f75')),
            Node::circle(315, 90, 17, Paint::fill('#8b5cf6')),
            Node::circle(315, 90, 6, Paint::fill('#ffffff')),
            Node::rect(295, 350, 280, 64, Paint::fill('#ffffff'), 18),
            Node::text('Your next adventure', 318, 390, 21, Paint::fill('#1c2030'), ''),
            Node::path('M536 382 H552 M546 376 L552 382 L546 388', Paint::stroke('#1c2030', 2)->cap('round'))
        );
    }

    private static function candles(): Scene
    {
        return Scene::make(600, 440)->background('#ffffff')->add(
            Node::text('MARKET OVERVIEW', 35, 43, 14, Paint::fill('#88909e'), ''),
            Node::text('$48,592', 35, 99, 45, Paint::fill('#1c2030'), ''),
            Node::text('+ 18.4%', 435, 92, 23, Paint::fill('#38b99c'), ''),
            Node::path('M35 160 H565', Paint::stroke('#eceef1', 1)->cap('round')->join('round')),
            Node::path('M35 220 H565', Paint::stroke('#eceef1', 1)->cap('round')->join('round')),
            Node::path('M35 280 H565', Paint::stroke('#eceef1', 1)->cap('round')->join('round')),
            Node::path('M35 340 H565', Paint::stroke('#eceef1', 1)->cap('round')->join('round')),
            Node::path('M46 282.5 V327.5', Paint::stroke('#ee8d84', 2)->cap('round')->join('round')),
            Node::rect(40, 295.5, 12, 19.0, Paint::fill('#ee8d84'), 2),
            Node::path('M69 282.5706840971038 V360.2956228420353', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(63, 295.5706840971038, 12, 51.724938744931464, Paint::fill('#38b99c'), 2),
            Node::path('M92 294.55130548114676 V347.98416184803216', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(86, 307.55130548114676, 12, 27.43285636688543, Paint::fill('#38b99c'), 2),
            Node::path('M115 262.6906943881396 V338.2425789049548', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(109, 275.6906943881396, 12, 49.55188451681517, Paint::fill('#38b99c'), 2),
            Node::path('M138 239.95655729395708 V301.26229788153114', Paint::stroke('#ee8d84', 2)->cap('round')->join('round')),
            Node::rect(132, 252.95655729395708, 12, 35.305740587574064, Paint::fill('#ee8d84'), 2),
            Node::path('M161 214.4541193470897 V285.80419406366485', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(155, 227.4541193470897, 12, 45.35007471657518, Paint::fill('#38b99c'), 2),
            Node::path('M184 216.31466200313892 V284.41052669372584', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(178, 229.31466200313892, 12, 42.09586469058689, Paint::fill('#38b99c'), 2),
            Node::path('M207 234.27152686165073 V299.6700515654728', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(201, 247.27152686165073, 12, 39.3985247038221, Paint::fill('#38b99c'), 2),
            Node::path('M230 246.5465302426441 V319.8988701329085', Paint::stroke('#ee8d84', 2)->cap('round')->join('round')),
            Node::rect(224, 259.5465302426441, 12, 47.35233989026436, Paint::fill('#ee8d84'), 2),
            Node::path('M253 253.6106952470073 V311.7031341603176', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(247, 266.6106952470073, 12, 32.092438913310254, Paint::fill('#38b99c'), 2),
            Node::path('M276 223.1762589707565 V299.90237620278185', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(270, 236.1762589707565, 12, 50.72611723202537, Paint::fill('#38b99c'), 2),
            Node::path('M299 206.73051104835673 V256.6474789002253', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(293, 219.73051104835673, 12, 23.91696785186856, Paint::fill('#38b99c'), 2),
            Node::path('M322 172.5372027057842 V250.5303684104923', Paint::stroke('#ee8d84', 2)->cap('round')->join('round')),
            Node::rect(316, 185.5372027057842, 12, 51.99316570470808, Paint::fill('#ee8d84'), 2),
            Node::path('M345 187.87195582576985 V236.45696347476436', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(339, 200.87195582576985, 12, 22.585007648994516, Paint::fill('#38b99c'), 2),
            Node::path('M368 190.40677096741808 V267.4761196769656', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(362, 203.40677096741808, 12, 51.06934870954749, Paint::fill('#38b99c'), 2),
            Node::path('M391 216.5815011020796 V273.4304267848112', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(385, 229.5815011020796, 12, 30.848925682731554, Paint::fill('#38b99c'), 2),
            Node::path('M414 207.0304122261428 V281.04642326061673', Paint::stroke('#ee8d84', 2)->cap('round')->join('round')),
            Node::rect(408, 220.0304122261428, 12, 48.016011034473905, Paint::fill('#ee8d84'), 2),
            Node::path('M437 190.44571993808123 V254.77175215723307', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(431, 203.44571993808123, 12, 38.32603221915182, Paint::fill('#38b99c'), 2),
            Node::path('M460 158.25423171162163 V227.2901370500643', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(454, 171.25423171162163, 12, 43.03590533844266, Paint::fill('#38b99c'), 2),
            Node::path('M483 137.68626967987134 V208.20609003555663', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(477, 150.68626967987134, 12, 44.51982035568528, Paint::fill('#38b99c'), 2),
            Node::path('M506 142.74249276941268 V205.20222141137347', Paint::stroke('#ee8d84', 2)->cap('round')->join('round')),
            Node::rect(500, 155.74249276941268, 12, 36.45972864196079, Paint::fill('#ee8d84'), 2),
            Node::path('M529 153.40233517333766 V228.421335343844', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(523, 166.40233517333766, 12, 49.01900017050633, Paint::fill('#38b99c'), 2),
            Node::path('M552 179.4207832254447 V234.1449460749532', Paint::stroke('#38b99c', 2)->cap('round')->join('round')),
            Node::rect(546, 192.4207832254447, 12, 28.724162849508502, Paint::fill('#38b99c'), 2),
            Node::text('09:00', 35, 390, 12, Paint::fill('#88909e'), ''),
            Node::text('12:00', 275, 390, 12, Paint::fill('#88909e'), ''),
            Node::text('16:00', 530, 390, 12, Paint::fill('#88909e'), '')
        );
    }

    private static function audio(): Scene
    {
        return Scene::make(600, 440)->background('#ffffff')->add(
            Node::text('NOW PLAYING', 35, 44, 14, Paint::fill('#88909e'), ''),
            Node::text('Feel the frequency.', 35, 89, 32, Paint::fill('#1c2030'), ''),
            Node::group([
                Node::rect(-3, -33.33963168725608, 6, 66.67926337451216, Paint::fill('#8b5cf6'), 3),
            ])->transform(40, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.27, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -41.008394706152416, 6, 82.01678941230483, Paint::fill('#8b5cf6'), 3),
            ])->transform(52, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.34, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -49.805578020605, 6, 99.61115604121, Paint::fill('#8b5cf6'), 3),
            ])->transform(64, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.41000000000000003, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -54.40739947513791, 6, 108.81479895027582, Paint::fill('#8b5cf6'), 3),
            ])->transform(76, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.48000000000000004, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -51.27309024372332, 6, 102.54618048744663, Paint::fill('#8b5cf6'), 3),
            ])->transform(88, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.55, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -41.767344500210925, 6, 83.53468900042185, Paint::fill('#8b5cf6'), 3),
            ])->transform(100, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.6200000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -32.26845890851915, 6, 64.5369178170383, Paint::fill('#8b5cf6'), 3),
            ])->transform(112, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.6900000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -30.840832290516964, 6, 61.68166458103393, Paint::fill('#8b5cf6'), 3),
            ])->transform(124, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.27, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -42.24515528306355, 6, 84.4903105661271, Paint::fill('#8b5cf6'), 3),
            ])->transform(136, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.34, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -64.29112371715107, 6, 128.58224743430213, Paint::fill('#8b5cf6'), 3),
            ])->transform(148, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.41000000000000003, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -87.98830154999538, 6, 175.97660309999077, Paint::fill('#8b5cf6'), 3),
            ])->transform(160, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.48000000000000004, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -101.84761196291826, 6, 203.69522392583653, Paint::fill('#8b5cf6'), 3),
            ])->transform(172, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.55, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -98.2051371757962, 6, 196.4102743515924, Paint::fill('#8b5cf6'), 3),
            ])->transform(184, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.6200000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -78.0445157304623, 6, 156.0890314609246, Paint::fill('#8b5cf6'), 3),
            ])->transform(196, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.6900000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -51.37877921148787, 6, 102.75755842297573, Paint::fill('#8b5cf6'), 3),
            ])->transform(208, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.27, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -32.59221683922781, 6, 65.18443367845562, Paint::fill('#8b5cf6'), 3),
            ])->transform(220, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.34, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -32.97849657263984, 6, 65.95699314527968, Paint::fill('#8b5cf6'), 3),
            ])->transform(232, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.41000000000000003, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -54.43825970705544, 6, 108.87651941411087, Paint::fill('#8b5cf6'), 3),
            ])->transform(244, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.48000000000000004, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -87.87960151160323, 6, 175.75920302320645, Paint::fill('#8b5cf6'), 3),
            ])->transform(256, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.55, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -117.44103942810503, 6, 234.88207885621006, Paint::fill('#8b5cf6'), 3),
            ])->transform(268, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.6200000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -128.50973244614346, 6, 257.0194648922869, Paint::fill('#8b5cf6'), 3),
            ])->transform(280, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.6900000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -115.36589266125323, 6, 230.73178532250645, Paint::fill('#8b5cf6'), 3),
            ])->transform(292, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.27, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -84.36211902504456, 6, 168.72423805008913, Paint::fill('#8b5cf6'), 3),
            ])->transform(304, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.34, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -50.85376766374944, 6, 101.70753532749887, Paint::fill('#8b5cf6'), 3),
            ])->transform(316, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.41000000000000003, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -31.411272796237338, 6, 62.822545592474675, Paint::fill('#8b5cf6'), 3),
            ])->transform(328, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.48000000000000004, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -35.37379495543648, 6, 70.74758991087296, Paint::fill('#8b5cf6'), 3),
            ])->transform(340, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.55, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -60.16633344212684, 6, 120.33266688425368, Paint::fill('#8b5cf6'), 3),
            ])->transform(352, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.6200000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -92.79741921430823, 6, 185.59483842861647, Paint::fill('#8b5cf6'), 3),
            ])->transform(364, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.6900000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -116.6704335220829, 6, 233.3408670441658, Paint::fill('#8b5cf6'), 3),
            ])->transform(376, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.27, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -120.05799512027475, 6, 240.1159902405495, Paint::fill('#d7cdf4'), 3),
            ])->transform(388, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.34, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -101.7968814068968, 6, 203.5937628137936, Paint::fill('#d7cdf4'), 3),
            ])->transform(400, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.41000000000000003, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -71.35017461044313, 6, 142.70034922088627, Paint::fill('#d7cdf4'), 3),
            ])->transform(412, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.48000000000000004, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -43.44413425273027, 6, 86.88826850546054, Paint::fill('#d7cdf4'), 3),
            ])->transform(424, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.55, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -30.331887337091473, 6, 60.663774674182946, Paint::fill('#d7cdf4'), 3),
            ])->transform(436, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.6200000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -35.83947489366188, 6, 71.67894978732376, Paint::fill('#d7cdf4'), 3),
            ])->transform(448, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.6900000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -54.18215577942777, 6, 108.36431155885553, Paint::fill('#d7cdf4'), 3),
            ])->transform(460, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.27, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -73.82801667263008, 6, 147.65603334526017, Paint::fill('#d7cdf4'), 3),
            ])->transform(472, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.34, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -83.97678989425283, 6, 167.95357978850566, Paint::fill('#d7cdf4'), 3),
            ])->transform(484, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.41000000000000003, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -79.99408179944308, 6, 159.98816359888616, Paint::fill('#d7cdf4'), 3),
            ])->transform(496, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.48000000000000004, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -64.99035523004662, 6, 129.98071046009323, Paint::fill('#d7cdf4'), 3),
            ])->transform(508, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.55, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -47.07297954697734, 6, 94.14595909395469, Paint::fill('#d7cdf4'), 3),
            ])->transform(520, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.6200000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -34.23572872380371, 6, 68.47145744760742, Paint::fill('#d7cdf4'), 3),
            ])->transform(532, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.6900000000000001, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -30.004170946431536, 6, 60.00834189286307, Paint::fill('#d7cdf4'), 3),
            ])->transform(544, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.22, 1, 0.27, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -32.24580783673209, 6, 64.49161567346418, Paint::fill('#d7cdf4'), 3),
            ])->transform(556, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.33999999999999997, 1, 0.34, 'easeInOut', 'mirror')),
            Node::group([
                Node::rect(-3, -35.49795064179804, 6, 70.99590128359608, Paint::fill('#d7cdf4'), 3),
            ])->transform(568, 260, 0, 1, 1)->animate('scaleY', Animation::between(0.45999999999999996, 1, 0.41000000000000003, 'easeInOut', 'mirror')),
            Node::text('HANDS', 35, 388, 18, Paint::fill('#1c2030'), ''),
            Node::text('Heyson', 35, 413, 12, Paint::fill('#88909e'), ''),
            Node::circle(536, 393, 24, Paint::fill('#1c2030')),
            Node::rect(528, 384, 5, 18, Paint::fill('#ffffff'), 1),
            Node::rect(539, 384, 5, 18, Paint::fill('#ffffff'), 1)
        );
    }

    private static function upload(): Scene
    {
        return Scene::make(600, 440)->background('#ffffff')->add(
            Node::text('CLOUD STUDIO', 32, 40, 13, Paint::fill('#898697'), ''),
            Node::text('Good things are on the way.', 32, 80, 28, Paint::fill('#242335'), ''),
            Node::circle(159, 243, 105, Paint::fill('#f0eafa')),
            Node::circle(159, 243, 95, Paint::fill('#ebe4fb')),
            Node::circle(159, 243, 95, Paint::fill('#8b5cf6')->runtimeShader('uniform float time; half4 main(float2 p){float h=284.0-68.0*clamp(time/2.8,0.0,1.0);float w=sin(p.x*.036-time*2.6)*7.0+sin(p.x*.022+time*1.7)*4.0;float w2=sin(p.x*.027+time*2.0)*8.0;float3 c=float3(.92,.89,.99);if(p.y>h+w2-9.0)c=float3(.76,.65,.96);if(p.y>h+w)c=mix(float3(.57,.37,.94),float3(.36,.20,.71),clamp((p.y-h)/140.0,0.0,1.0));return half4(c,1);}', [], 'time')),
            Node::rect(100, 195, 118, 34, Paint::fill('#ffffff'), 17),
            Node::text('Uploading', 108, 218, 17, Paint::fill('#242335'), ''),
            Node::text('Trip photos', 32, 390, 22, Paint::fill('#242335'), ''),
            Node::text('Your memories. Safely stored.', 32, 418, 13, Paint::fill('#898697'), ''),
            Node::rect(303, 144, 262, 65, Paint::fill('#f8f6fc'), 12),
            Node::rect(317, 158, 38, 38, Paint::fill('#e8ddfa'), 9),
            Node::path('M323 185l9 -12 6 7 9 -14', Paint::stroke('#8b5cf6', 2)->cap('round')->join('round')),
            Node::text('San Francisco', 367, 170, 17, Paint::fill('#242335'), ''),
            Node::text('24 photos', 367, 190, 11, Paint::fill('#898697'), ''),
            Node::circle(543, 167, 9, Paint::fill('#219d83')),
            Node::path('M537 167l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(303, 223, 262, 65, Paint::fill('#f8f6fc'), 12),
            Node::rect(317, 237, 38, 38, Paint::fill('#e8ddfa'), 9),
            Node::path('M323 264l9 -12 6 7 9 -14', Paint::stroke('#8b5cf6', 2)->cap('round')->join('round')),
            Node::text('Weekend away', 367, 249, 17, Paint::fill('#242335'), ''),
            Node::text('18 photos', 367, 269, 11, Paint::fill('#898697'), ''),
            Node::circle(543, 246, 9, Paint::fill('#219d83')),
            Node::path('M537 246l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(303, 302, 262, 65, Paint::fill('#f8f6fc'), 12),
            Node::rect(317, 316, 38, 38, Paint::fill('#e8ddfa'), 9),
            Node::path('M323 343l9 -12 6 7 9 -14', Paint::stroke('#8b5cf6', 2)->cap('round')->join('round')),
            Node::text('The good stuff', 367, 328, 17, Paint::fill('#242335'), ''),
            Node::text('32 photos · uploading', 367, 348, 11, Paint::fill('#898697'), '')
        );
    }

    private static function habits(): Scene
    {
        return Scene::make(600, 440)->background('#fffcf7')->add(
            Node::text('A LITTLE BETTER, EVERY DAY', 32, 40, 12, Paint::fill('#9e7951'), ''),
            Node::text('Keep your streak alive.', 32, 81, 30, Paint::fill('#242335'), ''),
            Node::rect(32, 111, 194, 289, Paint::fill('#fcf0dd'), 22),
            Node::text('12', 68, 207, 82, Paint::fill('#c58336'), ''),
            Node::text('DAY STREAK', 61, 239, 14, Paint::fill('#9e7951'), ''),
            Node::path('M61 277H197', Paint::stroke('#e9d7bc', 1)->cap('round')->join('round')),
            Node::text('Morning movement', 50, 314, 16, Paint::fill('#242335'), ''),
            Node::text('Today, you showed up.', 50, 340, 12, Paint::fill('#9e7951'), ''),
            Node::rect(50, 360, 157, 24, Paint::fill('#fffaf1'), 12),
            Node::text('Personal best: 18 days', 62, 377, 11, Paint::fill('#9e7951'), ''),
            Node::text('OCTOBER', 258, 132, 14, Paint::fill('#898697'), ''),
            Node::text('M', 267, 170, 12, Paint::fill('#898697'), ''),
            Node::text('T', 309, 170, 12, Paint::fill('#898697'), ''),
            Node::text('W', 351, 170, 12, Paint::fill('#898697'), ''),
            Node::text('T', 393, 170, 12, Paint::fill('#898697'), ''),
            Node::text('F', 435, 170, 12, Paint::fill('#898697'), ''),
            Node::text('S', 477, 170, 12, Paint::fill('#898697'), ''),
            Node::text('S', 519, 170, 12, Paint::fill('#898697'), ''),
            Node::rect(260, 192, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M268 208l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(302, 192, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M310 208l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(344, 192, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M352 208l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(386, 192, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M394 208l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(428, 192, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M436 208l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(470, 192, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M478 208l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(512, 192, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M520 208l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(260, 236, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M268 252l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(302, 236, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M310 252l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(344, 236, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M352 252l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(386, 236, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M394 252l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(428, 236, 32, 32, Paint::fill('#d69a53'), 9),
            Node::path('M436 252l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(470, 236, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('13', 477, 258, 13, Paint::fill('#898697'), ''),
            Node::rect(512, 236, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('14', 519, 258, 13, Paint::fill('#898697'), ''),
            Node::rect(260, 280, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('15', 267, 302, 13, Paint::fill('#898697'), ''),
            Node::rect(302, 280, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('16', 309, 302, 13, Paint::fill('#898697'), ''),
            Node::rect(344, 280, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('17', 351, 302, 13, Paint::fill('#898697'), ''),
            Node::rect(386, 280, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('18', 393, 302, 13, Paint::fill('#898697'), ''),
            Node::rect(428, 280, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('19', 435, 302, 13, Paint::fill('#898697'), ''),
            Node::rect(470, 280, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('20', 477, 302, 13, Paint::fill('#898697'), ''),
            Node::rect(512, 280, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('21', 519, 302, 13, Paint::fill('#898697'), ''),
            Node::rect(260, 324, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('22', 267, 346, 13, Paint::fill('#898697'), ''),
            Node::rect(302, 324, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('23', 309, 346, 13, Paint::fill('#898697'), ''),
            Node::rect(344, 324, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('24', 351, 346, 13, Paint::fill('#898697'), ''),
            Node::rect(386, 324, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('25', 393, 346, 13, Paint::fill('#898697'), ''),
            Node::rect(428, 324, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('26', 435, 346, 13, Paint::fill('#898697'), ''),
            Node::rect(470, 324, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('27', 477, 346, 13, Paint::fill('#898697'), ''),
            Node::rect(512, 324, 32, 32, Paint::fill('#f4f2ed'), 9),
            Node::text('28', 519, 346, 13, Paint::fill('#898697'), ''),
            Node::circle(269, 399, 5, Paint::fill('#d69a53')),
            Node::text('Small steps. Real progress.', 285, 403, 13, Paint::fill('#9e7951'), '')
        );
    }

    private static function seats(): Scene
    {
        return Scene::make(600, 440)->background('#ffffff')->add(
            Node::text('NP AIR / FLIGHT 204', 32, 39, 12, Paint::fill('#898697'), ''),
            Node::text('A window to your next adventure.', 32, 79, 27, Paint::fill('#242335'), ''),
            Node::rect(32, 111, 220, 294, Paint::fill('#f2edfc'), 20),
            Node::text('SFO', 54, 163, 42, Paint::fill('#242335'), ''),
            Node::text('JFK', 54, 251, 42, Paint::fill('#242335'), ''),
            Node::path('M182 145V231 M177 226l5 5 5 -5', Paint::stroke('#8b5cf6', 2)->cap('round')->join('round')),
            Node::text('SAN FRANCISCO', 55, 185, 11, Paint::fill('#898697'), ''),
            Node::text('NEW YORK', 55, 275, 11, Paint::fill('#898697'), ''),
            Node::rect(50, 312, 184, 71, Paint::fill('#ffffff'), 14),
            Node::text('YOUR SEAT', 66, 336, 11, Paint::fill('#898697'), ''),
            Node::text('08A', 66, 367, 27, Paint::fill('#8b5cf6'), ''),
            Node::text('Window', 139, 365, 14, Paint::fill('#242335'), ''),
            Node::text('A', 312, 118, 12, Paint::fill('#898697'), ''),
            Node::text('B', 354, 118, 12, Paint::fill('#898697'), ''),
            Node::text('C', 396, 118, 12, Paint::fill('#898697'), ''),
            Node::text('D', 472, 118, 12, Paint::fill('#898697'), ''),
            Node::text('E', 514, 118, 12, Paint::fill('#898697'), ''),
            Node::text('F', 556, 118, 12, Paint::fill('#898697'), ''),
            Node::text('06', 435, 160, 11, Paint::fill('#898697'), ''),
            Node::rect(300, 138, 32, 33, Paint::fill('#d8d8e0'), 8),
            Node::path('M305 163h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(342, 138, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M347 163h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(384, 138, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M389 163h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(460, 138, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M465 163h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(502, 138, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M507 163h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(544, 138, 32, 33, Paint::fill('#d8d8e0'), 8),
            Node::path('M549 163h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::text('07', 435, 206, 11, Paint::fill('#898697'), ''),
            Node::rect(300, 184, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M305 209h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(342, 184, 32, 33, Paint::fill('#d8d8e0'), 8),
            Node::path('M347 209h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(384, 184, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M389 209h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(460, 184, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M465 209h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(502, 184, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M507 209h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(544, 184, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M549 209h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::text('08', 435, 252, 11, Paint::fill('#898697'), ''),
            Node::rect(300, 230, 32, 33, Paint::fill('#8b5cf6'), 8),
            Node::path('M305 255h22', Paint::stroke('#b69ae9', 2)->cap('round')->join('round')),
            Node::path('M308 246l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::rect(342, 230, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M347 255h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(384, 230, 32, 33, Paint::fill('#d8d8e0'), 8),
            Node::path('M389 255h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(460, 230, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M465 255h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(502, 230, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M507 255h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(544, 230, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M549 255h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::text('09', 435, 298, 11, Paint::fill('#898697'), ''),
            Node::rect(300, 276, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M305 301h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(342, 276, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M347 301h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(384, 276, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M389 301h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(460, 276, 32, 33, Paint::fill('#d8d8e0'), 8),
            Node::path('M465 301h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(502, 276, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M507 301h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(544, 276, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M549 301h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::text('10', 435, 344, 11, Paint::fill('#898697'), ''),
            Node::rect(300, 322, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M305 347h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(342, 322, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M347 347h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(384, 322, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M389 347h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(460, 322, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M465 347h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(502, 322, 32, 33, Paint::fill('#d8d8e0'), 8),
            Node::path('M507 347h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::rect(544, 322, 32, 33, Paint::fill('#f1eef8'), 8),
            Node::path('M549 347h22', Paint::stroke('#c8b7e8', 2)->cap('round')->join('round')),
            Node::circle(308, 399, 5, Paint::fill('#8b5cf6')),
            Node::text('Selected', 321, 403, 11, Paint::fill('#898697'), ''),
            Node::circle(404, 399, 5, Paint::fill('#f1eef8')),
            Node::text('Available', 416, 403, 11, Paint::fill('#898697'), ''),
            Node::circle(509, 399, 5, Paint::fill('#d8d8e0')),
            Node::text('Taken', 521, 403, 11, Paint::fill('#898697'), '')
        );
    }

    private static function ticket(): Scene
    {
        return Scene::make(600, 440)->background('#ffffff')->add(
            Node::rect(32, 23, 536, 394, Paint::fill('#f0eaff'), 25),
            Node::text('BOARDING PASS', 58, 60, 13, Paint::fill('#70608c'), ''),
            Node::text('SFO', 57, 149, 61, Paint::fill('#1c2030'), ''),
            Node::text('JFK', 404, 149, 61, Paint::fill('#1c2030'), ''),
            Node::path('M228 124 H361', Paint::stroke('#9784be', 2)->cap('round')->join('round')),
            Node::path('M285 109 L324 124 L285 139 L292 124 Z', Paint::fill('#8b5cf6')),
            Node::text('SAN FRANCISCO', 60, 180, 12, Paint::fill('#70608c'), ''),
            Node::text('NEW YORK', 407, 180, 12, Paint::fill('#70608c'), ''),
            Node::path('M50 225 H550', Paint::stroke('#bdaed6', 1)->cap('round')->join('round')),
            Node::text('FLIGHT', 62, 264, 11, Paint::fill('#70608c'), ''),
            Node::text('NP 204', 62, 296, 27, Paint::fill('#1c2030'), ''),
            Node::text('GATE', 260, 264, 11, Paint::fill('#70608c'), ''),
            Node::text('A12', 260, 296, 27, Paint::fill('#1c2030'), ''),
            Node::text('SEAT', 428, 264, 11, Paint::fill('#70608c'), ''),
            Node::text('08A', 428, 296, 27, Paint::fill('#1c2030'), ''),
            Node::rect(61, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(75, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(82, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(89, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(103, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(110, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(117, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(131, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(138, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(145, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(159, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(166, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(173, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(187, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(194, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(201, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(215, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(222, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(229, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(243, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(250, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(257, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(271, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(278, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(285, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(299, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(306, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(313, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(327, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(334, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(341, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(355, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(362, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(369, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(383, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(390, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(397, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(411, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(418, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(425, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(439, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(446, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(453, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(467, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(474, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(481, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(495, 340, 4, 49, Paint::fill('#1c2030'), 0),
            Node::rect(502, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(509, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(523, 340, 2, 49, Paint::fill('#1c2030'), 0),
            Node::rect(530, 340, 3, 49, Paint::fill('#1c2030'), 0),
            Node::rect(537, 340, 4, 49, Paint::fill('#1c2030'), 0)
        );
    }

    private static function camera(): Scene
    {
        return Scene::make(600, 440)->background('#f3f6f3')->add(
            Node::text('MADE TO BE SEEN', 35, 45, 13, Paint::fill('#88909e'), ''),
            Node::text('Capture the moment.', 35, 86, 31, Paint::fill('#1c2030'), ''),
            Node::rect(141, 157, 318, 193, Paint::fill('#d7dedb'), 32),
            Node::rect(166, 133, 87, 42, Paint::fill('#c5ceca'), 10),
            Node::rect(178, 176, 70, 28, Paint::fill('#1c2030'), 5),
            Node::circle(329, 251, 79, Paint::fill('#1c2030')),
            Node::circle(329, 251, 61, Paint::fill('#586c67')),
            Node::circle(329, 251, 45, Paint::fill('#8faf9a')),
            Node::circle(329, 251, 30, Paint::fill('#d4ead4')),
            Node::circle(316, 237, 9, Paint::fill('#ffffff')),
            Node::circle(426, 186, 7, Paint::fill('#8b5cf6')),
            Node::text('STUDIO CAM', 35, 407, 17, Paint::fill('#1c2030'), ''),
            Node::text('Designed for the everyday.', 305, 407, 15, Paint::fill('#88909e'), '')
        );
    }

    private static function budget(): Scene
    {
        return Scene::make(600, 440)->background('#ffffff')->add(
            Node::text('YOUR MONEY, AT A GLANCE', 32, 40, 12, Paint::fill('#898697'), ''),
            Node::text('Room for what matters.', 32, 80, 30, Paint::fill('#242335'), ''),
            Node::text('OCTOBER SPENDING', 32, 125, 11, Paint::fill('#898697'), ''),
            Node::text('$2,840', 32, 170, 44, Paint::fill('#242335'), ''),
            Node::rect(420, 114, 145, 35, Paint::fill('#e7f5ef'), 17),
            Node::text('Under budget', 435, 137, 15, Paint::fill('#219d83'), ''),
            Node::path('M139.0 215.0A80 80 0 0 1 172.80946093925596 367.504622962932', Paint::stroke('#8b5cf6', 25)->cap('round')->join('round'))->trim(0, 1)->animate('trimEnd', Animation::between(0.08, 1, 2.7, 'easeInOut', 'once')),
            Node::path('M165.04545235657253 370.64148604794536A80 80 0 0 1 59.0 295.0', Paint::stroke('#8bcbb9', 25)->cap('round')->join('round'))->trim(0, 1)->animate('trimEnd', Animation::between(0.08, 1, 2.7, 'easeInOut', 'once')),
            Node::path('M59.43824837053813 286.63772293858773A80 80 0 0 1 125.10814578664558 216.21537975902336', Paint::stroke('#f1b878', 25)->cap('round')->join('round'))->trim(0, 1)->animate('trimEnd', Animation::between(0.08, 1, 2.7, 'easeInOut', 'once')),
            Node::text('71%', 104, 300, 35, Paint::fill('#242335'), ''),
            Node::text('OF BUDGET', 105, 324, 10, Paint::fill('#898697'), ''),
            Node::circle(292, 221, 4, Paint::fill('#8b5cf6')),
            Node::text('Everyday', 305, 226, 15, Paint::fill('#242335'), ''),
            Node::text('$1,240', 511, 226, 15, Paint::fill('#242335'), ''),
            Node::rect(285, 240, 280, 7, Paint::fill('#f1eef6'), 3),
            Node::rect(285, 240, 224.0, 7, Paint::fill('#8b5cf6'), 3),
            Node::circle(292, 288, 4, Paint::fill('#8bcbb9')),
            Node::text('Experiences', 305, 293, 15, Paint::fill('#242335'), ''),
            Node::text('$960', 511, 293, 15, Paint::fill('#242335'), ''),
            Node::rect(285, 307, 280, 7, Paint::fill('#f1eef6'), 3),
            Node::rect(285, 307, 173.6, 7, Paint::fill('#8bcbb9'), 3),
            Node::circle(292, 355, 4, Paint::fill('#f1b878')),
            Node::text('For the future', 305, 360, 15, Paint::fill('#242335'), ''),
            Node::text('$640', 511, 360, 15, Paint::fill('#242335'), ''),
            Node::rect(285, 374, 280, 7, Paint::fill('#f1eef6'), 3),
            Node::rect(285, 374, 117.6, 7, Paint::fill('#f1b878'), 3)
        );
    }

    private static function delivery(): Scene
    {
        return Scene::make(600, 440)->background('#ffffff')->add(
            Node::rect(0, 0, 600, 440, Paint::fill('#eff4ec'), 0),
            Node::path('M220 0L280 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M303 0L363 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M386 0L446 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M469 0L529 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M552 0L612 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M635 0L695 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M718 0L778 440', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M245 20L600 -20', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M245 100L600 60', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M245 180L600 140', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M245 260L600 220', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M245 340L600 300', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M245 420L600 380', Paint::stroke('#ffffff', 13)->cap('round')->join('round')),
            Node::path('M560 -20 Q460 160 565 260 T590 460', Paint::stroke('#c9e4da', 39)->cap('round')->join('round')),
            Node::path('M330 344L418 332L401 210L512 198', Paint::stroke('#d2c2f4', 13)->cap('round')->join('round')),
            Node::path('M330 344L418 332L401 210L512 198', Paint::stroke('#8b5cf6', 5)->cap('round')->join('round'))->trim(0, 1)->animate('trimEnd', Animation::between(0.08, 1, 2.7, 'easeInOut', 'once')),
            Node::circle(512, 198, 16, Paint::fill('#8b5cf6')),
            Node::path('M505 200v-7l7 -5 7 5v7h-14z', Paint::stroke('#ffffff', 2)->cap('round')->join('round')),
            Node::circle(330, 344, 14, Paint::fill('#ffffff')),
            Node::circle(330, 344, 7, Paint::fill('#219d83')),
            Node::rect(23, 23, 255, 394, Paint::fill('#ffffff'), 22),
            Node::text('ORDER #1024', 44, 58, 11, Paint::fill('#898697'), ''),
            Node::text('Almost there.', 44, 95, 29, Paint::fill('#242335'), ''),
            Node::text('Arrives in 8 min', 44, 126, 18, Paint::fill('#219d83'), ''),
            Node::path('M51 170V324', Paint::stroke('#dcd4ef', 3)->cap('round')->join('round')),
            Node::circle(51, 171, 9, Paint::fill('#8b5cf6')),
            Node::path('M45 171l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::text('Order confirmed', 74, 176, 17, Paint::fill('#242335'), ''),
            Node::text('Your favorites, on the way.', 74, 198, 10, Paint::fill('#898697'), ''),
            Node::circle(51, 246, 9, Paint::fill('#8b5cf6')),
            Node::path('M45 246l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::text('Picked up', 74, 251, 17, Paint::fill('#242335'), ''),
            Node::text('Fresh from the kitchen.', 74, 273, 10, Paint::fill('#898697'), ''),
            Node::circle(51, 321, 9, Paint::fill('#219d83')),
            Node::path('M45 321l5 5 10 -11', Paint::stroke('#ffffff', 2.5)->cap('round')->join('round')),
            Node::text('Out for delivery', 74, 326, 17, Paint::fill('#242335'), ''),
            Node::text('Alex is nearby.', 74, 348, 10, Paint::fill('#898697'), ''),
            Node::rect(41, 364, 218, 33, Paint::fill('#f2edfc'), 16),
            Node::text('Track your delivery', 82, 386, 14, Paint::fill('#8b5cf6'), '')
        );
    }

    private static function sphere(): Scene
    {
        return Scene::make(360, 300)->background('#fafafa')->add(
            Node::circle(180, 150, 116, Paint::fill('#000000')->radialGradient(148, 110, 145, ['#ffffff', '#a899ff', '#222d47'], null, 'clamp'))
        );
    }

    private static function shader(): Scene
    {
        return Scene::make(360, 300)->background('#fafafa')->add(
            Node::rect(0, 0, 360, 300, Paint::fill('#000000')->runtimeShader('uniform float time;
uniform float energy;
uniform float palette;
half4 main(float2 pos) {
    float2 p = (pos - float2(180, 150)) / 130.0;
    float t = time * 0.35;
    float a = atan(p.y, p.x);
    float radius = 0.91 + 0.05 * sin(a * 3.0 + t) + 0.035 * sin(a * 5.0 - t * 1.3);
    float r = length(p) / radius;
    float3 bg = float3(0.980392, 0.980392, 0.980392);

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
}', ['energy' => [0.45], 'palette' => [0]], 'time'), 0)
        );
    }

    private static function mesh(): Scene
    {
        return Scene::make(360, 300)->background('#fafafa')->add(
            Node::mesh([[180, 150], [305.0, 150.0], [288.25317547305485, 212.5], [242.5, 258.25317547305485], [180.0, 275.0], [117.50000000000003, 258.25317547305485], [71.74682452694516, 212.5], [55.0, 150.00000000000003], [71.74682452694515, 87.50000000000003], [117.49999999999994, 41.746824526945204], [179.99999999999997, 25.0], [242.5, 41.746824526945176], [288.2531754730548, 87.49999999999994], [305.0, 149.99999999999997]], ['#f6f7fc', '#a8ffe1', '#777aff', '#ff78c8', '#ffc18e', '#a8ffe1', '#777aff', '#ff78c8', '#ffc18e', '#a8ffe1', '#777aff', '#ff78c8', '#ffc18e', '#a8ffe1'], [0, 1, 2, 0, 2, 3, 0, 3, 4, 0, 4, 5, 0, 5, 6, 0, 6, 7, 0, 7, 8, 0, 8, 9, 0, 9, 10, 0, 10, 11, 0, 11, 12, 0, 12, 13], [], Paint::fill('#ffffff'), 'triangles')
        );
    }

    private static function lottie(): Scene
    {
        return Scene::make(360, 300)->background('#fafafa')->add(
            Node::lottie('{"v":"5.7.4","fr":60,"ip":0,"op":180,"w":300,"h":270,"nm":"Skia motion identity","ddd":0,"assets":[],"layers":[{"ddd":0,"ind":1,"ty":4,"nm":"Orbit 1","ip":0,"op":180,"st":0,"sr":1,"ks":{"o":{"a":0,"k":100},"p":{"a":0,"k":[150,135,0]},"a":{"a":0,"k":[0,0,0]},"s":{"a":0,"k":[100,100,100]},"r":{"a":1,"k":[{"t":0,"s":[0],"e":[360],"o":{"x":0.333,"y":0.333},"i":{"x":0.667,"y":0.667}},{"t":180,"s":[360]}]}},"shapes":[{"ty":"el","p":{"a":0,"k":[55,0]},"s":{"a":0,"k":[68,68]},"d":1},{"ty":"fl","c":{"a":0,"k":[0.6588235294117647,0.6,1,1]},"o":{"a":0,"k":82},"r":1}]},{"ddd":0,"ind":2,"ty":4,"nm":"Orbit 2","ip":0,"op":180,"st":0,"sr":1,"ks":{"o":{"a":0,"k":100},"p":{"a":0,"k":[150,135,0]},"a":{"a":0,"k":[0,0,0]},"s":{"a":0,"k":[100,100,100]},"r":{"a":1,"k":[{"t":0,"s":[60],"e":[420],"o":{"x":0.333,"y":0.333},"i":{"x":0.667,"y":0.667}},{"t":180,"s":[420]}]}},"shapes":[{"ty":"el","p":{"a":0,"k":[55,0]},"s":{"a":0,"k":[68,68]},"d":1},{"ty":"fl","c":{"a":0,"k":[0.5137254901960784,0.8862745098039215,0.7450980392156863,1]},"o":{"a":0,"k":82},"r":1}]},{"ddd":0,"ind":3,"ty":4,"nm":"Orbit 3","ip":0,"op":180,"st":0,"sr":1,"ks":{"o":{"a":0,"k":100},"p":{"a":0,"k":[150,135,0]},"a":{"a":0,"k":[0,0,0]},"s":{"a":0,"k":[100,100,100]},"r":{"a":1,"k":[{"t":0,"s":[120],"e":[480],"o":{"x":0.333,"y":0.333},"i":{"x":0.667,"y":0.667}},{"t":180,"s":[480]}]}},"shapes":[{"ty":"el","p":{"a":0,"k":[55,0]},"s":{"a":0,"k":[68,68]},"d":1},{"ty":"fl","c":{"a":0,"k":[0.9490196078431372,0.7490196078431373,0.5372549019607843,1]},"o":{"a":0,"k":82},"r":1}]},{"ddd":0,"ind":4,"ty":4,"nm":"Orbit 4","ip":0,"op":180,"st":0,"sr":1,"ks":{"o":{"a":0,"k":100},"p":{"a":0,"k":[150,135,0]},"a":{"a":0,"k":[0,0,0]},"s":{"a":0,"k":[100,100,100]},"r":{"a":1,"k":[{"t":0,"s":[180],"e":[540],"o":{"x":0.333,"y":0.333},"i":{"x":0.667,"y":0.667}},{"t":180,"s":[540]}]}},"shapes":[{"ty":"el","p":{"a":0,"k":[55,0]},"s":{"a":0,"k":[68,68]},"d":1},{"ty":"fl","c":{"a":0,"k":[0.9490196078431372,0.9568627450980393,1,1]},"o":{"a":0,"k":82},"r":1}]},{"ddd":0,"ind":5,"ty":4,"nm":"Orbit 5","ip":0,"op":180,"st":0,"sr":1,"ks":{"o":{"a":0,"k":100},"p":{"a":0,"k":[150,135,0]},"a":{"a":0,"k":[0,0,0]},"s":{"a":0,"k":[100,100,100]},"r":{"a":1,"k":[{"t":0,"s":[240],"e":[600],"o":{"x":0.333,"y":0.333},"i":{"x":0.667,"y":0.667}},{"t":180,"s":[600]}]}},"shapes":[{"ty":"el","p":{"a":0,"k":[55,0]},"s":{"a":0,"k":[68,68]},"d":1},{"ty":"fl","c":{"a":0,"k":[0.6588235294117647,0.6,1,1]},"o":{"a":0,"k":82},"r":1}]},{"ddd":0,"ind":6,"ty":4,"nm":"Orbit 6","ip":0,"op":180,"st":0,"sr":1,"ks":{"o":{"a":0,"k":100},"p":{"a":0,"k":[150,135,0]},"a":{"a":0,"k":[0,0,0]},"s":{"a":0,"k":[100,100,100]},"r":{"a":1,"k":[{"t":0,"s":[300],"e":[660],"o":{"x":0.333,"y":0.333},"i":{"x":0.667,"y":0.667}},{"t":180,"s":[660]}]}},"shapes":[{"ty":"el","p":{"a":0,"k":[55,0]},"s":{"a":0,"k":[68,68]},"d":1},{"ty":"fl","c":{"a":0,"k":[0.5137254901960784,0.8862745098039215,0.7450980392156863,1]},"o":{"a":0,"k":82},"r":1}]}]}', 35, 5, 290, 260, 1.875, 'loop', 0, 'contain')
        );
    }
}
