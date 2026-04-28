<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class Profile extends NativeComponent
{
    public string $name  = 'Shane Rosenthal';
    public string $email = 'srosenthal82@gmail.com';
    public int $followers = 1248;
    public int $following = 312;

    public function navTitle(): string
    {
        return 'Profile';
    }

    public function render(): Element
    {
        return $this->view('profile');
    }
}
