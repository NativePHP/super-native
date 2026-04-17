<?php

namespace App\NativeComponents;

use Local\DoomGame\Models\Enemy;
use Local\DoomGame\Models\Player;
use Local\DoomGame\Services\GameEngine;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class DoomGame extends NativeComponent
{
    public bool $gameStarted = false;

    public bool $isMultiplayer = false;

    public string $matchStatus = '';

    public int $mpKills = 0;

    public int $mpDeaths = 0;

    public int $lastScore = 0;

    public int $lastKills = 0;

    public int $totalKills = 0;

    public int $gamesPlayed = 0;

    public string $playerName = '';

    public bool $serverOnline = false;

    public function mount(): void
    {
        nativephp_call('UI.SetBackground', json_encode(['color' => '#1a1a1a']));

        $this->playerName = 'Player'.rand(1, 999);
        $this->totalKills = Enemy::dead()->count();
        $this->gamesPlayed = Player::count();
        $this->checkServer();
    }

    public function checkServer(): void
    {
        $host = config('doom.server_host', '127.0.0.1');
        $port = (int) config('doom.server_port', 9001);

        try {
            $socket = @stream_socket_client("udp://{$host}:{$port}", $errno, $errstr, 2);
            if (! $socket) {
                $this->serverOnline = false;

                return;
            }

            stream_set_timeout($socket, 2);

            // Send a join packet
            $packet = chr(0x01).'_ping_'.rand(1000, 9999);
            @fwrite($socket, $packet);

            // Wait for response
            $response = @fread($socket, 512);

            if ($response !== false && strlen($response) >= 5 && ord($response[0]) === 0x01) {
                $this->serverOnline = true;

                // Send disconnect so we don't leave a ghost player
                @fwrite($socket, chr(0x06));
            } else {
                $this->serverOnline = false;
            }

            @fclose($socket);
        } catch (\Throwable) {
            $this->serverOnline = false;
        }
    }

    public function startGame(): void
    {
        $engine = app(GameEngine::class);
        $engine->initGame();
        $this->gameStarted = true;
        $this->isMultiplayer = false;
    }

    public function findMatch(): void
    {
        $this->matchStatus = 'Connecting...';

        // Init the scene in PvP mode (no AI enemies)
        $spawnPoints = [
            ['x' => -6.0, 'z' => -6.0],
            ['x' => 6.0, 'z' => -6.0],
            ['x' => -6.0, 'z' => 6.0],
            ['x' => 6.0, 'z' => 6.0],
        ];
        $spawn = $spawnPoints[array_rand($spawnPoints)];

        $initData = [
            'room' => [
                'width' => 20.0,
                'depth' => 20.0,
                'height' => 8.0,
            ],
            'player' => [
                'x' => $spawn['x'],
                'z' => $spawn['z'],
                'health' => 100,
                'ammo' => 50,
            ],
            'enemies' => [],
        ];

        if (function_exists('nativephp_call')) {
            nativephp_call('Game.Init', json_encode($initData));
        }

        // Connect to the UDP server
        $serverHost = config('doom.server_host', '127.0.0.1');
        $serverPort = (int) config('doom.server_port', 9001);

        if (function_exists('nativephp_call')) {
            $result = nativephp_call('Game.Connect', json_encode([
                'host' => $serverHost,
                'port' => $serverPort,
                'player_name' => $this->playerName,
            ]));

            if ($result) {
                $data = json_decode($result, true);
                if (! empty($data['connected'])) {
                    $this->matchStatus = 'Matched! ID: '.($data['player_id'] ?? '?');
                    $this->gameStarted = true;
                    $this->isMultiplayer = true;
                } else {
                    $this->matchStatus = 'Failed: '.($data['error'] ?? 'unknown');
                }
            } else {
                $this->matchStatus = 'No response from server';
            }
        } else {
            $this->matchStatus = 'Not running in native mode';
        }
    }

    public function disconnectMatch(): void
    {
        if (function_exists('nativephp_call')) {
            $result = nativephp_call('Game.Stop', '{}');
            if ($result) {
                $data = json_decode($result, true);
                $this->mpKills = $data['mp_kills'] ?? 0;
                $this->mpDeaths = $data['mp_deaths'] ?? 0;
                $this->lastScore = $data['score'] ?? 0;
            }
        }

        $this->gameStarted = false;
        $this->isMultiplayer = false;
        $this->matchStatus = '';
    }

    public function checkResults(): void
    {
        if (function_exists('nativephp_call')) {
            $result = nativephp_call('Game.Stop', '{}');
            if ($result) {
                $data = json_decode($result, true);

                $player = Player::latest()->first();
                if ($player && $data) {
                    $player->update([
                        'score' => $data['score'] ?? $player->score,
                        'health' => $data['health'] ?? $player->health,
                        'ammo' => $data['ammo'] ?? $player->ammo,
                    ]);

                    if (! empty($data['kills'])) {
                        Enemy::whereIn('id', $data['kills'])->update(['state' => 'dead', 'health' => 0]);
                    }

                    $this->lastScore = $player->fresh()->score;
                    $this->mpKills = $data['mp_kills'] ?? 0;
                    $this->mpDeaths = $data['mp_deaths'] ?? 0;
                }
            }
        }

        $this->lastKills = Enemy::dead()->count();
        $this->totalKills = $this->lastKills;
        $this->gamesPlayed = Player::count();
        $this->gameStarted = false;
        $this->isMultiplayer = false;
    }

    public function render(): Element
    {
        return $this->view('doom-game');
    }
}
