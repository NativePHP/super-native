<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;

/**
 * Top-level launcher screen — lists every demo app in the project.
 * Tapping a row pushes that demo onto the navigation stack; the framework
 * TopBar (via StackLayout) provides a back chevron to return here.
 */
class DemoLauncher extends NativeComponent
{
    /**
     * Immutable master list of every demo, organised into logical sections.
     * Never mutated — searching filters a copy of this into [$groups], so
     * clearing the query restores the full set. Each group is
     * `['title' => string, 'demos' => array<int, array<string, string>>]`
     * and renders as a `<list-section>` in the view.
     *
     * @var array<int, array{title: string, demos: array<int, array<string, string>>}>
     */
    private array $allGroups = [
        [
            'title' => 'Fundamentals',
            'demos' => [
                ['id' => 'counter', 'title' => 'Counter', 'subtitle' => 'Minimal Livewire-style counter', 'icon' => 'add', 'color' => '#10B981', 'url' => '/counter'],
                ['id' => 'forms', 'title' => 'Slider', 'subtitle' => 'Text input, slider, toggle, checkbox, select, radio', 'icon' => 'square.text.square', 'color' => '#10B981', 'url' => '/explore/forms'],
                ['id' => 'selection', 'title' => 'Caret & Selection', 'subtitle' => '@selectionChange: caret tracking, mention typeahead, secure suppression', 'icon' => 'cursorarrow.and.square.on.square.dashed', 'color' => '#14B8A6', 'url' => '/selection'],
                ['id' => 'platformicons', 'title' => 'Platform Icons', 'subtitle' => 'ios-icon / android-icon on Button, Chip, Tab + height parity', 'icon' => 'apps.iphone', 'color' => '#F97316', 'url' => '/platform-icons'],
                ['id' => 'accordion', 'title' => 'Accordion', 'subtitle' => 'Expand/collapse sections, two-way expanded binding, custom headers', 'icon' => 'chevron.down.circle', 'color' => '#22C55E', 'url' => '/accordion'],
                ['id' => 'typography', 'title' => 'Typography & Colors', 'subtitle' => 'Sizes, theme tokens, tailwind palette', 'icon' => 'textformat.alt', 'color' => '#A855F7', 'url' => '/explore/typography'],
                ['id' => 'themelab', 'title' => 'Theme Lab', 'subtitle' => 'Design tokens, opacity ramps, variants, font aliases — live in light & dark', 'icon' => 'paintpalette.fill', 'color' => '#8B5CF6', 'url' => '/theme-lab'],
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
                ['id' => 'pickers', 'title' => 'Date & Time Pickers', 'subtitle' => 'Date/time/datetime, bounds, timezones, locales, inline & wheel', 'icon' => 'calendar', 'color' => '#F43F5E', 'url' => '/explore/pickers'],
                ['id' => 'sheets', 'title' => 'Sheets & Modals', 'subtitle' => 'Bottom-sheet detents, dismissible + blocking modals', 'icon' => 'square.on.square', 'color' => '#A855F7', 'url' => '/explore/sheets'],
                ['id' => 'panelab', 'title' => 'Pane Lab', 'subtitle' => 'Sheet pane detents, permanent sheet, background layer, zero-inset anchors', 'icon' => 'map.fill', 'color' => '#06B6D4', 'url' => '/pane-lab'],
                ['id' => 'menus', 'title' => 'Menus', 'subtitle' => 'Tap-to-open dropdowns on Pressable, Button, ListItem.trailing', 'icon' => 'ellipsis.circle', 'color' => '#0891B2', 'url' => '/explore/menus'],
                ['id' => 'mail', 'title' => 'Mail Inbox', 'subtitle' => 'Pull-to-refresh + leading/trailing swipe actions', 'icon' => 'envelope.fill', 'color' => '#0EA5E9', 'url' => '/mail-demo'],
                ['id' => 'refresh', 'title' => 'Pull to refresh', 'subtitle' => 'Native pull-to-refresh on custom card content', 'icon' => 'arrow.clockwise', 'color' => '#10B981', 'url' => '/refreshable-demo'],
                ['id' => 'reactivity', 'title' => 'Reactivity', 'subtitle' => '#[Computed], #[Poll] and #[Lazy] placeholder in one screen', 'icon' => 'bolt.fill', 'color' => '#8B5CF6', 'url' => '/reactivity'],
                ['id' => 'webview', 'title' => 'Webview', 'subtitle' => 'Embedded web content — remote URL + inline HTML, @navigated events', 'icon' => 'globe', 'color' => '#3B82F6', 'url' => '/webview-demo'],
            ],
        ],
        [
            'title' => 'Motion & Chrome',
            'demos' => [
                ['id' => 'gestures', 'title' => 'Gestures', 'subtitle' => 'Double-tap (@doubleTap) ', 'icon' => 'hand.tap.fill', 'color' => '#6366F1', 'url' => '/gestures'],
                ['id' => 'gamepad', 'title' => 'Game Pad', 'subtitle' => 'Held-press d-pad, auto-fire + shield (@tapDown / @tapUp)', 'icon' => 'gamecontroller.fill', 'color' => '#22C55E', 'url' => '/game-pad'],
                ['id' => 'transitions', 'title' => 'Page Transitions', 'subtitle' => 'Fade, slide, scale - every @navigate animation', 'icon' => 'arrow.left.arrow.right', 'color' => '#14B8A6', 'url' => '/transitions'],
                ['id' => 'animate', 'title' => 'Animations', 'subtitle' => 'Awesome native animations', 'icon' => 'sparkles', 'color' => '#F59E0B', 'url' => '/animate'],
                ['id' => 'numberswitcher', 'title' => 'Number Switcher', 'subtitle' => 'content-transition — rolling in-place digit changes', 'icon' => 'textformat.123', 'color' => '#14B8A6', 'url' => '/number-switcher'],
            ],
        ],
        [
            'title' => 'Masterclass Fixes',
            'demos' => [
                ['id' => 'mc309', 'title' => '#309 · items-start vs items-stretch', 'subtitle' => 'Explicit start moved to wire value 4 so UNSET (0) keeps each platform default', 'icon' => 'align.horizontal.left.fill', 'color' => '#F43F5E', 'url' => '/masterclass/align-items'],
                ['id' => 'mc310', 'title' => '#310 · max-w-*', 'subtitle' => 'Dropped in the parser, the collector and both renderers — wire already had the fields', 'icon' => 'arrow.left.and.right.square', 'color' => '#0EA5E9', 'url' => '/masterclass/max-width'],
                ['id' => 'mc311', 'title' => '#311 · Per-corner radius', 'subtitle' => 'rounded-br-none etc. now ride the prop bag — one border_radius float, four corners', 'icon' => 'square.on.circle', 'color' => '#8B5CF6', 'url' => '/masterclass/corner-radius'],
                ['id' => 'mc304', 'title' => '#304 · Autocapitalization', 'subtitle' => 'keyboardType sets the key layout only — capitalization now derives from it', 'icon' => 'textformat.abc', 'color' => '#F59E0B', 'url' => '/masterclass/autocapitalize'],
                ['id' => 'mc308', 'title' => '#308 · Keyboard dismiss (chrome)', 'subtitle' => 'Tap-to-dismiss was only attached to chrome-less roots — stack/tabs never got it', 'icon' => 'keyboard.chevron.compact.down', 'color' => '#14B8A6', 'url' => '/masterclass/keyboard-dismiss'],
                ['id' => 'mc308b', 'title' => '#308 · Keyboard dismiss (no chrome)', 'subtitle' => 'The control — same screen outside the stack layout, always worked', 'icon' => 'keyboard', 'color' => '#64748B', 'url' => '/masterclass/keyboard-dismiss-plain'],
                ['id' => 'mc303', 'title' => '#303 · Centering in scroll-view', 'subtitle' => 'Scroll content is measured unbounded, so fill had nothing to fill — min-height: 100%', 'icon' => 'arrow.up.and.down.square', 'color' => '#EC4899', 'url' => '/masterclass/scroll-center'],
                ['id' => 'mc303b', 'title' => '#303 · Centred login (full screen)', 'subtitle' => 'The realistic case from the issue — centred, still scrolls with the keyboard up', 'icon' => 'person.crop.circle', 'color' => '#DB2777', 'url' => '/masterclass/scroll-center-login'],
            ],
        ],
        [
            'title' => 'Mini Apps',
            'demos' => [
                ['id' => 'twitter', 'title' => 'Twitter / X', 'subtitle' => 'Feed, tweet detail, profile, compose', 'icon' => 'bubble.left.and.bubble.right.fill', 'color' => '#1D9BF0', 'url' => '/twitter'],
                ['id' => 'facebook', 'title' => 'Facebook', 'subtitle' => 'Feed, post, profile, create', 'icon' => 'person.2.fill', 'color' => '#1877F2', 'url' => '/facebook'],
                ['id' => 'instagram', 'title' => 'Instagram', 'subtitle' => 'Feed, post, profile, search', 'icon' => 'camera', 'color' => '#E1306C', 'url' => '/instagram'],
                ['id' => 'spotify', 'title' => 'Spotify', 'subtitle' => 'Home, playlist, artist, search', 'icon' => 'music.note', 'color' => '#1DB954', 'url' => '/spotify'],
                ['id' => 'youtube', 'title' => 'YouTube', 'subtitle' => 'Home, video, channel, search', 'icon' => 'play.rectangle.fill', 'color' => '#FF0000', 'url' => '/youtube'],
            ],
        ],
    ];

