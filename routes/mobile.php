<?php

use App\NativeComponents\Animate;
use App\NativeComponents\ButtonsForm;
use App\NativeComponents\ComposeTweet;
use App\NativeComponents\Counter;
use App\NativeComponents\DemoLauncher;
use App\NativeComponents\EdgeChildTest;
use App\NativeComponents\EventChannelTest;
use App\NativeComponents\ExploreButtons;
use App\NativeComponents\ExploreCards;
use App\NativeComponents\ExploreForms;
use App\NativeComponents\ExploreIcons;
use App\NativeComponents\ExploreLayout;
use App\NativeComponents\ExploreMenus;
use App\NativeComponents\ExplorePickers;
use App\NativeComponents\ExploreSheets;
use App\NativeComponents\ExploreTypography;
use App\NativeComponents\FacebookCreate;
use App\NativeComponents\FacebookFeed;
use App\NativeComponents\FacebookPost;
use App\NativeComponents\FacebookProfile;
use App\NativeComponents\GamePad;
use App\NativeComponents\GeoWatchDemo;
use App\NativeComponents\GestureDemo;
use App\NativeComponents\Glass;
use App\NativeComponents\Home;
use App\NativeComponents\InstagramFeed;
use App\NativeComponents\InstagramPost;
use App\NativeComponents\InstagramProfile;
use App\NativeComponents\InstagramSearch;
use App\NativeComponents\ItemDetail;
use App\NativeComponents\JustifyRepro;
use App\NativeComponents\Layouts\NativeStackLayout;
use App\NativeComponents\Layouts\StackLayout;
use App\NativeComponents\MailDemo;
use App\NativeComponents\NumberSwitcherDemo;
use App\NativeComponents\ReactivityDemo;
use App\NativeComponents\RefreshableDemo;
use App\NativeComponents\SpotifyArtist;
use App\NativeComponents\SpotifyHome;
use App\NativeComponents\SpotifyPlaylist;
use App\NativeComponents\SpotifySearch;
use App\NativeComponents\StackPositioningDemo;
use App\NativeComponents\SyncUpNative\Layouts\SyncUpNativeTabsLayout;
use App\NativeComponents\SyncUpNative\SyncUpNativeChat;
use App\NativeComponents\SyncUpNative\SyncUpNativeChats;
use App\NativeComponents\SyncUpNative\SyncUpNativeFriends;
use App\NativeComponents\SyncUpNative\SyncUpNativeLogin;
use App\NativeComponents\SyncUpNative\SyncUpNativeProfile;
use App\NativeComponents\TestLayout;
use App\NativeComponents\ThemeLab;
use App\NativeComponents\TransitionDetail;
use App\NativeComponents\TransitionsDemo;
use App\NativeComponents\TweetDetail;
use App\NativeComponents\TwitterFeed;
use App\NativeComponents\TwitterProfile;
use App\NativeComponents\WebviewDemo;
use App\NativeComponents\YouTubeChannel;
use App\NativeComponents\YouTubeHome;
use App\NativeComponents\YouTubeSearch;
use App\NativeComponents\YouTubeVideo;
use Illuminate\Support\Facades\Route;

// ── Demo launcher (root) ──
// Wrapped in NativeStackLayout so the title bar renders via SwiftUI's
// NavigationStack — fixed at the top, with Liquid Glass on iOS 26+.
Route::nativeGroup(NativeStackLayout::class, function () {
    Route::native('/', DemoLauncher::class)->name('demos');
});

// ── Layout demo: pushed detail (Stack with auto-back) ──
Route::native('/item/{id}', ItemDetail::class)
    ->layout(StackLayout::class)
    ->name('item.detail');

// ── Page-transition showcase ──
// The index gets native chrome (TopBar back chevron + title) via StackLayout.
// The DETAIL stays chrome-less, so navigating index → detail is a full
// tree replace (chrome → no-chrome) that rides the router-level path — which
// is where @navigate.<transition> animations actually play. (Native-chrome
// push/pop uses its own built-in animation, so a chrome detail would hide
// the transitions this demo exists to show.)
Route::native('/transitions', TransitionsDemo::class)
    ->layout(StackLayout::class)
    ->name('transitions');
Route::native('/transitions/detail', TransitionDetail::class)->name('transitions.detail');

