<?php

use Native\Mobile\Testing\Native;

/**
 * Smoke test — every static demo screen mounts and publishes a wire tree
 * without throwing. Screens with bridge-driven mounts (vibe, geo) or
 * deliberately slow mounts (reactivity's #[Lazy] sleep) have their own tests.
 */
it('renders the demo screen without errors', function (string $uri) {
    expect(Native::visit($uri)->tree())->not->toBeEmpty();
})->with([
    'demo launcher' => '/',
    'counter' => '/counter',
    'typography' => '/explore/typography',
    'buttons' => '/explore/buttons',
    'buttons form' => '/buttons-form',
    'icons' => '/explore/icons',
    'layout' => '/explore/layout',
    'cards' => '/explore/cards',
    'forms' => '/explore/forms',
    'sheets' => '/explore/sheets',
    'menus' => '/explore/menus',
    'mail inbox' => '/mail-demo',
    'pull to refresh' => '/refreshable-demo',
    'webview' => '/webview-demo',
    'number switcher' => '/number-switcher',
    'gestures' => '/gestures',
    'transitions' => '/transitions',
    'glass' => '/glass',
    'event channel' => '/event-channel-test',
    'twitter feed' => '/twitter',
    'twitter profile' => '/twitter/profile/0',
    'tweet detail' => '/twitter/tweet/0',
    'twitter compose' => '/twitter/compose',
    'instagram feed' => '/instagram',
    'instagram post' => '/instagram/post/0',
    'instagram profile' => '/instagram/profile/0',
    'instagram search' => '/instagram/search',
    'facebook feed' => '/facebook',
    'facebook post' => '/facebook/post/0',
    'facebook profile' => '/facebook/profile/0',
    'facebook create' => '/facebook/create',
    'syncup chats' => '/syncup-native',
    'syncup login' => '/syncup-native/login',
    'syncup friends' => '/syncup-native/friends',
    'syncup profile' => '/syncup-native/profile',
]);
