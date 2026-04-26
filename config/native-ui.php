<?php

/**
 * Native UI — Theme Tokens
 *
 * Published via `php artisan vendor:publish --tag=native-ui-config`.
 * Edit to customize your app's visual identity in one place.
 *
 * For dynamic per-tenant theming, use Nativephp\NativeUi\Theme::merge([...])
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

        'light' => [
            // Primary brand color — used for filled buttons, active states, key accents.
            'primary'       => '#02f54f',
            'on-primary'    => '#FFFFFF',

            // Secondary / muted action color.
            'secondary'     => '#52de7e',
            'on-secondary'  => '#FFFFFF',

            // Surface = cards, sheets, dialogs. Background = page root.
            'surface'       => '#FFFFFF',
            'on-surface'    => '#000000',
            'background'    => '#FFFFFF',
            'on-background' => '#000000',

            // Destructive / error actions and messages.
            'destructive'         => '#DC2626',
            'on-destructive'      => '#FFFFFF',

            // Tertiary accent — for highlights, badges, emphasis not covered by primary.
            'accent'        => '#FB923C',
            'on-accent'     => '#FFFFFF',
        ],

        'dark' => [
            // Leave empty or partial to auto-derive from `light` (luminance inversion).
            // Specify any token here to override the derived value.
            'primary'       => '#6617cf',
            'on-primary'    => '#FFFFFF',

            'secondary'     => '#e1fa02',
            'on-secondary'  => '#000000',

            'surface'       => '#1E293B',
            'on-surface'    => '#d3fc05',
            'background'    => '#000000',
            'on-background' => '#FFFFFF',

            'destructive'         => '#cf1729',
            'on-destructive'      => '#FFFFFF',

            'accent'        => '#FDBA74',
            'on-accent'     => '#0F172A',
        ],

        // Corner radii (points / dp).
        'radius-sm'   => 4,
        'radius-md'   => 8,
        'radius-lg'   => 16,
        'radius-full' => 9999,

        // Font size scale (points / sp).
        'font-sm' => 14,
        'font-md' => 16,
        'font-lg' => 20,
        'font-xl' => 24,

        // 'System' resolves to the platform default (San Francisco on iOS, Roboto on Android).
        // Use a specific family name to load a custom font.
        'font-family' => 'System',
    ],

];
