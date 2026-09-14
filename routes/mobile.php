<?php

// use App\Http\Middleware\DemoAuth;
use App\NativeComponents\AccordionDemo;
use App\NativeComponents\Animate;
// use App\NativeComponents\AppearanceEventsDemo;
use App\NativeComponents\AsyncLoadingDemo;
use App\NativeComponents\BreakpointsDemo;
use App\NativeComponents\ButtonsForm;
use App\NativeComponents\ComposeTweet;
use App\NativeComponents\Counter;
use App\NativeComponents\CounterWithClick;
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
use App\NativeComponents\HeroCardDetail;
use App\NativeComponents\HeroCardList;
use App\NativeComponents\HeroChain;
use App\NativeComponents\HeroDeepDetail;
use App\NativeComponents\HeroDeepList;
use App\NativeComponents\HeroEdgeCases;
use App\NativeComponents\HeroEdgeDetail;
use App\NativeComponents\HeroGallery;
use App\NativeComponents\HeroNested;
use App\NativeComponents\HeroNestedDetail;
use App\NativeComponents\HeroPhotoDetail;
use App\NativeComponents\HeroPhotoGrid;
use App\NativeComponents\HeroPlayer;
use App\NativeComponents\HeroPlayerFull;
use App\NativeComponents\HeroProfileDetail;
use App\NativeComponents\HeroProfileList;
use App\NativeComponents\HeroScroll20k;
use App\NativeComponents\HeroSeam;
use App\NativeComponents\HeroSeamDetail;
use App\NativeComponents\HeroShape;
use App\NativeComponents\HeroShapeDetail;
use App\NativeComponents\HeroStyles;
use App\NativeComponents\HeroStylesDetail;
use App\NativeComponents\HeroTiming;
use App\NativeComponents\HeroTimingDetail;
use App\NativeComponents\Home;
use App\NativeComponents\InstagramFeed;
use App\NativeComponents\InstagramPost;
use App\NativeComponents\InstagramProfile;
use App\NativeComponents\InstagramSearch;
use App\NativeComponents\ItemDetail;
use App\NativeComponents\JustifyRepro;
use App\NativeComponents\Layouts\NativeStackLayout;
use App\NativeComponents\Layouts\PaneLabLayout;
use App\NativeComponents\Layouts\StackLayout;
use App\NativeComponents\MailDemo;
use App\NativeComponents\MasterclassAlignItems;
use App\NativeComponents\MasterclassAutocapitalize;
use App\NativeComponents\MasterclassChatRepin;
use App\NativeComponents\MasterclassComposerLines;
use App\NativeComponents\MasterclassCornerRadius;
use App\NativeComponents\MasterclassImageCorners;
use App\NativeComponents\MasterclassKeyboardDismiss;
use App\NativeComponents\MasterclassKeyboardDismissPlain;
use App\NativeComponents\MasterclassMaxWidth;
use App\NativeComponents\MasterclassScrollCenter;
use App\NativeComponents\MasterclassScrollCenterLogin;
use App\NativeComponents\MasterclassTextWhitespace;
use App\NativeComponents\NumberSwitcherDemo;
use App\NativeComponents\PaneLab;
// use App\NativeComponents\MiddlewareDemo;
// use App\NativeComponents\MiddlewareDemoLogin;
// use App\NativeComponents\MiddlewareDemoSecret;
use App\NativeComponents\PlatformIconsDemo;
use App\NativeComponents\ProjectsGrid;
use App\NativeComponents\PushTokenDemo;
use App\NativeComponents\ReactivityDemo;
use App\NativeComponents\RefreshableDemo;
use App\NativeComponents\SelectionDemo;
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

// ── Shared-element ("view") transitions ──
// Same chrome rule as the transitions showcase above, and for the same
// reason: each INDEX gets StackLayout chrome, every DESTINATION is
// chrome-less. A chrome-to-chrome push is handled by NavigationStack's own
// animation and never reaches the router-level swap, which is the only path
// a `transition-name` morph rides — so a chrome detail here would silently
// show no morph at all.
Route::native('/hero', HeroGallery::class)
    ->layout(StackLayout::class)
    ->name('hero');

