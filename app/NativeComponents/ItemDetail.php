<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

class ItemDetail extends NativeComponent
{
    public int $id;
    public string $title = '';

    public function mount(): void
    {
        $this->id = (int) ($this->params['id'] ?? 0);
        $this->title = "Item #{$this->id}";
    }

    public function navTitle(): string
    {
        return $this->title;
    }

    public function render(): \Illuminate\View\View
    {
        return view('item-detail');
    }
}
