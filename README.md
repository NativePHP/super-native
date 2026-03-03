# NativePHP Element Demo

A demonstration app showcasing [NativePHP Mobile](https://nativephp.com) with Laravel and Livewire. Renders fully native Android UI components from PHP — no JavaScript frameworks, no WebViews.

> **Android only.** iOS is not supported in this demo.

> **Not for production.** This is a demo/reference app for exploring NativePHP's Element rendering system.

## What's Inside

The app includes 30+ native component demos that replicate popular app interfaces using mock data:

| Category | Demos |
|---|---|
| **Listings** | Airbnb-style explore feed, listing detail (active by default) |
| **Social** | Twitter feed/profile/compose, Instagram feed/search, Facebook feed/profile |
| **E-commerce** | IKEA store/cart/search, iHerb store/cart/categories |
| **Entertainment** | Spotify home/playlists/artists, YouTube home/videos/channels |
| **Simple** | Counter (increment/decrement) |

Swap active demos by uncommenting routes in `routes/web.php`.

## Requirements

- PHP 8.2+
- Composer
- Android Studio (with an emulator or connected device)
- Node.js & npm

## Getting Started

```bash
# 1. Clone the repo
git clone <repo-url> && cd native

# 2. Install dependencies & set up the app
composer install

# 3. Install NativePHP
php artisan native:install

# 4. Run on Android
php artisan native:run android -W --no-vite
```

That's it. The app will build and launch on your connected Android device or emulator.

## Project Structure

```
app/NativeComponents/       # Native UI components (the demos)
app/NativeComponents/Concerns/  # Shared traits (mock data, etc.)
resources/views/native/     # Blade templates using <native:*> elements
routes/web.php              # Route::native() definitions
```

## Switching Demos

Edit `routes/web.php` — comment out the current active routes and uncomment whichever demo set you want to try:

```php
// Airbnb-style (default)
Route::native('/', \App\NativeComponents\Explore::class);
Route::native('/listing/{id}', \App\NativeComponents\ListingDetail::class);

// Twitter
// Route::native('/', \App\NativeComponents\TwitterFeed::class);
// ...

// Spotify
// Route::native('/', \App\NativeComponents\SpotifyHome::class);
// ...
```

## License

MIT