<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasYouTubeData;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class YouTubeHome extends NativeComponent
{
    use HasYouTubeData;

    public string $activeCategory = 'All';

    public function viewVideo(int $index): void
    {
        $this->navigate($this->route('youtube.video', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function viewChannel(int $index): void
    {
        $this->navigate($this->route('youtube.channel', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function viewSearch(): void
    {
        $this->navigate($this->route('youtube.search'))
            ->transition(Transition::SlideFromRight);
    }

    public function selectCategory(string $category): void
    {
        $this->activeCategory = $category;
    }

    public function render(): Element
    {
        $videos = self::ytVideos();
        $channels = self::ytChannels();
        $shorts = self::ytShorts();
        $categories = self::ytCategories();

        $videosWithChannels = [];
        foreach ($videos as $video) {
            $video['channel'] = $channels[$video['channelId']];
            $video['viewsFormatted'] = self::formatYtCount($video['views']);
            $videosWithChannels[] = $video;
        }

        $shortsWithChannels = [];
        foreach ($shorts as $short) {
            $short['channel'] = $channels[$short['channelId']];
            $short['viewsFormatted'] = self::formatYtCount($short['views']);
            $shortsWithChannels[] = $short;
        }

        return $this->view('youtube-home', [
            'videos' => $videosWithChannels,
            'shorts' => $shortsWithChannels,
            'categories' => $categories,
        ]);
    }
}
