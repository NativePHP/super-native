<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Attributes\On;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Events\PushNotification\TokenGenerated;
use Native\Mobile\Facades\PushNotifications;
use Native\Mobile\Facades\Share;

/**
 * Shows the device's push token so it can be pasted into the Firebase
 * console ("Send test message" → "Add an FCM registration token").
 *
 * There are two ways to get the token, and this screen exposes both because
 * they fail differently:
 *
 *   getToken()  is SYNCHRONOUS — it round-trips the bridge and returns the
 *               token, or null. Null means the device has not registered
 *               yet, which is the normal state before permission is granted.
 *
 *   enroll()    is ASYNCHRONOUS — it asks for notification permission and
 *               registers with FCM/APNs, then dispatches TokenGenerated when
 *               the platform hands the token back. That can be a second or
 *               two after the tap, so it arrives at #[On] rather than as a
 *               return value.
 *
 * Cold start on a fresh install: permission is "not_determined" and
 * getToken() returns null. Tap Enable first, accept the prompt, and the
 * token lands via the event.
 *
 * The token is FCM on Android and an APNs token on iOS. Firebase accepts the
 * FCM one; for iOS you generally send through FCM too, which maps it.
 */
class PushTokenDemo extends NativeComponent
{
    public string $token = '';

    public string $permission = '';

    public string $status = 'Tap "Check permission" to start.';

    /** Set when the token arrived via the async enrollment event. */
    public bool $fromEvent = false;

    public function navTitle(): string
    {
        return 'Push Token';
    }

    public function mount(): void
    {
        $this->permission = PushNotifications::checkPermission() ?? 'unknown';
    }

    public function checkPermission(): void
    {
        $this->permission = PushNotifications::checkPermission() ?? 'unknown';
        $this->status = 'Permission is "'.$this->permission.'".';
    }

    /**
     * Asks for permission and registers with the push service. The token
     * does not come back here — it arrives at onTokenGenerated() below.
     */
    public function enable(): void
    {
        $this->status = 'Requesting permission… the token will appear when the platform returns it.';
        $this->fromEvent = false;

        PushNotifications::enroll();
    }

    /**
     * The async half of enroll(). TokenGenerated carries the event's public
     * properties as named arguments.
     */
    #[On(TokenGenerated::class)]
    public function onTokenGenerated(string $token, ?string $id = null): void
    {
        $this->token = $token;
        $this->fromEvent = true;
        $this->permission = PushNotifications::checkPermission() ?? 'unknown';
        $this->status = 'Token received from enrollment.';
    }

    /**
     * The sync read. Returns null until the device has actually registered,
     * so an empty result here is a prompt to tap Enable, not an error.
     */
    public function fetchToken(): void
    {
        $token = PushNotifications::getToken();

        $this->fromEvent = false;

        if ($token === null) {
            $this->token = '';
            $this->status = 'No token yet. Tap "Enable notifications" first, then try again.';

            return;
        }

        $this->token = $token;
        $this->status = 'Token read directly from the bridge.';
    }

    /**
     * Opens the native share sheet with the token as its payload. "Copy" in
     * that sheet puts it on the device clipboard — and Android Studio's
     * emulator shares its clipboard with the host, so it pastes straight
     * into the Firebase console.
     */
    public function shareToken(): void
    {
        if ($this->token === '') {
            $this->status = 'Nothing to share yet — get a token first.';

            return;
        }

        Share::url('FCM registration token', $this->token, '');
    }

    public function clear(): void
    {
        $this->token = '';
        $this->fromEvent = false;
        $this->status = 'Cleared.';
    }

    public function render(): View
    {
        return view('native.push-token-demo');
    }
}
