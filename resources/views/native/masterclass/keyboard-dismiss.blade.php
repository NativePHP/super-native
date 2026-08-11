<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-8">

        <column class="gap-1">
            <text class="text-2xl font-bold">#308 · Keyboard dismiss</text>
            @if($chrome)
                <text class="text-sm font-bold text-emerald-600">
                    This screen HAS native chrome (stack layout — note the title bar above).
                    This is the case that was broken.
                </text>
            @else
                <text class="text-sm font-bold text-sky-600">
                    This screen has NO native chrome. This is the case that always worked —
                    open it side by side with the chrome version to compare.
                </text>
            @endif
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             1. The repro. Focus the field, then tap the empty space.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">1. Tap outside to dismiss</text>
            <text class="text-sm opacity-60">
                Focus the field, then tap anywhere in the grey area below. The keyboard
                should go away. Before the fix it stayed up on this screen and the only
                way out was to drag the page down.
            </text>

            <outlined-text-input native:model="message" label="Message" />

            <column class="w-full h-40 bg-zinc-200 items-center justify-center rounded-xl">
                <text class="opacity-60">Tap here — empty space</text>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             2. The gesture must not SWALLOW taps. simultaneousGesture runs
                alongside the button's own tap; onTapGesture would have
                eaten it. Worth checking explicitly — a dismiss that also
                broke every button would be a worse bug than the original.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">2. Buttons still work</text>
            <text class="text-sm opacity-60">
                The dismiss gesture is `simultaneousGesture`, so it runs alongside taps
                rather than consuming them. With the keyboard UP, tapping this button
                must BOTH dismiss the keyboard and increment the counter — not one or
                the other.
            </text>

            <row class="w-full items-center gap-3">
                <button variant="secondary" @tap="countTap">Tap me</button>
                <text class="text-lg font-bold">{{ $taps }}</text>
                @if($taps > 0)
                    <button variant="tertiary" size="sm" @tap="resetTaps">Reset</button>
                @endif
            </row>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             3. Drag-to-dismiss is SwiftUI's own scrollDismissesKeyboard and
                was never part of this bug — but it is the workaround the
                issue described, so confirm it still works.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">3. Drag still dismisses</text>
            <text class="text-sm opacity-60">
                Unrelated to the fix — this is SwiftUI's own scrollDismissesKeyboard, and
                it is the workaround the issue was stuck with. Focus the field and drag
                this page downward; it should still dismiss.
            </text>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             4. The other chrome kind. Both renderers were changed; this
                screen only exercises the stack one.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">4. Also check a TAB layout</text>
            <text class="text-sm opacity-60">
                NativeRootTabsRenderer got the same fix and this screen does not exercise
                it. The SyncUp Native chat screen is a text field inside a tab layout —
                the exact shape the issue was filed from. Check tap-to-dismiss there too.
            </text>
        </column>

        <column class="h-64"></column>
    </column>
</scroll-view>
