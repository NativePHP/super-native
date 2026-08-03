<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasSpotifyData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;

class SpotifyArtist extends NativeComponent
{
    use HasSpotifyData;

    public array $artist = [];

    /** @var array<int, array> */
    public array $topTracks = [];

    public bool $isFollowing = false;

    public function mount(): void
    {
        nativephp_call('UI.SetBackground', json_encode(['color' => '#121212']));

        $id = (int) $this->param('id');
        $artists = self::spotifyArtists();
        $this->artist = $artists[$id] ?? $artists[0];

        $allTracks = self::spotifyTracks();
        $this->topTracks = array_values(
            array_filter($allTracks, fn (array $t): bool => $t['artistId'] === $id)
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

    public function toggleFollow(): void
    {
        $this->isFollowing = ! $this->isFollowing;
    }

    public function playTrack(int $index): void
    {
        $track = $this->topTracks[$index] ?? null;
        if ($track) {
            Dialog::alert('Now Playing', $track['title'].' by '.$this->artist['name']);
        }
    }

    public function render(): View
    {
        $tracksWithMeta = [];
        foreach ($this->topTracks as $track) {
            $track['playsFormatted'] = self::formatSpotifyCount($track['plays']);
            $tracksWithMeta[] = $track;
        }

        return view('spotify-artist', [
            'tracksWithMeta' => $tracksWithMeta,
            'followersFormatted' => self::formatSpotifyCount($this->artist['followers']),
            'listenersFormatted' => self::formatSpotifyCount($this->artist['monthlyListeners']),
        ]);
    }
}
