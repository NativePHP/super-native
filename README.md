# NativePHP UI Kitchen Sink

A showcase app for [NativePHP Mobile](https://nativephp.com) — fully native UI rendered from PHP using Blade templates, Tailwind classes, and Yoga layout. No JavaScript frameworks, no WebViews.

> **Not for production.** This is a reference app for exploring NativePHP's Element rendering system.

## What's Inside

A single-page UI kitchen sink (`/`) demonstrating every core native primitive:

| Section | What it covers |
|---|---|
| **Typography** | Font sizes (xs–3xl), weights (thin–extrabold), text alignment |
| **Colors** | All Tailwind color palettes (slate through rose) |
| **Buttons** | Solid, pill, outlined, ghost, and icon buttons |
| **Interactive Counter** | Increment/decrement with live state |
| **Border Radius** | none through full |
| **Shadows & Elevation** | shadow-none through shadow-2xl |
| **Borders** | Widths, colors, and pill borders |
| **Opacity** | 10–100 opacity levels |
| **Icons** | Full mapped icon set (navigation, content, communication, actions, device, commerce) |
| **Text Input** | Standard and secure (password) fields |
| **Toggle** | On/off switches with labels |
| **Image** | Remote images with fit modes and horizontal scroll galleries |
| **Flex Layout** | justify-start/center/end/between/evenly, flex-1 distribution |
| **Stack (Layered)** | Notification badges, image overlays |
| **Canvas & Shapes** | Rectangles, circles, lines |
| **Card Layouts** | Profile cards, stat cards |
| **List Items** | Settings-style list with icons and badges |
| **Activity Indicator** | Sizes and custom colors |
| **Creative Compositions** | Gradient banners, tag clouds, chat bubbles |

## Requirements

- Composer
- Android Studio (with an emulator or connected device)

## Getting Started

```bash
# 1. Clone the repo
git clone <repo-url> && cd native

# 2. Install dependencies
composer install

# 3. Install NativePHP
php artisan native:install

# 4. Run on Android
php artisan native:run android -W --no-vite
```

## Project Structure

```
app/NativeComponents/Explore.php    # The kitchen sink component
resources/views/native/explore.blade.php  # Blade template with <native:*> elements
routes/web.php                      # Single route: / → Explore
```

## License

MIT
