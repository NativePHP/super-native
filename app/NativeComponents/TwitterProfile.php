<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasTweetData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class TwitterProfile extends NativeComponent
{
    use HasTweetData;

    /** @var array{name: string, handle: string, avatarUrl: string, bio: string, following: int, followers: int, isVerified: bool, bannerUrl: string} */
    public array $user = [];

    /** @var array<int, array> */
    public array $userTweets = [];

    public int $selectedTab = 0;

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $users = self::tweetUsers();
        $this->user = $users[$id] ?? $users[0];

        $allTweets = self::tweets();
        $this->userTweets = array_values(
            array_filter($allTweets, fn (array $tweet): bool => $tweet['userId'] === $id)
        );
    }

    public function selectTab(int $index): void
    {
        $this->selectedTab = $index;
    }

    public function viewTweet(int $tweetId): void
    {
        $this->navigate($this->route('twitter.tweet', $tweetId))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): \Illuminate\View\View
    {
        $users = self::tweetUsers();
        $allTweets = self::tweets();

        $tweetsWithMeta = [];
        foreach ($this->userTweets as $tweet) {
            $originalIndex = array_search($tweet, $allTweets);
            $tweet['user'] = $users[$tweet['userId']];
            $tweet['originalIndex'] = $originalIndex;
            $tweet['replyFormatted'] = self::formatCount($tweet['replyCount']);
            $tweet['retweetFormatted'] = self::formatCount($tweet['retweetCount']);
            $tweet['likeFormatted'] = self::formatCount($tweet['likeCount']);
            $tweetsWithMeta[] = $tweet;
        }

        return view('twitter-profile', [
            'tweetsWithMeta' => $tweetsWithMeta,
            'followersFormatted' => self::formatCount($this->user['followers']),
            'followingFormatted' => self::formatCount($this->user['following']),
        ]);
    }
}
