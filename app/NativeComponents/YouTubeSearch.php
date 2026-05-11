<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasYouTubeData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class YouTubeSearch extends NativeComponent
{
    use HasYouTubeData;

    public string $query = '';

    /** @var array<int, array> */
    public array $results = [];

    public function mount(): void
    {
        nativephp_call('UI.SetBackground', json_encode(['color' => '#0F0F0F']));
    }

    public function search(): void
    {
        if (trim($this->query) === '') {
            $this->results = [];

            return;
        }

        $videos = self::ytVideos();
        $channels = self::ytChannels();
        $q = strtolower(trim($this->query));

        $this->results = [];
        foreach ($videos as $i => $video) {
            if (str_contains(strtolower($video['title']), $q)
                || str_contains(strtolower($channels[$video['channelId']]['name']), $q)) {
                $video['channel'] = $channels[$video['channelId']];
                $video['viewsFormatted'] = self::formatYtCount($video['views']);
                $video['globalIndex'] = $i;
                $this->results[] = $video;
            }
        }
    }

    public function viewVideo(int $globalIndex): void
    {
        $this->navigate($this->route('youtube.video', $globalIndex))
            ->transition(Transition::SlideFromRight);
    }

    public function viewChannel(int $channelId): void
    {
        $this->navigate($this->route('youtube.channel', $channelId))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): \Illuminate\View\View
    {
        $videos = self::ytVideos();
        $channels = self::ytChannels();

        $trending = [];
        $sorted = $videos;
        usort($sorted, fn (array $a, array $b): int => $b['views'] <=> $a['views']);
        foreach (array_slice($sorted, 0, 5) as $video) {
            $originalIndex = array_search($video['title'], array_column($videos, 'title'));
            $video['channel'] = $channels[$video['channelId']];
            $video['viewsFormatted'] = self::formatYtCount($video['views']);
            $video['globalIndex'] = $originalIndex;
            $trending[] = $video;
        }

        return view('youtube-search', [
            'trending' => $trending,
            'channels' => $channels,
        ]);
    }
}