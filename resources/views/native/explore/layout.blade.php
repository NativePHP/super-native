@php use App\Icons\Android; use App\Icons\Ios; @endphp
<scroll-view class="w-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        {{-- FLEX --}}
        <text class="text-lg font-semibold text-theme-on-background">Flex layout</text>
        <text class="text-sm text-theme-on-surface-variant">flex-1 distributes remaining space equally.</text>

        <row class="w-full gap-2 h-[60]">
            <column class="flex-1 bg-theme-primary rounded items-center justify-center">
                <text class="text-theme-on-primary">flex-1</text>
            </column>
            <column class="flex-1 bg-theme-accent rounded items-center justify-center">
                <text class="text-theme-on-accent">flex-1</text>
            </column>
            <column class="flex-1 bg-theme-secondary rounded items-center justify-center">
                <text class="text-theme-on-secondary">flex-1</text>
            </column>
        </row>

        <text class="text-sm text-theme-on-surface-variant">Mix of fixed widths and flex-1.</text>
        <row class="w-full gap-2 h-[60]">
            <column class="w-[60] bg-theme-primary rounded items-center justify-center">
                <text class="text-theme-on-primary text-xs">60</text>
            </column>
            <column class="flex-1 bg-theme-secondary rounded items-center justify-center">
                <text class="text-theme-on-secondary">flex-1</text>
            </column>
            <column class="w-[100] bg-theme-accent rounded items-center justify-center">
                <text class="text-theme-on-accent text-xs">100</text>
            </column>
        </row>

        <divider class="my-2"/>

        {{-- STACK --}}
        <text class="text-lg font-semibold text-theme-on-background">Stack (layered)</text>
        <text class="text-sm text-theme-on-surface-variant">Children layer on top of each other (centered).</text>

        <row class="w-full gap-6 items-center">
            <stack class="w-[100] h-[100]">
                <column class="w-[100] h-[100] rounded-full bg-theme-primary"/>
                <column class="w-[60] h-[60] rounded-full bg-theme-secondary"/>
                <column class="w-[24] h-[24] rounded-full bg-theme-accent"/>
            </stack>

            <stack class="w-[160] h-[80]">
                <column class="w-[160] h-[80] rounded-lg bg-theme-primary items-center justify-center">
                    <text class="text-theme-on-primary">Background</text>
                </column>
                <column class="w-[110] h-[40] rounded-lg bg-theme-secondary items-center justify-center">
                    <text class="text-theme-on-secondary font-semibold">Foreground</text>
                </column>
            </stack>
        </row>

        <divider class="my-2"/>

        {{-- SHAPE PRIMITIVES --}}
        <text class="text-lg font-semibold text-theme-on-background">Shape primitives</text>
        <text class="text-sm text-theme-on-surface-variant">rect / circle — fill a frame with a color.</text>

        <row class="w-full gap-3">
            <rect class="flex-1 h-[60] bg-theme-primary rounded"/>
            <rect class="flex-1 h-[60] bg-theme-accent rounded-lg"/>
            <rect class="flex-1 h-[60] bg-theme-secondary rounded-3xl"/>
        </row>

        <row class="w-full gap-3 items-center">
            <circle class="w-[80] h-[80] bg-theme-destructive"/>
            <circle class="w-[60] h-[60] bg-theme-secondary"/>
            <circle class="w-[40] h-[40] bg-theme-accent"/>
            <circle class="w-[24] h-[24] bg-theme-primary"/>
        </row>

        <divider class="my-2"/>

        {{-- ACTIVITY INDICATOR --}}
        <text class="text-lg font-semibold text-theme-on-background">Activity indicator</text>
        <row class="w-full gap-4 items-center">
            <activity-indicator size="small"/>
            <activity-indicator size="medium"/>
            <activity-indicator size="large"/>
            <activity-indicator size="large" class="text-theme-primary"/>
            <activity-indicator size="large" class="text-theme-secondary"/>
            <activity-indicator size="large" class="text-theme-accent"/>
            <activity-indicator size="large" class="text-theme-destructive"/>
            <activity-indicator size="large" class="text-theme-on-surface-variant"/>
        </row>

        <divider class="my-2"/>

        {{-- SPACER --}}
        <text class="text-lg font-semibold text-theme-on-background">Spacer</text>
        <text class="text-sm text-theme-on-surface-variant">Pushes content apart inside a flex container.</text>
        <row class="w-full p-3 bg-theme-surface-variant rounded items-center">
            <text class="font-semibold text-theme-on-surface">Left</text>
            <spacer/>
            <text class="font-semibold text-theme-on-surface">Right</text>
        </row>

        <divider class="my-2"/>

        {{-- BOTTOM NAV — visual mockup composed from primitives. The real
             <bottom-nav> element is purpose-built to anchor at the
             bottom of the screen via a layout's tabBar(); inline rendering
             collapses because the renderer expects to fill the screen-edge
             frame from the layout chrome. The mockups below show what the
             bar looks like in the various configurations.

             To use a real bottom nav, attach a TabsLayout to your route —
             see /tabs in the launcher. --}}
        <text class="text-lg font-semibold text-theme-on-background">Bottom Nav (mockup)</text>
        <text class="text-sm text-theme-on-surface-variant">Tabs render via UITabBar on iOS / Material BottomNavigation on
            Android. The layouts below are stylistic mockups built from primitives.
        </text>

        {{-- 3-item basic --}}
        <row class="w-full h-[64] bg-theme-surface rounded-xl border border-theme-outline items-center">
            <column class="flex-1 items-center gap-1">
                <icon :ios="Ios::House" :android="Android::Home" :size="22" class="text-theme-primary"/>
                <text class="text-[11] text-theme-primary text-center font-semibold">Home</text>
            </column>
            <column class="flex-1 items-center gap-1">
                <icon :ios="Ios::Magnifyingglass" :android="Android::Search" :size="22" class="text-theme-on-surface-variant"/>
                <text class="text-[11] text-theme-on-surface-variant text-center">Search</text>
            </column>
            <column class="flex-1 items-center gap-1">
                <icon :ios="Ios::Person" :android="Android::Person" :size="22" class="text-theme-on-surface-variant"/>
                <text class="text-[11] text-theme-on-surface-variant text-center">Profile</text>
            </column>
        </row>

        <text class="text-sm text-theme-on-surface-variant">With badge + "news" indicator.</text>
        <row class="w-full h-[64] bg-theme-surface rounded-xl border border-theme-outline items-center">
            <column class="flex-1 items-center gap-1">
                <icon :ios="Ios::House" :android="Android::Home" :size="22" class="text-theme-primary"/>
                <text class="text-[11] text-theme-primary text-center font-semibold">Feed</text>
            </column>
            <column class="flex-1 items-center gap-1">
                <stack class="w-[32] h-[24]">
                    <icon :ios="Ios::BellFill" :android="Android::Notifications" :size="22" class="text-theme-on-surface-variant"/>
                    <row class="w-[32] h-[24] items-start justify-end">
                        <column class="w-[16] h-[14] rounded-full bg-theme-destructive items-center justify-center">
                            <text class="text-[9] font-bold text-theme-on-destructive">3</text>
                        </column>
                    </row>
                </stack>
                <text class="text-[11] text-theme-on-surface-variant text-center">Alerts</text>
            </column>
            <column class="flex-1 items-center gap-1">
                <stack class="w-[32] h-[24]">
                    <icon :ios="Ios::BubbleLeft" :android="Android::Chat" :size="22" class="text-theme-on-surface-variant"/>
                    <row class="w-[32] h-[24] items-start justify-end">
                        <column class="w-[8] h-[8] rounded-full bg-theme-destructive"/>
                    </row>
                </stack>
                <text class="text-[11] text-theme-on-surface-variant text-center">Messages</text>
            </column>
            <column class="flex-1 items-center gap-1">
                <icon :ios="Ios::Person" :android="Android::Person" :size="22" class="text-theme-on-surface-variant"/>
                <text class="text-[11] text-theme-on-surface-variant text-center">Profile</text>
            </column>
        </row>

        <text class="text-sm text-theme-on-surface-variant">5-item nav with custom active color.</text>
        <row class="w-full h-[64] bg-theme-surface rounded-xl border border-theme-outline items-center">
            <column class="flex-1 items-center gap-1">
                <icon :ios="Ios::House" :android="Android::Home" :size="20" class="text-theme-on-surface-variant"/>
                <text class="text-[10] text-theme-on-surface-variant text-center">Home</text>
            </column>
            <column class="flex-1 items-center gap-1">
                <icon :ios="Ios::Magnifyingglass" :android="Android::Search" :size="20" class="text-theme-on-surface-variant"/>
                <text class="text-[10] text-theme-on-surface-variant text-center">Search</text>
            </column>
            <column class="flex-1 items-center gap-1">
                <icon :ios="Ios::Plus" :android="Android::Add" :size="20" class="text-theme-secondary"/>
                <text class="text-[10] text-theme-secondary text-center font-semibold">Post</text>
            </column>
            <column class="flex-1 items-center gap-1">
                <icon :ios="Ios::Bookmark" :android="Android::Bookmark" :size="20" class="text-theme-on-surface-variant"/>
                <text class="text-[10] text-theme-on-surface-variant text-center">Saved</text>
            </column>
            <column class="flex-1 items-center gap-1">
                <icon :ios="Ios::Person" :android="Android::Person" :size="20" class="text-theme-on-surface-variant"/>
                <text class="text-[10] text-theme-on-surface-variant text-center">Me</text>
            </column>
        </row>

    </column>
</scroll-view>
