{{-- Root is a plain column, NOT a scroll-view: each case below is its own
     fixed-height scroll-view so the "viewport" is a visible box you can
     compare against. Nesting vertical scroll views would also fight for the
     drag gesture on iOS. --}}
<column class="w-full h-full p-4 gap-4 bg-theme-background">

    <column class="gap-1">
        <text class="text-xl font-bold">#303 · Centering in scroll-view</text>
        <text class="text-sm opacity-60">
            Each blue box is a scroll-view with a fixed 160pt height — that is the
            viewport. The red box is a `fill` child asking to be at least that tall.
        </text>
    </column>

    {{-- ─────────────────────────────────────────────────────────────
         1. The repro. Before the fix the red box hugged its text and sat
            at the top, because nothing inside a scroll view knows the
            viewport height.
    ───────────────────────────────────────────────────────────────── --}}
    <column class="gap-1">
        <text class="font-bold">1. fill + justify-center inside scroll-view</text>
        <scroll-view class="w-full h-40 bg-blue-200">
            <column fill class="w-full items-center justify-center bg-red-300">
                <text>Should be centered</text>
            </column>
        </scroll-view>
    </column>

    {{-- ─────────────────────────────────────────────────────────────
         2. The control from the issue — the same markup in a plain
            column, which always worked. These two must now match.
    ───────────────────────────────────────────────────────────────── --}}
    <column class="gap-1">
        <text class="font-bold">2. Same markup in a plain column (control)</text>
        <column class="w-full h-40 items-center justify-center bg-blue-200">
            <column class="bg-red-300 p-2">
                <text>Centered</text>
            </column>
        </column>
    </column>

    {{-- ─────────────────────────────────────────────────────────────
         3. It is a MINIMUM, not a fixed height. Content taller than the
            viewport must still grow and scroll — the same as CSS
            min-height: 100%. If this squashed to 160pt instead of
            scrolling, the fix would be wrong in the other direction.
    ───────────────────────────────────────────────────────────────── --}}
    <column class="gap-1">
        <text class="font-bold">3. Taller than the viewport — still scrolls</text>
        <text class="text-sm opacity-60">Drag inside this one; it must not squash to 160pt.</text>
        <scroll-view class="w-full h-40 bg-blue-200">
            <column fill class="w-full items-center justify-center bg-red-300 gap-2 py-4">
                <text>Row 1 of 8</text>
                <text>Row 2 of 8</text>
                <text>Row 3 of 8</text>
                <text>Row 4 of 8</text>
                <text>Row 5 of 8</text>
                <text>Row 6 of 8</text>
                <text>Row 7 of 8</text>
                <text>Row 8 of 8 — scroll to see me</text>
            </column>
        </scroll-view>
    </column>

    <column class="gap-1">
        <text class="text-sm opacity-60">
            The realistic full-screen version of this — a login screen centred in the
            viewport that still scrolls when the keyboard appears — is at
            /masterclass/scroll-center-login.
        </text>
    </column>

</column>
