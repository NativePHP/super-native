<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasTweetData;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class TwitterFeed extends NativeComponent
{
    use HasTweetData;

    public int $selectedTab = 0;

    public function navTitle(): string
    {
        return 'Twitter / X';
    }

    /** @var array<int, bool> */
    public array $likedTweets = [];

    public function selectTab(int $index): void
    {
        $this->selectedTab = $index;
    }

    public function viewTweet(int $index): void
    {
        $this->navigate($this->route('twitter.tweet', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function viewProfile(int $userId): void
    {
        $this->navigate($this->route('twitter.profile', $userId))
            ->transition(Transition::SlideFromRight);
    }

    public function composeTweet(): void
    {
        $this->navigate($this->route('twitter.compose'))
            ->transition(Transition::SlideFromBottom);
    }

    public function toggleLike(int $index): void
    {
        if (isset($this->likedTweets[$index])) {
            unset($this->likedTweets[$index]);
        } else {
            $this->likedTweets[$index] = true;
        }
    }

    public function render(): Element
    {
        $users = self::tweetUsers();
        $tweets = self::tweets();

        foreach ($tweets as $i => &$tweet) {
            $tweet['user'] = $users[$tweet['userId']];
            $tweet['replyFormatted'] = self::formatCount($tweet['replyCount']);
            $tweet['retweetFormatted'] = self::formatCount($tweet['retweetCount']);
            $tweet['likeFormatted'] = self::formatCount(
                $tweet['likeCount'] + (isset($this->likedTweets[$i]) ? 1 : 0)
            );
            $tweet['isLiked'] = isset($this->likedTweets[$i]);
        }

        return $this->view('twitter-feed', [
            'tweets' => $tweets,
        ]);
    }
}
