<?php

use App\NativeComponents\HeroCardDetail;
use App\NativeComponents\HeroChain;
use App\NativeComponents\HeroDeepDetail;
use App\NativeComponents\HeroEdgeDetail;
use App\NativeComponents\HeroNestedDetail;
use App\NativeComponents\HeroPhotoDetail;
use App\NativeComponents\HeroPhotoGrid;
use App\NativeComponents\HeroPlayerFull;
use App\NativeComponents\HeroProfileDetail;
use App\NativeComponents\HeroSeamDetail;
use App\NativeComponents\HeroShapeDetail;
use App\NativeComponents\HeroStylesDetail;
use Native\Mobile\Edge\Transition;
use Native\Mobile\Testing\Native;

/**
 * Shared-element ("view") transitions — a shared `ref` pairs an element on
 * two screens so it morphs across the navigation instead of cross-fading.
 *
 * These assert the two halves the morph depends on, both of which are silent
 * when broken: the transition actually being `view_transition`, and the SAME
 * name reaching the wire tree on BOTH screens. A typo in either name is
 * invisible at runtime — the element simply doesn't travel, with no error.
 */
function heroNameIs(string $name): Closure
{
    return fn ($node) => ($node['props']['ref'] ?? null) === $name;
}

// ── The canonical grid → detail morph ────────────────────────────

it('navigates from the photo grid with the view transition', function () {
    Native::visit('/hero/photos')
        ->assertScreen(HeroPhotoGrid::class)
        ->assertNoNavigation()
        ->tap('Cliff Path')
        ->assertNavigatedTo('/hero/photos/1')
        ->assertTransition(Transition::ViewTransition);
});

it('tags the grid thumbnail and the detail image with the same name', function () {
    Native::visit('/hero/photos')
        ->assertElement('column', heroNameIs('photo-1'));

    Native::visit('/hero/photos/1')
        ->assertScreen(HeroPhotoDetail::class)
        ->assertElement('column', heroNameIs('photo-1'));
});

// ── Container morph, non-identical content on the two ends ───────

it('tags the card container on both the list and the expanded page', function () {
    Native::visit('/hero/cards')
        ->assertElement('column', heroNameIs('card-2'));

    Native::visit('/hero/cards/2')
        ->assertScreen(HeroCardDetail::class)
        ->assertElement('column', heroNameIs('card-2'))
        // The content genuinely differs across the morph — that is the point
        // of this demo, and what distinguishes sharedBounds-style behaviour
        // from a plain matched image.
        ->assertSee('Flex direction reaches the layout');
});

// ── Two elements travelling in one navigation ────────────────────

it('tags the avatar and the name independently on both screens', function () {
    Native::visit('/hero/people')
        ->assertElement('column', heroNameIs('avatar-3'))
        ->assertElement('text', heroNameIs('name-3'));

    Native::visit('/hero/people/3')
        ->assertScreen(HeroProfileDetail::class)
        ->assertElement('column', heroNameIs('avatar-3'))
        ->assertElement('text', heroNameIs('name-3'));
});

// ── Edge cases: these must DEGRADE, not break ────────────────────

it('leaves the unmatched destination deliberately untagged', function () {
    // The source tags `edge-orphan`; nothing on the destination claims it.
    // An unmatched name has no partner and is inert by design.
    Native::visit('/hero/edges')
        ->assertElement('column', heroNameIs('edge-orphan'));

    Native::visit('/hero/edges/unmatched')
        ->assertScreen(HeroEdgeDetail::class)
        ->assertMissingElement('column', heroNameIs('edge-orphan'));
});

it('still renders a screen that duplicates one name', function () {
    // Malformed input on purpose: two elements claim `edge-dupe`. Only one
    // pairing can win, but the screen must render rather than blow up.
    Native::visit('/hero/edges/duplicate')
        ->assertScreen(HeroEdgeDetail::class)
        ->assertElement('column', heroNameIs('edge-dupe'))
        ->assertSee('Duplicated');
});

it('renders the off-screen partner case without laying it out early', function () {
    Native::visit('/hero/edges/offscreen')
        ->assertScreen(HeroEdgeDetail::class)
        ->assertElement('column', heroNameIs('edge-deep'));
});

it('keeps the control case matched on both sides', function () {
    Native::visit('/hero/edges')
        ->assertElement('column', heroNameIs('edge-hero'));

    Native::visit('/hero/edges/matched')
        ->assertElement('column', heroNameIs('edge-hero'));
});

// ── The comparison rows on the gallery index ─────────────────────

it('offers the same hero under a non-morphing transition for comparison', function () {
    Native::visit('/hero')
        ->tap('@navigate.fade')
        ->assertNavigatedTo('/hero/edges/matched')
        ->assertTransition(Transition::Fade);
});

// ── Mini-player → full player: three names in one navigation ─────

it('carries artwork, title and surface from the mini player', function () {
    Native::visit('/hero/player')
        ->assertElement('column', heroNameIs('player-surface'))
        ->assertElement('column', heroNameIs('player-art'))
        ->assertElement('text', heroNameIs('player-title'));

    Native::visit('/hero/player/1')
        ->assertScreen(HeroPlayerFull::class)
        ->assertElement('column', heroNameIs('player-surface'))
        ->assertElement('column', heroNameIs('player-art'))
        ->assertElement('text', heroNameIs('player-title'));
});

it('navigates from the mini player with the view transition', function () {
    Native::visit('/hero/player')
        ->tap('Ultraviolet')
        ->assertNavigatedTo('/hero/player/1')
        ->assertTransition(Transition::ViewTransition);
});

// ── Nested: inner element matched independently of its parent ────

