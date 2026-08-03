<?php

/**
 * Native UI — Theme Tokens
 *
 * Published via `php artisan vendor:publish --tag=native-ui-config`.
 * Edit to customize your app's visual identity in one place.
 *
 * For dynamic per-tenant theming, use Native\Mobile\UI\Theme::merge([...])
 * from a service provider. Runtime merges deep-merge on top of these values.
 *
 * Decision log: /docs/NATIVE-UI-REWRITE-PLAN.md (D — theme layer)
 */

return [

    /*
    |---------------------------------------------------------------------------
    | Theme
    |---------------------------------------------------------------------------
    |
    | 14 color tokens, 4 radii, 4 font sizes, font family.
    |
    | "on-X" means "color of content placed ON a surface of color X"
    |   — i.e., text/icons on that background.
    |
    | Dark mode is auto-derived from `light` when `dark` is not set. To opt
    | into explicit dark tokens, fill out the `dark` block.
    |
    */

    'theme' => [

        // Matched to nativephp.com's light theme: white page, #272D48 navy ink,
        // violet-600 primary accent, slate-200 borders, brand teal highlight.
        'light' => [
            // Primary brand color — used for filled buttons, active states, key accents.
            'primary' => 'violet-600',
            'on-primary' => 'white',

            // Secondary / muted action color.
            'secondary' => 'teal-500',
            'on-secondary' => 'white',

            // Surface = cards, sheets, dialogs. Background = page root.
            'surface' => 'slate-50',
            'on-surface' => '#272D48',
            'background' => 'white',
            'on-background' => '#272D48',

            // Surface variant = filled text fields, muted tonal surfaces.
            // on-surface-variant = muted label/hint text on those surfaces.
            'surface-variant' => 'slate-200',
            'on-surface-variant' => 'slate-800',

            // Outline = neutral borders (text fields, dividers, cards).
            // outline-variant = softer edges: hairline dividers, card seams.
            'outline' => 'slate-200',
            'outline-variant' => 'slate-100',

            // Destructive / error actions and messages.
            'destructive' => 'red-600',
            'on-destructive' => 'white',

            // Success / "all systems go" — confirmations, verified badges.
            'success' => 'emerald-600',
            'on-success' => 'white',

            // Tertiary accent — for highlights, badges, emphasis not covered by primary.
            'accent' => 'yellow-400',
            'on-accent' => 'white',
        ],

        // Matched to nativephp.com's dark theme: #050714 page, slate-950 cards,
        // "cloud" navy (#2B2E53) tonal fills, violet-500 accents, teal #3EDAD7.
        'dark' => [
            'shane' => 'yellow-400',
            'primary' => 'violet-500',
            'on-primary' => 'white',

            'secondary' => 'fuchsia-500',
            'on-secondary' => 'white',

            'surface' => 'slate-950',
            'on-surface' => 'white',
            'background' => '#050714',
            'on-background' => 'white',

            'surface-variant' => '#2B2E53',
            'on-surface-variant' => 'gray-400',

            'outline' => 'slate-700',
            'outline-variant' => 'slate-800',

            'destructive' => 'red-500',
            'on-destructive' => 'white',

            'success' => 'emerald-400',
            'on-success' => '#052E16',

            'accent' => '#3EDAD7',
            'on-accent' => '#050714',
        ],

        // Corner radii (points / dp).
        'radius-sm' => 4,
        'radius-md' => 8,
        'radius-lg' => 16,
        'radius-full' => 9999,

        // Font size scale (points / sp).
        'font-sm' => 14,
        'font-md' => 16,
        'font-lg' => 20,
        'font-xl' => 24,

    ],

    'fonts' => [
        'default' => 'Geist+Pixel-Regular',
        'accent' => 'Lobster-Regular',

        // Theme Lab display faces.
        'display' => 'Unbounded-Bold',
        'grotesk' => 'SpaceGrotesk-Regular',
        'grotesk-bold' => 'SpaceGrotesk-Bold',
    ],

];
