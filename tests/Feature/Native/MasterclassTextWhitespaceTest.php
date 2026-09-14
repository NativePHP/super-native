<?php

use Native\Mobile\Testing\Native;

/**
 * mobile-air #336, fixed in #425 — the blocks on the demo screen, asserted
 * on the wire tree so the fix is checked without a device.
 */
$message = "First paragraph, written by a user.\n\nSecond paragraph after a blank line.\nThird line, no blank.";
$collapsed = 'First paragraph, written by a user. Second paragraph after a blank line. Third line, no blank.';

it('collapses by default on both paths and keeps line breaks under whitespace-pre-line', function () use ($message, $collapsed) {
    $screen = Native::visit('/masterclass/text-whitespace');
    $texts = fn (string $value) => count(array_filter(
        iterator_to_array(walkTexts($screen->tree()), false),
        fn ($t) => $t === $value,
    ));

    // 1 + 2: slot and :text both collapse by default
    expect($texts($collapsed))->toBe(2);

    // 3 + 4: slot and :text both keep breaks under pre-line
    expect($texts($message))->toBe(2);

    // 5: author-wrapped template text flows by default, breaks under pre-line
    expect($texts('A long sentence that I wrapped over two lines in my editor.'))->toBe(1);
    expect($texts("A long sentence that I wrapped\nover two lines in my editor."))->toBe(1);

    // 6: pre-wrap keeps indentation
    expect($texts("if (\$ready) {\n    launch();\n}"))->toBe(1);

    // 7: a classless nested run inherits the parent's pre-line
    expect($texts("a bold run\non its own line"))->toBe(1);
});

function walkTexts(array $node): Generator
{
    if (($node['type'] ?? null) === 'text' && isset($node['props']['text'])) {
        yield $node['props']['text'];
    }
    foreach ($node['children'] ?? [] as $child) {
        yield from walkTexts($child);
    }
}
