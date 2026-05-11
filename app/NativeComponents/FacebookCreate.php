<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;

class FacebookCreate extends NativeComponent
{
    public string $postText = '';

    public function updateText(string $text): void
    {
        $this->postText = $text;
    }

    public function submitPost(): void
    {
        if (trim($this->postText) !== '') {
            Dialog::alert('Post Shared', 'Your post has been shared with your friends.');
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('facebook-create');
    }
}
