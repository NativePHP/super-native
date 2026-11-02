<?php

namespace App\NativeComponents;

use App\Support\Skia\Commercial;
use App\Support\Skia\Gallery;
use App\Support\Skia\Showcase;
use Illuminate\View\View;
use Native\Mobile\Attributes\On;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Share;
use Native\Mobile\Skia\Animation;
use Native\Mobile\Skia\Canvas as SkiaCanvas;
use Native\Mobile\Skia\Events\CanvasAction;
use Native\Mobile\Skia\Events\CanvasFailed;
use Native\Mobile\Skia\Events\CanvasGesture;
use Native\Mobile\Skia\Events\CanvasPointer;
use Native\Mobile\Skia\Events\CanvasTouched;
use Native\Mobile\Skia\Node;
use Native\Mobile\Skia\Paint;
use Native\Mobile\Skia\Snapshot;

class SkiaDemo extends NativeComponent
{
    public bool $showcase = true;

    public bool $commercial = false;

    public int $product = 0;

    public int $replay = 0;

    public string $exportPath = '';

    public int $inkColor = 0;

    public bool $alternateShape = false;

    public int $exhibit = 0;

    public int $chapter = 0;

    public float $intensity = 45;

    public bool $playing = true;

    public string $fit = 'contain';

    public int $palette = 0;

    public float $touchX = 180;

    public float $touchY = 150;

    public int $touches = 0;

    public string $status = 'Choose a chapter and explore.';

    public function mount(?int $chapter = null, float $intensity = 45, int $exhibit = 0, ?int $product = null): void
    {
        if ($product !== null) {
            $this->selectCommercial($product);
        } elseif ($chapter !== null) {
            $this->selectChapter($chapter);
        } else {
            $this->selectExhibit($exhibit);
        }
        $this->intensity = max(0, min(100, $intensity));
    }

