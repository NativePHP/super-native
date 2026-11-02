<?php

use App\NativeComponents\SpatialStudio;
use App\Support\Skia\SpatialGallery;
use Native\Mobile\Testing\Native;

it('opens every spatial example through its separate native route', function (int $demo) {
    $screen = Native::visit('/skia-3d/'.$demo)->assertScreen(SpatialStudio::class)
        ->assertNavTitle('Spatial Studio')->assertSet('demo', $demo)->assertSkiaCanvas('spatial-studio');

    $scene = $screen->skiaScene('spatial-studio');
    expect($scene['nodes'])->not->toBeEmpty();
    expect($scene['values'])->toHaveKeys(['phase', 'pan', 'panY', 'zoom', 'spin']);
    expect(json_encode($screen->tree()))->toContain(SpatialGallery::DEMOS[$demo]['title']);
})->with(range(0, 13));

it('wraps navigation and resets native state when changing or replaying demos', function () {
    Native::test(SpatialStudio::class)->call('previousDemo')->assertSet('demo', 13)
        ->call('nextDemo')->assertSet('demo', 0)->call('selectDemo', 100)->assertSet('demo', 0)
        ->call('selectDemo', 7)->assertSet('pose', 0.0)->call('toggleMotion')->assertSet('playing', false)
        ->call('resetDemo')->assertSet('playing', true)->assertSet('exportPath', '');
});

it('scrubs the native value without rebuilding the canvas and clamps input', function () {
    Native::fakeBridge()->withSkiaControl();
    $screen = Native::test(SpatialStudio::class);
    $key = $screen->instance()->revision;
    $screen->set('pose', 250)->assertSet('pose', 100.0)->assertSet('revision', $key)
        ->assertSkiaControl('spatial-studio', 'values', fn (array $command) => $command['values']['phase'] === 1);
});

it('clears projected ink and exports the mounted canvas state', function () {
    Native::fakeBridge()->withSkiaControl()->withSkiaExport(['success' => true, 'path' => '/tmp/spatial.png', 'bytes' => 200]);
    Native::test(SpatialStudio::class)->call('selectDemo', 9)->call('clearInk')
        ->assertSkiaControl('spatial-studio', 'clearInk', fn (array $command) => $command['id'] === 'signature')
        ->call('exportFrame', 'png')->assertSet('exportPath', '/tmp/spatial.png')->assertSkiaExport('spatial-studio', 'png');
});

it('isolates canvas errors and touch events and reports failed exports', function () {
    Native::fakeBridge()->withSkiaExport(['success' => false, 'error' => 'Disk full']);
    Native::test(SpatialStudio::class)->call('failed', 'other', 'Oops')->assertSet('status', '')
        ->call('touched', 'other', 1, 2, 'card')->assertSet('status', '')
        ->call('touched', 'spatial-studio', 1, 2, 'ticket')->assertSet('status', 'Selected: ticket')
        ->call('exportFrame', 'png')->assertSet('exportPath', '')->assertSet('status', 'Disk full');
});

it('exposes the implemented native source with a usable fallback and rejects unknown demos', function () {
    $scene = SpatialGallery::scene(11)->jsonSerialize();
    expect($scene['values']->phase)->toBe(['initial' => 0.45, 'source' => 'fold.openAmount', 'ease' => 0.8]);
    expect(SpatialGallery::scene(11)->toJson())->toContain('fold.openAmount');
    expect(fn () => SpatialGallery::scene(-1))->toThrow(InvalidArgumentException::class);
});
