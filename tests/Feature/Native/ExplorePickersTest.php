<?php

use App\NativeComponents\ExplorePickers;
use Native\Mobile\Testing\Native;
use PHPUnit\Framework\AssertionFailedError;

/**
 * Date & time picker screen. The point of these is the WIRE CONTRACT —
 * that what reaches PHP is a wall-clock ISO string shaped by `mode`, and
 * that nothing (timezone, locale) quietly rewrites it.
 */

/** Every date_picker node in the rendered tree, flattened. */
function pickerNodes(array $node, array &$found = []): array
{
    if (($node['type'] ?? null) === 'date_picker') {
        $found[] = $node['props'];
    }
    foreach ($node['children'] ?? [] as $child) {
        pickerNodes($child, $found);
    }

    return $found;
}

it('renders the picker screen', function () {
    Native::visit('/explore/pickers')
        ->assertScreen(ExplorePickers::class)
        ->assertElement('date_picker');
});

it('renders every mode, style and state on the screen', function () {
    $props = pickerNodes(Native::visit('/explore/pickers')->tree());

    expect($props)->toHaveCount(10);

    $modes = array_column($props, 'mode');
    expect($modes)->toContain('time')->toContain('datetime');

    $styles = array_filter(array_column($props, 'picker_style'));
    expect($styles)->toContain('inline')->toContain('wheel');
});

it('serializes each mode to its wall-clock ISO shape', function () {
    $props = pickerNodes(Native::visit('/explore/pickers')->tree());
    $byLabel = collect($props)->keyBy('label');

    expect($byLabel['Starts']['value'])->toBe('2026-07-25');
    expect($byLabel['Opens at']['value'])->toBe('09:30');
    expect($byLabel['Appointment']['value'])->toBe('2026-07-25T09:30');
});

it('keeps an empty value as an explicit empty string', function () {
    $props = pickerNodes(Native::visit('/explore/pickers')->tree());
    $deadline = collect($props)->firstWhere('label', 'Deadline');

    expect($deadline)->toHaveKey('value');
    expect($deadline['value'])->toBe('');
});

it('serializes bounds alongside the value', function () {
    $props = pickerNodes(Native::visit('/explore/pickers')->tree());
    $bounded = collect($props)->firstWhere('label', 'In July');

    expect($bounded['min'])->toBe('2026-07-01');
    expect($bounded['max'])->toBe('2026-07-31');
});

it('passes timezone and locale through without touching the value', function () {
    $props = pickerNodes(Native::visit('/explore/pickers')->tree());
    $termin = collect($props)->firstWhere('label', 'Termin');

    expect($termin['timezone'])->toBe('Europe/Berlin');
    expect($termin['locale'])->toBe('de-DE');
    expect($termin['hour_format'])->toBe('24');
    // The whole point: German display, unshifted wall-clock value.
    expect($termin['value'])->toBe('2026-07-25T14:00');
});

it('carries translated dialog chrome for Android', function () {
    $props = pickerNodes(Native::visit('/explore/pickers')->tree());
    $termin = collect($props)->firstWhere('label', 'Termin');

    expect($termin['confirm_label'])->toBe('Übernehmen');
    expect($termin['cancel_label'])->toBe('Abbrechen');
    expect($termin['title'])->toBe('Termin wählen');
});

it('marks the disabled picker disabled', function () {
    $props = pickerNodes(Native::visit('/explore/pickers')->tree());

    expect(collect($props)->firstWhere('label', 'Locked')['disabled'])->toBeTrue();
});

it('plumbs a11y labels onto every picker', function () {
    $props = pickerNodes(Native::visit('/explore/pickers')->tree());

    foreach ($props as $p) {
        expect($p['a11y_label'] ?? '')->not->toBe('');
    }
});

// ── Two-way binding + events ────────────────────────────────────────────────

it('syncs a picked value back into the bound model property', function () {
    Native::visit('/explore/pickers')
        ->pickDate('date', '2026-12-24')
        ->assertSet('date', '2026-12-24')
        ->assertPickerValue('Starts', '2026-12-24')
        ->assertSee('2026-12-24');
});

it('syncs a time pick in 24-hour wire form', function () {
    Native::visit('/explore/pickers')
        ->pickTime('time', '18:05')
        ->assertSet('time', '18:05')
        ->assertPickerValue('Opens at', '18:05');
});

it('syncs a datetime pick', function () {
    Native::visit('/explore/pickers')
        ->pickDateTime('datetime', '2027-03-01T07:45')
        ->assertSet('datetime', '2027-03-01T07:45')
        ->assertPickerValue('Appointment', '2027-03-01T07:45');
});

it('fires @change on a picker that has no model binding', function () {
    Native::visit('/explore/pickers')
        ->pickDateTime('noteChange', '2026-09-09T12:00')
        ->assertSet('lastEvent', '2026-09-09T12:00');
});

it('reports a cleared selection distinctly from a value', function () {
    Native::visit('/explore/pickers')
        ->clearPicker('noteChange')
        ->assertSet('lastEvent', '(cleared)');
});

// ── Testing macros ──────────────────────────────────────────────────────────

it('normalizes a DateTimeInterface through the pick macros', function () {
    Native::visit('/explore/pickers')
        ->pickDate('date', new DateTimeImmutable('2026-12-24 14:30:59'))
        ->assertSet('date', '2026-12-24');
});

it('truncates an over-precise string to the mode the macro targets', function () {
    Native::visit('/explore/pickers')
        ->pickTime('time', '2026-12-24T18:05:59Z')
        ->assertSet('time', '18:05');
});

it('asserts a picker exists and its mode', function () {
    Native::visit('/explore/pickers')
        ->assertPicker('Starts')
        ->assertPicker('Opens at', 'time')
        ->assertPicker('Appointment', 'datetime');
});

it('asserts an empty picker', function () {
    Native::visit('/explore/pickers')->assertPickerEmpty('Deadline');
});

it('fails assertPickerValue when the value differs', function () {
    Native::visit('/explore/pickers')->assertPickerValue('Starts', '1999-01-01');
})->throws(AssertionFailedError::class);

it('fails assertPicker for a label that is not a picker', function () {
    Native::visit('/explore/pickers')->assertPicker('Nope');
})->throws(AssertionFailedError::class);
