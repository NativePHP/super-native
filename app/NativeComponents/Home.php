<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class Home extends NativeComponent
{
    public array $items = [
        ['id' => 1, 'title' => 'First item',  'subtitle' => 'A short description'],
        ['id' => 2, 'title' => 'Second item', 'subtitle' => 'Another row to tap'],
        ['id' => 3, 'title' => 'Third item',  'subtitle' => 'Push me to see detail'],
        ['id' => 4, 'title' => 'Fourth item', 'subtitle' => 'Back swipe to return'],
    ];

    public function navTitle(): string
    {
        return 'Home';
    }

    public function render(): Element
    {
        return $this->view('home');
    }
}
