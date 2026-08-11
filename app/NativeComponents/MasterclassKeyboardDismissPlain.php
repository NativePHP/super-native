<?php

namespace App\NativeComponents;

/**
 * The chrome-LESS twin of [MasterclassKeyboardDismiss] — the case that always
 * worked, kept for side-by-side comparison (mobile-air #308).
 *
 * A subclass rather than a route default because `Route::native(...)`
 * parameters land in the component's `nativeParams` bag and are never bound to
 * public properties, so `->defaults('chrome', false)` would silently do
 * nothing and this screen would claim to have no chrome while having it.
 *
 * Registered OUTSIDE the StackLayout group in routes/mobile.php — that
 * placement is the only thing that makes it chrome-less.
 */
class MasterclassKeyboardDismissPlain extends MasterclassKeyboardDismiss
{
    public bool $chrome = false;
}
