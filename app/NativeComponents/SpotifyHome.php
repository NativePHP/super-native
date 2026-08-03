<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasSpotifyData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class SpotifyHome extends NativeComponent
{
    use HasSpotifyData;

    public function mount(): void
    {
        nativephp_call('UI.SetBackground', json_encode(['color' => '#121212']));
    }

    public function unmount(): void
    {
        // UI.SetBackground is app-global sticky native state — without
        // this clear it leaks the window color into every screen visited
        // after this one. Empty color = restore the platform default.
        nativephp_call('UI.SetBackground', json_encode(['color' => null]));

        parent::unmount();
    }

    public function navTitle(): string
    {
        return 'Spotify';
    }

    public function viewPlaylist(int $index): void
    {
        $this->navigate($this->route('spotify.playlist', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function viewArtist(int $index): void
    {
        $this->navigate($this->route('spotify.artist', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function viewSearch(): void
    {
        $this->navigate($this->route('spotify.search'))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): View
    {
        $playlists = self::spotifyPlaylists();
        $artists = self::spotifyArtists();
        $recentlyPlayed = array_slice($playlists, 0, 6);
        $madeForYou = array_slice($playlists, 2, 4);

        return view('spotify-home', [
            'recentlyPlayed' => $recentlyPlayed,
            'madeForYou' => $madeForYou,
            'artists' => $artists,
        ]);
    }
}
