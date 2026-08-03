<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasYouTubeData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class YouTubeHome extends NativeComponent
{
    use HasYouTubeData;

    public string $activeCategory = 'All';

    public function mount(): void
    {
        nativephp_call('UI.SetBackground', json_encode(['color' => '#0F0F0F']));
    }

    public function unmount(): void
    {
        // UI.SetBackground is app-global sticky native state — without
        // this clear it leaks the window color into every screen visited
        // after this one. Empty color = restore the platform default.
        nativephp_call('UI.SetBackground', json_encode(['color' => null]));

        parent::unmount();
    }

    public function castDevice(): void
    {
        // No-op stub for the demo — real impl would open AirPlay / cast picker.
    }

    public function viewNotifications(): void
    {
        // No-op stub for the demo.
    }

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

    public function render(): View
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

        return view('youtube-home', [
            'videos' => $videosWithChannels,
            'shorts' => $shortsWithChannels,
            'categories' => $categories,
        ]);
    }
}
