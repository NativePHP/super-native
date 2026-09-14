<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Nested morphs: a tagged element INSIDE another tagged element.
 *
 * The card morphs into the detail header while the avatar it contains morphs
 * to a different place within that header. The inner element is not carried
 * along by its parent — it is matched independently and takes its own path, so
 * the two animate at different speeds and directions simultaneously.
 */
class HeroNested extends NativeComponent
{
    public function navTitle(): string
    {
        return 'Nested Morphs';
    }

    public function render(): View
    {
        return view('native.hero.nested');
    }
}
