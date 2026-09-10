<?php

use App\NativeComponents\EdgeComponents\BottomNav;
use App\NativeComponents\EdgeComponents\BottomNavSearchItem;
use App\NativeComponents\EdgeComponents\SideNav;
use App\NativeComponents\EdgeComponents\SideNavHeaderImage;
use App\NativeComponents\EdgeComponents\TopBar;
use App\NativeComponents\EdgeComponents\TopBarDestructiveAction;
use App\NativeComponents\EdgeComponents\TopBarLargeTitle;
use App\NativeComponents\EdgeComponents\TopBarLogo;
use App\NativeComponents\EdgeComponents\TopBarSearch;
use Native\Mobile\Testing\Native;

it('renders a top bar with a subtitle, two actions, and a back chevron', function () {
    Native::visit('/edge-components/top-bar')
        ->assertScreen(TopBar::class)
        ->assertNavTitle('Dashboard')
        ->assertSee('Welcome back')
        ->assertElement('top_bar_action', fn (array $node): bool => ($node['props']['id'] ?? null) === 'search')
        ->assertElement('top_bar_action', fn (array $node): bool => ($node['props']['id'] ?? null) === 'settings')
        ->assertElement('native_root_stack', fn (array $node): bool => $node['props']['back'] ?? false);
});

it('renders a top bar with the large-title display mode and a back chevron', function () {
    Native::visit('/edge-components/top-bar-large-title')
        ->assertScreen(TopBarLargeTitle::class)
        ->assertNavTitle('Dashboard')
        ->assertElement('native_root_stack', fn (array $node): bool => ($node['props']['display_mode'] ?? null) === 'large'
            && ($node['props']['back'] ?? false));
});

it('renders a top bar with an inline search field and a back chevron', function () {
    Native::visit('/edge-components/top-bar-search')
        ->assertScreen(TopBarSearch::class)
        ->assertElement('native_root_stack', fn (array $node): bool => ($node['props']['scroll_behavior'] ?? null) === 'pinned'
            && ($node['props']['search_placeholder'] ?? null) === 'Search'
            && ($node['props']['back'] ?? false));
});

it('renders a top bar with a destructive action and a back chevron', function () {
    Native::visit('/edge-components/top-bar-destructive-action')
        ->assertScreen(TopBarDestructiveAction::class)
        ->assertNavTitle('Conversation')
        ->assertElement('top_bar_action', fn (array $node): bool => $node['props']['destructive'] ?? false)
        ->assertElement('native_root_stack', fn (array $node): bool => $node['props']['back'] ?? false);
});

it('renders a top bar with a logo in the title slot and a back chevron', function () {
    Native::visit('/edge-components/top-bar-logo')
        ->assertScreen(TopBarLogo::class)
        ->assertElement('top_bar_title')
        ->assertElement('image', fn (array $node): bool => ($node['props']['src'] ?? null) === 'https://nativephp.com/favicon.svg')
        ->assertElement('native_root_stack', fn (array $node): bool => $node['props']['back'] ?? false)
        ->assertMissingElement('top_bar_action');
});

it('renders a bottom nav with active, news, and badge items', function () {
    Native::visit('/edge-components/bottom-nav')
        ->assertScreen(BottomNav::class)
        ->assertNavTitle('Bottom Nav')
        ->assertElement('bottom_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'home'
            && ($node['props']['active'] ?? false))
        ->assertElement('bottom_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'friends'
            && ($node['props']['news'] ?? false))
        ->assertElement('bottom_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'profile'
            && ($node['props']['badge'] ?? null) === '3');
});

it('renders a bottom nav with a search tab item', function () {
    Native::visit('/edge-components/bottom-nav-search-item')
        ->assertScreen(BottomNavSearchItem::class)
        ->assertElement('bottom_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'home'
            && ($node['props']['active'] ?? false))
        ->assertElement('bottom_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'search'
            && ($node['props']['search'] ?? false)
            && ($node['props']['search_placeholder'] ?? null) === 'Search')
        ->assertElement('bottom_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'profile');
});

it('renders a side nav drawer with a header, an active item, a collapsed group, and a divider', function () {
    Native::visit('/edge-components/side-nav')
        ->assertScreen(SideNav::class)
        ->assertNavTitle('Side Nav')
        ->assertElement('side_nav_header', fn (array $node): bool => ($node['props']['title'] ?? null) === 'My App'
            && ($node['props']['subtitle'] ?? null) === 'user@example.com'
            && ($node['props']['icon'] ?? null) === 'person')
        ->assertElement('side_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'home'
            && ($node['props']['active'] ?? false))
        ->assertElement('side_nav_group', fn (array $node): bool => ($node['props']['heading'] ?? null) === 'Account'
            && ! ($node['props']['expanded'] ?? true))
        ->assertElement('side_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'profile')
        ->assertElement('side_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'settings')
        ->assertElement('divider')
        ->assertElement('side_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'help'
            && ($node['props']['url'] ?? null) === 'https://nativephp.com/docs'
            && ($node['props']['open_in_browser'] ?? false));
});

it('renders a side nav header with a background image', function () {
    Native::visit('/edge-components/side-nav-header-image')
        ->assertScreen(SideNavHeaderImage::class)
        ->assertElement('side_nav_header', fn (array $node): bool => ($node['props']['image_url'] ?? null)
            === 'https://images.nationalgeographic.org/image/upload/v1638892520/EducationHub/photos/stream-in-colorado.jpg')
        ->assertElement('side_nav_item', fn (array $node): bool => ($node['props']['id'] ?? null) === 'home'
            && ($node['props']['active'] ?? false));
});
