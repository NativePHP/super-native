<scroll-view class="w-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        {{-- TYPOGRAPHY --}}
        <text font="RockSalt-Regular" class="text-2xl font-semibold text-theme-on-background">Typography</text>
        <column class="w-full gap-2">
            <text class="text-xs text-theme-on-surface-variant">text-xs (12pt) — The quick brown fox</text>
            <text class="text-sm text-theme-on-surface-variant">text-sm (14pt) — The quick brown fox</text>
            <text class="text-theme-on-surface-variant">(16pt) — The quick brown fox</text>
            <text class="text-lg text-theme-on-surface-variant">text-lg (18pt) — The quick brown fox</text>
            <text class="text-xl text-theme-on-surface-variant">text-xl (20pt) — The quick brown fox</text>
            <text class="text-2xl text-theme-on-background">text-2xl (24pt)</text>
            <text class="text-3xl text-theme-on-background">text-3xl (30pt)</text>
            <text class="text-4xl text-theme-on-background font-extrabold">text-4xl bold</text>
        </column>

        <divider class="my-2" />

        {{-- TEXT STYLES --}}
        <text class="text-lg font-semibold text-theme-on-background">Text styles</text>
        <column class="w-full gap-2">
            <text class="text-theme-on-surface-variant italic">italic — The quick brown fox</text>
            <text class="text-theme-on-surface-variant underline">underline — The quick brown fox</text>
            <text class="text-theme-on-surface-variant line-through">line-through — The quick brown fox</text>
            <text class="text-theme-on-surface-variant underline line-through">underline line-through (combined)</text>
            <text class="text-theme-on-background italic underline font-semibold">italic + underline + semibold</text>
        </column>

        {{-- FONT FAMILY --}}
        <text class="text-base font-semibold text-theme-on-background mt-2">Font family</text>
        <column class="w-full gap-2">
            <text class="text-theme-on-surface-variant font-sans">font-sans — The quick brown fox 0123</text>
            <text class="text-theme-on-surface-variant font-serif">font-serif — The quick brown fox 0123</text>
            <text class="text-theme-on-surface-variant font-mono">font-mono — The quick brown fox 0123</text>
            <text font="RockSalt-Regular" class="text-theme-on-surface-variant">Custom font: font="RockSalt-Regular"</text>
        </column>

        {{-- TEXT TRANSFORM --}}
        <text class="text-base font-semibold text-theme-on-background mt-2">Text transform</text>
        <column class="w-full gap-2">
            <text class="text-theme-on-surface-variant uppercase">uppercase — the quick brown fox</text>
            <text class="text-theme-on-surface-variant lowercase">LOWERCASE — The Quick Brown Fox</text>
            <text class="text-theme-on-surface-variant capitalize">capitalize — the quick brown fox</text>
        </column>

        {{-- LETTER SPACING --}}
        <text class="text-base font-semibold text-theme-on-background mt-2">Letter spacing (tracking)</text>
        <column class="w-full gap-2">
            <text class="text-theme-on-surface-variant tracking-tighter">tracking-tighter — The quick brown fox</text>
            <text class="text-theme-on-surface-variant tracking-normal">tracking-normal — The quick brown fox</text>
            <text class="text-theme-on-surface-variant tracking-wide">tracking-wide — The quick brown fox</text>
            <text class="text-theme-on-surface-variant tracking-widest">tracking-widest — The quick brown fox</text>
        </column>

        <divider class="my-2" />

        {{-- THEME TOKENS --}}
        <text class="text-lg font-semibold text-theme-on-background">Theme tokens</text>
        <text class="text-sm text-theme-on-surface-variant">All colors below come from the active theme. Toggle system dark mode to see them flip.</text>
        <row class="w-full gap-2 flex-wrap">
            <column class="flex-1 h-[72] rounded-lg p-3 bg-theme-primary justify-center items-center min-w-[120]">
                <text class="font-semibold text-theme-on-primary">Primary</text>
                <text class="text-xs text-theme-on-primary">on-primary</text>
            </column>
            <column class="flex-1 h-[72] rounded-lg p-3 bg-theme-secondary justify-center items-center min-w-[120]">
                <text class="font-semibold text-theme-on-secondary">Secondary</text>
                <text class="text-xs text-theme-on-secondary">on-secondary</text>
            </column>
        </row>
        <row class="w-full gap-2 flex-wrap">
            <column class="flex-1 h-[72] rounded-lg p-3 bg-theme-destructive justify-center items-center min-w-[120]">
                <text class="font-semibold text-theme-on-destructive">Destructive</text>
                <text class="text-xs text-theme-on-destructive">on-destructive</text>
            </column>
            <column class="flex-1 h-[72] rounded-lg p-3 bg-theme-accent justify-center items-center min-w-[120]">
                <text class="font-semibold text-theme-on-accent">Accent</text>
                <text class="text-xs text-theme-on-accent">on-accent</text>
            </column>
        </row>
        <row class="w-full gap-2 flex-wrap">
            <column class="flex-1 h-[72] rounded-lg p-3 bg-theme-surface border border-theme-outline justify-center items-center min-w-[120]">
                <text class="font-semibold text-theme-on-surface">Surface</text>
                <text class="text-xs text-theme-on-surface">on-surface</text>
            </column>
            <column class="flex-1 h-[72] rounded-lg p-3 bg-theme-surface-variant justify-center items-center min-w-[120]">
                <text class="font-semibold text-theme-on-surface-variant">Surface-variant</text>
                <text class="text-xs text-theme-on-surface-variant">on-surface-variant</text>
            </column>
        </row>

        <divider class="my-2" />

        {{-- TAILWIND PALETTE --}}
        <text class="text-lg font-semibold text-theme-on-background">Tailwind palette</text>

        @php
            $palette = [
                'slate'   => '#64748B',
                'gray'    => '#6B7280',
                'red'     => '#EF4444',
                'orange'  => '#F97316',
                'amber'   => '#F59E0B',
                'yellow'  => '#EAB308',
                'lime'    => '#84CC16',
                'green'   => '#22C55E',
                'emerald' => '#10B981',
                'teal'    => '#14B8A6',
                'cyan'    => '#06B6D4',
                'sky'     => '#0EA5E9',
                'blue'    => '#3B82F6',
                'indigo'  => '#6366F1',
                'violet'  => '#8B5CF6',
                'purple'  => '#A855F7',
                'fuchsia' => '#D946EF',
                'pink'    => '#EC4899',
                'rose'    => '#F43F5E',
            ];
        @endphp

        @foreach ($palette as $name => $hex)
            <row class="w-full items-center gap-3">
                <column class="w-[44] h-[44] rounded-lg bg-[{{ $hex }}]" />
                <column class="flex-1 gap-0">
                    <text class="text-base font-semibold capitalize text-theme-on-background">{{ $name }}</text>
                    <text class="text-sm text-theme-on-surface-variant">{{ $hex }}</text>
                </column>
            </row>
        @endforeach

    </column>
</scroll-view>
