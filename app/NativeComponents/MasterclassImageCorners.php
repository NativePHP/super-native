<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * mobile-air #355 — "Android: <native:image> ignores per-corner border
 * radii (containers honour them)".
 *
 * Follow-up to #311. Containers resolve their shape through `nodeShape`,
 * which reads the per-corner `radius_*` props; the image renderer clipped
 * with `RoundedCornerShape(style.borderRadius)` and only ever knew the
 * uniform value. It now clips through the same `nodeShape`, so an image
 * and a column with identical classes produce identical shapes.
 */
class MasterclassImageCorners extends NativeComponent
{
    public string $src = 'https://picsum.photos/seed/nativephp-355/600/300';

    public function navTitle(): string
    {
        return '#355 · Image corners';
    }

    public function render(): View
    {
        return view('native.masterclass.image-corners');
    }
}
