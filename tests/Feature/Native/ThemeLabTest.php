<?php

use App\NativeComponents\ThemeLab;
use Native\Mobile\Edge\TailwindParser;
use Native\Mobile\Testing\Native;

/**
 * Theme Lab is the living style guide: it must exercise the app-defined
 * success / outline-variant tokens, theme-class opacity, every button and
 * badge variant, and the font aliases — on both platforms.
 */
it('renders the theme lab with every design-system section', function (?string $platform) {
    $screen = $platform
        ? Native::test(ThemeLab::class, platform: $platform)
        : Native::test(ThemeLab::class);

    $screen->assertSee('THEME LAB')
        ->assertSee('Theme Tokens')
        ->assertSee('Success — custom token')
        ->assertSee('Opacity Ramps')
        ->assertSee('variant="success"')
        ->assertSee('Badge Variants')
        ->assertSee('Font Aliases')
        ->assertElement('button', fn (array $node): bool => ($node['props']['variant'] ?? null) === 'success')
        ->assertElement('badge', fn (array $node): bool => ($node['props']['variant'] ?? null) === 'success')
        ->assertAccessible();
})->with(['ios' => 'ios', 'android' => 'android', 'default' => [null]]);

it('keeps every button variant interactive', function () {
    $screen = Native::test(ThemeLab::class);

    foreach (['primary', 'secondary', 'success', 'destructive', 'ghost'] as $i => $variant) {
        $screen->tap('Demo button: '.$variant)
            ->assertSet('presses', $i + 1);
    }
});

it('resolves the custom tokens the lab showcases, in both modes', function () {
    // Open-ended token map: success + outline-variant come from
    // config/native-ui.php, not the shipped set. Light and dark both resolve.
    $success = TailwindParser::parse('bg-theme-success');
    $outline = TailwindParser::parse('border-theme-outline-variant');

    expect($success['bg'])->not->toBeNull()
        ->and($success['dark']['bg'] ?? null)->not->toBeNull()
        ->and($outline['borderColor'])->not->toBeNull();

    // Opacity modifiers apply to the resolved token (9-digit wire hex).
    expect(TailwindParser::parse('bg-theme-success/25')['bg'])->toStartWith('#40');
});