    /**
     * Displayed groups — what the view renders. Starts as the full master set
     * and is narrowed by [findADemo] (empty groups are dropped).
     *
     * @var array<int, array{title: string, demos: array<int, array<string, string>>}>
     */
    public array $groups = [];

    public function mount(): void
    {
        $this->groups = $this->allGroups;
    }

    /**
     * Returning from a pushed demo resets the native search field to empty, so
     * clear the filter to keep the list in sync with the (now blank) search bar.
     */
    public function onResume(): void
    {
        $this->groups = $this->allGroups;
    }

    public function navTitle(): string
    {
        return 'SuperNative Demo';
    }

    /** Root screen — nothing to pop back to, hide the chevron. */
    public function showsNavBack(): bool
    {
        return false;
    }

    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()
            ->displayMode('large')
            ->searchBar('Find a demo...', 'findADemo')
            ->scrollBehavior('collapse')
            ->subtitle('Tap a demo to launch');
    }

    public function findADemo($query): void
    {
        $needle = trim($query);

        if ($needle === '') {
            $this->groups = $this->allGroups;

            return;
        }

        $lower = str($needle)->lower();

        $this->groups = collect($this->allGroups)
            ->map(function ($group) use ($lower) {
                $group['demos'] = collect($group['demos'])
                    ->filter(fn ($demo) => str($demo['title'])->lower()->contains($lower))
                    ->values()
                    ->toArray();

                return $group;
            })
            ->filter(fn ($group) => count($group['demos']) > 0)
            ->values()
            ->toArray();
    }

    public function render(): View
    {
        return view('native.demo-launcher');
    }
}
