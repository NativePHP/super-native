<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasSpotifyData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class SpotifySearch extends NativeComponent
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

    public function render(): View
    {
        return view('spotify-search', [
            'genres' => self::spotifyGenres(),
            'playlists' => self::spotifyPlaylists(),
            'artists' => self::spotifyArtists(),
        ]);
    }
}
