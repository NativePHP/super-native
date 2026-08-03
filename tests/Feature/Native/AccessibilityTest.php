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
    return ['/reactivity'];
}
