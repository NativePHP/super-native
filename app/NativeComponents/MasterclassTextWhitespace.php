<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * mobile-air #336 — "<text> slot content is whitespace-normalized,
 * destroying line breaks in user-generated text".
 *
 * Fixed in #425 (gwleuverink's #356 rebased). One whitespace policy now
 * applies where slot and attribute text merge, so `<text>{{ $m }}</text>`
 * and `<text :text="$m" />` render identically. The default collapses,
 * exactly what CSS `white-space: normal` does; `whitespace-pre-line`
 * keeps line breaks and collapses spaces; `whitespace-pre-wrap` keeps
 * every byte. Nested runs inherit the closest classed ancestor.
 */
class MasterclassTextWhitespace extends NativeComponent
{
    public string $message = "First paragraph, written by a user.\n\nSecond paragraph after a blank line.\nThird line, no blank.";

    public string $code = "if (\$ready) {\n    launch();\n}";

    public function navTitle(): string
    {
        return '#336 · Text whitespace';
    }

    public function render(): View
    {
        return view('native.masterclass.text-whitespace');
    }
}
