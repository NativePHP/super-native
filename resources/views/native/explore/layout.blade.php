<native:scroll-view class="w-full bg-theme-background">
    <native:column class="w-full p-5 gap-5">

        {{-- FLEX --}}
        <native:text class="text-lg font-semibold text-theme-on-background">Flex layout</native:text>
        <native:text class="text-sm text-theme-on-surface-variant">flex-1 distributes remaining space equally.</native:text>

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

        <native:text class="text-sm text-theme-on-surface-variant">Mix of fixed widths and flex-1.</native:text>
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

        <native:divider class="my-2"/>

        {{-- STACK --}}
        <native:text class="text-lg font-semibold text-theme-on-background">Stack (layered)</native:text>
        <native:text class="text-sm text-theme-on-surface-variant">Children layer on top of each other (centered).</native:text>

        <native:row class="w-full gap-6 items-center">
            <native:stack class="w-[100] h-[100]">
                <native:column class="w-[100] h-[100] rounded-full bg-blue-500"/>
                <native:column class="w-[60] h-[60] rounded-full bg-amber-400"/>
                <native:column class="w-[24] h-[24] rounded-full bg-red-500"/>
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

        <native:divider class="my-2"/>

        {{-- SHAPE PRIMITIVES --}}
        <native:text class="text-lg font-semibold text-theme-on-background">Shape primitives</native:text>
        <native:text class="text-sm text-theme-on-surface-variant">rect / circle — fill a frame with a color.</native:text>

        <native:row class="w-full gap-3">
            <native:rect class="flex-1 h-[60] bg-blue-500 rounded"/>
            <native:rect class="flex-1 h-[60] bg-green-500 rounded-lg"/>
            <native:rect class="flex-1 h-[60] bg-purple-500 rounded-3xl"/>
        </native:row>

        <native:row class="w-full gap-3 items-center">
            <native:circle class="w-[80] h-[80] bg-red-500"/>
            <native:circle class="w-[60] h-[60] bg-amber-500"/>
            <native:circle class="w-[40] h-[40] bg-emerald-500"/>
            <native:circle class="w-[24] h-[24] bg-blue-500"/>
        </native:row>

        <native:divider class="my-2"/>

        {{-- ACTIVITY INDICATOR --}}
        <native:text class="text-lg font-semibold text-theme-on-background">Activity indicator</native:text>
        <native:row class="w-full gap-4 items-center">
            <native:activity-indicator size="small"/>
            <native:activity-indicator size="medium"/>
            <native:activity-indicator size="large"/>
            <native:activity-indicator size="large" class="text-yellow-500"/>
            <native:activity-indicator size="large" class="text-red-500"/>
            <native:activity-indicator size="large" class="text-purple-500"/>
            <native:activity-indicator size="large" class="text-emerald-500"/>
            <native:activity-indicator size="large" class="text-fuchsia-500"/>
        </native:row>

        <native:divider class="my-2"/>

        {{-- SPACER --}}
        <native:text class="text-lg font-semibold text-theme-on-background">Spacer</native:text>
        <native:text class="text-sm text-theme-on-surface-variant">Pushes content apart inside a flex container.</native:text>
        <native:row class="w-full p-3 bg-theme-surface-variant rounded items-center">
            <native:text class="font-semibold text-theme-on-surface">Left</native:text>
            <native:spacer/>
            <native:text class="font-semibold text-theme-on-surface">Right</native:text>
        </native:row>

        <native:divider class="my-2"/>

        {{-- BOTTOM NAV — visual mockup composed from primitives. The real
             <native:bottom-nav> element is purpose-built to anchor at the
             bottom of the screen via a layout's tabBar(); inline rendering
             collapses because the renderer expects to fill the screen-edge
             frame from the layout chrome. The mockups below show what the
             bar looks like in the various configurations.

             To use a real bottom nav, attach a TabsLayout to your route —
             see /tabs in the launcher. --}}
        <native:text class="text-lg font-semibold text-theme-on-background">Bottom Nav (mockup)</native:text>
        <native:text class="text-sm text-theme-on-surface-variant">Tabs render via UITabBar on iOS / Material BottomNavigation on
            Android. The layouts below are stylistic mockups built from primitives.
        </native:text>

        {{-- 3-item basic --}}
        <native:row class="w-full h-[64] bg-theme-surface rounded-xl border border-theme-outline items-center">
            <native:column class="flex-1 items-center gap-1">
                <native:icon name="home" :size="22" color="#3B82F6"/>
                <native:text class="text-[11] text-blue-500 text-center font-semibold">Home</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:icon name="search" :size="22" color="#9CA3AF" dark-color="#94A3B8"/>
                <native:text class="text-[11] text-theme-on-surface-variant text-center">Search</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:icon name="person" :size="22" color="#9CA3AF" dark-color="#94A3B8"/>
                <native:text class="text-[11] text-theme-on-surface-variant text-center">Profile</native:text>
            </native:column>
        </native:row>

        <native:text class="text-sm text-theme-on-surface-variant">With badge + "news" indicator.</native:text>
        <native:row class="w-full h-[64] bg-theme-surface rounded-xl border border-theme-outline items-center">
            <native:column class="flex-1 items-center gap-1">
                <native:icon name="home" :size="22" color="#3B82F6"/>
                <native:text class="text-[11] text-blue-500 text-center font-semibold">Feed</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:stack class="w-[32] h-[24]">
                    <native:icon name="notifications" :size="22" color="#9CA3AF" dark-color="#94A3B8"/>
                    <native:row class="w-[32] h-[24] items-start justify-end">
                        <native:column class="w-[16] h-[14] rounded-full bg-red-500 items-center justify-center">
                            <native:text class="text-[9] font-bold text-white">3</native:text>
                        </native:column>
                    </native:row>
                </native:stack>
                <native:text class="text-[11] text-theme-on-surface-variant text-center">Alerts</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:stack class="w-[32] h-[24]">
                    <native:icon name="chat" :size="22" color="#9CA3AF" dark-color="#94A3B8"/>
                    <native:row class="w-[32] h-[24] items-start justify-end">
                        <native:column class="w-[8] h-[8] rounded-full bg-red-500"/>
                    </native:row>
                </native:stack>
                <native:text class="text-[11] text-theme-on-surface-variant text-center">Messages</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:icon name="person" :size="22" color="#9CA3AF" dark-color="#94A3B8"/>
                <native:text class="text-[11] text-theme-on-surface-variant text-center">Profile</native:text>
            </native:column>
        </native:row>

        <native:text class="text-sm text-theme-on-surface-variant">5-item nav with custom active color.</native:text>
        <native:row class="w-full h-[64] bg-theme-surface rounded-xl border border-theme-outline items-center">
            <native:column class="flex-1 items-center gap-1">
                <native:icon name="home" :size="20" color="#9CA3AF" dark-color="#94A3B8"/>
                <native:text class="text-[10] text-theme-on-surface-variant text-center">Home</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:icon name="search" :size="20" color="#9CA3AF" dark-color="#94A3B8"/>
                <native:text class="text-[10] text-theme-on-surface-variant text-center">Search</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:icon name="add" :size="20" color="#E11D48"/>
                <native:text class="text-[10] text-rose-600 text-center font-semibold">Post</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:icon name="bookmark" :size="20" color="#9CA3AF" dark-color="#94A3B8"/>
                <native:text class="text-[10] text-theme-on-surface-variant text-center">Saved</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:icon name="person" :size="20" color="#9CA3AF" dark-color="#94A3B8"/>
                <native:text class="text-[10] text-theme-on-surface-variant text-center">Me</native:text>
            </native:column>
        </native:row>

    </native:column>
</native:scroll-view>
