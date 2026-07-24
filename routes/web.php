<?php

use App\NativeComponents\Animate;
use App\NativeComponents\AsyncTaskDemo;
use App\NativeComponents\Browse;
use App\NativeComponents\ButtonsForm;
use App\NativeComponents\ComposeTweet;
use App\NativeComponents\Counter;
use App\NativeComponents\DemoLauncher;
use App\NativeComponents\DrawerHome;
use App\NativeComponents\DrawerReveal;
use App\NativeComponents\EventChannelTest;
use App\NativeComponents\ExploreButtons;
use App\NativeComponents\ExploreCards;
use App\NativeComponents\ExploreForms;
use App\NativeComponents\ExploreIcons;
use App\NativeComponents\ExploreLayout;
use App\NativeComponents\ExploreMenus;
use App\NativeComponents\ExploreSheets;
use App\NativeComponents\ExploreTypography;
use App\NativeComponents\FacebookCreate;
use App\NativeComponents\FacebookFeed;
use App\NativeComponents\FacebookPost;
use App\NativeComponents\FacebookProfile;
use App\NativeComponents\GeoWatchDemo;
use App\NativeComponents\GestureDemo;
use App\NativeComponents\Glass;
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
use App\NativeComponents\Layouts\DrawerLayout;
use App\NativeComponents\Layouts\NativeStackLayout;
use App\NativeComponents\Layouts\NativeTabsLayout;
use App\NativeComponents\Layouts\StackLayout;
use App\NativeComponents\Layouts\SyncUpTabsLayout;
use App\NativeComponents\Layouts\TabsLayout;
use App\NativeComponents\MailDemo;
use App\NativeComponents\NativeChromeDemo;
use App\NativeComponents\NativeChromeDetail;
use App\NativeComponents\NativeTabsHome;
use App\NativeComponents\NativeTabsProfile;
use App\NativeComponents\NumberSwitcherDemo;
use App\NativeComponents\PerfDemo;
use App\NativeComponents\PerfShowdown;
use App\NativeComponents\Phase1KeyTest;
use App\NativeComponents\Phase2MemoTest;
use App\NativeComponents\Phase4VirtualListTest;
use App\NativeComponents\Profile;
use App\NativeComponents\ReactivityDemo;
use App\NativeComponents\RefreshableDemo;
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
use App\NativeComponents\TransitionDetail;
use App\NativeComponents\TransitionsDemo;
use App\NativeComponents\TweetDetail;
use App\NativeComponents\TwitterFeed;
use App\NativeComponents\TwitterProfile;
use App\NativeComponents\VibeDemo;
use App\NativeComponents\VibeLogin;
use App\NativeComponents\VibePresenceDemo;
use App\NativeComponents\VibePrivateDemo;
use App\NativeComponents\WebviewDemo;
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
    Route::native('/tabs', Home::class)->name('home');
    Route::native('/tabs/browse', Browse::class)->name('browse');
    Route::native('/tabs/profile', Profile::class)->name('profile');
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
    Route::native('/reactivity', ReactivityDemo::class)->name('reactivity.demo');
    Route::native('/async-tasks', AsyncTaskDemo::class)->name('async.tasks.demo');
    Route::native('/webview-demo', WebviewDemo::class)->name('webview.demo');
    Route::native('/animate', Animate::class)->name('animate');
    Route::native('/number-switcher', NumberSwitcherDemo::class)->name('number.switcher');
    Route::native('/gestures', GestureDemo::class)->name('gestures');
    Route::native('/mail-demo', MailDemo::class)->name('mail.demo');
    Route::native('/refreshable-demo', RefreshableDemo::class)->name('refreshable.demo');
    Route::native('/perf', PerfDemo::class)->name('perf.demo');
    Route::native('/benchmark', BenchmarkComponent::class)->name('benchmark');
    Route::native('/phase1-key-test', Phase1KeyTest::class)->name('phase1.key.test');
    Route::native('/phase2-memo-test', Phase2MemoTest::class)->name('phase2.memo.test');
    Route::native('/phase4-virtual-list-test', Phase4VirtualListTest::class)->name('phase4.virtuallist.test');
    Route::native('/perf-showdown', PerfShowdown::class)->name('perf.showdown');
    Route::native('/event-channel-test', EventChannelTest::class)->name('event.channel.test');
    Route::native('/vibe-login', VibeLogin::class)->name('vibe.login');
    Route::native('/vibe', VibeDemo::class)->name('vibe.demo');
    Route::native('/vibe-private', VibePrivateDemo::class)->name('vibe.private.demo');
    Route::native('/vibe-presence', VibePresenceDemo::class)->name('vibe.presence.demo');
    Route::native('/geo-watch', GeoWatchDemo::class)->name('geo.watch.demo');
    Route::native('/explore/buttons', ExploreButtons::class)->name('explore.buttons');
    Route::native('/explore/forms', ExploreForms::class)->name('explore.forms');
    Route::native('/explore/typography', ExploreTypography::class)->name('explore.typography');
    Route::native('/explore/cards', ExploreCards::class)->name('explore.cards');
    Route::native('/explore/icons', ExploreIcons::class)->name('explore.icons');
    Route::native('/explore/layout', ExploreLayout::class)->name('explore.layout');
    Route::native('/explore/sheets', ExploreSheets::class)->name('explore.sheets');
    Route::native('/explore/menus', ExploreMenus::class)->name('explore.menus');
    Route::native('/buttons-form', ButtonsForm::class)->name('buttons.form');
    Route::native('/glass', Glass::class)->name('glass');
    Route::native('/layout-test', TestLayout::class)->name('layout.test');

    // Mini app demos
    Route::native('/twitter', TwitterFeed::class)->name('twitter.feed');
    Route::native('/ikea', IkeaHome::class)->name('ikea.home');
    Route::native('/facebook', FacebookFeed::class)->name('facebook.feed');
    Route::native('/instagram', InstagramFeed::class)->name('instagram.feed');
    Route::native('/spotify', SpotifyHome::class)->name('spotify.home');
    Route::native('/youtube', YouTubeHome::class)->name('youtube.home');
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
    Route::native('/syncup', SyncUpChats::class)->name('syncup.chats');
    Route::native('/syncup/friends', SyncUpFriends::class)->name('syncup.friends');
    Route::native('/syncup/profile', SyncUpProfile::class)->name('syncup.profile');
});
Route::native('/syncup/chat/{id}', SyncUpChat::class)
    ->layout(StackLayout::class)
    ->name('syncup.chat');
