<?php

use App\NativeComponents\FacebookProfile;
use Native\Mobile\Testing\Native;

/**
 * Guards the Facebook profile header. The avatar overlaps the cover via
 * stack layering — a negative top margin can't do it (the flex renderers
 * shrink the avatar's flow slot but still draw it full size, so the bio
 * rides up into the avatar). Same renderer convention as
 * TwitterProfileTest: both native stack renderers only bottom/right-anchor
 * an absolute child when that inset is NON-ZERO (`bottom-0` reads as
 * "unset" and pins to the top), and zero opposing insets don't stretch —
 * so the avatar row must anchor from the top with an explicit width.
 */
function facebookProfileHeaderStack(): array
{
    $tree = Native::visit('/facebook/profile/0')->tree();

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
    Native::visit('/facebook/profile/0')
        ->assertScreen(FacebookProfile::class)
        ->assertSee('friends');
});

it('anchors the avatar row from the top with an explicit width', function () {
    $children = facebookProfileHeaderStack()['children'];
    $avatarRow = end($children);

    expect($avatarRow['type'])->toBe('row');

    $layout = $avatarRow['layout'] ?? [];
    expect($layout['position_type'] ?? 0)->toBe(1)
        ->and($layout['width'] ?? null)->toBe('fill')
        // position = [top, right, bottom, left]. A zero bottom inset would
        // silently re-pin the row to the top, so it must anchor via top.
        ->and($layout['position'] ?? null)->toEqual([116, 0, 0, 0]);
});

it('reserves flow space below the cover instead of a negative margin', function () {
    // The cover layer must include the 52pt strut that sizes the stack;
    // without it the bio overlaps the avatar's lower half. flex_grow MUST
    // be 0: the flex measurer sizes any grow child at 0 under the
    // indefinite proposal a stack measures its layers with, collapsing
    // the strut (spacer's default is flex_grow=1).
    $coverLayer = facebookProfileHeaderStack()['children'][0];

    $strut = collect($coverLayer['children'] ?? [])
        ->first(fn (array $node): bool => ($node['type'] ?? '') === 'spacer');

    expect($strut)->not->toBeNull()
        ->and($strut['layout']['height'] ?? null)->toEqual(52)
        ->and($strut['layout']['flex_grow'] ?? 1)->toEqual(0);
});

it('navigates back from the top bar back button', function () {
    Native::visit('/facebook/profile/0')
        ->press('back')
        ->assertWentBack();
});
