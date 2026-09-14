<?php

use App\NativeComponents\HeroScroll20k;
use Native\Mobile\Testing\Native;

it('publishes a virtual list window, not 20k cells', function () {
    $rowCount = (int) ceil(HeroScroll20k::CELL_COUNT / 5);

    Native::test(HeroScroll20k::class)
        ->assertElement('virtual_list', function (array $node) use ($rowCount) {
            $children = $node['children'] ?? [];

            return ($node['props']['count'] ?? null) === $rowCount
                && ($node['props']['window_from'] ?? null) === 0
                && ($node['props']['window_to'] ?? null) === 79
                && count($children) === 80;
        });
});

it('renders five image cells in the first row', function () {
    Native::test(HeroScroll20k::class)
        ->assertElement('virtual_list', function (array $node) {
            $firstRow = $node['children'][0] ?? [];
            $images = [];
            $walk = function (array $n) use (&$walk, &$images): void {
                if (($n['type'] ?? '') === 'image') {
                    $images[] = $n;
                }
                foreach ($n['children'] ?? [] as $child) {
                    if (is_array($child)) {
                        $walk($child);
                    }
                }
            };
            $walk($firstRow);

            return count($images) === 5;
        });
});

it('ramps the boot window on the second publish', function () {
    Native::test(HeroScroll20k::class)
        ->call('setVirtualWindow', 0, 79)
        ->assertElement('virtual_list', function (array $node) {
            return ($node['props']['window_from'] ?? null) === 0
                && ($node['props']['window_to'] ?? null) === 279
                && count($node['children'] ?? []) === 280;
        });
});

it('re-materializes rows when native reports a window change', function () {
    Native::test(HeroScroll20k::class)
        ->call('setVirtualWindow', 500, 579)
        ->assertElement('virtual_list', function (array $node) {
            return ($node['props']['window_from'] ?? null) === 500
                && ($node['props']['window_to'] ?? null) === 579
                && count($node['children'] ?? []) === 80;
        });
});

it('center-clamps a huge native window request around the midpoint', function () {
    Native::test(HeroScroll20k::class)
        ->call('setVirtualWindow', 1600, 3200)
        ->assertElement('virtual_list', function (array $node) {
            $from = $node['props']['window_from'] ?? null;
            $to = $node['props']['window_to'] ?? null;
            $children = count($node['children'] ?? []);

            // mid = 2400, half = 139 → from = 2261, to = 2540 (span 279)
            return $from === 2261
                && $to === 2540
                && $children === 280;
        });
});
