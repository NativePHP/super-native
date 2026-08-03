<scroll-view>
    <column class="w-full h-full px-6 gap-6 py-8 bg-theme-background">
        <text class="text-2xl font-extrabold text-theme-on-background">Gesture playground</text>

        {{-- Single tap + long press on one node — they coexist cleanly. --}}
        <stack @tap="tapped" @longTap="longPressed"
               class="w-full bg-theme-accent rounded-3xl shadow-xl p-8 items-center justify-center">
            <text class="text-theme-on-accent text-center text-xl font-semibold">Tap or long-press</text>
        </stack>

        {{-- Double-tap target. Uses @doubleTap alone (no @press) for a clean demo. --}}
        <stack @doubleTap="doubleTapped"
               class="w-full bg-theme-primary rounded-3xl shadow-xl p-8 items-center justify-center">
            <text class="text-theme-on-primary text-center text-xl font-semibold">Double-tap</text>
        </stack>

        {{-- Latest gesture + per-gesture counters --}}
        <text class="text-center text-base font-medium text-theme-on-background">{{ $gesture }}</text>

        <row class="gap-4">
            <column class="flex-1 bg-theme-surface-variant rounded-2xl p-5 items-center gap-1">
                <text class="text-3xl font-extrabold text-theme-accent">{{ $taps }}</text>
                <text class="text-sm text-theme-on-surface-variant">taps</text>
            </column>
            <column class="flex-1 bg-theme-surface-variant rounded-2xl p-5 items-center gap-1">
                <text class="text-3xl font-extrabold text-theme-accent">{{ $longPresses }}</text>
                <text class="text-sm text-theme-on-surface-variant">long-presses</text>
            </column>
        </row>

        <row class="gap-4">
            <column class="flex-1 bg-theme-surface-variant rounded-2xl p-5 items-center gap-1">
                <text class="text-3xl font-extrabold text-theme-primary">{{ $doubleTaps }}</text>
                <text class="text-sm text-theme-on-surface-variant">double-taps</text>
            </column>
            <column class="flex-1 bg-theme-surface-variant rounded-2xl p-5 items-center gap-1">
                <text class="text-3xl font-extrabold text-theme-primary">{{ $shakes }}</text>
                <text class="text-sm text-theme-on-surface-variant">shakes</text>
            </column>
        </row>
    </column>
</scroll-view>
