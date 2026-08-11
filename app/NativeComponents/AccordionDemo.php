<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class AccordionDemo extends NativeComponent
{
    /** @var array<string, bool> */
    public array $open = [
        'shipping' => true,
        'returns' => false,
        'warranty' => false,
    ];

    public int $changes = 0;

    public function navTitle(): string
    {
        return 'Accordion';
    }

    public function toggled(string $key, bool $expanded): void
    {
        $this->open[$key] = $expanded;
        $this->changes++;
    }

    /** Server-side push: drives the `expanded` binding programmatically. */
    public function expandAll(): void
    {
        $this->open = array_map(fn () => true, $this->open);
    }

    public function collapseAll(): void
    {
        $this->open = array_map(fn () => false, $this->open);
    }

    public function render(): View
    {
        return view('native.accordion-demo');
    }
}
