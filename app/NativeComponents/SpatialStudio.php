<?php

namespace App\NativeComponents;

use App\Support\Skia\SpatialGallery;
use Illuminate\View\View;
use Native\Mobile\Attributes\On;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Share;
use Native\Mobile\Skia\Canvas;
use Native\Mobile\Skia\Events\CanvasFailed;
use Native\Mobile\Skia\Events\CanvasTouched;
use Native\Mobile\Skia\Snapshot;

class SpatialStudio extends NativeComponent
{
    public int $demo = 0;

    public int $revision = 0;

    public bool $playing = true;

    public float $pose = 35;

    public string $status = '';

    public string $exportPath = '';

    public function mount(int $demo = 0): void
    {
        $this->selectDemo($demo);
    }

    public function navTitle(): string
    {
        return 'Spatial Studio';
    }

    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()->backgroundColor('#f7f8fc')->textColor('#172039');
    }

    public function selectDemo(int $demo): void
    {
        if (! isset(SpatialGallery::DEMOS[$demo])) {
            return;
        }
        $this->demo = $demo;
        $this->revision++;
        $this->playing = true;
        $this->pose = $demo === 7 ? 0 : 35;
        $this->status = '';
        $this->exportPath = '';
    }

    public function nextDemo(): void
    {
        $this->selectDemo(($this->demo + 1) % count(SpatialGallery::DEMOS));
    }

    public function previousDemo(): void
    {
        $this->selectDemo(($this->demo + count(SpatialGallery::DEMOS) - 1) % count(SpatialGallery::DEMOS));
    }

    public function resetDemo(): void
    {
        $this->selectDemo($this->demo);
    }

    public function toggleMotion(): void
    {
        $this->playing = ! $this->playing;
    }

    public function updatedPose(): void
    {
        $this->pose = max(0, min(100, $this->pose));
        $this->control(fn () => Canvas::values('spatial-studio', ['phase' => $this->pose / 100]));
    }

    public function adjustPose(float $delta): void
    {
        $this->control(function () use ($delta): void {
            $state = Canvas::state('spatial-studio');
            $phase = (float) ($state['values']['phase'] ?? 0);
            Canvas::values('spatial-studio', ['phase' => max(0, min(1, $phase + max(-0.1, min(0.1, $delta))))]);
        });
    }

    public function clearInk(): void
    {
        if ($this->demo === 9) {
            $this->control(fn () => Canvas::clearInk('spatial-studio', 'signature'));
        }
    }

    public function exportFrame(string $format): void
    {
        if (! in_array($format, ['png', 'pdf'], true)) {
            return;
        }
        $this->control(function () use ($format): void {
            $result = Snapshot::capture('spatial-studio', $format, 1200, 1320);
            $this->exportPath = $result['path'];
            $this->status = $format === 'pdf' ? 'Saved PDF. Spatial artwork is rasterized inside the PDF.' : 'Saved current frame as PNG.';
        });
    }

    public function shareExport(): void
    {
        if ($this->exportPath !== '') {
            Share::file($this->exportPath);
        }
    }

    #[On(CanvasTouched::class)]
    public function touched(string $canvasId, float $x, float $y, string $shapeId = ''): void
    {
        if ($canvasId === 'spatial-studio' && $shapeId !== '' && $shapeId !== 'native-scrubber') {
            $this->status = 'Selected: '.$shapeId;
        }
    }

    #[On(CanvasFailed::class)]
    public function failed(string $canvasId, string $message): void
    {
        if ($canvasId === 'spatial-studio') {
            $this->status = 'Renderer: '.$message;
        }
    }

    private function control(callable $action): void
    {
        try {
            $this->status = '';
            $action();
        } catch (\RuntimeException $exception) {
            $this->status = $exception->getMessage();
        }
    }

    public function render(): View
    {
        return view('native.spatial-studio', [
            'demos' => SpatialGallery::DEMOS,
            'current' => SpatialGallery::DEMOS[$this->demo],
            'scene' => SpatialGallery::scene($this->demo),
        ]);
    }
}
