<?php

use App\NativeComponents\YouTubeChannel;
use App\NativeComponents\YouTubeHome;
use App\NativeComponents\YouTubeSearch;
use App\NativeComponents\YouTubeVideo;
use Native\Mobile\Testing\Native;

/**
 * Guards the four YouTube demo screens. Besides render + interaction
 * coverage, every screen is swept for the stack renderer inset trap:
 * both native stack renderers read a zero bottom/right inset as "unset"
 * and pin the child to the top/left, so an absolute overlay (duration
 * badge, corner icon) must never position itself with only zero insets.
 */
function youtubeAbsoluteNodes(string $uri): array
{
    $tree = Native::visit($uri)->tree();

    $absolutes = [];
    $walk = function (array $node) use (&$walk, &$absolutes): void {
        if (($node['layout']['position_type'] ?? 0) === 1) {
            $absolutes[] = $node;
        }
        foreach ($node['children'] ?? [] as $child) {
            $walk($child);
        }
    };
    $walk($tree);

    return $absolutes;
}

it('renders the home feed and switches categories', function () {
    Native::visit('/youtube')
        ->assertScreen(YouTubeHome::class)
        ->assertSee('Shorts')
        ->tap('Gaming')
        ->assertSet('activeCategory', 'Gaming');
});

it('renders the video page with working like, subscribe, and comments', function () {
    Native::visit('/youtube/video/0')
        ->assertScreen(YouTubeVideo::class)
        ->assertSee('Up next')
        ->press('toggleLike')
        ->assertSet('isLiked', true)
        ->press('toggleDislike')
        ->assertSet('isDisliked', true)
        ->assertSet('isLiked', false)
        ->press('toggleSubscribe')
        ->assertSet('isSubscribed', true)
        ->assertSee('Subscribed')
        ->press('toggleComments')
        ->assertSet('showComments', true)
        ->assertSee('MrBeast never disappoints with these comparisons');
});

it('renders the channel page and toggles subscribe', function () {
    Native::visit('/youtube/channel/0')
        ->assertScreen(YouTubeChannel::class)
        ->assertSee('subscribers')
        ->press('toggleSubscribe')
        ->assertSet('isSubscribed', true);
});

it('searches videos and shows feed-style results', function () {
    Native::visit('/youtube/search')
        ->assertScreen(YouTubeSearch::class)
        ->assertSee('Trending')
        ->set('query', 'iphone')
        ->press('search')
        ->assertSee('iPhone 17 Pro Review: They Finally Did It')
        ->assertSee('1 result');
});

it('navigates back from the home top bar', function () {
    Native::visit('/youtube')
        ->press('back')
        ->assertWentBack();
});

it('navigates back from the video page back button', function () {
    Native::visit('/youtube/video/0')
        ->press('back')
        ->assertWentBack();
});

it('never pins an absolute overlay with only zero insets', function (string $uri) {
    $absolutes = youtubeAbsoluteNodes($uri);

    expect($absolutes)->not->toBeEmpty();

    foreach ($absolutes as $node) {
        // position = [top, right, bottom, left]
        $position = $node['layout']['position'] ?? [0, 0, 0, 0];
        expect(array_sum(array_map('abs', $position)))->toBeGreaterThan(
            0,
            "Absolute {$node['type']} on {$uri} has all-zero insets — the stack renderers will pin it to the top-left."
        );
    }
})->with([
    '/youtube',
    '/youtube/video/0',
    '/youtube/channel/0',
    '/youtube/search',
]);
