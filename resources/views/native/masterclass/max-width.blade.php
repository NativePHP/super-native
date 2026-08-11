<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-8">

        <column class="gap-1">
            <text class="text-2xl font-bold">#310 · max-w-*</text>
            <text class="text-sm opacity-60">
                Pale blue = the full available width. Red = what the child occupies.
                Identical results expected on iOS and Android.
            </text>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             1–3. The exact three blocks from the issue. Block 3 used to
             render identically to block 1 (constraint absent); it should
             now match block 2's clamp while still WRAPPING rather than
             padding out to the maximum.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">1. No constraint (baseline)</text>
            <column class="w-full items-start bg-blue-200 p-1">
                <column class="bg-red-300 px-3 py-2">
                    <text>{{ $longText }}</text>
                </column>
            </column>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">2. w-[280px] (was already working)</text>
            <text class="text-sm opacity-60">Clamps at 280 — proves widths were parsed all along.</text>
            <column class="w-full items-start bg-blue-200 p-1">
                <column class="w-[280px] bg-red-300 px-3 py-2">
                    <text>{{ $longText }}</text>
                </column>
            </column>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">3. max-w-[280px] — the fix</text>
            <text class="text-sm opacity-60">
                Should now look like block 2. Before the fix this was indistinguishable
                from block 1.
            </text>
            <column class="w-full items-start bg-blue-200 p-1">
                <column class="max-w-[280px] bg-red-300 px-3 py-2">
                    <text>{{ $longText }}</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             4. A maximum is a CEILING, not a fixed width — short content
             must still hug. This is the check the issue explicitly called
             out ("not a case of the maximum being applied as a fixed
             width"), so getting block 3 to clamp is only half a pass.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">4. Ceiling, not a fixed width</text>
            <text class="text-sm opacity-60">
                Same max-w-[280px], short content. Must HUG the text — if it padded out
                to 280 the constraint would be mis-implemented as a width.
            </text>
            <column class="w-full items-start bg-blue-200 p-1">
                <column class="max-w-[280px] bg-red-300 px-3 py-2">
                    <text>Short</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             5. Named container scale — the issue confirmed `max-w-sm`
             failed too, so both spellings need covering.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">5. Named scale + spacing scale</text>
            <text class="text-sm opacity-60">
                max-w-64 = 256pt (spacing scale). max-w-xs = 320pt (container scale).
                Most container sizes are wider than a phone, so they simply never bind —
                which is correct, not a failure.
            </text>

            <column class="w-full items-start bg-blue-200 p-1">
                <column class="max-w-64 bg-red-300 px-3 py-2">
                    <text>max-w-64 → 256pt</text>
                </column>
            </column>

            <column class="w-full items-start bg-blue-200 p-1">
                <column class="max-w-xs bg-red-300 px-3 py-2">
                    <text>{{ $longText }}</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             6. The ordering case iOS got wrong independently of the parser:
             `resolvedMaxWidth` returned .infinity as soon as widthMode was
             FILL, so the bound never applied. On Android the equivalent is
             the modifier ORDER — widthIn must narrow the constraints BEFORE
             fillMaxWidth consumes them.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">6. w-full + max-w-* together</text>
            <text class="text-sm opacity-60">
                Fills up TO the bound, then stops. This combination is the one that
                needed a fix on each platform beyond the parser.
            </text>
            <column class="w-full items-start bg-blue-200 p-1">
                <column class="w-full max-w-[280px] bg-red-300 px-3 py-2">
                    <text>w-full max-w-[280px]</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             7. The other three constraints, which were missing for the
             same reason and are fixed by the same plumbing.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">7. min-w / min-h / max-h</text>
            <text class="text-sm opacity-60">
                min-w-48 floors a short label at 192pt; min-h-24 floors a one-line box at
                96pt; max-h-16 caps a tall box at 64pt.
            </text>

            <column class="w-full items-start bg-blue-200 p-1">
                <column class="min-w-48 bg-red-300 px-3 py-2">
                    <text>min-w-48</text>
                </column>
            </column>

            <column class="w-full items-start bg-blue-200 p-1">
                <column class="min-h-24 bg-red-300 px-3 py-2">
                    <text>min-h-24</text>
                </column>
            </column>

            <column class="w-full items-start bg-blue-200 p-1">
                <column class="max-h-16 bg-red-300 px-3 py-2">
                    <text>max-h-16 caps this box even though its content is taller than 64pt would allow.</text>
                </column>
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             8. Deliberately unsupported. Left unparsed so `php artisan`
             logs them as dropped classes in debug builds instead of them
             looking supported-but-broken.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">8. max-w-full is intentionally NOT supported</text>
            <text class="text-sm opacity-60">
                The wire carries min/max as bare floats with no size mode, so "100% of
                the parent" has nowhere to go. This box is unconstrained, and the class
                is reported in the dropped-class log rather than failing silently. Use
                w-full for this.
            </text>
            <column class="w-full items-start bg-blue-200 p-1">
                <column class="max-w-full bg-red-300 px-3 py-2">
                    <text>{{ $longText }}</text>
                </column>
            </column>
        </column>

        <column class="h-8"></column>
    </column>
</scroll-view>
