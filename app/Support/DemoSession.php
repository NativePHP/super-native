<?php

namespace App\Support;

/**
 * Toy auth state for the route-middleware demo, plus a log of everything the
 * middleware did.
 *
 * Static rather than session-backed on purpose: the demo needs to survive
 * across screens in one runloop and be readable from both the middleware and
 * the screens, without dragging a real auth guard into a demo app.
 */
class DemoSession
{
    private static bool $signedIn = false;

    /** @var array<int, string> */
    private static array $log = [];

    public static function signedIn(): bool
    {
        return static::$signedIn;
    }

    public static function signIn(): void
    {
        static::$signedIn = true;
        static::record('Signed in');
    }

    public static function signOut(): void
    {
        static::$signedIn = false;
        static::record('Signed out');
    }

    public static function record(string $line): void
    {
        static::$log[] = date('H:i:s').'  '.$line;

        // Keep the on-screen log short enough to read at a glance.
        if (count(static::$log) > 8) {
            static::$log = array_slice(static::$log, -8);
        }
    }

    /** @return array<int, string> */
    public static function log(): array
    {
        return static::$log;
    }

    public static function clearLog(): void
    {
        static::$log = [];
    }
}