it('tags both the card and the avatar inside it', function () {
    Native::visit('/hero/nested')
        ->assertElement('column', heroNameIs('nest-card-2'))
        ->assertElement('column', heroNameIs('nest-avatar-2'));

    Native::visit('/hero/nested/2')
        ->assertScreen(HeroNestedDetail::class)
        ->assertElement('column', heroNameIs('nest-card-2'))
        ->assertElement('column', heroNameIs('nest-avatar-2'));
});

// ── Chain: the same name on all three hops ───────────────────────

it('carries one token across all three chain steps', function () {
    foreach ([1, 2, 3] as $step) {
        Native::visit('/hero/chain/'.$step)
            ->assertScreen(HeroChain::class)
            ->assertSet('step', $step)
            ->assertElement('column', heroNameIs('chain-token'));
    }
});

it('clamps an out-of-range chain step instead of rendering nothing', function () {
    Native::visit('/hero/chain/9')->assertSet('step', 3);
});

it('reverses the chain with a tagged back navigation', function () {
    Native::visit('/hero/chain/2')
        ->tap('Back one hop — in reverse')
        ->assertWentBack()
        ->assertTransition(Transition::ViewTransition);
});

// ── Shape: geometry that disagrees on every axis ─────────────────

it('matches the circle to the banner and the tall tile to the wide one', function () {
    Native::visit('/hero/shape')
        ->assertElement('column', heroNameIs('shape-morph'))
        ->assertElement('column', heroNameIs('shape-invert'));

    Native::visit('/hero/shape/banner')
        ->assertScreen(HeroShapeDetail::class)
        ->assertElement('column', heroNameIs('shape-morph'));

    Native::visit('/hero/shape/inverted')
        ->assertElement('column', heroNameIs('shape-invert'))
        ->assertSee('Aspect inverted');
});

// ── Deep scroll: an arbitrary start frame ────────────────────────

it('tags every row so any scroll position can be the source', function () {
    $list = Native::visit('/hero/deep');

    foreach ([1, 17, 40] as $id) {
        $list->assertElement('column', heroNameIs('deep-'.$id));
    }

    Native::visit('/hero/deep/37')
        ->assertScreen(HeroDeepDetail::class)
        ->assertElement('column', heroNameIs('deep-37'))
        ->assertSee('Row 37');
});

// ── The seam: half tagged, half deliberately not ─────────────────

it('tags only one half of the split badge', function () {
    Native::visit('/hero/seam')
        ->assertElement('column', heroNameIs('seam-half'))
        ->assertSee('UNTAGGED');

    Native::visit('/hero/seam/detail')
        ->assertScreen(HeroSeamDetail::class)
        ->assertElement('column', heroNameIs('seam-half'))
        // The twin does not exist on the destination at all — that asymmetry
        // is the demo, not an oversight.
        ->assertDontSee('UNTAGGED');
});

// ── Morph style: frame / position / size / none ──────────────────

it('tags each style tile with its morph mode', function () {
    $index = Native::visit('/hero/styles');

    // The default tile says nothing — absent `morph` means frame.
    $index->assertElement('column', fn ($n) => ($n['props']['ref'] ?? null) === 'style-frame'
        && ! isset($n['props']['morph']));

    $index->assertElement('column', fn ($n) => ($n['props']['ref'] ?? null) === 'style-position'
        && ($n['props']['morph'] ?? null) === 'position');

    $index->assertElement('column', fn ($n) => ($n['props']['ref'] ?? null) === 'style-size'
        && ($n['props']['morph'] ?? null) === 'size');
});

it('matches each style destination to its source ref', function () {
    foreach (['frame' => 'style-frame', 'position' => 'style-position', 'size' => 'style-size'] as $mode => $ref) {
        Native::visit('/hero/styles/'.$mode)
            ->assertScreen(HeroStylesDetail::class)
            ->assertSet('mode', $mode)
            ->assertElement('column', fn ($n) => ($n['props']['ref'] ?? null) === $ref
                && ($n['props']['morph'] ?? null) === $mode);
    }
});

it('navigates to a style detail with the view transition', function () {
    Native::visit('/hero/styles')
        ->tap('morph="position"')
        ->assertNavigatedTo('/hero/styles/position')
        ->assertTransition(Transition::ViewTransition);
});

// ── Timing: per-element duration and easing ──────────────────────

it('carries per-element duration and easing on both screens', function () {
    foreach (['/hero/timing', '/hero/timing/detail'] as $uri) {
        $screen = Native::visit($uri);

        $screen->assertElement('column', fn ($n) => ($n['props']['ref'] ?? null) === 'tick-1'
            && ($n['props']['morph_duration'] ?? null) === 220.0
            && ($n['props']['morph_easing'] ?? null) === 'linear');

        // A spring with no duration — the renderer falls back to the shared
        // 350ms pace, so naming only an easing is a complete instruction.
        $screen->assertElement('column', fn ($n) => ($n['props']['ref'] ?? null) === 'tick-3'
            && ($n['props']['morph_easing'] ?? null) === 'spring'
            && ! isset($n['props']['morph_duration']));

        $screen->assertElement('column', fn ($n) => ($n['props']['ref'] ?? null) === 'tick-4'
            && ($n['props']['morph_duration'] ?? null) === 900.0);
    }
});

it('leaves the default tile untimed so it rides the shared pace', function () {
    Native::visit('/hero/timing')
        ->assertElement('column', fn ($n) => ($n['props']['ref'] ?? null) === 'tick-2'
            && ! isset($n['props']['morph_duration'])
            && ! isset($n['props']['morph_easing']));
});
