<?php

use Native\Mobile\Testing\Native;

/**
 * Guards the /stack-positioning demo screen — the testbed for the stack
 * z-overlay + two-point anchor/origin work.
 *
 * These assert the PHP half only (what the resolver puts on the wire).
 * Whether the native renderers honour it is a device check.
 */

/** Flatten the published tree into a list of nodes. */
function flattenNodes(array $node, array &$out = []): array
{
    $out[] = $node;

    foreach ($node['children'] ?? [] as $child) {
        flattenNodes($child, $out);
    }

    return $out;
}

function demoNodes(): array
{
    $tree = Native::visit('/stack-positioning')->tree();

    return flattenNodes($tree);
}

it('renders the demo screen', function () {
    Native::visit('/stack-positioning')
        ->assertSee('Stack & Positioning')
        ->assertElement('stack');
});

it('never leaks anchor or origin into the layout struct', function () {
    // The layout struct is packed by the C extension, which drops unknown
    // keys — anchor/origin must ride the tolerant props blob instead.
    foreach (demoNodes() as $node) {
        expect($node['layout'] ?? [])->not->toHaveKey('anchor');
        expect($node['layout'] ?? [])->not->toHaveKey('origin');
    }
});
