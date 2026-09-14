<?php

use App\Models\Click;
use App\NativeComponents\CounterWithClick;
use Native\Mobile\Edge\Exceptions\LockedPropertyException;
use Native\Mobile\Edge\NativeRouter;
use Native\Mobile\Testing\Native;

it('opens from the launcher through the native navigation directive', function () {
    Native::visit('/')
        ->tap('Component Features')
        ->assertNavigatedTo('/counter/1/overview');
});

it('injects mount dependencies and hydrates the typed public model property first', function () {
    $click = Click::create(['count' => 12]);

    $screen = Native::visit("/counter/{$click->getRouteKey()}")
        ->assertScreen(CounterWithClick::class)
        ->assertSet('count', 12)
        ->assertSet('section', 'overview')
        ->assertSet('propertyHydratedBeforeMount', true)
        ->assertSet('mountResolution', "Container injected for Click #{$click->getRouteKey()}")
        ->assertSee("Click #{$click->getRouteKey()} · stored count 12");

    expect($screen->get('click')->is($click))->toBeTrue();
});

it('injects models, services, and backed enums into actions', function () {
    $click = Click::create(['count' => 4]);

    Native::visit("/counter/{$click->getRouteKey()}")
        ->call('resolveAction', (string) $click->getRouteKey(), 'inspect')
        ->assertSet(
            'actionResolution',
            "Action resolved Click #{$click->getRouteKey()} + service + inspect enum",
        );
});

it('runs dotted state hooks in component order', function () {
    $click = Click::create(['count' => 4]);

    Native::visit("/counter/{$click->getRouteKey()}")
        ->set('profile.name', 'Caleb')
        ->assertSet('profile.name', 'Caleb')
        ->assertSet('hookLog', [
            'updating(profile.name, Caleb)',
            'updatingProfile(Caleb, name)',
            'updatingProfileName(Caleb, name)',
            'updated(profile.name, Caleb)',
            'updatedProfile(Caleb, name)',
            'updatedProfileName(Caleb, name)',
        ]);
});

it('protects locked state through the same mutation pipeline', function () {
    $click = Click::create(['count' => 4]);

    Native::visit("/counter/{$click->getRouteKey()}")
        ->set('lockedClickId', 999);
})->throws(LockedPropertyException::class);

it('skips exactly one render for attribute and imperative renderless actions', function () {
    $click = Click::create(['count' => 12]);

    Native::visit("/counter/{$click->getRouteKey()}")
        ->assertRenderCount(1)
        ->call('incrementRenderless')
        ->assertSet('count', 13)
        ->assertRenderCount(1)
        ->assertNotRerendered()
        ->call('incrementAndSkip')
        ->assertSet('count', 14)
        ->assertRenderCount(1)
        ->call('revealPhpState')
        ->assertRenderCount(2)
        ->assertSee('Rendered count: 14');
});

it('dispatches bubbling, self-only, and class-targeted component events', function () {
    $click = Click::create(['count' => 8]);

    Native::visit("/counter/{$click->getRouteKey()}")
        ->call('dispatchBubbling')
        ->call('dispatchToSelf')
        ->call('dispatchToClass')
        ->assertSet('eventLog', [
            'bubble event received at count 8 (listener service injected)',
            'self event received at count 8 (listener service injected)',
            'targeted event received at count 8 (listener service injected)',
        ])
        ->assertDispatched('parity-notice', mode: 'bubble')
        ->assertDispatchedTo(CounterWithClick::class, 'parity-notice', mode: 'targeted');
});

it('uses Laravel optional parameters, constraints, and query separation', function () {
    $click = Click::create(['count' => 8]);

    Native::visit("/counter/{$click->getRouteKey()}/details?source=test")
        ->assertSet('section', 'details')
        ->assertSet('click.id', $click->getKey());

    expect(NativeRouter::resolve('/counter/not-a-number'))->toBeNull();
});
