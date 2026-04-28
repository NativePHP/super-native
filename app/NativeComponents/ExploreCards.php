<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class ExploreCards extends NativeComponent
{
    public bool $subscribed = true;
    public bool $termsAccepted = false;

    public function navTitle(): string
    {
        return 'Cards & Chips';
    }

    public function toggleField(string $field): void
    {
        if (property_exists($this, $field) && is_bool($this->{$field})) {
            $this->{$field} = ! $this->{$field};
        }
    }

    public function render(): Element
    {
        return $this->view('explore.cards');
    }
}
