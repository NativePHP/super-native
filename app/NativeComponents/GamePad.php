<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Attributes\Poll;
use Native\Mobile\Edge\NativeComponent;

/**
 * Game Pad — held-press playground built on `@tapDown` / `@tapUp`.
 *
 * Holding a d-pad button moves the character every tick until the finger
 * lifts; holding FIRE auto-fires shots toward the facing direction; holding
 * SHIELD recolors the button icon (and the character) only while pressed.
 * A `#[Poll]` tick is the game loop: it steps the character, spawns held
 * fire, advances shots, and flashes the wall edge a shot connects with.
 */
class GamePad extends NativeComponent
{
    /** Arena is a fixed square; all positions are point offsets from its center. */
    public const ARENA = 320.0;

    public const PLAYER_SIZE = 44.0;

    public const SHOT_SIZE = 12.0;

    /** Points travelled per tick. */
    private const PLAYER_SPEED = 10.0;

    private const SHOT_SPEED = 26.0;

    /** Ticks between shots while the fire button is held. */
    private const FIRE_COOLDOWN = 3;

    /** Ticks a wall edge stays lit after a shot connects. */
    private const FLASH_TICKS = 4;

    public float $x = 0.0;

    public float $y = 0.0;

    /** Direction shots travel — the last direction the character moved. */
    public string $facing = 'up';

    /** D-pad direction currently held, or null once the finger lifts. */
    public ?string $moving = null;

    public bool $firing = false;

    public bool $shieldRaised = false;

    /**
     * In-flight shots.
     *
     * @var array<int, array{id: int, x: float, y: float, dx: float, dy: float}>
     */
    public array $shots = [];

    public int $wallHits = 0;

    /** Wall side currently flashing from a hit (up/down/left/right), or null. */
    public ?string $flashingWall = null;

    public int $nextShotId = 1;

    public int $fireCooldown = 0;

    public int $flashTicksLeft = 0;

    public function navTitle(): string
    {
        return 'Game Pad';
    }

    /** `@tapDown` on a d-pad button — move immediately, then keep moving each tick. */
    public function startMove(string $direction): void
    {
        $this->moving = $direction;
        $this->facing = $direction;
        $this->stepPlayer();
    }

    /** `@tapUp` on every d-pad button. */
    public function stopMove(): void
    {
        $this->moving = null;
    }

    /** `@tapDown` on FIRE — first shot is instant, the tick loop keeps firing. */
    public function startFire(): void
    {
        $this->firing = true;
        $this->fireShot();
        $this->fireCooldown = self::FIRE_COOLDOWN;
    }

    /** `@tapUp` on FIRE. */
    public function stopFire(): void
    {
        $this->firing = false;
    }

    /** `@tapDown` on SHIELD. */
    public function raiseShield(): void
    {
        $this->shieldRaised = true;
    }

    /** `@tapUp` on SHIELD. */
    public function lowerShield(): void
    {
        $this->shieldRaised = false;
    }

    /** The game loop — held movement, held auto-fire, shot flight, wall flash decay. */
    #[Poll(50)]
    public function tick(): void
    {
        if ($this->moving !== null) {
            $this->stepPlayer();
        }

        if ($this->firing && --$this->fireCooldown <= 0) {
            $this->fireShot();
            $this->fireCooldown = self::FIRE_COOLDOWN;
        }

        $this->advanceShots();

        if ($this->flashTicksLeft > 0 && --$this->flashTicksLeft === 0) {
            $this->flashingWall = null;
        }
    }

    private function stepPlayer(): void
    {
        [$dx, $dy] = $this->vector($this->moving ?? $this->facing);
        $limit = (self::ARENA - self::PLAYER_SIZE) / 2;

        $this->x = max(-$limit, min($limit, $this->x + $dx * self::PLAYER_SPEED));
        $this->y = max(-$limit, min($limit, $this->y + $dy * self::PLAYER_SPEED));
    }

    private function fireShot(): void
    {
        [$dx, $dy] = $this->vector($this->facing);

        $this->shots[] = [
            'id' => $this->nextShotId++,
            'x' => $this->x,
            'y' => $this->y,
            'dx' => $dx * self::SHOT_SPEED,
            'dy' => $dy * self::SHOT_SPEED,
        ];
    }

    private function advanceShots(): void
    {
        $limit = (self::ARENA - self::SHOT_SIZE) / 2;
        $surviving = [];

        foreach ($this->shots as $shot) {
            $shot['x'] += $shot['dx'];
            $shot['y'] += $shot['dy'];

            if (abs($shot['x']) > $limit || abs($shot['y']) > $limit) {
                $this->wallHits++;
                $this->flashingWall = match (true) {
                    $shot['y'] < -$limit => 'up',
                    $shot['y'] > $limit => 'down',
                    $shot['x'] < -$limit => 'left',
                    default => 'right',
                };
                $this->flashTicksLeft = self::FLASH_TICKS;

                continue;
            }

            $surviving[] = $shot;
        }

        $this->shots = $surviving;
    }

    /**
     * Unit vector for a d-pad direction (screen coordinates — up is negative y).
     *
     * @return array{float, float}
     */
    private function vector(string $direction): array
    {
        return match ($direction) {
            'up' => [0.0, -1.0],
            'down' => [0.0, 1.0],
            'left' => [-1.0, 0.0],
            default => [1.0, 0.0],
        };
    }

    public function render(): View
    {
        return view('native.game-pad');
    }
}
