<?php

namespace App\Support;

use App\Icons\Android;
use App\Icons\Ios;

/**
 * Fixtures for the shared-element (`ref`) demos under `/hero`.
 *
 * Kept in one place because every demo screen exists as a PAIR — a list and a
 * detail — and a morph only happens when both sides agree on the element's
 * identity. Letting the two screens build their own copies of this data is
 * exactly how a demo ends up silently not morphing.
 */
class HeroDemoData
{
    /**
     * Tiles for the canonical grid → detail morph.
     *
     * Deliberately drawn with native shapes (a tinted block + an icon) rather
     * than remote images. On a slow connection a downloaded image arrives
     * AFTER the transition has already run, so the element you are trying to
     * watch morph is an empty box for the whole animation — which hides the
     * exact thing this demo exists to show. Shapes are on screen from the
     * first frame and need no network at all.
     */
    public static function photos(): array
    {
        return [
            ['id' => 1, 'title' => 'Cliff Path', 'place' => 'Cinque Terre', 'tint' => '#0EA5E9', 'ios' => Ios::Mountain2Fill, 'android' => Android::Landscape],
            ['id' => 2, 'title' => 'Dune Ridge', 'place' => 'Erg Chebbi', 'tint' => '#F59E0B', 'ios' => Ios::SunMaxFill, 'android' => Android::WbSunny],
            ['id' => 3, 'title' => 'Pine Hollow', 'place' => 'Cascade Range', 'tint' => '#10B981', 'ios' => Ios::LeafFill, 'android' => Android::Eco],
            ['id' => 4, 'title' => 'Slate Harbour', 'place' => 'Lofoten', 'tint' => '#6366F1', 'ios' => Ios::DropFill, 'android' => Android::WaterDrop],
            ['id' => 5, 'title' => 'Salt Flat', 'place' => 'Uyuni', 'tint' => '#EC4899', 'ios' => Ios::Snowflake, 'android' => Android::AcUnit],
            ['id' => 6, 'title' => 'Iron Coast', 'place' => 'Donegal', 'tint' => '#14B8A6', 'ios' => Ios::CloudFill, 'android' => Android::Cloud],
        ];
    }

    public static function photo(int $id): array
    {
        return collect(static::photos())->firstWhere('id', $id)
            ?? static::photos()[0];
    }

    /**
     * Cards for the "expands into a page" demo. The two ends deliberately
     * show DIFFERENT content — a one-line summary vs. full body copy — which
     * is the case a naive shared-element implementation tears on.
     */
    public static function cards(): array
    {
        return [
            [
                'id' => 1,
                'tint' => '#6366F1',
                'ios' => Ios::BoltFill, 'android' => Android::Bolt,
                'kicker' => 'Performance',
                'title' => 'Trees publish in one pass',
                'summary' => 'Why the renderer stopped re-walking children.',
                'body' => 'The collector used to rebuild every child on each publish, so a '
                    .'list of fifty rows re-serialised fifty subtrees to say one label changed. '
                    .'Nodes now carry a stable identity, the diff hands back the previous '
                    .'reference when a subtree is untouched, and the renderer skips it entirely.',
            ],
            [
                'id' => 2,
                'tint' => '#F59E0B',
                'ios' => Ios::SquareStack3dUpFill, 'android' => Android::Layers,
                'kicker' => 'Layout',
                'title' => 'Flex direction reaches the layout',
                'summary' => 'The fix that made flex-row and flex-col real.',
                'body' => 'Direction was parsed correctly and then dropped before it reached '
                    .'the layout pass, so every container laid out as a column no matter what '
                    .'the class said. Forwarding one field turned both utilities on at once.',
            ],
            [
                'id' => 3,
                'tint' => '#10B981',
                'ios' => Ios::ArrowTriangle2Circlepath, 'android' => Android::Sync,
                'kicker' => 'Navigation',
                'title' => 'Screens swap in two layers',
                'summary' => 'Holding the old screen instead of removing it.',
                'body' => 'SwiftUI animates insertions reliably and removals barely at all. '
                    .'So the outgoing screen is never removed at swap time — it is held '
                    .'beneath the incoming one, driven by ordinary animated modifiers, and '
                    .'dropped a beat later underneath an already-opaque replacement.',
            ],
        ];
    }

    public static function card(int $id): array
    {
        return collect(static::cards())->firstWhere('id', $id) ?? static::cards()[0];
    }

    /**
     * Tracks for the mini-player → full-player demo. The mini bar and the
     * full player share `player-art`, `player-title` and `player-surface`,
     * which travel very different distances in the same navigation — the art
     * crosses and quadruples, the surface grows from a 64pt bar to the whole
     * screen.
     */
    public static function tracks(): array
    {
        return [
            ['id' => 1, 'title' => 'Ultraviolet', 'artist' => 'Kite Parade', 'tint' => '#7C3AED', 'ios' => Ios::Waveform, 'android' => Android::GraphicEq, 'len' => '3:42'],
            ['id' => 2, 'title' => 'Salt and Static', 'artist' => 'Moss Harbour', 'tint' => '#0891B2', 'ios' => Ios::AntennaRadiowavesLeftAndRight, 'android' => Android::SettingsInputAntenna, 'len' => '4:15'],
            ['id' => 3, 'title' => 'Paper Cities', 'artist' => 'Nils Ardent', 'tint' => '#DB2777', 'ios' => Ios::Building2Fill, 'android' => Android::Apartment, 'len' => '2:58'],
            ['id' => 4, 'title' => 'Low Tide Radio', 'artist' => 'The Quiet Sum', 'tint' => '#EA580C', 'ios' => Ios::DotRadiowavesLeftAndRight, 'android' => Android::Podcasts, 'len' => '5:07'],
        ];
    }

    public static function track(int $id): array
    {
        return collect(static::tracks())->firstWhere('id', $id) ?? static::tracks()[0];
    }

    /**
     * Rows for the deep-scroll demo. Long enough that the tapped row is at an
     * arbitrary scroll offset, which is the whole point: the morph reads the
     * element's LIVE frame rather than assuming where it sits.
     */
    public static function deepRows(): array
    {
        $tints = ['#6366F1', '#0EA5E9', '#10B981', '#F59E0B', '#EC4899', '#14B8A6'];
        $rows = [];
        for ($i = 1; $i <= 40; $i++) {
            $rows[] = [
                'id' => $i,
                'label' => 'Row '.$i,
                'tint' => $tints[($i - 1) % count($tints)],
            ];
        }

        return $rows;
    }

    public static function deepRow(int $id): array
    {
        return collect(static::deepRows())->firstWhere('id', $id) ?? static::deepRows()[0];
    }

    /** People for the multi-element morph (avatar AND name travel together). */
    public static function people(): array
    {
        return [
            ['id' => 1, 'name' => 'Ada Speight',   'role' => 'Runtime',      'tint' => '#6366F1', 'initials' => 'AS'],
            ['id' => 2, 'name' => 'Bo Karlsen',    'role' => 'Rendering',    'tint' => '#EC4899', 'initials' => 'BK'],
            ['id' => 3, 'name' => 'Cleo Marchand', 'role' => 'Layout',       'tint' => '#14B8A6', 'initials' => 'CM'],
            ['id' => 4, 'name' => 'Dev Anand',     'role' => 'Native bridge', 'tint' => '#F59E0B', 'initials' => 'DA'],
        ];
    }

    public static function person(int $id): array
    {
        return collect(static::people())->firstWhere('id', $id) ?? static::people()[0];
    }
}
