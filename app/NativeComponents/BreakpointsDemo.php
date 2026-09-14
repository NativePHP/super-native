<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Responsive class prefixes: the same Blade should stack on a phone and
 * go side by side from `md` (768pt) up, re-flowing on rotation / Split View.
 */
class BreakpointsDemo extends NativeComponent
{
    public function render(): View
    {
        $projects = collect(range(1, 9))->map(fn (int $i) => [
            'id' => $i,
            'name' => 'Project '.$i,
            'status' => ['Building', 'In review', 'Shipped'][$i % 3],
        ])->all();

        return view('native.breakpoints-demo', ['projects' => $projects]);
    }
}
