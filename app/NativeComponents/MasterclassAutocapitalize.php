<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * mobile-air #304 — "Text input autocapitalizes first letter on iOS even with
 * keyboard='email'".
 *
 * Cause: `NativeUITextInputCore` applied `.keyboardType(keyboard)` and nothing
 * else. On iOS `keyboardType` sets the KEY LAYOUT only — it says nothing about
 * capitalization, and an untouched SwiftUI TextField defaults to `.sentences`.
 * So the email keyboard appeared (which is why the issue correctly ruled out
 * `keyboard="email"` being ignored) while the first letter still capitalized.
 *
 * Fix, in two halves, matching the two things the issue asked for:
 *
 *   1. The field type carries its typing behaviour. Every keyboard kind whose
 *      content is case-sensitive or non-alphabetic (email, url, number,
 *      decimal, phone, password) now resolves to `.never`. Autocorrect is
 *      disabled for the same set — iOS will otherwise happily "correct" an
 *      email local part into a dictionary word, which is the same bug wearing
 *      a different hat.
 *
 *   2. A new `autocapitalize` attribute for the cases a keyboard type cannot
 *      imply: "none" | "sentences" | "words" | "characters" (HTML's
 *      vocabulary). It overrides the derived value. Unknown values fall back
 *      to the derived behaviour rather than erroring.
 *
 * Android never had the bug — Compose's KeyboardOptions defaults to no
 * capitalization — but it got there by accident, and `autocapitalize` had
 * nowhere to land. It now resolves the same prop through the same rules.
 *
 * ONE DELIBERATE ASYMMETRY, section 4: for a plain text field with nothing
 * specified, iOS capitalizes sentences and Android does not. Making Android
 * match would mean silently capitalizing every unclassified text field in
 * every existing app, so that default is left alone as a separate decision.
 */
class MasterclassAutocapitalize extends NativeComponent
{
    public string $email = '';

    public string $plain = '';

    public string $url = '';

    public string $name = '';

    public string $code = '';

    public string $forced = '';

    public function navTitle(): string
    {
        return '#304 · Autocapitalization';
    }

    public function render(): View
    {
        return view('native.masterclass.autocapitalize');
    }
}
