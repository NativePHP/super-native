<native:scroll-view class="w-full bg-theme-surface">
    <native:column class="w-full p-5 gap-5">

        {{-- FLEX --}}
        <native:text class="text-lg font-semibold">Flex layout</native:text>
        <native:text class="text-sm text-gray-500">flex-1 distributes remaining space equally.</native:text>

        <native:row class="w-full gap-2 h-[60]">
            <native:column class="flex-1 bg-blue-500 rounded items-center justify-center">
                <native:text class="text-white">flex-1</native:text>
            </native:column>
            <native:column class="flex-1 bg-green-500 rounded items-center justify-center">
                <native:text class="text-white">flex-1</native:text>
            </native:column>
            <native:column class="flex-1 bg-purple-500 rounded items-center justify-center">
                <native:text class="text-white">flex-1</native:text>
            </native:column>
        </native:row>

        <native:text class="text-sm text-gray-500">Mix of fixed widths and flex-1.</native:text>
        <native:row class="w-full gap-2 h-[60]">
            <native:column class="w-[60] bg-amber-500 rounded items-center justify-center">
                <native:text class="text-white text-xs">60</native:text>
            </native:column>
            <native:column class="flex-1 bg-rose-500 rounded items-center justify-center">
                <native:text class="text-white">flex-1</native:text>
            </native:column>
            <native:column class="w-[100] bg-teal-500 rounded items-center justify-center">
                <native:text class="text-white text-xs">100</native:text>
            </native:column>
        </native:row>

        <native:divider class="my-2" />

        {{-- STACK --}}
        <native:text class="text-lg font-semibold">Stack (layered)</native:text>
        <native:text class="text-sm text-gray-500">Children layer on top of each other (centered).</native:text>

        <native:row class="w-full gap-6 items-center">
            <native:stack class="w-[100] h-[100]">
                <native:column class="w-[100] h-[100] rounded-full bg-blue-500" />
                <native:column class="w-[60] h-[60] rounded-full bg-amber-400" />
                <native:column class="w-[24] h-[24] rounded-full bg-red-500" />
            </native:stack>

            <native:stack class="w-[160] h-[80]">
                <native:column class="w-[160] h-[80] rounded-lg bg-purple-600 items-center justify-center">
                    <native:text class="text-white">Background</native:text>
                </native:column>
                <native:column class="w-[110] h-[40] rounded-lg bg-amber-400 items-center justify-center">
                    <native:text class="text-amber-950 font-semibold">Foreground</native:text>
                </native:column>
            </native:stack>
        </native:row>

        <native:divider class="my-2" />

        {{-- SHAPE PRIMITIVES --}}
        <native:text class="text-lg font-semibold">Shape primitives</native:text>
        <native:text class="text-sm text-gray-500">rect / circle — fill a frame with a color.</native:text>

        <native:row class="w-full gap-3">
            <native:rect class="flex-1 h-[60] bg-blue-500 rounded" />
            <native:rect class="flex-1 h-[60] bg-green-500 rounded-lg" />
            <native:rect class="flex-1 h-[60] bg-purple-500 rounded-3xl" />
        </native:row>

        <native:row class="w-full gap-3 items-center">
            <native:circle class="w-[80] h-[80] bg-red-500" />
            <native:circle class="w-[60] h-[60] bg-amber-500" />
            <native:circle class="w-[40] h-[40] bg-emerald-500" />
            <native:circle class="w-[24] h-[24] bg-blue-500" />
        </native:row>

        <native:divider class="my-2" />

        {{-- ACTIVITY INDICATOR --}}
        <native:text class="text-lg font-semibold">Activity indicator</native:text>
        <native:row class="w-full gap-4 items-center">
            <native:activity-indicator size="small" />
            <native:activity-indicator size="medium" />
            <native:activity-indicator size="large" />
            <native:activity-indicator size="large" color="#EF4444" />
        </native:row>

        <native:divider class="my-2" />

        {{-- SPACER --}}
        <native:text class="text-lg font-semibold">Spacer</native:text>
        <native:text class="text-sm text-gray-500">Pushes content apart inside a flex container.</native:text>
        <native:row class="w-full p-3 bg-slate-100 rounded items-center">
            <native:text class="font-semibold">Left</native:text>
            <native:spacer />
            <native:text class="font-semibold">Right</native:text>
        </native:row>

    </native:column>
</native:scroll-view>
