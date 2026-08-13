<?php

namespace App;

/**
 * The one list of demos in this app.
 *
 * It used to be a private property of [NativeComponents\DemoLauncher], which was
 * fine while the launcher screen was the only thing that needed to know what
 * demos exist. Desktop's permanent sidebar needs the same list — same titles,
 * same grouping, same order — and a second copy of 41 entries in
 * `routes/desktop.php` is a copy that drifts: a demo added to one and not the
 * other is a demo that exists on one platform.
 *
 * Not derived from the screen registry, though every one of these paths is in
 * it. The registry knows a path maps to a component class and nothing else —
 * no display name, no grouping, no order, and no idea that `/tabs/browse` is a
 * sub-screen of a demo rather than a demo. Those are editorial facts about how
 * this app wants to present itself, so they are written down here, and the
 * registry stays the mechanical index it is.
 */
class Demos
{
    /**
     * Every demo, in sections, in the order they should be shown.
     *
     * @return array<int, array{title: string, demos: array<int, array<string, string>>}>
     */
    public static function groups(): array
    {
        return [
            [
                'title' => 'Fundamentals',
                'demos' => [
                    ['id' => 'counter', 'title' => 'Counter', 'subtitle' => 'Minimal Livewire-style counter', 'icon' => 'add', 'color' => '#10B981', 'url' => '/counter'],
                    ['id' => 'typography', 'title' => 'Typography & Colors', 'subtitle' => 'Sizes, theme tokens, tailwind palette', 'icon' => 'textformat.alt', 'color' => '#A855F7', 'url' => '/explore/typography'],
                    ['id' => 'buttons', 'title' => 'Buttons', 'subtitle' => 'Variants, sizes, icons, states, pressable', 'icon' => 'square.and.pencil', 'color' => '#0EA5E9', 'url' => '/explore/buttons'],
                    ['id' => 'buttonsform', 'title' => 'Buttons (Form)', 'subtitle' => 'Variants, sizes, extras in a NavigationStack + grouped form', 'icon' => 'list.bullet.rectangle', 'color' => '#0EA5E9', 'url' => '/buttons-form'],
                    ['id' => 'icons', 'title' => 'Icons', 'subtitle' => 'IconHelper catalog + direct SF Symbols', 'icon' => 'star.fill', 'color' => '#EC4899', 'url' => '/explore/icons'],
                    ['id' => 'layout', 'title' => 'Layout & Canvas', 'subtitle' => 'Flex, stack, canvas shapes, activity indicator', 'icon' => 'rectangle.3.group', 'color' => '#6366F1', 'url' => '/explore/layout'],
                ],
            ],
            [
                'title' => 'Components & Patterns',
                'demos' => [
                    ['id' => 'cards', 'title' => 'Cards & Chips', 'subtitle' => 'Card variants, chips, badges, list items', 'icon' => 'rectangle.stack.fill', 'color' => '#F59E0B', 'url' => '/explore/cards'],
                    ['id' => 'forms', 'title' => 'Slider', 'subtitle' => 'Text input, slider, toggle, checkbox, select, radio', 'icon' => 'square.text.square', 'color' => '#10B981', 'url' => '/explore/forms'],
                    ['id' => 'sheets', 'title' => 'Sheets & Modals', 'subtitle' => 'Bottom-sheet detents, dismissible + blocking modals', 'icon' => 'square.on.square', 'color' => '#A855F7', 'url' => '/explore/sheets'],
                    ['id' => 'menus', 'title' => 'Menus', 'subtitle' => 'Tap-to-open dropdowns on Pressable, Button, ListItem.trailing', 'icon' => 'ellipsis.circle', 'color' => '#0891B2', 'url' => '/explore/menus'],
                    ['id' => 'mail', 'title' => 'Mail Inbox', 'subtitle' => 'Pull-to-refresh + leading/trailing swipe actions', 'icon' => 'envelope.fill', 'color' => '#0EA5E9', 'url' => '/mail-demo'],
                    ['id' => 'refresh', 'title' => 'Pull to refresh', 'subtitle' => 'Native pull-to-refresh on custom card content', 'icon' => 'arrow.clockwise', 'color' => '#10B981', 'url' => '/refreshable-demo'],
                    ['id' => 'reactivity', 'title' => 'Reactivity', 'subtitle' => '#[Computed], #[Poll] and #[Lazy] placeholder in one screen', 'icon' => 'bolt.fill', 'color' => '#8B5CF6', 'url' => '/reactivity'],
                    ['id' => 'webview', 'title' => 'Webview', 'subtitle' => 'Embedded web content — remote URL + inline HTML, @navigated events', 'icon' => 'globe', 'color' => '#3B82F6', 'url' => '/webview-demo'],
                    ['id' => 'accordion', 'title' => 'Accordion', 'subtitle' => 'Disclosure groups — uncontrolled, PHP-controlled, rich content', 'icon' => 'chevron.down.circle', 'color' => '#F43F5E', 'url' => '/accordion-demo'],
                    ['id' => 'live-code', 'title' => 'Live Code', 'subtitle' => 'Prompt Claude for PHP, write it to disk, run it on the next render', 'icon' => 'chevron.left.forwardslash.chevron.right', 'color' => '#22C55E', 'url' => '/live-code'],
                    //                ['id' => 'eventchannel', 'title' => 'Event Channel Test', 'subtitle' => 'Native → PHP payload > 4KB (growable event buffer)', 'icon' => 'arrow.up.arrow.down', 'color' => '#EF4444', 'url' => '/event-channel-test'],
                    //                ['id' => 'vibe', 'title' => 'Vibe — Live Events', 'subtitle' => 'Websocket broadcast events (Vask/Reverb) into a component', 'icon' => 'antenna.radiowaves.left.and.right', 'color' => '#22C55E', 'url' => '/vibe'],
                    //                ['id' => 'vibe-private', 'title' => 'Vibe — Private Channel', 'subtitle' => 'Authenticated private-channel subscription (bearer + /broadcasting/auth)', 'icon' => 'lock.fill', 'color' => '#16A34A', 'url' => '/vibe-private'],
                    //                ['id' => 'vibe-presence', 'title' => 'Vibe — Presence', 'subtitle' => 'Who\'s online + live join/leave (here/joining/leaving)', 'icon' => 'person.2.fill', 'color' => '#15803D', 'url' => '/vibe-presence'],
                    //                ['id' => 'geo-watch', 'title' => 'Geo — Watch Position', 'subtitle' => 'Streaming GPS fixes (watchPosition/clearWatch)', 'icon' => 'location.fill', 'color' => '#F97316', 'url' => '/geo-watch'],
                ],
            ],
            [
                'title' => 'Motion & Chrome',
                'demos' => [
                    ['id' => 'gestures', 'title' => 'Gestures', 'subtitle' => 'Double-tap (@doubleTap) ', 'icon' => 'hand.tap.fill', 'color' => '#6366F1', 'url' => '/gestures'],
                    ['id' => 'transitions', 'title' => 'Page Transitions', 'subtitle' => 'Fade, slide, scale - every @navigate animation', 'icon' => 'arrow.left.arrow.right', 'color' => '#14B8A6', 'url' => '/transitions'],
                    ['id' => 'animate', 'title' => 'Animations', 'subtitle' => 'Awesome native animations', 'icon' => 'sparkles', 'color' => '#F59E0B', 'url' => '/animate'],
                    ['id' => 'numberswitcher', 'title' => 'Number Switcher', 'subtitle' => 'content-transition — rolling in-place digit changes', 'icon' => 'textformat.123', 'color' => '#14B8A6', 'url' => '/number-switcher'],
                    //                ['id' => 'glass', 'title' => 'Glass', 'subtitle' => 'Liquid Glass Demo', 'icon' => 'drop.fill', 'color' => '#0EA5E9', 'url' => '/glass'],
                    ['id' => 'nativetabs', 'title' => 'Native Tabs', 'subtitle' => 'TabView-rendered bottom bar; Liquid Glass on iOS 26+', 'icon' => 'rectangle.split.3x1', 'color' => '#A855F7', 'url' => '/native-tabs'],
                    ['id' => 'drawer', 'title' => 'Side Drawer', 'subtitle' => 'X-style slide-out nav — modal + reveal, declared once on the layout', 'icon' => 'line.3.horizontal', 'color' => '#6366F1', 'url' => '/drawer'],
                    ['id' => 'syncupnative', 'title' => 'SyncUp Messaging', 'subtitle' => 'Login, chat threads, friends, profile (5 screens) — custom chrome', 'icon' => 'bubble.left.fill', 'color' => '#0891b2', 'url' => '/syncup-native'],
                ],
            ],
            [
                'title' => 'Mini Apps',
                'demos' => [
                    ['id' => 'tabs', 'title' => 'Search Demo', 'subtitle' => 'TabsLayout + StackLayout (Home / Browse / Profile + push detail)', 'icon' => 'dashboard', 'color' => '#6366F1', 'url' => '/tabs'],
                    ['id' => 'twitter', 'title' => 'Twitter / X', 'subtitle' => 'Feed, tweet detail, profile, compose', 'icon' => 'bubble.left.and.bubble.right.fill', 'color' => '#1D9BF0', 'url' => '/twitter'],
                    ['id' => 'ikea', 'title' => 'IKEA', 'subtitle' => 'Home, product detail, cart, search', 'icon' => 'bed.double.fill', 'color' => '#0058A3', 'url' => '/ikea'],
                    ['id' => 'facebook', 'title' => 'Facebook', 'subtitle' => 'Feed, post, profile, create', 'icon' => 'person.2.fill', 'color' => '#1877F2', 'url' => '/facebook'],
                    ['id' => 'instagram', 'title' => 'Instagram', 'subtitle' => 'Feed, post, profile, search', 'icon' => 'camera', 'color' => '#E1306C', 'url' => '/instagram'],
                    ['id' => 'spotify', 'title' => 'Spotify', 'subtitle' => 'Home, playlist, artist, search', 'icon' => 'music.note', 'color' => '#1DB954', 'url' => '/spotify'],
                    ['id' => 'youtube', 'title' => 'YouTube', 'subtitle' => 'Home, video, channel, search', 'icon' => 'play.rectangle.fill', 'color' => '#FF0000', 'url' => '/youtube'],
                ],
            ],
        ];
    }

    /**
     * The desktop-only screens, which are not demos of the element layer and so
     * are not in [groups] — but are still windows a developer wants to reach.
     * The sidebar shows them under their own heading.
     *
     * @return array<int, array<string, string>>
     */
    public static function desktopScreens(): array
    {
        return [
            ['title' => 'Dashboard', 'icon' => 'square.grid.2x2', 'url' => '/desktop'],
            ['title' => 'Settings', 'icon' => 'gearshape', 'url' => '/settings'],
            ['title' => 'Renderer batch 1', 'icon' => 'rectangle.3.group', 'url' => '/renderer-batch1'],
        ];
    }
}
