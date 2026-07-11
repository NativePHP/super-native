<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

class Profile extends NativeComponent
{
    public string $name  = 'Shane Rosenthal';
    public string $email = 'shane@nativephp.com';
    public int $followers = 2850;
    public int $following = 312;

    public function navTitle(): string
    {
        return 'Profile';
    }

    public function render(): \Illuminate\View\View
    {
        return view('profile');
    }
}
