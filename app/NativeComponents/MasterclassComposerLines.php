<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * mobile-air #421 — "Android: <bare-text-input> ignores max-lines and
 * min-lines — a multiline input grows without limit".
 *
 * `parseTextInputProps` already read both props (defaulting a multiline
 * field to a five-line cap, the same default iOS's lineLimit applies) but
 * the bare renderer only forwarded `singleLine`. It now forwards
 * `maxLines`/`minLines` like the filled and outlined variants.
 */
class MasterclassComposerLines extends NativeComponent
{
    public string $capped = '';

    public string $tall = '';

    public string $defaulted = '';

    public function navTitle(): string
    {
        return '#421 · Composer line limits';
    }

    public function render(): View
    {
        return view('native.masterclass.composer-lines');
    }
}
