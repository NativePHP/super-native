<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasYouTubeData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class YouTubeChannel extends NativeComponent
{
    use HasYouTubeData;

    /** @var array */
    public array $channel = [];

    /** @var array<int, array> */
    public array $channelVideos = [];

    public bool $isSubscribed = false;

    public int $channelId = 0;

    public function mount(): void
    {
        nativephp_call('UI.SetBackground', json_encode(['color' => '#0F0F0F']));

        $this->channelId = (int) $this->param('id');
        $channels = self::ytChannels();
        $this->channel = $channels[$this->channelId] ?? $channels[0];

        $allVideos = self::ytVideos();
        $this->channelVideos = array_values(
            array_filter($allVideos, fn (array $v): bool => $v['channelId'] === $this->channelId)
        );
    }

    public function toggleSubscribe(): void
    {
        $this->isSubscribed = ! $this->isSubscribed;
    }

    public function viewVideo(int $index): void
    {
        $allVideos = self::ytVideos();
        $globalIndex = array_search($this->channelVideos[$index]['title'], array_column($allVideos, 'title'));
        if ($globalIndex !== false) {
            $this->navigate($this->route('youtube.video', $globalIndex))
                ->transition(Transition::SlideFromRight);
        }
    }

    public function render(): \Illuminate\View\View
    {
        $videosWithMeta = [];
        foreach ($this->channelVideos as $video) {
            $video['viewsFormatted'] = self::formatYtCount($video['views']);
            $videosWithMeta[] = $video;
        }

        return view('youtube-channel', [
            'videosWithMeta' => $videosWithMeta,
            'subscribersFormatted' => self::formatYtCount($this->channel['subscribers']),
        ]);
    }
}