    public function navTitle(): string
    {
        return 'Skia Studio';
    }

    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()->backgroundColor('#060911')->textColor('#f4f5fa');
    }

    public function selectExhibit(int $exhibit): void
    {
        if (! isset(Showcase::EXHIBITS[$exhibit])) {
            return;
        }
        $this->commercial = false;
        $this->exhibit = $exhibit;
        $this->showcase = true;
        $this->status = '';
    }

    public function selectCommercial(int $product = 0): void
    {
        if (! isset(Commercial::DEMOS[$product])) {
            return;
        }
        $this->commercial = true;
        $this->showcase = false;
        $this->product = $product;
        $this->replay++;
        $this->exportPath = '';
        $this->status = '';
    }

    public function openCommercial(): void
    {
        $this->selectCommercial($this->product);
    }

    public function nextCommercial(): void
    {
        $this->selectCommercial(($this->product + 1) % count(Commercial::DEMOS));
    }

    public function previousCommercial(): void
    {
        $this->selectCommercial(($this->product + count(Commercial::DEMOS) - 1) % count(Commercial::DEMOS));
    }

    public function replayCommercial(): void
    {
        $this->replay++;
    }

    public function nextExhibit(): void
    {
        $this->selectExhibit(($this->exhibit + 1) % count(Showcase::EXHIBITS));
    }

    public function openShowcase(): void
    {
        $this->selectExhibit($this->exhibit);
    }

    public function openLab(): void
    {
        $this->selectChapter($this->chapter);
    }

    public function selectChapter(int $chapter): void
    {
        if (! isset(Gallery::CHAPTERS[$chapter])) {
            return;
        }
        $this->commercial = false;
        $this->showcase = false;
        $this->chapter = $chapter;
        $this->status = $chapter === 10 ? 'Tap anywhere inside the drawing.' : 'Choose a chapter and explore.';
    }

    public function nextChapter(): void
    {
        $this->selectChapter(($this->chapter + 1) % count(Gallery::CHAPTERS));
    }

    public function previousChapter(): void
    {
        $this->selectChapter(($this->chapter + count(Gallery::CHAPTERS) - 1) % count(Gallery::CHAPTERS));
    }

    public function toggleMotion(): void
    {
        $this->playing = ! $this->playing;
    }

    public function changePalette(): void
    {
        $this->palette = ($this->palette + 1) % 3;
    }

    public function changeFit(): void
    {
        $this->fit = match ($this->fit) {
            'contain' => 'cover', 'cover' => 'fill', default => 'contain'
        };
    }

    #[On(CanvasTouched::class)]
    public function canvasTouched(string $canvasId, float $x, float $y, string $shapeId = ''): void
    {
        if ($canvasId !== 'skia-studio' || ! is_finite($x) || ! is_finite($y)) {
            return;
        }
        $this->touchX = max(0, min(360, $x));
        $this->touchY = max(0, min(300, $y));
        $this->touches++;
        $this->status = $this->chapter === 16 ? ($shapeId !== '' ? 'Selected shape: '.$shapeId : 'Tap the stamp, planet or pass.') : sprintf('Touch %d · x %.1f, y %.1f · received in PHP', $this->touches, $this->touchX, $this->touchY);
    }

    #[On(CanvasGesture::class)]
    public function canvasGesture(string $canvasId, string $gesture, string $phase): void
    {
        if ($canvasId === 'skia-studio' && $phase !== 'start') {
            $this->status = ucfirst($gesture).' '.$phase.' · native shared values preserved';
        }
    }

    public function exportFrame(string $format): void
    {
        if (! in_array($format, ['png', 'jpeg', 'webp', 'pdf'], true)) {
            return;
        }
        try {
            $result = Snapshot::capture('skia-studio', $format);
            $this->exportPath = $result['path'];
            $this->status = strtoupper($format).' saved · 1080 × 900 · '.round($result['bytes'] / 1024).' KB · '.basename($result['path']);
        } catch (\Throwable $error) {
            $this->status = 'Export: '.$error->getMessage();
        }
    }

    public function shareExport(): void
    {
        if ($this->exportPath === '' || ! is_file($this->exportPath)) {
            $this->status = 'Export a canvas first.';

            return;
        }
        Share::file('Made with NativePHP Skia', 'My Skia Studio creation', $this->exportPath);
    }

    private function nativeControl(callable $operation, string $message): void
    {
        try {
            $operation();
            $this->status = $message;
        } catch (\Throwable $error) {
            $this->status = 'Canvas: '.$error->getMessage();
        }
    }

    public function updateShape(): void
    {
        $this->alternateShape = ! $this->alternateShape;
        $node = $this->alternateShape ? Node::rect(120, 80, 120, 120, Paint::fill('#83e2be'), 24) : Node::circle(180, 140, 50, Paint::fill('#a899ff'));
        $this->nativeControl(fn () => SkiaCanvas::update('skia-studio', $node->id('live-shape')->accessible('Live-updated shape')), 'Only the identified shape was replaced.');
    }

    public function springShape(): void
    {
        $this->nativeControl(function (): void {
            $state = SkiaCanvas::state('skia-studio');
            $from = (float) ($state['values']['liveX'] ?? 180);
            SkiaCanvas::update('skia-studio', Node::circle(0, 140, 50, Paint::fill('#a899ff'))->id('live-shape')->bind('x', 'liveX')->accessible('Spring-driven shape'));
            SkiaCanvas::animate('skia-studio', 'liveX', Animation::spring($from, $from > 180 ? 90 : 270));
        }, 'Spring runs entirely on the native clock.');
    }

    public function rotatePoster(): void
    {
        $this->nativeControl(function (): void {
            $state = SkiaCanvas::state('skia-studio');
            SkiaCanvas::values('skia-studio', ['angle' => (float) ($state['values']['angle'] ?? -27) + 15]);
        }, 'Poster rotated 15 degrees.');
    }

    public function resetPoster(): void
    {
        $this->nativeControl(fn () => SkiaCanvas::values('skia-studio', ['x' => 370, 'y' => 211, 'angle' => -27, 'zoom' => 1, 'titleX' => 0, 'titleY' => 0]), 'Poster reset.');
    }

    public function changeInk(): void
    {
        $this->inkColor = ($this->inkColor + 1) % 3;
        $this->nativeControl(fn () => SkiaCanvas::inkStyle('skia-studio', 'ink-surface', ['#5f44b3', '#dd5947', '#3b9a89'][$this->inkColor], 9), 'New strokes use the selected color.');
    }

    public function undoInk(): void
    {
        $this->nativeControl(fn () => SkiaCanvas::undoInk('skia-studio', 'ink-surface'), 'Last stroke removed.');
    }

    public function clearInk(): void
    {
        $this->nativeControl(fn () => SkiaCanvas::clearInk('skia-studio', 'ink-surface'), 'Drawing cleared.');
    }

    public function moveChart(int $direction): void
    {
        $this->nativeControl(function () use ($direction): void {
            $state = SkiaCanvas::state('skia-studio');
            SkiaCanvas::values('skia-studio', ['cursor' => max(32, min(564, (float) ($state['values']['cursor'] ?? 300) + ($direction < 0 ? -35 : 35)))]);
        }, 'Chart selection updated.');
    }

    #[On(CanvasPointer::class)]
    public function canvasPointer(string $canvasId, string $shapeId, string $phase, float $x, float $y, float $pressure = 1): void
    {
        if ($canvasId !== 'skia-studio' || $phase !== 'up') {
            return;
        }
        $this->status = $shapeId === 'chart-cursor' ? sprintf('Selected position %.0f%% across the price history', max(0, min(100, ($x - 32) / 532 * 100))) : $shapeId.' · native interaction complete';
    }

    #[On(CanvasAction::class)]
    public function canvasAction(string $canvasId, string $shapeId, string $action): void
    {
        if ($canvasId !== 'skia-studio') {
            return;
        }
        match ([$shapeId, $action]) {
            ['poster-art', 'rotate'] => $this->rotatePoster(),
            ['poster-art', 'reset'] => $this->resetPoster(),
            ['ink-surface', 'undo'] => $this->undoInk(),
            ['ink-surface', 'clear'] => $this->clearInk(),
            ['chart-cursor', 'earlier'] => $this->moveChart(-1),
            ['chart-cursor', 'later'] => $this->moveChart(1),
            default => $this->status = 'Accessible action: '.$shapeId.' / '.$action,
        };
    }

    #[On(CanvasFailed::class)]
    public function canvasFailed(string $canvasId, string $message): void
    {
        if ($canvasId === 'skia-studio') {
            $this->status = 'Renderer: '.$message;
        }
    }

    public function render(): View
    {
        if ($this->commercial) {
            return view('native.skia-demo', [
                'scene' => Commercial::scene($this->product),
                'current' => Commercial::DEMOS[$this->product],
                'products' => Commercial::DEMOS,
                'chapters' => Gallery::CHAPTERS,
                'exhibits' => Showcase::EXHIBITS,
            ]);
        }

        $chapter = $this->showcase ? Showcase::EXHIBITS[$this->exhibit] : Gallery::CHAPTERS[$this->chapter];
        $scene = $this->showcase ? Showcase::scene($this->exhibit, $this->intensity, $this->palette) : Gallery::scene($this->chapter, $this->intensity, ['#a899ff', '#f29cbb', '#77c8f2'][$this->palette], $this->touchX, $this->touchY, $this->chapter === 14 ? file_get_contents(resource_path('fonts/SpaceGrotesk-Bold.ttf')) : null);

        return view('native.skia-demo', ['scene' => $scene, 'current' => $chapter, 'chapters' => Gallery::CHAPTERS, 'exhibits' => Showcase::EXHIBITS]);
    }
}
