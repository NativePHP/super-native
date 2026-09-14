<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5 items-center">

        <text class="text-sm text-theme-on-surface-variant">
            Every other demo tags whole, self-contained elements, which hides the join. This one
            splits one object down the middle: the left half is tagged, the right half is not.
        </text>

        {{-- Two halves flush against each other, reading as a single badge. --}}
        <row @navigate.viewTransition('/hero/seam/detail')
             class="w-[240] h-[120] rounded-2xl shadow">

            {{-- TAGGED half — this one flies. --}}
            <column ref="seam-half"
                    class="flex-1 h-full items-center justify-center bg-[#0EA5E9]">
                <text class="text-sm font-bold text-white">TAGGED</text>
                <text class="text-xs text-[#FFFFFFCC]">flies</text>
            </column>

            {{-- UNTAGGED twin — identical in every other way. This one stays. --}}
            <column class="flex-1 h-full items-center justify-center bg-[#0369A1]">
                <text class="text-sm font-bold text-white">UNTAGGED</text>
                <text class="text-xs text-[#FFFFFFCC]">cross-fades</text>
            </column>

        </row>

        <text class="text-sm text-theme-on-surface-variant text-center">
            Tap it. The left half detaches and travels to the destination; the right half stays
            exactly where it is and dissolves with the rest of the screen. The object tears in
            half mid-navigation.
        </text>

        <text class="text-xs text-theme-on-surface-variant text-center pt-2">
            This is not a bug to fix — it is the boundary of what a shared element is. Anything
            you want carried across has to be tagged, and anything tagged travels as its own
            independent object regardless of what it looked like it belonged to.
        </text>

    </column>
</scroll-view>
