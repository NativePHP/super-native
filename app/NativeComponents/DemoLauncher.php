<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

/**
 * Top-level launcher screen — lists every demo app in the project.
 * Tapping a row pushes that demo onto the navigation stack; the framework
 * TopBar (via StackLayout) provides a back chevron to return here.
 */
class DemoLauncher extends NativeComponent
{
    public array $demos = [
        // ── Component showcases (broken out from explore) ──
        ['id' => 'buttons',    'title' => 'Buttons',           'subtitle' => 'Variants, sizes, icons, states, pressable',           'icon' => 'square.and.pencil',  'color' => '#0EA5E9', 'url' => '/explore/buttons'],
        ['id' => 'forms',      'title' => 'Forms',             'subtitle' => 'Text input, slider, toggle, checkbox, select, radio', 'icon' => 'square.text.square', 'color' => '#10B981', 'url' => '/explore/forms'],
        ['id' => 'typography', 'title' => 'Typography & Colors', 'subtitle' => 'Sizes, theme tokens, tailwind palette',             'icon' => 'textformat.alt',     'color' => '#A855F7', 'url' => '/explore/typography'],
        ['id' => 'cards',      'title' => 'Cards & Chips',     'subtitle' => 'Card variants, chips, badges, list items',            'icon' => 'rectangle.stack.fill','color' => '#F59E0B', 'url' => '/explore/cards'],
        ['id' => 'icons',      'title' => 'Icons',             'subtitle' => 'IconHelper catalog + direct SF Symbols',              'icon' => 'star.fill',          'color' => '#EC4899', 'url' => '/explore/icons'],
        ['id' => 'layout',     'title' => 'Layout & Canvas',   'subtitle' => 'Flex, stack, canvas shapes, activity indicator',      'icon' => 'rectangle.3.group',  'color' => '#6366F1', 'url' => '/explore/layout'],

        // ── Mini app demos ──
        ['id' => 'tabs',      'title' => 'Layout Demo',      'subtitle' => 'TabsLayout + StackLayout (Home / Browse / Profile + push detail)', 'icon' => 'dashboard',          'color' => '#6366F1', 'url' => '/tabs'],
        ['id' => 'twitter',   'title' => 'Twitter / X',      'subtitle' => 'Feed, tweet detail, profile, compose',                              'icon' => 'chat_bubble',        'color' => '#1D9BF0', 'url' => '/twitter'],
        ['id' => 'ikea',      'title' => 'IKEA',             'subtitle' => 'Home, product detail, cart, search',                                'icon' => 'bed.double.fill',    'color' => '#0058A3', 'url' => '/ikea'],
        ['id' => 'facebook',  'title' => 'Facebook',         'subtitle' => 'Feed, post, profile, create',                                       'icon' => 'person.2.fill',      'color' => '#1877F2', 'url' => '/facebook'],
        ['id' => 'instagram', 'title' => 'Instagram',        'subtitle' => 'Feed, post, profile, search',                                       'icon' => 'camera',             'color' => '#E1306C', 'url' => '/instagram'],
        ['id' => 'spotify',   'title' => 'Spotify',          'subtitle' => 'Home, playlist, artist, search',                                    'icon' => 'music.note',         'color' => '#1DB954', 'url' => '/spotify'],
        ['id' => 'youtube',   'title' => 'YouTube',          'subtitle' => 'Home, video, channel, search',                                      'icon' => 'play.rectangle.fill','color' => '#FF0000', 'url' => '/youtube'],
        ['id' => 'counter',   'title' => 'Counter',          'subtitle' => 'Minimal Livewire-style counter',                                    'icon' => 'add',                'color' => '#10B981', 'url' => '/counter'],
//        ['id' => 'benchmark', 'title' => 'Benchmark',        'subtitle' => 'Render perf benchmarks',                                            'icon' => 'bolt',               'color' => '#F59E0B', 'url' => '/benchmark'],
    ];

    public function navTitle(): string
    {
        return 'NativePHP Demos';
    }

    public function render(): Element
    {
        return $this->view('demo-launcher');
    }
}