Route::native('/hero/photos', HeroPhotoGrid::class)
    ->layout(StackLayout::class)
    ->name('hero.photos');
Route::native('/hero/photos/{id}', HeroPhotoDetail::class)
    ->whereNumber('id')
    ->name('hero.photos.detail');

Route::native('/hero/cards', HeroCardList::class)
    ->layout(StackLayout::class)
    ->name('hero.cards');
Route::native('/hero/cards/{id}', HeroCardDetail::class)
    ->whereNumber('id')
    ->name('hero.cards.detail');

Route::native('/hero/people', HeroProfileList::class)
    ->layout(StackLayout::class)
    ->name('hero.people');
Route::native('/hero/people/{id}', HeroProfileDetail::class)
    ->whereNumber('id')
    ->name('hero.people.detail');

Route::native('/hero/edges', HeroEdgeCases::class)
    ->layout(StackLayout::class)
    ->name('hero.edges');
Route::native('/hero/edges/{case}', HeroEdgeDetail::class)
    ->name('hero.edges.detail');

// Mini-player → full player: three names travelling different paths at once.
Route::native('/hero/player', HeroPlayer::class)
    ->layout(StackLayout::class)
    ->name('hero.player');
Route::native('/hero/player/{id}', HeroPlayerFull::class)
    ->whereNumber('id')
    ->name('hero.player.full');

// A tagged element inside another tagged element — matched independently.
Route::native('/hero/nested', HeroNested::class)
    ->layout(StackLayout::class)
    ->name('hero.nested');
Route::native('/hero/nested/{id}', HeroNestedDetail::class)
    ->whereNumber('id')
    ->name('hero.nested.detail');

// Three-hop chain carrying one token, re-paired at every hop. Step 1 gets the
// chrome; steps 2 and 3 are chrome-less so each hop stays a router-level swap.
Route::native('/hero/chain', HeroChain::class)
    ->layout(StackLayout::class)
    ->name('hero.chain');
Route::native('/hero/chain/{step}', HeroChain::class)
    ->whereNumber('step')
    ->name('hero.chain.step');

// Size, aspect ratio and corner radius all interpolating together.
Route::native('/hero/shape', HeroShape::class)
    ->layout(StackLayout::class)
    ->name('hero.shape');
Route::native('/hero/shape/{variant}', HeroShapeDetail::class)
    ->name('hero.shape.detail');

// Forty rows: the start frame is wherever the tapped row happens to be.
Route::native('/hero/deep', HeroDeepList::class)
    ->layout(StackLayout::class)
    ->name('hero.deep');
Route::native('/hero/deep/{id}', HeroDeepDetail::class)
    ->whereNumber('id')
    ->name('hero.deep.detail');

// 20k image stress scroll — windowed virtual-list (see ExploreIcons pattern).
Route::native('/hero/scroll-20k', HeroScroll20k::class)
    ->layout(StackLayout::class)
    ->name('hero.scroll20k');

// One object, half tagged and half not — the boundary made visible.
Route::native('/hero/seam', HeroSeam::class)
    ->layout(StackLayout::class)
    ->name('hero.seam');
Route::native('/hero/seam/detail', HeroSeamDetail::class)
    ->name('hero.seam.detail');

// The three `morph` styles, same start and same destination each time.
Route::native('/hero/styles', HeroStyles::class)
    ->layout(StackLayout::class)
    ->name('hero.styles');
Route::native('/hero/styles/{mode}', HeroStylesDetail::class)
    ->name('hero.styles.detail');

// Per-element duration and easing — four heroes, four arrival times.
Route::native('/hero/timing', HeroTiming::class)
    ->layout(StackLayout::class)
    ->name('hero.timing');
Route::native('/hero/timing/detail', HeroTimingDetail::class)
    ->name('hero.timing.detail');

