<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;

class ComposeTweet extends NativeComponent
{
    public string $tweetText = '';

    public function updateText(string $text): void
    {
        $this->tweetText = $text;
    }

    public function postTweet(): void
    {
        if (trim($this->tweetText) !== '') {
            Dialog::alert('Posted!', 'Your post has been shared.');
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('compose-tweet');
    }
}
