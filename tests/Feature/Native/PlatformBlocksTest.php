<?php

use App\NativeComponents\Counter;
use Illuminate\Support\Facades\Blade;
use Native\Mobile\Testing\Native;
use SupaNative\Core\Edge\NativeTagPrecompiler;
use SupaNative\Core\Platform;

/*
 * `@desktop` … `@enddesktop` and `@mobile` … `@endmobile`, proved both ways.
 *
 * /counter is a real shared screen: one Blade file with a block of each, so
 * these tests are the regression net for the demo as well as for the directive.
 * The sidebar is no longer one of the things being gated — it is window chrome
 * the desktop host applies to every screen (SidebarChromeTest covers that), and
 * a screen carries no markup for it at all.
 */

afterEach(function () {
    // Only the override, not reset(): reset() would also drop the host resolver
    // nativephp/mobile registers at boot, which the rest of the suite reads.
    Platform::set(null);
});

it('renders a @desktop block on macOS and drops it on a phone', function () {
    // macOS FIRST, then iOS, deliberately. Laravel caches one compiled file per
    // view keyed by path + mtime, with nothing about the platform in the key —
    // so if the directive resolved the platform at compile time, the desktop
    // branch would be baked into that file and the iOS assertion below would
    // find it anyway. It compiles to a runtime `Blade::check()` instead, which
    // is what makes one cached file correct for both platforms.
    Platform::set(Platform::MACOS);

    expect(json_encode(Native::test(Counter::class)->tree()))->toContain('Click or hold');

    Platform::set(Platform::IOS);

    expect(json_encode(Native::test(Counter::class)->tree()))->not->toContain('Click or hold');
});

it('renders a @mobile block on a phone and drops it on macOS', function () {
    Platform::set(Platform::IOS);

    expect(json_encode(Native::test(Counter::class)->tree()))->toContain('Tap or hold');

    Platform::set(Platform::MACOS);

    expect(json_encode(Native::test(Counter::class)->tree()))->not->toContain('Tap or hold');
});

it('drops both blocks when no platform has been declared', function () {
    Platform::set(null);
    Platform::declareRenderer(null);

    // A plain web request or a test run has no renderer. Both families answering
    // false is the honest outcome — neither block leaks in.
    expect(Platform::isDesktop())->toBeFalse()
        ->and(Platform::isMobile())->toBeFalse()
        ->and(Blade::check('desktop'))->toBeFalse()
        ->and(Blade::check('mobile'))->toBeFalse();
})->skip(fn () => Platform::current() !== null, 'a platform is declared in this environment');

it('registers a block per platform under the names Platform already uses', function () {
    foreach ([Platform::IOS, Platform::ANDROID, Platform::MACOS, Platform::WINDOWS, Platform::LINUX] as $platform) {
        Platform::set($platform);

        expect(Blade::check($platform))->toBeTrue();

        foreach ([Platform::IOS, Platform::ANDROID, Platform::MACOS, Platform::WINDOWS, Platform::LINUX] as $other) {
            if ($other !== $platform) {
                expect(Blade::check($other))->toBeFalse();
            }
        }
    }
});

it('wraps the collector calls for nested native tags, not the raw tags', function () {
    // The precompiler rewrites `<native:*>` before Blade compiles directives, so
    // by the time `@desktop` is looked at its body is already a run of collector
    // calls. The `if` wraps those — which is why nothing has to be closed on the
    // platform that skips the block.
    $was = NativeTagPrecompiler::setActive(true);

    $compiled = Blade::compileString(<<<'BLADE'
        @desktop
            <native:side-nav><native:side-nav-item label="Home" @press="go('/')" /></native:side-nav>
        @enddesktop
        BLADE);

    NativeTagPrecompiler::setActive($was);

    expect($compiled)
        ->toContain("Blade::check('desktop')")
        ->toContain("::open('side_nav', [])")
        ->toContain("'_press' => 'go(\\'/\\')'")
        ->toContain('endif;')
        // No native tag survived into the guarded body.
        ->not->toContain('<native:');

    // And the guard opens before the collector call and closes after it.
    $if = strpos($compiled, "Blade::check('desktop')");
    $open = strpos($compiled, "::open('side_nav'");
    $endif = strpos($compiled, 'endif;');

    expect($if)->toBeLessThan($open)
        ->and($open)->toBeLessThan($endif);
});

it('keeps the native-compile marker in the first bytes of a platform-gated view', function () {
    // The precompiler's stale-cache guard reads the marker from the head of the
    // compiled file. A platform block must not push it out of range.
    $was = NativeTagPrecompiler::setActive(true);

    $compiled = Blade::compileString("@desktop\n<native:text>x</native:text>\n@enddesktop");

    NativeTagPrecompiler::setActive($was);

    expect(substr($compiled, 0, 256))->toContain(NativeTagPrecompiler::COMPILED_MARKER);
});