// ── Demo HOME routes — get a back-arrow TopBar via StackLayout ──
Route::native('/pane-lab', PaneLab::class)->layout(PaneLabLayout::class)->name('pane.lab');
Route::native('/counter', Counter::class)->name('counter');
Route::native('/projects-grid', ProjectsGrid::class)->layout(StackLayout::class)->name('projects.grid');
Route::native('/breakpoints', BreakpointsDemo::class)->layout(StackLayout::class)->name('breakpoints.demo');
// No layout: the feed draws edge to edge under the status bar and home
// indicator, with its own floating back button.
Route::native('/counter/{click}/{section?}', CounterWithClick::class)
    ->whereNumber('click')
    ->layout(StackLayout::class)
    ->name('counter.with-click');

Route::nativeGroup(StackLayout::class, function () {
    // Component showcases (broken out from explore)
    Route::native('/selection', SelectionDemo::class)->name('selection.demo');
    Route::native('/platform-icons', PlatformIconsDemo::class)->name('platform.icons.demo');
    Route::native('/accordion', AccordionDemo::class)->name('accordion.demo');
    Route::native('/justify-repro', JustifyRepro::class)->name('justify.repro');
    Route::native('/theme-lab', ThemeLab::class)->name('theme.lab');
    Route::native('/reactivity', ReactivityDemo::class)->name('reactivity.demo');
    Route::native('/async-loading', AsyncLoadingDemo::class)->name('async.loading.demo');
    Route::native('/push-token', PushTokenDemo::class)->name('push.token.demo');
    // Parked while vendor/nativephp/mobile points at main: both demos depend on
    // branches that only exist on local/demo-integration (#341 nested child
    // events, #252 native route middleware). ->middleware() is not a native
    // route method on main, so leaving these registered fatals at boot.
    // Route::native('/appearance-events', AppearanceEventsDemo::class)->name('appearance.events.demo');
    // Route::native('/middleware-demo', MiddlewareDemo::class)->name('middleware.demo');
    // Route::native('/middleware-demo/login', MiddlewareDemoLogin::class)->name('middleware.demo.login');
    // Route::native('/middleware-demo/secret', MiddlewareDemoSecret::class)
    //     ->middleware(DemoAuth::class)
    //     ->name('middleware.demo.secret');
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

    // Masterclass bug-fix demos — one screen per mobile-air issue, each a
    // visual assertion of the fix. Read them on iOS and Android side by side.
    Route::native('/masterclass/align-items', MasterclassAlignItems::class)->name('masterclass.align.items');
    Route::native('/masterclass/max-width', MasterclassMaxWidth::class)->name('masterclass.max.width');
    Route::native('/masterclass/corner-radius', MasterclassCornerRadius::class)->name('masterclass.corner.radius');
    Route::native('/masterclass/autocapitalize', MasterclassAutocapitalize::class)->name('masterclass.autocapitalize');
    // #308 — this one MUST stay inside the group: native chrome is the failing case.
    Route::native('/masterclass/keyboard-dismiss', MasterclassKeyboardDismiss::class)->name('masterclass.keyboard.dismiss');
    Route::native('/masterclass/scroll-center', MasterclassScrollCenter::class)->name('masterclass.scroll.center');
    Route::native('/masterclass/chat-repin', MasterclassChatRepin::class)->name('masterclass.chat.repin');
    Route::native('/masterclass/text-whitespace', MasterclassTextWhitespace::class)->name('masterclass.text.whitespace');
    Route::native('/masterclass/image-corners', MasterclassImageCorners::class)->name('masterclass.image.corners');
    Route::native('/masterclass/composer-lines', MasterclassComposerLines::class)->name('masterclass.composer.lines');

    // Mini app demos
    Route::native('/twitter', TwitterFeed::class)->name('twitter.feed');
    Route::native('/facebook', FacebookFeed::class)->name('facebook.feed');
    Route::native('/instagram', InstagramFeed::class)->name('instagram.feed');
});

// #308 control — the same screen with NO native chrome, so the two can be
// compared side by side. Must stay OUTSIDE the StackLayout group.
Route::native('/masterclass/keyboard-dismiss-plain', MasterclassKeyboardDismissPlain::class)
    ->name('masterclass.keyboard.dismiss.plain');

// #303 — the realistic full-screen login case. Chrome-less so the scroll view
// really is the whole viewport.
Route::native('/masterclass/scroll-center-login', MasterclassScrollCenterLogin::class)
    ->name('masterclass.scroll.center.login');

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
