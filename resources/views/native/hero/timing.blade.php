<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        <text class="text-sm text-theme-on-surface-variant">
            Four elements, one navigation, four different curves. Tap anywhere below — they all
            leave together and deliberately do not arrive together.
        </text>

        <row @navigate.viewTransition('/hero/timing/detail') class="w-full gap-3">

            {{-- Fast and linear: arrives first, mechanically. --}}
            <column ref="tick-1" morph-duration="220" morph-easing="linear"
                    class="flex-1 h-[110] rounded-2xl items-center justify-center bg-[#6366F1]">
                <text class="text-xs font-bold text-white">220ms</text>
                <text class="text-xs text-[#FFFFFFCC]">linear</text>
            </column>

            {{-- Default pace, default curve. --}}
            <column ref="tick-2"
                    class="flex-1 h-[110] rounded-2xl items-center justify-center bg-[#0891B2]">
                <text class="text-xs font-bold text-white">350ms</text>
                <text class="text-xs text-[#FFFFFFCC]">shared default</text>
            </column>

            {{-- Spring: overshoots and settles — the native hero feel. --}}
            <column ref="tick-3" morph-easing="spring"
                    class="flex-1 h-[110] rounded-2xl items-center justify-center bg-[#DB2777]">
                <text class="text-xs font-bold text-white">spring</text>
                <text class="text-xs text-[#FFFFFFCC]">overshoots</text>
            </column>

            {{-- Slow ease-out: the straggler, still moving after the rest have landed. --}}
            <column ref="tick-4" morph-duration="900" morph-easing="ease-out"
                    class="flex-1 h-[110] rounded-2xl items-center justify-center bg-[#EA580C]">
                <text class="text-xs font-bold text-white">900ms</text>
                <text class="text-xs text-[#FFFFFFCC]">ease-out</text>
            </column>

        </row>

        <text class="text-sm text-theme-on-surface-variant">
            The 900ms tile is the one to watch: the screen cross-fade finishes long before it
            does, so it is still travelling across an already-settled destination.
        </text>

        <text class="text-xs text-theme-on-surface-variant">
            Naming only an easing (like the spring above) keeps the shared 350ms pace, so
            morph-easing="spring" on its own is a sensible thing to write.
        </text>

    </column>
</scroll-view>
