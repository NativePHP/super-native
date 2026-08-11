<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-8">

        <column class="gap-1">
            <text class="text-2xl font-bold">#309 · items-start vs items-stretch</text>
            <text class="text-sm opacity-60">
                Pale blue = the full available width. The coloured box inside = what the
                child actually occupies. Every section below should look IDENTICAL on
                iOS and Android.
            </text>
            <text class="text-sm opacity-60">
                Fixed by giving explicit start its own wire value (4). 0 now means UNSET,
                so both renderers keep their existing default — nothing in an existing
                app moves. Section 3 is the part that is still deliberately left alone.
            </text>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             1. The exact repro from the issue.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">1. The reported repro</text>
            <text class="text-sm opacity-60">
                Expected: the red box HUGS its text; the green box FILLS the width.
            </text>

            <column class="w-full items-start bg-blue-200 p-2">
                <column class="bg-red-300 p-3">
                    <text>items-start → hugs</text>
                </column>
            </column>

            <column class="w-full items-stretch bg-blue-200 p-2">
                <column class="bg-green-300 p-3">
                    <text>items-stretch → fills</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             2. The other two alignments were never broken — they're here
                so a regression in the swap would show up immediately.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">2. center &amp; end still correct</text>
            <text class="text-sm opacity-60">
                Both hug their content; one sits centred, the other on the trailing edge.
            </text>

            <column class="w-full items-center bg-blue-200 p-2">
                <column class="bg-amber-300 p-3">
                    <text>items-center</text>
                </column>
            </column>

            <column class="w-full items-end bg-blue-200 p-2">
                <column class="bg-purple-300 p-3">
                    <text>items-end</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             3. No items-* class at all — the UNSET slot (wire 0), which is
                now distinct from items-start. Deliberately NOT unified:
                the two platforms still disagree here, and reconciling them
                moves every unclassed container on one side or the other.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">3. No items-* class — UNSET ⚠️</text>
            <text class="text-sm opacity-60">
                THE ONE SECTION EXPECTED TO DIFFER. iOS fills (CSS's default for
                align-items); Android content-sizes. Both are unchanged by this fix —
                that is the point, it is what keeps existing apps still.
            </text>
            <text class="text-sm opacity-60">
                Unifying this is a separate call: making Android fill would move every
                unclassed Android container.
            </text>

            <column class="w-full bg-blue-200 p-2">
                <column class="bg-red-300 p-3">
                    <text>no class → iOS fills, Android hugs</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             4. w-full is the child's own opt-in to the full cross axis and
                is handled BEFORE the items-* switch (`crossFill`), so it
                must win over items-start.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">4. w-full beats items-start</text>
            <text class="text-sm opacity-60">
                A child that asks for the full width gets it, regardless of the parent's
                items-start — same as CSS align-self: stretch.
            </text>

            <column class="w-full items-start bg-blue-200 p-2">
                <column class="w-full bg-green-300 p-3">
                    <text>w-full inside items-start → fills</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             5. self-* overrides the parent per child. Both renderers do
                `alignSelf > 0 ? alignSelf : align` — which is exactly why
                `self-start` was a silent no-op while Start was 0. Moving
                Start to 4 fixes it on both platforms for free.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">5. self-* overrides the parent</text>
            <text class="text-sm opacity-60">
                Parent is items-stretch (fill). The middle child asks for self-start and
                hugs — that one used to do nothing at all, on BOTH platforms, because
                `self-start` sent 0 and 0 read as "no self-* class". The last asks for
                self-end.
            </text>

            <column class="w-full items-stretch bg-blue-200 p-2 gap-2">
                <column class="bg-green-300 p-3">
                    <text>inherits items-stretch → fills</text>
                </column>
                <column class="self-start bg-red-300 p-3">
                    <text>self-start → hugs</text>
                </column>
                <column class="self-end bg-purple-300 p-3">
                    <text>self-end → hugs, trailing</text>
                </column>
            </column>

            <text class="text-sm opacity-60">
                Android needed a second fix here: buildChildModifier consulted align_self
                only to decide whether a child FILLED, never where it sat, so self-center
                and self-end hugged correctly but stayed on the leading edge. Per-child
                placement in Compose needs Modifier.align() inside the layout scope.
            </text>

            <text class="text-sm opacity-60">
                Same thing on a row, where the cross axis is vertical. The tall green box
                sets the row's height; the other three place against it — top, middle,
                bottom. Labels are kept SHORT on purpose: see the note below.
            </text>

            <row class="w-full bg-blue-200 p-2 gap-2">
                <column class="bg-green-300 px-3 py-8">
                    <text>tall</text>
                </column>
                <column class="self-start bg-red-300 px-3 py-2">
                    <text>start</text>
                </column>
                <column class="self-center bg-amber-300 px-3 py-2">
                    <text>center</text>
                </column>
                <column class="self-end bg-purple-300 px-3 py-2">
                    <text>end</text>
                </column>
            </row>

            <text class="text-sm opacity-60">
                ⚠️ Unrelated parity bug found here: give this row long labels and it
                overflows a phone's width, and the two platforms disagree about what
                happens. iOS shrinks every child proportionally (FlexContainer has an
                explicit weighted-shrink pass). Android's Row has no shrink handling at
                all, so children take their measured width in order and the LAST one is
                squeezed into whatever remains — down to one character per line, which
                then makes the row absurdly tall. Not part of #309; filed separately.
            </text>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             6. The motivating use case from the issue: chat bubbles that
                hug their own text and sit on opposite edges.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">6. Why it mattered — chat bubbles</text>
            <text class="text-sm opacity-60">
                The pattern the issue was filed from: each bubble only as wide as its
                own text, incoming on the leading edge, outgoing on the trailing edge.
            </text>

            <column class="w-full bg-blue-200 p-2 gap-2">
                <column class="w-full items-start">
                    <column class="bg-zinc-300 px-4 py-2 rounded-2xl">
                        <text>Hey, are we still on for tonight?</text>
                    </column>
                </column>

                <column class="w-full items-end">
                    <column class="bg-sky-400 px-4 py-2 rounded-2xl">
                        <text class="text-white">Yep — 7pm works</text>
                    </column>
                </column>

                <column class="w-full items-start">
                    <column class="bg-zinc-300 px-4 py-2 rounded-2xl">
                        <text>Perfect, see you then</text>
                    </column>
                </column>
            </column>
        </column>

        <column class="h-8"></column>
    </column>
</scroll-view>