// ── Demo HOME routes — get a back-arrow TopBar via StackLayout ──
Route::nativeGroup(StackLayout::class, function () {
    // Component showcases (broken out from explore)
    Route::native('/counter', Counter::class)->name('counter');
    Route::native('/justify-repro', JustifyRepro::class)->name('justify.repro');
    Route::native('/theme-lab', ThemeLab::class)->name('theme.lab');
    Route::native('/reactivity', ReactivityDemo::class)->name('reactivity.demo');
    Route::native('/webview-demo', WebviewDemo::class)->name('webview.demo');
    Route::native('/animate', Animate::class)->name('animate');
    Route::native('/number-switcher', NumberSwitcherDemo::class)->name('number.switcher');
    Route::native('/gestures', GestureDemo::class)->name('gestures');
    Route::native('/game-pad', GamePad::class)->name('game.pad');
    Route::native('/mail-demo', MailDemo::class)->name('mail.demo');
    Route::native('/refreshable-demo', RefreshableDemo::class)->name('refreshable.demo');
    Route::native('/edge-child-test', EdgeChildTest::class)->name('edge.child.test');
    Route::native('/event-channel-test', EventChannelTest::class)->name('event.channel.test');
    Route::native('/geo-watch', GeoWatchDemo::class)->name('geo.watch.demo');
    Route::native('/explore/buttons', ExploreButtons::class)->name('explore.buttons');
    Route::native('/explore/forms', ExploreForms::class)->name('explore.forms');
    Route::native('/explore/pickers', ExplorePickers::class)->name('explore.pickers');
    Route::native('/explore/typography', ExploreTypography::class)->name('explore.typography');
    Route::native('/explore/cards', ExploreCards::class)->name('explore.cards');
    Route::native('/explore/icons', ExploreIcons::class)->name('explore.icons');
    Route::native('/explore/layout', ExploreLayout::class)->name('explore.layout');
    Route::native('/explore/sheets', ExploreSheets::class)->name('explore.sheets');
    Route::native('/explore/menus', ExploreMenus::class)->name('explore.menus');
    Route::native('/buttons-form', ButtonsForm::class)->name('buttons.form');
    Route::native('/glass', Glass::class)->name('glass');
    Route::native('/layout-test', TestLayout::class)->name('layout.test');
    Route::native('/stack-positioning', StackPositioningDemo::class)->name('stack.positioning');

    // Mini app demos
    Route::native('/twitter', TwitterFeed::class)->name('twitter.feed');
    Route::native('/facebook', FacebookFeed::class)->name('facebook.feed');
    Route::native('/instagram', InstagramFeed::class)->name('instagram.feed');
});

// ── Demo INNER routes — keep their own custom blade chrome ──
// Twitter / X
Route::native('/twitter/tweet/{id}', TweetDetail::class)->name('twitter.tweet');
Route::native('/twitter/profile/{id}', TwitterProfile::class)->name('twitter.profile');
Route::native('/twitter/compose', ComposeTweet::class)->name('twitter.compose');

// Facebook
Route::native('/facebook/post/{id}', FacebookPost::class)->name('facebook.post');
Route::native('/facebook/profile/{id}', FacebookProfile::class)->name('facebook.profile');
Route::native('/facebook/create', FacebookCreate::class)->name('facebook.create');

// Instagram
Route::native('/instagram/post/{id}', InstagramPost::class)->name('instagram.post');
Route::native('/instagram/profile/{id}', InstagramProfile::class)->name('instagram.profile');
Route::native('/instagram/search', InstagramSearch::class)->name('instagram.search');

// Spotify — home lives OUTSIDE the NavBar stack group: stack screens sit
// inside a SwiftUI NavigationStack whose container background is the
// (white) systemBackground with no PHP-side override, so a dark screen
// shows a white bar in the bottom safe-area inset. As a plain screen the
// root fills the window edge-to-edge and its own bg covers the insets.
Route::native('/spotify', SpotifyHome::class)->name('spotify.home');
Route::native('/spotify/playlist/{id}', SpotifyPlaylist::class)->name('spotify.playlist');
Route::native('/spotify/artist/{id}', SpotifyArtist::class)->name('spotify.artist');
Route::native('/spotify/search', SpotifySearch::class)->name('spotify.search');

// YouTube — home outside the NavBar stack group for the same reason as
// Spotify above (dark screen vs the stack's white container background).
Route::native('/youtube', YouTubeHome::class)->name('youtube.home');
Route::native('/youtube/video/{id}', YouTubeVideo::class)->name('youtube.video');
Route::native('/youtube/channel/{id}', YouTubeChannel::class)->name('youtube.channel');
Route::native('/youtube/search', YouTubeSearch::class)->name('youtube.search');

Route::nativeGroup(SyncUpNativeTabsLayout::class, function () {
    Route::native('/syncup-native', SyncUpNativeChats::class)->name('syncup-native.chats');
    Route::native('/syncup-native/friends', SyncUpNativeFriends::class)->name('syncup-native.friends');
    Route::native('/syncup-native/profile', SyncUpNativeProfile::class)->name('syncup-native.profile');
    Route::native('/syncup-native/chat/{id}', SyncUpNativeChat::class)->name('syncup-native.chat');
});

Route::native('/syncup-native/login', SyncUpNativeLogin::class)->name('syncup-native.login');

// Plain web route — loaded by the webview demo's `php`-mode webview, where the
// embedded runtime serves it with the app session and window.Native bridge.
Route::get('/webview-embedded', function () {
    return view('webview-embedded', [
        'hits' => session()->increment('webview_embedded_hits'),
    ]);
})->name('webview.embedded');
