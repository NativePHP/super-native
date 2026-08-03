<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasYouTubeData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class YouTubeChannel extends NativeComponent
{
    use HasYouTubeData;

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

    public function unmount(): void
    {
        // UI.SetBackground is app-global sticky native state — without
        // this clear it leaks the window color into every screen visited
        // after this one. Empty color = restore the platform default.
        nativephp_call('UI.SetBackground', json_encode(['color' => null]));

        parent::unmount();
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

    public function render(): View
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
