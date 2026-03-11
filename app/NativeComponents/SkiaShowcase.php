<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class SkiaShowcase extends NativeComponent
{
    public bool $pulseRunning = true;
    public bool $spinRunning = true;
    public bool $timerRunning = false;
    public int $timerSeconds = 30;
    public int $barAnimRunning = 1;
    public int $waveRunning = 1;

    public function mount(): void
    {
        nativephp_call('UI.SetBackground', json_encode(['color' => '#0f0f1e']));
    }

    public function togglePulse(): void
    {
        $this->pulseRunning = ! $this->pulseRunning;
    }

    public function toggleSpin(): void
    {
        $this->spinRunning = ! $this->spinRunning;
    }

    public function toggleTimer(): void
    {
        $this->timerRunning = ! $this->timerRunning;
    }

    public function setTimerSeconds(int $seconds): void
    {
        $this->timerSeconds = $seconds;
        $this->timerRunning = false;
    }

    public function toggleBars(): void
    {
        $this->barAnimRunning = $this->barAnimRunning === 1 ? 0 : 1;
    }

    public function toggleWave(): void
    {
        $this->waveRunning = $this->waveRunning === 1 ? 0 : 1;
    }

    public function render(): Element
    {
        return $this->view('skia-showcase');
    }
}