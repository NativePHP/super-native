<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Theme Lab — a living style guide for the whole design system: theme
 * tokens (including the app-defined success + outline-variant roles),
 * theme-class opacity ramps, every button/badge variant, and font
 * aliases. Flip system dark mode while it's open — every token
 * re-resolves live, no code changes.
 */
class ThemeLab extends NativeComponent
{
    /** Incremented by every demo button — proves variants stay interactive. */
    public int $presses = 0;

    public function navTitle(): string
    {
        return 'Theme Lab';
    }

    public function recordPress(): void
    {
        $this->presses++;
    }

    /**
     * Token pairs rendered as swatches: bg token → its on-* companion.
     *
     * @return array<string, string>
     */
    public function swatchTokens(): array
    {
        return [
            'primary' => 'Primary — brand violet',
            'secondary' => 'Secondary — teal / fuchsia',
            'surface' => 'Surface — cards & sheets',
            'surface-variant' => 'Surface Variant — tonal fills',
            'destructive' => 'Destructive — errors',
            'success' => 'Success — custom token',
            'accent' => 'Accent — highlights',
        ];
    }

    /**
     * Button variants including the success case.
     *
     * @return array<int, string>
     */
    public function buttonVariants(): array
    {
        return ['primary', 'secondary', 'success', 'destructive', 'ghost'];
    }

    /**
     * Badge variants including the success case.
     *
     * @return array<int, string>
     */
    public function badgeVariants(): array
    {
        return ['destructive', 'primary', 'success', 'accent'];
    }

    /**
     * Opacity steps for the theme-class tonal-fill ramp.
     *
     * @return array<int, int>
     */
    public function opacitySteps(): array
    {
        return [10, 25, 50, 75, 100];
    }

    /**
     * Font aliases from config/native-ui.php with sample copy.
     *
     * @return array<string, string>
     */
    public function fontSamples(): array
    {
        return [
            'display' => 'SUPERNATIVE',
            'grotesk' => 'Space Grotesk — clean UI copy with personality.',
            'grotesk-bold' => 'Space Grotesk Bold — headlines that mean it.',
            'accent' => 'Lobster — when the moment calls for flair.',
            'default' => 'Geist Pixel — the app-wide default face.',
        ];
    }

    public function render(): View
    {
        return view('native.theme-lab');
    }
}
