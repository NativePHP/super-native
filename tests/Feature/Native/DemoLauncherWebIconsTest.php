<?php

use Native\Mobile\Edge\Web\Renderer\WebRenderer;
use Native\Mobile\Testing\Native;

/**
 * The launcher labels every demo with an SF Symbol name, which the web
 * renderer translates to a Material Symbols ligature. Two ways that goes
 * wrong and neither throws:
 *
 *   - a dotted name with no mapping falls back to the neutral `circle`,
 *     so the row renders a blank puck instead of its icon;
 *   - a dotless name with no mapping reaches the font as a raw ligature
 *     and renders as literal text ("sparkles").
 *
 * Both look like a broken page, so assert every launcher icon lands on a
 * real translation.
 */
function launcherIconNames(): array
{
    $groups = Native::visit('/')->get('groups');

    $icons = collect($groups)
        ->flatMap(fn (array $group) => array_column($group['demos'], 'icon'))
        ->unique()
        ->values()
        ->all();

    expect($icons)->not->toBeEmpty();

    return $icons;
}

function materialNameFor(string $icon): string
{
    $translate = new ReflectionMethod(WebRenderer::class, 'materialName');

    return $translate->invoke(null, $icon);
}

it('translates every launcher icon to a Material Symbols glyph', function () {
    $unmapped = array_values(array_filter(
        launcherIconNames(),
        fn (string $icon) => materialNameFor($icon) === 'circle',
    ));

    expect($unmapped)->toBe([], 'These SF names have no SF_TO_MATERIAL entry and render as a blank circle: '.implode(', ', $unmapped));
});

it('never leaves a dotless icon name to reach the font as raw text', function () {
    $map = (new ReflectionClass(WebRenderer::class))->getConstant('SF_TO_MATERIAL');

    $passthrough = array_values(array_filter(
        launcherIconNames(),
        fn (string $icon) => ! str_contains($icon, '.') && ! isset($map[strtolower($icon)]),
    ));

    // `add` and `keyboard` are Material names already, so passing through is
    // correct for them — anything else is an SF name the map has missed.
    expect(array_diff($passthrough, ['add', 'keyboard']))->toBe([]);
});
