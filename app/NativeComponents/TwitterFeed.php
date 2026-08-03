<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasTweetData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class TwitterFeed extends NativeComponent
{
    use HasTweetData;

    /** User ids shown on the Following tab. */
    private const FOLLOWING_USER_IDS = [0, 1, 2, 7];

    public int $selectedTab = 0;

    public int $refreshCount = 0;

    /** @var array<int, bool> Keyed by tweet id, stable across tab filters and refresh rotation. */
    public array $likedTweets = [];

    public function navTitle(): string
    {
        return 'Twitter / X';
    }

    public function selectTab(int $index): void
    {
        $this->selectedTab = $index;
    }

    public function refresh(): void
    {
        $this->refreshCount++;
    }

    public function viewTweet(int $id): void
    {
        $this->navigate($this->route('twitter.tweet', $id))
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

    public function toggleLike(int $id): void
    {
        if (isset($this->likedTweets[$id])) {
            unset($this->likedTweets[$id]);
        } else {
            $this->likedTweets[$id] = true;
        }
    }

    public function render(): View
    {
        $users = self::tweetUsers();
        $tweets = self::tweets();

        foreach ($tweets as $id => &$tweet) {
            $tweet['id'] = $id;
            $tweet['user'] = $users[$tweet['userId']];
            $tweet['replyFormatted'] = self::formatCount($tweet['replyCount']);
            $tweet['retweetFormatted'] = self::formatCount($tweet['retweetCount']);
            $tweet['viewFormatted'] = self::formatCount($tweet['likeCount'] * 41 + $tweet['replyCount'] * 173);
            $tweet['likeFormatted'] = self::formatCount(
                $tweet['likeCount'] + (isset($this->likedTweets[$id]) ? 1 : 0)
            );
            $tweet['isLiked'] = isset($this->likedTweets[$id]);
        }
        unset($tweet);

        if ($this->selectedTab === 1) {
            $tweets = array_values(array_filter(
                $tweets,
                fn (array $tweet): bool => in_array($tweet['userId'], self::FOLLOWING_USER_IDS, true)
            ));
        }

        if ($this->refreshCount > 0 && count($tweets) > 1) {
            $offset = $this->refreshCount % count($tweets);
            $tweets = array_merge(array_slice($tweets, $offset), array_slice($tweets, 0, $offset));
        }

        return view('twitter-feed', [
            'tweets' => $tweets,
        ]);
    }
}
