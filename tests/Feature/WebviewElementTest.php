<?php

use Native\Mobile\Edge\CallbackRegistry;
use Native\Mobile\Edge\NativeElementCollector;
use Native\Mobile\Edge\NativeTagPrecompiler;
use Native\Mobile\UI\Elements\Webview;

// The precompiler only transforms while a native view is being compiled;
// enable it for the tests that invoke it directly.
beforeEach(fn () => NativeTagPrecompiler::setActive(true));
afterEach(fn () => NativeTagPrecompiler::setActive(false));

it('exposes webview as a registered native element', function () {
    expect(class_exists(Webview::class))->toBeTrue();
    expect((new Webview)->getType())->toBe('webview');
});

it('captures src, html and opt-in js on a Webview element', function () {
    $el = new Webview;
    $el->applyAttributes([
        'src' => 'https://example.com',
        'html' => '<h1>hi</h1>',
        'javascript' => 'true',
    ]);

    $props = $el->getResolvedProps(new CallbackRegistry);

    expect($props['src'])->toBe('https://example.com');
    expect($props['html'])->toBe('<h1>hi</h1>');
    expect($props['javascript'])->toBeTrue();
});

it('maps php and fullscreen attributes onto webview props', function () {
    $el = new Webview;
    $el->applyAttributes([
        'php' => 'true',
        'fullscreen' => 'true',
    ]);

    $props = $el->getResolvedProps(new CallbackRegistry);

    expect($props['php'])->toBeTrue();
    expect($props['fullscreen'])->toBeTrue();

    // fullscreen implies fill layout so the element claims the whole screen.
    $tree = $el->toArray(new CallbackRegistry);
    expect($tree['layout'])->toMatchArray(['width' => 'fill', 'height' => 'fill']);
});

it('binds @navigated to a PHP method name via the callback registry', function () {
    $el = new Webview;
    $el->onNavigated('urlChanged');

    $registry = new CallbackRegistry;
    $props = $el->getResolvedProps($registry);

    expect($props['on_navigated'])->toBeInt()->toBeGreaterThan(0);
    expect($registry->resolve($props['on_navigated']))->toMatchArray(['method' => 'urlChanged']);
});

it('compiles <native:webview> tags through the precompiler', function () {
    $precompiler = new NativeTagPrecompiler;

    $compiled = $precompiler('<native:webview src="https://example.com" @navigated="urlChanged" />');

    expect($compiled)->toContain("leaf('webview'");
    expect($compiled)->toContain('_navigated');
});

it('captures slot HTML as a raw html prop (no strip_tags)', function () {
    $precompiler = new NativeTagPrecompiler;

    $template = '<native:webview><h1>Hi</h1><p>Hello <em>world</em></p></native:webview>';
    $compiled = $precompiler($template);

    // Opening should start a buffer; closing should drop the captured
    // slot into the attrs without stripping tags.
    expect($compiled)->toContain('ob_start()');
    expect($compiled)->toContain("'html'");
});

it('lets :html attribute take precedence over slot content', function () {
    $precompiler = new NativeTagPrecompiler;
    $template = '<native:webview :html="$x"><h1>fallback</h1></native:webview>';

    $compiled = $precompiler($template);

    expect($compiled)->toContain("'html' => (\$x)");
    expect($compiled)->toContain("!isset(\$__nativeSlotAttrs['html'])");
});

it('routes _navigated through onNavigated() on the Webview element', function () {
    $el = new Webview;
    NativeElementCollector::setCallbacks(new CallbackRegistry);

    // The collector wires _navigated → $element->onNavigated(...) only
    // when the method exists; smoke-test that wiring directly.
    $reflection = new ReflectionMethod(NativeElementCollector::class, 'applyCallbacks');
    $reflection->setAccessible(true);
    $reflection->invoke(null, $el, ['_navigated' => 'urlChanged']);

    $props = $el->getResolvedProps(new CallbackRegistry);
    expect($props)->toHaveKey('on_navigated');
});
