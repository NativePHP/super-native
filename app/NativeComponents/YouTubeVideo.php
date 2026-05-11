<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasYouTubeData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class YouTubeVideo extends NativeComponent
{
    use HasYouTubeData;

    /** @var array */
    public array $video = [];

    /** @var array */
    public array $channel = [];

    /** @var array<int, array> */
    public array $comments = [];

    public bool $isLiked = false;

    public bool $isDisliked = false;

    public bool $isSubscribed = false;

    public bool $showDescription = false;

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $videos = self::ytVideos();
        $channels = self::ytChannels();
        $allComments = self::ytComments();

        $this->video = $videos[$id] ?? $videos[0];
        $this->channel = $channels[$this->video['channelId']];
        $this->comments = $allComments[$id] ?? $allComments[0] ?? [];
    }

    public function toggleLike(): void
    {
        $this->isLiked = ! $this->isLiked;
        if ($this->isLiked) {
            $this->isDisliked = false;
        }
    }

    public function toggleDislike(): void
    {
        $this->isDisliked = ! $this->isDisliked;
        if ($this->isDisliked) {
            $this->isLiked = false;
        }
    }

    public function toggleSubscribe(): void
    {
        $this->isSubscribed = ! $this->isSubscribed;
    }

    public function toggleDescription(): void
    {
        $this->showDescription = ! $this->showDescription;
    }

    public function viewChannel(int $id): void
    {
        $this->navigate($this->route('youtube.channel', $id))
            ->transition(Transition::SlideFromRight);
    }

    public function viewVideo(int $index): void
    {
        $this->replace($this->route('youtube.video', $index));
    }

    public function render(): \Illuminate\View\View
    {
        $videos = self::ytVideos();
        $channels = self::ytChannels();

        $suggested = [];
        foreach ($videos as $i => $v) {
            if ($v['title'] !== $this->video['title']) {
                $v['channel'] = $channels[$v['channelId']];
                $v['viewsFormatted'] = self::formatYtCount($v['views']);
                $v['index'] = $i;
                $suggested[] = $v;
            }
            if (count($suggested) >= 5) {
                break;
            }
        }

        return view('youtube-video', [
            'suggested' => $suggested,
            'likesFormatted' => self::formatYtCount($this->video['likes'] + ($this->isLiked ? 1 : 0)),
            'viewsFormatted' => self::formatYtCount($this->video['views']),
            'subscribersFormatted' => self::formatYtCount($this->channel['subscribers']),
            'commentCountFormatted' => self::formatYtCount($this->video['commentCount']),
        ]);
    }
}