Route::native('/syncup/login', SyncUpLogin::class)->name('syncup.login');

Route::nativeGroup(SyncUpNativeTabsLayout::class, function () {
    Route::native('/syncup-native', SyncUpNativeChats::class)->name('syncup-native.chats');
    Route::native('/syncup-native/friends', SyncUpNativeFriends::class)->name('syncup-native.friends');
    Route::native('/syncup-native/profile', SyncUpNativeProfile::class)->name('syncup-native.profile');
    Route::native('/syncup-native/chat/{id}', SyncUpNativeChat::class)->name('syncup-native.chat');
});

Route::native('/syncup-native/login', SyncUpNativeLogin::class)->name('syncup-native.login');

// ── NavigationStack + Form/Section demo (SwiftUI grouped-form replica) ──

// ── Native chrome — NavigationStack-rendered top bar ──
Route::nativeGroup(NativeStackLayout::class, function () {
    Route::native('/native-chrome', NativeChromeDemo::class)->name('native.chrome');
    Route::native('/native-chrome/detail', NativeChromeDetail::class)->name('native.chrome.detail');
});

// ── Native chrome — TabView-rendered bottom bar ──
Route::nativeGroup(NativeTabsLayout::class, function () {
    Route::native('/native-tabs', NativeTabsHome::class)->name('native.tabs.home');
    Route::native('/native-tabs/profile', NativeTabsProfile::class)->name('native.tabs.profile');
});

// ── Side drawer (X-style) — one Drawer declared on DrawerLayout, shown on
// every screen routed under it. The two screens differ only by mode. ──
Route::nativeGroup(DrawerLayout::class, function () {
    Route::native('/drawer', DrawerHome::class)->name('drawer.home');
    Route::native('/drawer/reveal', DrawerReveal::class)->name('drawer.reveal');
});

// ── Extras ──
// (note: /benchmark is registered above inside the StackLayout group so it gets a back-chevron)

// Plain web route — loaded by the webview demo's `php`-mode webview, where the
// embedded runtime serves it with the app session and window.Native bridge.
Route::get('/webview-embedded', function () {
    return view('webview-embedded', [
        'hits' => session()->increment('webview_embedded_hits'),
    ]);
})->name('webview.embedded');
