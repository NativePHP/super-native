<?php

use App\NativeComponents\WebviewDemo;
use Native\Mobile\Testing\Native;

it('starts in remote mode', function () {
    Native::test(WebviewDemo::class)->assertSet('mode', 'remote');
});

it('renders the enriched php webview in php mode', function () {
    $screen = Native::test(WebviewDemo::class)->call('showPhp');

    $tree = json_encode($screen->tree());

    expect($tree)->toContain('"php":true')
        ->toContain('/webview-embedded');
});

it('renders a fullscreen webview in fullscreen mode', function () {
    $screen = Native::test(WebviewDemo::class)->call('showFullscreen');

    expect(json_encode($screen->tree()))->toContain('"fullscreen":true');
});

it('serves the embedded page with a session visit counter', function () {
    $this->get('/webview-embedded')
        ->assertOk()
        ->assertSee('Embedded PHP runtime')
        ->assertSee('Session visits: <strong>1</strong>', escape: false);

    // The counter is session-backed, so a second request in the same
    // test session increments it.
    $this->get('/webview-embedded')
        ->assertSee('Session visits: <strong>2</strong>', escape: false);
});
