<?php

use App\NativeComponents\TwitterProfile;
use Native\Mobile\Testing\Native;

/**
 * Guards the Twitter profile header stack. Both native stack renderers
 * only bottom/right-anchor an absolute child when that inset is NON-ZERO
 * (`bottom-0` reads as "unset" and pins to the top), and zero opposing
 * insets don't stretch — so the avatar row must anchor from the top with
 * an explicit width, and the floating back button must be the stack's
 * LAST child to draw above the banner and avatar layers.
 */
function twitterProfileHeaderStack(): array
{
    $tree = Native::visit('/twitter/profile/0')->tree();

    $stack = null;
    $walk = function (array $node) use (&$walk, &$stack): void {
        if ($stack === null && ($node['type'] ?? '') === 'stack') {
            $stack = $node;
        }
        foreach ($node['children'] ?? [] as $child) {
            $walk($child);
        }
    };
    $walk($tree);

    expect($stack)->not->toBeNull();

    return $stack;
}

it('renders the profile screen', function () {
    Native::visit('/twitter/profile/0')
        ->assertScreen(TwitterProfile::class)
        ->assertSee('Follow');
});

it('anchors the avatar row from the top with an explicit width', function () {
    $children = twitterProfileHeaderStack()['children'];
    $avatarRow = $children[1];

    expect($avatarRow['type'])->toBe('row');

    $layout = $avatarRow['layout'] ?? [];
    expect($layout['position_type'] ?? 0)->toBe(1)
        ->and($layout['width'] ?? null)->toBe('fill')
        // position = [top, right, bottom, left]. A zero bottom inset would
        // silently re-pin the row to the top, so it must anchor via top.
        ->and($layout['position'] ?? null)->toEqual([112, 0, 0, 0]);
});

it('reserves flow space below the banner with a non-grow strut', function () {
    // The banner layer's 44pt strut sizes the stack. flex_grow MUST be 0:
    // the flex measurer sizes any grow child at 0 under the indefinite
    // proposal a stack measures its layers with, collapsing the strut
    // (spacer's default is flex_grow=1) — content below then rides up
    // into the avatar row.
    $bannerLayer = twitterProfileHeaderStack()['children'][0];

    $strut = collect($bannerLayer['children'] ?? [])
        ->first(fn (array $node): bool => ($node['type'] ?? '') === 'spacer');

    expect($strut)->not->toBeNull()
        ->and($strut['layout']['height'] ?? null)->toEqual(44)
        ->and($strut['layout']['flex_grow'] ?? 1)->toEqual(0);
});

it('floats the back button as the topmost stack layer', function () {
    $children = twitterProfileHeaderStack()['children'];
    $backButton = end($children);

    $layout = $backButton['layout'] ?? [];
    expect($backButton['props']['a11y_label'] ?? '')->toBe('Back')
        ->and($layout['position_type'] ?? 0)->toBe(1)
        // position = [top, right, bottom, left].
        ->and($layout['position'] ?? null)->toEqual([12, 0, 0, 12]);
});

it('navigates back from the floating back button', function () {
    Native::visit('/twitter/profile/0')
        ->press('back')
        ->assertWentBack();
});
