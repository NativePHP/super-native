<?php

use App\NativeComponents\Browse;
use App\NativeComponents\ComposeTweet;
use App\NativeComponents\Counter;
use App\NativeComponents\DemoLauncher;
use App\NativeComponents\ExploreButtons;
use App\NativeComponents\ExploreCards;
use App\NativeComponents\ExploreForms;
use App\NativeComponents\ExploreIcons;
use App\NativeComponents\ExploreLayout;
use App\NativeComponents\ExploreTypography;
use App\NativeComponents\FacebookCreate;
use App\NativeComponents\FacebookFeed;
use App\NativeComponents\FacebookPost;
use App\NativeComponents\FacebookProfile;
use App\NativeComponents\Home;
use App\NativeComponents\IkeaCart;
use App\NativeComponents\IkeaHome;
use App\NativeComponents\IkeaProduct;
use App\NativeComponents\IkeaSearch;
use App\NativeComponents\InstagramFeed;
use App\NativeComponents\InstagramPost;
use App\NativeComponents\InstagramProfile;
use App\NativeComponents\InstagramSearch;
use App\NativeComponents\ItemDetail;
use App\NativeComponents\Layouts\StackLayout;
use App\NativeComponents\Layouts\TabsLayout;
use App\NativeComponents\Profile;
use App\NativeComponents\SpotifyArtist;
use App\NativeComponents\SpotifyHome;
use App\NativeComponents\SpotifyPlaylist;
use App\NativeComponents\SpotifySearch;
use App\NativeComponents\TweetDetail;
use App\NativeComponents\TwitterFeed;
use App\NativeComponents\TwitterProfile;
use App\NativeComponents\YouTubeChannel;
use App\NativeComponents\YouTubeHome;
use App\NativeComponents\YouTubeSearch;
use App\NativeComponents\YouTubeVideo;
use Illuminate\Support\Facades\Route;
use Native\Mobile\Edge\BenchmarkComponent;

// ── Demo launcher (root) ──
Route::native('/', DemoLauncher::class)->name('demos');

// ── Layout demo (Tabs) ──
Route::nativeGroup(TabsLayout::class, function () {
    Route::native('/tabs/browse', Browse::class)->name('browse');
    Route::native('/tabs/profile', Profile::class)->name('profile');
});

// ── Layout demo: pushed detail (Stack with auto-back) ──
Route::native('/item/{id}', ItemDetail::class)
    ->layout(StackLayout::class)
    ->name('item.detail');

// ── Demo HOME routes — get a back-arrow TopBar via StackLayout ──
Route::nativeGroup(StackLayout::class, function () {
    Route::native('/tabs', Home::class)->name('home');

    // Component showcases (broken out from explore)
    Route::native('/explore/buttons', ExploreButtons::class)->name('explore.buttons');
    Route::native('/explore/forms', ExploreForms::class)->name('explore.forms');
    Route::native('/explore/typography', ExploreTypography::class)->name('explore.typography');
    Route::native('/explore/cards', ExploreCards::class)->name('explore.cards');
    Route::native('/explore/icons', ExploreIcons::class)->name('explore.icons');
    Route::native('/explore/layout', ExploreLayout::class)->name('explore.layout');

    // Mini app demos
    Route::native('/twitter', TwitterFeed::class)->name('twitter.feed');
    Route::native('/ikea', IkeaHome::class)->name('ikea.home');
    Route::native('/facebook', FacebookFeed::class)->name('facebook.feed');
    Route::native('/instagram', InstagramFeed::class)->name('instagram.feed');
    Route::native('/spotify', SpotifyHome::class)->name('spotify.home');
    Route::native('/youtube', YouTubeHome::class)->name('youtube.home');
    Route::native('/counter', Counter::class)->name('counter');
});

// ── Demo INNER routes — keep their own custom blade chrome ──
// Twitter / X
Route::native('/twitter/tweet/{id}', TweetDetail::class)->name('twitter.tweet');
Route::native('/twitter/profile/{id}', TwitterProfile::class)->name('twitter.profile');
Route::native('/twitter/compose', ComposeTweet::class)->name('twitter.compose');

// IKEA
Route::native('/ikea/product/{id}', IkeaProduct::class)->name('ikea.product');
Route::native('/ikea/cart', IkeaCart::class)->name('ikea.cart');
Route::native('/ikea/search', IkeaSearch::class)->name('ikea.search');

// Facebook
Route::native('/facebook/post/{id}', FacebookPost::class)->name('facebook.post');
Route::native('/facebook/profile/{id}', FacebookProfile::class)->name('facebook.profile');
Route::native('/facebook/create', FacebookCreate::class)->name('facebook.create');

// Instagram
Route::native('/instagram/post/{id}', InstagramPost::class)->name('instagram.post');
Route::native('/instagram/profile/{id}', InstagramProfile::class)->name('instagram.profile');
Route::native('/instagram/search', InstagramSearch::class)->name('instagram.search');

// Spotify
Route::native('/spotify/playlist/{id}', SpotifyPlaylist::class)->name('spotify.playlist');
Route::native('/spotify/artist/{id}', SpotifyArtist::class)->name('spotify.artist');
Route::native('/spotify/search', SpotifySearch::class)->name('spotify.search');

// YouTube
Route::native('/youtube/video/{id}', YouTubeVideo::class)->name('youtube.video');
Route::native('/youtube/channel/{id}', YouTubeChannel::class)->name('youtube.channel');
Route::native('/youtube/search', YouTubeSearch::class)->name('youtube.search');

// ── Extras ──
Route::native('/benchmark', BenchmarkComponent::class)->name('benchmark');
