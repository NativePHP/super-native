<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Adaptive lazy-grid check: the same Blade should render one column on a
 * phone and two or more on an iPad, re-flowing on rotation / Split View.
 */
class ProjectsGrid extends NativeComponent
{
    public function render(): View
    {
        $statuses = ['Building', 'In review', 'Shipped', 'Blocked'];
        $projects = collect(range(1, 14))->map(fn (int $i) => [
            'id' => $i,
            'name' => 'Project '.$i,
            'status' => $statuses[$i % 4],
            'summary' => 'Card '.$i.' sized by min-column-width, not a fixed column count.',
        ])->all();

        return view('native.projects-grid', ['projects' => $projects]);
    }
}
