<native:scroll-view class="w-full bg-theme-surface">
    <native:column class="w-full p-5 gap-5">

        {{-- TYPOGRAPHY --}}
        <native:text class="text-lg font-semibold">Typography</native:text>
        <native:column class="w-full gap-2">
            <native:text class="text-xs text-gray-600">text-xs (12pt) — The quick brown fox</native:text>
            <native:text class="text-sm text-gray-600">text-sm (14pt) — The quick brown fox</native:text>
            <native:text class="text-gray-600">(16pt) — The quick brown fox</native:text>
            <native:text class="text-lg text-gray-600">text-lg (18pt) — The quick brown fox</native:text>
            <native:text class="text-xl text-gray-600">text-xl (20pt) — The quick brown fox</native:text>
            <native:text class="text-2xl text-gray-700">text-2xl (24pt)</native:text>
            <native:text class="text-3xl text-gray-700">text-3xl (30pt)</native:text>
            <native:text class="text-4xl text-gray-800 font-extrabold">text-4xl bold</native:text>
        </native:column>

        <native:divider class="my-2" />

        {{-- THEME TOKENS --}}
        <native:text class="text-lg font-semibold">Theme tokens</native:text>
        <native:text class="text-sm text-gray-500">All colors below come from the active theme. Toggle system dark mode to see them flip.</native:text>
        <native:row class="w-full gap-2 flex-wrap">
            <native:column class="flex-1 h-[72] rounded-lg p-3 bg-theme-primary justify-center items-center min-w-[120]">
                <native:text class="font-semibold text-theme-on-primary">Primary</native:text>
                <native:text class="text-xs text-theme-on-primary">on-primary</native:text>
            </native:column>
            <native:column class="flex-1 h-[72] rounded-lg p-3 bg-theme-secondary justify-center items-center min-w-[120]">
                <native:text class="font-semibold text-theme-on-secondary">Secondary</native:text>
                <native:text class="text-xs text-theme-on-secondary">on-secondary</native:text>
            </native:column>
        </native:row>
        <native:row class="w-full gap-2 flex-wrap">
            <native:column class="flex-1 h-[72] rounded-lg p-3 bg-theme-destructive justify-center items-center min-w-[120]">
                <native:text class="font-semibold text-theme-on-destructive">Destructive</native:text>
                <native:text class="text-xs text-theme-on-destructive">on-destructive</native:text>
            </native:column>
            <native:column class="flex-1 h-[72] rounded-lg p-3 bg-theme-accent justify-center items-center min-w-[120]">
                <native:text class="font-semibold text-theme-on-accent">Accent</native:text>
                <native:text class="text-xs text-theme-on-accent">on-accent</native:text>
            </native:column>
        </native:row>

        <native:divider class="my-2" />

        {{-- TAILWIND PALETTE --}}
        <native:text class="text-lg font-semibold">Tailwind palette</native:text>

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
            <native:row class="w-full items-center gap-3">
                <native:column class="w-[44] h-[44] rounded-lg bg-[{{ $hex }}]" />
                <native:column class="flex-1 gap-0">
                    <native:text class="text-base font-semibold capitalize">{{ $name }}</native:text>
                    <native:text class="text-sm text-gray-500">{{ $hex }}</native:text>
                </native:column>
            </native:row>
        @endforeach

    </native:column>
</native:scroll-view>
