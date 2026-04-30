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
use App\NativeComponents\ExploreSheets;
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
use App\NativeComponents\Layouts\NativeStackLayout;
use App\NativeComponents\Layouts\NativeTabsLayout;
use App\NativeComponents\Layouts\StackLayout;
use App\NativeComponents\Layouts\SyncUpTabsLayout;
use App\NativeComponents\Layouts\TabsLayout;
use App\NativeComponents\NativeChromeDemo;
use App\NativeComponents\NativeChromeDetail;
use App\NativeComponents\NativeTabsHome;
use App\NativeComponents\NativeTabsProfile;
use App\NativeComponents\Profile;
use App\NativeComponents\SpotifyArtist;
use App\NativeComponents\SpotifyHome;
use App\NativeComponents\SpotifyPlaylist;
use App\NativeComponents\SpotifySearch;
use App\NativeComponents\SyncUpChat;
use App\NativeComponents\SyncUpChats;
use App\NativeComponents\SyncUpFriends;
use App\NativeComponents\SyncUpLogin;
use App\NativeComponents\SyncUpNative\Layouts\SyncUpNativeTabsLayout;
use App\NativeComponents\SyncUpNative\SyncUpNativeChat;
use App\NativeComponents\SyncUpNative\SyncUpNativeChats;
use App\NativeComponents\SyncUpNative\SyncUpNativeFriends;
use App\NativeComponents\SyncUpNative\SyncUpNativeLogin;
use App\NativeComponents\SyncUpNative\SyncUpNativeProfile;
use App\NativeComponents\SyncUpProfile;
use App\NativeComponents\TestLayout;
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
// Wrapped in NativeStackLayout so the title bar renders via SwiftUI's
// NavigationStack — fixed at the top, with Liquid Glass on iOS 26+.
Route::nativeGroup(NativeStackLayout::class, function () {
    Route::native('/', DemoLauncher::class)->name('demos');
});

// ── Layout demo (Tabs) ──
Route::nativeGroup(TabsLayout::class, function () {
    Route::native('/tabs',         Home::class)->name('home');
    Route::native('/tabs/browse',  Browse::class)->name('browse');
    Route::native('/tabs/profile', Profile::class)->name('profile');
});

// ── Layout demo: pushed detail (Stack with auto-back) ──
Route::native('/item/{id}', ItemDetail::class)
    ->layout(StackLayout::class)
    ->name('item.detail');

// ── Demo HOME routes — get a back-arrow TopBar via StackLayout ──
Route::nativeGroup(StackLayout::class, function () {
    // Component showcases (broken out from explore)
    Route::native('/explore/buttons', ExploreButtons::class)->name('explore.buttons');
    Route::native('/explore/forms', ExploreForms::class)->name('explore.forms');
    Route::native('/explore/typography', ExploreTypography::class)->name('explore.typography');
    Route::native('/explore/cards', ExploreCards::class)->name('explore.cards');
    Route::native('/explore/icons', ExploreIcons::class)->name('explore.icons');
    Route::native('/explore/layout', ExploreLayout::class)->name('explore.layout');
    Route::native('/explore/sheets', ExploreSheets::class)->name('explore.sheets');
    Route::native('/layout-test', TestLayout::class)->name('layout.test');

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

// SyncUp messaging — three tab roots share SyncUpTabsLayout; chat detail
// pushes via StackLayout; login is a chrome-less entry screen.
Route::nativeGroup(SyncUpTabsLayout::class, function () {
    Route::native('/syncup',         SyncUpChats::class)->name('syncup.chats');
    Route::native('/syncup/friends', SyncUpFriends::class)->name('syncup.friends');
    Route::native('/syncup/profile', SyncUpProfile::class)->name('syncup.profile');
});
Route::native('/syncup/chat/{id}', SyncUpChat::class)
    ->layout(StackLayout::class)
    ->name('syncup.chat');
Route::native('/syncup/login', SyncUpLogin::class)->name('syncup.login');

// SyncUp messaging (native chrome variant) — same demo running through
// SwiftUI's TabView + NavigationStack instead of the custom HStack
// chrome. Side-by-side comparison with the `/syncup/...` flow above.
Route::nativeGroup(SyncUpNativeTabsLayout::class, function () {
    Route::native('/syncup-native',         SyncUpNativeChats::class)->name('syncup-native.chats');
    Route::native('/syncup-native/friends', SyncUpNativeFriends::class)->name('syncup-native.friends');
    Route::native('/syncup-native/profile', SyncUpNativeProfile::class)->name('syncup-native.profile');
});
Route::native('/syncup-native/chat/{id}', SyncUpNativeChat::class)
    ->layout(NativeStackLayout::class)
    ->name('syncup-native.chat');
Route::native('/syncup-native/login', SyncUpNativeLogin::class)->name('syncup-native.login');

// ── Native chrome — NavigationStack-rendered top bar ──
Route::native('/native-chrome', NativeChromeDemo::class)
    ->layout(NativeStackLayout::class)
    ->name('native.chrome');
Route::native('/native-chrome/detail', NativeChromeDetail::class)
    ->layout(NativeStackLayout::class)
    ->name('native.chrome.detail');

// ── Native chrome — TabView-rendered bottom bar ──
Route::native('/native-tabs', NativeTabsHome::class)
    ->layout(NativeTabsLayout::class)
    ->name('native.tabs.home');
Route::native('/native-tabs/profile', NativeTabsProfile::class)
    ->layout(NativeTabsLayout::class)
    ->name('native.tabs.profile');

// ── Extras ──
Route::native('/benchmark', BenchmarkComponent::class)->name('benchmark');
