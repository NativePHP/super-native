<?php

use App\NativeComponents\AccordionDemo;
use Native\Mobile\Testing\Native;

it('renders the three accordion sections', function () {
    Native::test(AccordionDemo::class)
        ->assertElement('accordion')
        ->assertElement('accordion_header')
        ->assertElement('accordion_content')
        ->assertSee('How long does shipping take?')
        ->assertSee('Specifications')
        ->assertSee('Trip to Lisbon');
});

it('reports open state back to php when a header is tapped', function () {
    Native::test(AccordionDemo::class)
        ->assertSet('changeCount', 0)
        ->toggle("setOpen('shipping')", true)
        ->assertSet('changeCount', 1)
        ->assertSet('open', [
            'shipping' => true,
            'returns' => true,
            'warranty' => false,
        ])
        ->toggle("setOpen('returns')", false)
        ->assertSet('changeCount', 2)
        ->assertSet('open', [
            'shipping' => true,
            'returns' => false,
            'warranty' => false,
        ]);
});

it('pushes the expanded prop down to the accordion element', function () {
    // `returns` starts open, `shipping` starts closed — both states must
    // reach the wire tree as `expanded`, since that is the prop the
    // native renderers read.
    Native::test(AccordionDemo::class)
        ->assertElement('accordion', fn ($node) => ($node['props']['expanded'] ?? null) === true)
        ->assertElement('accordion', fn ($node) => ($node['props']['expanded'] ?? null) === false);
});

it('keeps only one controlled section open at a time', function () {
    Native::test(AccordionDemo::class)
        ->assertSet('exclusive', 'specs')
        ->toggle("openOnly('care')", true)
        ->assertSet('exclusive', 'care')
        ->assertSet('allExpanded', false)
        // Tapping the section that is already open collapses the group.
        ->toggle("openOnly('care')", false)
        ->assertSet('exclusive', '');
});

it('clears the open badge when a section is closed after expand all', function () {
    // Regression: `openOnly` used to infer the new state by comparing the
    // tapped id against `$exclusive`. After `expandAll` that is empty, so
    // closing a row was read as opening it — every sibling collapsed but the
    // tapped row kept its "open" badge.
    Native::test(AccordionDemo::class)
        ->call('expandAll')
        ->assertElement('badge')
        ->toggle("openOnly('specs')", false)
        ->assertSet('exclusive', '')
        ->assertSet('allExpanded', false)
        ->assertMissingElement('badge');
});

it('expands and collapses every controlled section', function () {
    $screen = Native::test(AccordionDemo::class)
        ->call('expandAll')
        ->assertSet('allExpanded', true)
        ->assertSet('exclusive', '');

    // Badges only render on controlled rows that are open, so they track
    // `expanded` exactly — and nothing in the FAQ section renders one.
    $screen->assertElement('badge');

    $screen->call('collapseAll')
        ->assertSet('allExpanded', false)
        ->assertSet('exclusive', '')
        ->assertMissingElement('badge');
});
