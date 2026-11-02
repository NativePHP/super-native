<?php

use App\NativeComponents\SkiaDemo;
use App\Support\Skia\Commercial;
use App\Support\Skia\Gallery;
use Native\Mobile\Testing\Native;

it('opens the registered Skia studio with a native canvas', function () {
    $screen = Native::visit('/skia')->assertScreen(SkiaDemo::class)->assertNavTitle('Skia Studio');

    expect(json_encode($screen->tree()))->toContain('skia_canvas')->toContain('POLAR')->toContain('timeUniform');
});

it('renders every chapter through the real Blade collector', function (int $chapter) {
    $screen = Native::test(SkiaDemo::class)->call('selectChapter', $chapter);

    expect(json_encode($screen->tree()))->toContain('skia_canvas')->toContain(Gallery::CHAPTERS[$chapter]['title']);
})->with(range(0, count(Gallery::CHAPTERS) - 1));

it('wraps chapter navigation and ignores invalid selections', function () {
    Native::test(SkiaDemo::class)->call('previousChapter')->assertSet('chapter', count(Gallery::CHAPTERS) - 1)
        ->call('nextChapter')->assertSet('chapter', 0)->call('selectChapter', 99)->assertSet('chapter', 0);
});

it('updates only its own touch marker and clamps drawing coordinates', function () {
    Native::test(SkiaDemo::class)->call('canvasTouched', 'other', 2, 3)->assertSet('touches', 0)
        ->call('canvasTouched', 'skia-studio', 120, 75)->assertSet('touchX', 120.0)->assertSet('touchY', 75.0)->assertSet('touches', 1)
        ->call('canvasTouched', 'skia-studio', 500, -10)->assertSet('touchX', 360.0)->assertSet('touchY', 0.0);
});

it('changes motion playback and cycles the canvas fit modes', function () {
    Native::test(SkiaDemo::class)->call('selectChapter', 9)->call('toggleMotion')->assertSet('playing', false)
        ->call('changeFit')->assertSet('fit', 'cover')->call('changeFit')->assertSet('fit', 'fill')->call('changeFit')->assertSet('fit', 'contain');
});

it('opens the density stress case with a bounded native payload', function () {
    $screen = Native::visit('/skia/11/100')->assertSet('chapter', 11)->assertSet('intensity', 100.0);
    $json = json_encode($screen->tree());
    expect($json)->toContain('scene_path')->not->toContain('1000 shapes');
});

it('switches between all four artworks and the feature lab', function (int $exhibit) {
    $screen = Native::visit('/skia-showcase/'.$exhibit)->assertSet('showcase', true)->assertSet('exhibit', $exhibit);
    expect(json_encode($screen->tree()))->toContain('skia_canvas');
    $screen->call('openLab')->assertSet('showcase', false)->call('openShowcase')->assertSet('showcase', true)->assertSet('exhibit', $exhibit);
})->with(range(0, 3));

it('wraps the showcase without losing playback or palette', function () {
    Native::test(SkiaDemo::class)->call('selectExhibit', 3)->call('toggleMotion')->call('changePalette')
        ->call('nextExhibit')->assertSet('exhibit', 0)->assertSet('playing', false)->assertSet('palette', 1)
        ->call('selectExhibit', 99)->assertSet('exhibit', 0);
});

it('shows all thirty-one chapters and exposes the new native capabilities', function () {
    expect(Gallery::CHAPTERS)->toHaveCount(31);
    $screen = Native::test(SkiaDemo::class)->call('openLab');
    expect(json_encode($screen->tree()))->toContain('Lottie')->toContain('Typography')->toContain('Gestures')->toContain('Export');
    $screen->call('selectChapter', 15);
    expect(json_encode($screen->tree()))->toContain('bindings')->toContain('pulse');
    $screen->call('selectChapter', 16)->call('canvasTouched', 'skia-studio', 180, 150, 'stamp')->assertSet('status', 'Selected shape: stamp');
    $screen->call('selectChapter', 17);
    expect(json_encode($screen->tree()))->toContain('PNG')->toContain('JPEG')->toContain('WEBP')->toContain('PDF');
});

