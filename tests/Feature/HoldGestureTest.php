<?php

use Native\Mobile\Edge\CallbackRegistry;
use Native\Mobile\Edge\Elements\Column;
use Native\Mobile\Edge\Elements\Pressable;
use Native\Mobile\Edge\NativeElementCollector;
use Native\Mobile\Edge\NativeTagPrecompiler;

/**
 * `@hold` / `@release` — the PHP half of the press-and-hold gesture.
 *
 * The half that matters most is the wire contract: the two directives have to
 * compile to `on_hold` / `on_release` props carrying callback ids, because that
 * is all a renderer on any platform is given to work from. The timing is the
 * renderer's (see HoldRamp.swift in the desktop shell), and none of it is
 * testable from here — see `it('reaches 189 ...')` in the Counter test for the
 * closest PHP can get.
 *
 * Lives in the app's suite because `supanative/core`, where all of this is
 * implemented, has no suite of its own yet.
 */

// The precompiler only transforms while a native view is being compiled;
// enable it for the tests that invoke it directly.
beforeEach(fn () => NativeTagPrecompiler::setActive(true));
afterEach(fn () => NativeTagPrecompiler::setActive(false));

it('rewrites @hold and @release to underscored attributes', function () {
    $precompiler = new NativeTagPrecompiler;

    $compiled = $precompiler('<native:pressable @hold="faster" @release="stop"><text>Go</text></native:pressable>');

    expect($compiled)->toContain("'_hold' => 'faster'");
    expect($compiled)->toContain("'_release' => 'stop'");
});

it('does not mistake @hold for a child-component event binding', function () {
    // The catch-all pass turns any REMAINING `@name=` into `_event-name=`, which
    // a plain element then strips off. A directive missing from the known list
    // is therefore not a compile error — it is a handler that silently never
    // fires, which is the failure this asserts against.
    $precompiler = new NativeTagPrecompiler;

    $compiled = $precompiler('<native:pressable @hold="faster" @release="stop" />');

    expect($compiled)->not->toContain('_event-hold');
    expect($compiled)->not->toContain('_event-release');
});

it('keeps handler arguments through the rewrite', function () {
    $precompiler = new NativeTagPrecompiler;

    $compiled = $precompiler('<native:pressable @hold="step(\'up\')" @release="clear" />');

    // The expression is carried through as a literal string for the registry to
    // parse into method + args at render time, quotes escaped for the generated
    // PHP source.
    expect($compiled)->toContain("'_hold' => 'step(\\'up\\')'");
});

it('carries onHold / onRelease as props with registered callback ids', function () {
    $registry = new CallbackRegistry;

    $props = Column::make()
        ->onHold('faster')
        ->onRelease('stop')
        ->getResolvedProps($registry);

    // Both travel in the props dict, like on_press_down / on_press_up, so no
    // `nphp_node_*` signature or binary wire-format change was needed.
    expect($props['on_hold'])->toBeInt()->toBeGreaterThan(0);
    expect($props['on_release'])->toBeInt()->toBeGreaterThan(0);
    expect($props['on_hold'])->not->toBe($props['on_release']);

    expect($registry->resolve($props['on_hold'])['method'])->toBe('faster');
    expect($registry->resolve($props['on_release'])['method'])->toBe('stop');
});

it('registers hold without release, and the other way round', function () {
    $props = Column::make()->onHold('onlyHold')->getResolvedProps(new CallbackRegistry);
    expect($props)->toHaveKey('on_hold')->not->toHaveKey('on_release');

    $props = Column::make()->onRelease('onlyRelease')->getResolvedProps(new CallbackRegistry);
    expect($props)->toHaveKey('on_release')->not->toHaveKey('on_hold');
});

it('omits both props when neither handler is set', function () {
    $props = Column::make()->getResolvedProps(new CallbackRegistry);

    expect($props)->not->toHaveKey('on_hold')->not->toHaveKey('on_release');
});

it('leaves @pressDown / @pressUp working alongside them', function () {
    // The primitives are not replaced by the gesture built on them: an element
    // may carry all four, and each keeps its own callback id.
    $registry = new CallbackRegistry;

    $props = Pressable::make()
        ->onPressDown('down')
        ->onPressUp('up')
        ->onHold('faster')
        ->onRelease('stop')
        ->getResolvedProps($registry);

    expect(array_intersect_key($props, array_flip([
        'on_press_down', 'on_press_up', 'on_hold', 'on_release',
    ])))->toHaveCount(4);

    expect(count(array_unique([
        $props['on_press_down'], $props['on_press_up'], $props['on_hold'], $props['on_release'],
    ])))->toBe(4);
});

it('routes _hold and _release through the collector onto the element', function () {
    $el = Pressable::make();
    NativeElementCollector::setCallbacks(new CallbackRegistry);

    $applyCallbacks = new ReflectionMethod(NativeElementCollector::class, 'applyCallbacks');
    $applyCallbacks->setAccessible(true);
    $applyCallbacks->invoke(null, $el, ['_hold' => 'faster', '_release' => 'stop']);

    $props = $el->getResolvedProps(new CallbackRegistry);

    expect($props)->toHaveKey('on_hold')->toHaveKey('on_release');
});

it('resolves hold and release callback ids from compiled attributes', function () {
    // The streaming path reads them through these two resolvers rather than
    // through the element, so they need their own coverage.
    NativeElementCollector::setCallbacks($registry = new CallbackRegistry);

    $resolve = function (string $method, array $attrs) {
        $reflection = new ReflectionMethod(NativeElementCollector::class, $method);
        $reflection->setAccessible(true);

        return $reflection->invoke(null, $attrs);
    };

    expect($resolve('resolveOnHold', ['_hold' => 'faster']))->toBeGreaterThan(0);
    expect($resolve('resolveOnRelease', ['_release' => 'stop']))->toBeGreaterThan(0);

    // 0 is the "no callback" sentinel on the native side.
    expect($resolve('resolveOnHold', []))->toBe(0);
    expect($resolve('resolveOnRelease', []))->toBe(0);

    expect($registry->resolve($resolve('resolveOnHold', ['_hold' => 'faster']))['method'])->toBe('faster');
});
