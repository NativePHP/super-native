{{-- The device's push token, for pasting into Firebase → Cloud Messaging →
     "Send test message". Read this next to PushTokenDemo.php: the sync
     getToken() and the async enroll()/TokenGenerated pair are both here
     because they fail in different ways. --}}
<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        <column class="w-full gap-2">
            <text class="text-sm opacity-60">
                Firebase needs a registration token to target a single device.
                Get one below, copy it, then paste it into Cloud Messaging →
                Send test message.
            </text>
        </column>

        {{-- ── Permission ────────────────────────────────────────────── --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">1 · Permission</text>
            <text class="text-sm opacity-60">
                A fresh install reports "not_determined" and has no token yet.
                Enabling prompts the user and registers with FCM/APNs.
            </text>

            <row class="items-center gap-3 mt-2">
                <text class="text-sm">Status:</text>
                <text class="text-sm font-bold {{ $permission === 'granted' ? 'text-green-600' : 'text-amber-700' }}">
                    {{ $permission !== '' ? $permission : 'unknown' }}
                </text>
            </row>

            <row class="items-center gap-3 flex-wrap">
                <button @tap="checkPermission">Check permission</button>
                <button @tap="enable">Enable notifications</button>
            </row>
        </column>

        {{-- ── Token ─────────────────────────────────────────────────── --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">2 · Token</text>
            <text class="text-sm opacity-60">
                "Get token" is a synchronous bridge read. If enrollment has not
                finished it returns nothing — that is expected, not a failure.
            </text>

            <row class="items-center gap-3 flex-wrap">
                <button @tap="fetchToken">Get token</button>
                @if ($token !== '')
                    <button @tap="clear">Clear</button>
                @endif
            </row>

            @if ($token !== '')
                <column class="w-full p-3 gap-2 mt-2 bg-theme-background rounded-xl">
                    <row class="items-center gap-2">
                        <text class="text-sm font-bold text-theme-primary">
                            {{ $fromEvent ? 'via TokenGenerated event' : 'via getToken()' }}
                        </text>
                        <text class="text-sm opacity-60">{{ strlen($token) }} chars</text>
                    </row>
                    <text class="text-xs">{{ $token }}</text>
                </column>

                <button @tap="shareToken">Share / copy token</button>
                <text class="text-sm opacity-60">
                    Pick "Copy" in the share sheet. The Android Studio emulator
                    shares its clipboard with your Mac, so it pastes straight
                    into the Firebase console.
                </text>
            @else
                <text class="text-sm text-amber-700">
                    No token yet. Enable notifications above, accept the prompt,
                    and it appears here on its own.
                </text>
            @endif
        </column>

        {{-- ── Status line ───────────────────────────────────────────── --}}
        <column class="w-full p-5 gap-2 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">Log</text>
            <text class="text-sm opacity-60">{{ $status }}</text>
        </column>

    </column>
</scroll-view>
