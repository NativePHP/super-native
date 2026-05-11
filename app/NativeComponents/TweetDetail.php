<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasTweetData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class TweetDetail extends NativeComponent
{
    use HasTweetData;

    /** @var array{userId: int, text: string, time: string, replyCount: int, retweetCount: int, likeCount: int, imageUrl: string|null, user: array} */
    public array $tweet = [];

    /** @var array<int, array> */
    public array $replies = [];

    public bool $isLiked = false;

    public bool $isRetweeted = false;

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $tweets = self::tweets();
        $users = self::tweetUsers();

        $tweet = $tweets[$id] ?? $tweets[0];
        $tweet['user'] = $users[$tweet['userId']];
        $this->tweet = $tweet;

        $replies = self::tweetReplies();
        foreach ($replies as &$reply) {
            $reply['user'] = $users[$reply['userId']];
            $reply['likeFormatted'] = self::formatCount($reply['likeCount']);
        }
        $this->replies = $replies;
    }

    public function viewProfile(int $userId): void
    {
        $this->navigate($this->route('twitter.profile', $userId))
            ->transition(Transition::SlideFromRight);
    }

    public function toggleLike(): void
    {
        $this->isLiked = ! $this->isLiked;
    }

    public function toggleRetweet(): void
    {
        $this->isRetweeted = ! $this->isRetweeted;
    }

    public function render(): \Illuminate\View\View
    {
        $likeCount = $this->tweet['likeCount'] + ($this->isLiked ? 1 : 0);
        $retweetCount = $this->tweet['retweetCount'] + ($this->isRetweeted ? 1 : 0);

        return view('tweet-detail', [
            'likeFormatted' => self::formatCount($likeCount),
            'retweetFormatted' => self::formatCount($retweetCount),
            'replyFormatted' => self::formatCount($this->tweet['replyCount']),
        ]);
    }
}
