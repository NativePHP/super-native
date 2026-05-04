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
            'primary'       => '#00AAFF',
            'on-primary'    => '#FFFFFF',

            // Secondary / muted action color.
            'secondary'     => '#00AAFF',
            'on-secondary'  => '#FFFFFF',

            // Surface = cards, sheets, dialogs. Background = page root.
            'surface'       => '#FFFFFF',
            'on-surface'    => '#000000',
            'background'    => '#f7f7f7',
            'on-background' => '#000000',

            // Surface variant = filled text fields, muted tonal surfaces.
            // on-surface-variant = muted label/hint text on those surfaces.
            'surface-variant'    => '#F1F5F9',
            'on-surface-variant' => '#475569',

            // Outline = neutral borders (text fields, dividers, cards).
            'outline'       => '#CBD5E1',

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

            'secondary'     => '#6617cf',
            'on-secondary'  => '#FFFFFF',

            'surface'       => '#1E293B',
            'on-surface'    => '#FFFFFF',
            'background'    => '#000000',
            'on-background' => '#FFFFFF',

            'surface-variant'    => '#334155',
            'on-surface-variant' => '#94A3B8',

            'outline'       => '#475569',

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
