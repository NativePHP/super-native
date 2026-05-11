<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasSpotifyData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class SpotifySearch extends NativeComponent
{
    use HasSpotifyData;

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

    public function render(): \Illuminate\View\View
    {
        return view('spotify-search', [
            'genres' => self::spotifyGenres(),
            'playlists' => self::spotifyPlaylists(),
            'artists' => self::spotifyArtists(),
        ]);
    }
}
