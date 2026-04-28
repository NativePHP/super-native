<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasSpotifyData;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class SpotifyHome extends NativeComponent
{
    use HasSpotifyData;

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

    public function render(): Element
    {
        $playlists = self::spotifyPlaylists();
        $artists = self::spotifyArtists();
        $recentlyPlayed = array_slice($playlists, 0, 6);
        $madeForYou = array_slice($playlists, 2, 4);

        return $this->view('spotify-home', [
            'recentlyPlayed' => $recentlyPlayed,
            'madeForYou' => $madeForYou,
            'artists' => $artists,
        ]);
    }
}
