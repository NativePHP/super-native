<?php

use Native\Mobile\Edge\NativeRouter;
use Native\Mobile\Testing\Native;

/**
 * App-wide accessibility audit. Every registered native route is rendered
 * and swept with the wire-tree audit behind assertAccessible() — new
 * screens are covered automatically via NativeRouter::registeredRoutes().
 *
 * Parameterized routes are visited as a representative instance ({id} → 0);
 * the demo fixtures fall back to their first record for unknown ids.
 */

// Bridge-driven mounts (vibe/geo talk to the bridge or network on mount)
// and deliberately slow screens (reactivity's #[Lazy] sleep) — the same
// exclusions DemoScreensSmokeTest documents.
function a11ySkipList(): array
{
    return ['/vibe-login', '/vibe', '/vibe-private', '/vibe-presence', '/geo-watch', '/reactivity'];
}

it('renders every registered screen accessibly', function () {
    $uris = array_keys(NativeRouter::registeredRoutes());

    expect($uris)->not->toBeEmpty();

    $renderErrors = [];
    $violations = [];
    $audited = 0;

    foreach ($uris as $uri) {
        if (in_array($uri, a11ySkipList(), true)) {
            continue;
        }

        $visit = preg_replace('/\{[^}]+\}/', '0', $uri);

        try {
            $found = Native::visit($visit)->accessibilityViolations();
        } catch (\Throwable $e) {
            $renderErrors[$uri] = get_class($e).': '.$e->getMessage();

            continue;
        }

        if ($found !== []) {
            $violations[$uri] = $found;
        }

        $audited++;
    }

    $report = '';

    foreach ($violations as $uri => $list) {
        $report .= "\n[$uri]\n  - ".implode("\n  - ", $list);
    }
    foreach ($renderErrors as $uri => $error) {
        $report .= "\n[$uri] failed to render: $error";
    }

    expect($violations)->toBe([], "Accessibility violations:$report");
    expect($renderErrors)->toBe([], "Screens failed to render:$report");
    expect($audited)->toBeGreaterThan(50);
});