it('exposes practical demo controls and isolates canvas events', function () {
    $screen = Native::test(SkiaDemo::class)->call('selectChapter', 27);
    expect(json_encode($screen->tree()))->toContain('Reset poster')->toContain('Rotate 15');
    $screen->call('selectChapter', 29);
    expect(json_encode($screen->tree()))->toContain('Ink color')->toContain('Undo')->toContain('Clear');
    $screen->call('canvasAction', 'other', 'button', 'activate')->assertSet('status', 'Choose a chapter and explore.');
    $screen->call('canvasAction', 'skia-studio', 'accessible-button', 'activate')->assertSet('status', 'Accessible action: accessible-button / activate');
});

it('explains how to share when there is no export yet', function () {
    Native::test(SkiaDemo::class)->call('shareExport')->assertSet('status', 'Export a canvas first.');
});

it('opens every commercial composition as a native canvas', function (int $product) {
    $screen = Native::visit('/skia-commercial/'.$product)
        ->assertSet('commercial', true)
        ->assertSet('product', $product)
        ->assertSee(Commercial::DEMOS[$product]['title'])
        ->assertSee('Replay');

    expect(json_encode($screen->tree()))->toContain('skia_canvas')->not->toContain('Renderer:');
})->with(range(0, 17));

it('replays and wraps the commercial gallery while retaining the lab and showcase', function () {
    $screen = Native::visit('/skia-commercial/0')->assertSet('replay', 1);

    $screen->call('replayCommercial')->assertSet('replay', 2)
        ->call('previousCommercial')->assertSet('product', 17)
        ->call('nextCommercial')->assertSet('product', 0)
        ->call('selectCommercial', 999)->assertSet('product', 0)
        ->call('openLab')->assertSet('commercial', false)->assertSet('showcase', false)
        ->call('openCommercial')->assertSet('commercial', true)
        ->call('openShowcase')->assertSet('commercial', false)->assertSet('showcase', true);
});

it('covers all supported drawing families in the app gallery', function () {
    $types = [];
    foreach (Gallery::CHAPTERS as $index => $_) {
        $scene = json_decode(Gallery::scene($index)->toJson(), true, flags: JSON_THROW_ON_ERROR);
        foreach ($scene['nodes'] as $node) {
            $types[$node['type']] = true;
        }
    }
    foreach (['rect', 'circle', 'oval', 'line', 'path', 'text', 'paragraph', 'image', 'group'] as $type) {
        expect($types)->toHaveKey($type);
    }
});

it('exercises media and uniform bindings in the app gallery', function () {
    expect(Gallery::CHAPTERS)->toHaveCount(31);
    expect(Gallery::scene(12)->toJson())->toContain('"type":"svg"');
    expect(Gallery::scene(13)->toJson())->toContain('"type":"lottie"');
    expect(Gallery::scene(15)->toJson())->toContain('"bindings":{"pulse":"pulse"}');
    expect(Gallery::scene(16)->toJson())->toContain('"gestures":{"panX":"passX"');
});

it('uses the plugin scene and native event testing macros', function () {
    Native::visit('/skia/16')
        ->assertSkiaCanvas('skia-studio')
        ->assertSkiaNode('skia-studio', 'planet')
        ->touchSkia('skia-studio', 180, 150, 'stamp')
        ->assertSet('status', 'Selected shape: stamp')
        ->gestureSkia('skia-studio', 'pinch', 'end')
        ->assertSet('status', 'Pinch end · native shared values preserved')
        ->failSkia('skia-studio', 'Test shader error')
        ->assertSet('status', 'Renderer: Test shader error');
});

it('tests live canvas controls and exports using the plugin bridge macros', function () {
    Native::fakeBridge()->withSkiaControl()->withSkiaExport([
        'success' => true, 'path' => '/virtual/skia.png', 'bytes' => 1024,
    ]);

    Native::visit('/skia/27')
        ->actionSkia('skia-studio', 'poster-art', 'reset')
        ->assertSkiaControl('skia-studio', 'values', fn (array $command) => $command['values']['angle'] === -27)
        ->call('exportFrame', 'png')
        ->assertSkiaExport('skia-studio', 'png')
        ->assertSet('exportPath', '/virtual/skia.png');
});

it('surfaces scripted Skia export failures to the user', function () {
    Native::fakeBridge()->withSkiaExport(['success' => false, 'error' => 'Disk full']);

    Native::visit('/skia/17')->call('exportFrame', 'png')
        ->assertSkiaExport('skia-studio', 'png')
        ->assertSet('status', 'Export: Disk full');
});
