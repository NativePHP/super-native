<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-8">

        <column class="gap-1">
            <text class="text-2xl font-bold">#311 · Per-corner radius</text>
            <text class="text-sm opacity-60">
                Identical results expected on iOS and Android. Sections 1–5 are the
                five blocks from the issue, in order.
            </text>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             1–5. The issue's own repro, verbatim. Before the fix: block 2
             was indistinguishable from 1, blocks 3 and 4 rendered fully
             square, and block 5 was indistinguishable from 1.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">1. rounded-2xl (all corners)</text>
            <text class="text-sm opacity-60">The uniform case — worked all along.</text>
            <column class="w-full items-start">
                <column class="rounded-2xl bg-red-300 px-4 py-3">
                    <text>All four corners</text>
                </column>
            </column>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">2. rounded-2xl rounded-br-none</text>
            <text class="text-sm opacity-60">
                Bottom-right square, other three still 16. Was identical to block 1.
            </text>
            <column class="w-full items-start">
                <column class="rounded-2xl rounded-br-none bg-red-300 px-4 py-3">
                    <text>Bottom-right squared off</text>
                </column>
            </column>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">3. rounded-tl-2xl only</text>
            <text class="text-sm opacity-60">
                One corner rounded, three square. Was fully square.
            </text>
            <column class="w-full items-start">
                <column class="rounded-tl-2xl bg-red-300 px-4 py-3">
                    <text>Top-left only</text>
                </column>
            </column>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">4. rounded-t-2xl (top pair)</text>
            <text class="text-sm opacity-60">
                A side expands to its two corners. Was fully square.
            </text>
            <column class="w-full items-start">
                <column class="rounded-t-2xl bg-red-300 px-4 py-3">
                    <text>Top two corners</text>
                </column>
            </column>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">5. rounded-2xl rounded-br-[4px]</text>
            <text class="text-sm opacity-60">
                Arbitrary value on one corner. Was identical to block 1 — this one
                failed in parseArbitrary rather than parseRounded.
            </text>
            <column class="w-full items-start">
                <column class="rounded-2xl rounded-br-[4px] bg-red-300 px-4 py-3">
                    <text>Bottom-right small</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             6. Class ORDER must not matter. PHP keeps the uniform and the
                per-corner values as separate keys and resolves them at
                collection time, so the corner wins either way — as it does
                in Tailwind, where the longhand always follows the shorthand
                in the generated stylesheet.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">6. Class order is irrelevant</text>
            <text class="text-sm opacity-60">
                These two must be pixel-identical. If they differ, the uniform radius is
                clobbering the corner (or vice versa) depending on which was written last.
            </text>
            <row class="w-full gap-3">
                <column class="rounded-2xl rounded-br-none bg-emerald-300 px-4 py-3">
                    <text>uniform first</text>
                </column>
                <column class="rounded-br-none rounded-2xl bg-emerald-300 px-4 py-3">
                    <text>corner first</text>
                </column>
            </row>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             7. Every side and corner spelling, plus the bare-side default.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">7. All sides and corners</text>
            <text class="text-sm opacity-60">
                A bare side (rounded-b, no size) takes the same 4pt default a bare
                `rounded` does.
            </text>

            <row class="w-full gap-3">
                <column class="rounded-t-lg bg-sky-300 px-3 py-3"><text>t</text></column>
                <column class="rounded-r-lg bg-sky-300 px-3 py-3"><text>r</text></column>
                <column class="rounded-b-lg bg-sky-300 px-3 py-3"><text>b</text></column>
                <column class="rounded-l-lg bg-sky-300 px-3 py-3"><text>l</text></column>
            </row>

            <row class="w-full gap-3">
                <column class="rounded-tl-lg bg-violet-300 px-3 py-3"><text>tl</text></column>
                <column class="rounded-tr-lg bg-violet-300 px-3 py-3"><text>tr</text></column>
                <column class="rounded-br-lg bg-violet-300 px-3 py-3"><text>br</text></column>
                <column class="rounded-bl-lg bg-violet-300 px-3 py-3"><text>bl</text></column>
            </row>

            <column class="w-full items-start">
                <column class="rounded-b bg-amber-300 px-4 py-3">
                    <text>rounded-b → 4pt on the bottom pair</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             8. The border overlay and the clip have to take the SAME
                asymmetric outline as the background, or a bordered bubble
                shows a rounded stroke over a squared-off fill.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">8. Border follows the same outline</text>
            <text class="text-sm opacity-60">
                The stroke must square off at the bottom-right too — it is drawn from a
                separate shape to the background, so this is a real thing to get wrong.
                It must also stay INSIDE the box (strokeBorder, not stroke).
            </text>
            <column class="w-full items-start">
                <column class="rounded-2xl rounded-br-none border-2 border-indigo-600 bg-indigo-100 px-4 py-3">
                    <text>Bordered, bottom-right squared</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             9. Deliberately unsupported — logical/writing-direction corners.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">9. rounded-s-* is intentionally NOT supported</text>
            <text class="text-sm opacity-60">
                Tailwind's logical corners resolve against writing direction, and neither
                renderer flips corners for RTL — accepting them would silently render LTR
                geometry in an RTL layout. This box is square, and the class is reported
                in the dropped-class log. Use the physical rounded-l-* instead.
            </text>
            <column class="w-full items-start">
                <column class="rounded-s-2xl bg-red-300 px-4 py-3">
                    <text>rounded-s-2xl → dropped</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             10. The motivating use case: an asymmetric chat bubble whose
                 tail corner is squared off toward its owner. The issue
                 noted there was no workaround for this at all.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">10. Why it mattered — bubble tails</text>
            <text class="text-sm opacity-60">
                Three corners rounded, the one nearest the sender squared off so the
                bubble points at its owner. There was previously no way to express this.
            </text>

            <column class="w-full bg-blue-200 p-2 gap-2">
                <column class="w-full items-start">
                    <column class="rounded-2xl rounded-bl-none bg-zinc-300 px-4 py-2">
                        <text>Incoming — tail bottom-left</text>
                    </column>
                </column>

                <column class="w-full items-end">
                    <column class="rounded-2xl rounded-br-none bg-sky-400 px-4 py-2">
                        <text class="text-white">Outgoing — tail bottom-right</text>
                    </column>
                </column>
            </column>
        </column>

        <column class="h-8"></column>
    </column>
</scroll-view>
