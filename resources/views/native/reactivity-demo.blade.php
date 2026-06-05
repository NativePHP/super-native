<native:scroll-view class="w-full h-full bg-theme-background">
    <native:column class="w-full p-5 gap-5">

        {{-- ── #[Computed] ───────────────────────────────── --}}
        <native:column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <native:text class="text-xs font-bold uppercase text-theme-on-surface-variant">#[Computed]</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">
                $count is a public property; $this->doubled is a computed method, memoized per frame.
            </native:text>

            <native:row class="items-center justify-between mt-2">
                <native:text class="text-base text-theme-on-surface">count</native:text>
                <native:text class="text-2xl font-bold text-theme-on-surface">{{ $count }}</native:text>
            </native:row>
            <native:row class="items-center justify-between">
                <native:text class="text-base text-theme-on-surface">doubled (computed)</native:text>
                <native:text class="text-2xl font-bold text-emerald-500">{{ $this->doubled }}</native:text>
            </native:row>

            <native:row class="gap-3 mt-2">
                <native:pressable @press="decrement" class="w-[64] bg-purple-400 text-white rounded-full shadow px-4 py-2">
                    <text class="text-white text-center font-bold text-xl">−1</text>
                </native:pressable>
                <spacer />
                <native:button @press="increment" class="w-full">+1</native:button>
            </native:row>
        </native:column>


        {{-- ── native:poll (Blade) ───────────────────────── --}}
        <native:column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <native:text class="text-xs font-bold uppercase text-theme-on-surface-variant">native:poll (Blade)</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">
                The clock below uses native:poll="3s" right in the template — no PHP method or attribute on the class.
            </native:text>

            <native:column class="items-center justify-center py-4">
                <native:text native:poll.200ms class="text-lg font-bold text-violet-500">{{ now()->timezone('America/New_York')->format('D F j, Y H:i:s A T') }}</native:text>
            </native:column>
        </native:column>

        {{-- ── #[Lazy] ───────────────────────────────────── --}}
        <native:column class="w-full p-5 gap-3 rounded-2xl">
            <native:text class="text-xs font-bold uppercase text-theme-on-surface-variant">#[Lazy]</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">
                This screen showed a skeleton placeholder while a deliberately slow mount() (2s) ran. You're now looking at the hydrated content.
            </native:text>
            <native:row class="items-center gap-2 mt-1">
                <native:icon name="checkmark.circle.fill" :size="20" class="text-green-500" />
                <native:text class="text-base font-semibold text-theme-on-surface">Loaded</native:text>
            </native:row>
        </native:column>

    </native:column>
</native:scroll-view>
