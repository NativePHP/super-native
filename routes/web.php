<?php

use App\NativeComponents\Explore;
use Illuminate\Support\Facades\Route;
use Native\Mobile\Edge\BenchmarkComponent;

//
Route::native('/', Explore::class)->name('explore');
Route::native('/benchmark', BenchmarkComponent::class)->name('benchmark');
//
// // Doom Game
// Route::native('/doom', \App\NativeComponents\DoomGame::class)->name('game');
//
// // Twitter/X ssss
// Route::native('/', \App\NativeComponents\TwitterFeed::class)->name('twitter.feed');
// Route::native('/twitter/tweet/{id}', \App\NativeComponents\TweetDetail::class)->name('twitter.tweet');
// Route::native('/twitter/profile/{id}', \App\NativeComponents\TwitterProfile::class)->name('twitter.profile');
// Route::native('/twitter/compose', \App\NativeComponents\ComposeTweet::class)->name('twitter.compose');
//
// // IKEA
// Route::native('/', \App\NativeComponents\IkeaHome::class)->name('ikea.home');
// Route::native('/ikea/product/{id}', \App\NativeComponents\IkeaProduct::class)->name('ikea.product');
// Route::native('/ikea/cart', \App\NativeComponents\IkeaCart::class)->name('ikea.cart');
// Route::native('/ikea/search', \App\NativeComponents\IkeaSearch::class)->name('ikea.search');
//
// // Facebook
// Route::native('/', \App\NativeComponents\FacebookFeed::class)->name('facebook.feed');
// Route::native('/facebook/post/{id}', \App\NativeComponents\FacebookPost::class)->name('facebook.post');
// Route::native('/facebook/profile/{id}', \App\NativeComponents\FacebookProfile::class)->name('facebook.profile');
// Route::native('/facebook/create', \App\NativeComponents\FacebookCreate::class)->name('facebook.create');
//
// // Instagram
// Route::native('/', \App\NativeComponents\InstagramFeed::class)->name('instagram.feed');
// Route::native('/instagram/post/{id}', \App\NativeComponents\InstagramPost::class)->name('instagram.post');
// Route::native('/instagram/profile/{id}', \App\NativeComponents\InstagramProfile::class)->name('instagram.profile');
// Route::native('/instagram/search', \App\NativeComponents\InstagramSearch::class)->name('instagram.search');
//
// // Spotify
// Route::native('/', \App\NativeComponents\SpotifyHome::class)->name('spotify.home');
// Route::native('/spotify/playlist/{id}', \App\NativeComponents\SpotifyPlaylist::class)->name('spotify.playlist');
// Route::native('/spotify/artist/{id}', \App\NativeComponents\SpotifyArtist::class)->name('spotify.artist');
// Route::native('/spotify/search', \App\NativeComponents\SpotifySearch::class)->name('spotify.search');
//
// // YouTube
// Route::native('/', \App\NativeComponents\YouTubeHome::class)->name('youtube.home');
// Route::native('/youtube/video/{id}', \App\NativeComponents\YouTubeVideo::class)->name('youtube.video');
// Route::native('/youtube/channel/{id}', \App\NativeComponents\YouTubeChannel::class)->name('youtube.channel');
// Route::native('/youtube/search', \App\NativeComponents\YouTubeSearch::class)->name('youtube.search');
