<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasSpotifyData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;
use Native\Mobile\Facades\Dialog;

class SpotifyPlaylist extends NativeComponent
{
    use HasSpotifyData;

    /** @var array */
    public array $playlist = [];

    /** @var array<int, array> */
    public array $tracks = [];

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $playlists = self::spotifyPlaylists();
        $this->playlist = $playlists[$id] ?? $playlists[0];

        $allTracks = self::spotifyTracks();
        $artists = self::spotifyArtists();

        $this->tracks = array_slice($allTracks, 0, min(8, count($allTracks)));
        foreach ($this->tracks as &$track) {
            $track['artistName'] = $artists[$track['artistId']]['name'];
        }
    }

    public function viewArtist(int $artistId): void
    {
        $this->navigate($this->route('spotify.artist', $artistId))
            ->transition(Transition::SlideFromRight);
    }

    public function playTrack(int $index): void
    {
        $track = $this->tracks[$index] ?? null;
        if ($track) {
            Dialog::alert('Now Playing', $track['title'] . ' by ' . $track['artistName']);
        }
    }

    public function shufflePlay(): void
    {
        Dialog::alert('Shuffle Play', 'Playing ' . $this->playlist['name'] . ' on shuffle.');
    }

    public function render(): \Illuminate\View\View
    {
        $tracksWithMeta = [];
        foreach ($this->tracks as $track) {
            $track['playsFormatted'] = self::formatSpotifyCount($track['plays']);
            $tracksWithMeta[] = $track;
        }

        return view('spotify-playlist', [
            'tracksWithMeta' => $tracksWithMeta,
        ]);
    }
}
