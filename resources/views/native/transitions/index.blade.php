@php use App\Icons\Android; use App\Icons\Ios; @endphp
<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-3">

        {{-- Title + back chevron come from the framework TopBar (StackLayout). --}}
        <text class="text-sm text-theme-on-surface-variant pb-1">Tap one to push a screen with that animation</text>

        {{-- Slide from Right (default push) --}}
        <row @navigate.slideFromRight('/transitions/detail', ['via' => 'Slide from Right', 'color' => '#6366F1'])
             class="items-center justify-between p-4 bg-theme-surface rounded-2xl shadow">
            <column class="flex-1 gap-0.5">
                <text class="text-base font-semibold text-theme-on-surface">Slide from Right</text>
                <text class="text-sm text-theme-on-surface-variant">Default push — enters from the trailing edge</text>
            </column>
            <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
        </row>

        {{-- Parallax Push (the new one) --}}
        <row @navigate.parallaxPush('/transitions/detail', ['via' => 'Parallax Push', 'color' => '#14B8A6'])
             class="items-center justify-between p-4 bg-theme-surface rounded-2xl shadow">
            <column class="flex-1 gap-0.5">
                <row class="items-center gap-2">
                    <text class="text-base font-semibold text-theme-on-surface">Parallax Push</text>
                </row>
                <text class="text-sm text-theme-on-surface-variant">New screen slides in; old drifts back underneath</text>
            </column>
            <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
        </row>

        {{-- Slide from Left --}}
        <row @navigate.slideFromLeft('/transitions/detail', ['via' => 'Slide from Left', 'color' => '#F59E0B'])
             class="items-center justify-between p-4 bg-theme-surface rounded-2xl shadow">
            <column class="flex-1 gap-0.5">
                <text class="text-base font-semibold text-theme-on-surface">Slide from Left</text>
                <text class="text-sm text-theme-on-surface-variant">Enters from the leading edge (back-style)</text>
            </column>
            <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
        </row>

        {{-- Slide from Bottom --}}
        <row @navigate.slideFromBottom('/transitions/detail', ['via' => 'Slide from Bottom', 'color' => '#EC4899'])
             class="items-center justify-between p-4 bg-theme-surface rounded-2xl shadow">
            <column class="flex-1 gap-0.5">
                <text class="text-base font-semibold text-theme-on-surface">Slide from Bottom</text>
                <text class="text-sm text-theme-on-surface-variant">Sheet-like rise from the bottom edge</text>
            </column>
            <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
        </row>

        {{-- Fade --}}
        <row @navigate.fade('/transitions/detail', ['via' => 'Fade', 'color' => '#8B5CF6'])
             class="items-center justify-between p-4 bg-theme-surface rounded-2xl shadow">
            <column class="flex-1 gap-0.5">
                <text class="text-base font-semibold text-theme-on-surface">Fade</text>
                <text class="text-sm text-theme-on-surface-variant">Cross-dissolve between screens</text>
            </column>
            <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
        </row>

        {{-- Fade from Bottom --}}
        <row @navigate.fadeFromBottom('/transitions/detail', ['via' => 'Fade from Bottom', 'color' => '#0EA5E9'])
             class="items-center justify-between p-4 bg-theme-surface rounded-2xl shadow">
            <column class="flex-1 gap-0.5">
                <text class="text-base font-semibold text-theme-on-surface">Fade from Bottom</text>
                <text class="text-sm text-theme-on-surface-variant">Rises and fades in together</text>
            </column>
            <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
        </row>

        {{-- Scale from Center --}}
        <row @navigate.scaleFromCenter('/transitions/detail', ['via' => 'Scale from Center', 'color' => '#10B981'])
             class="items-center justify-between p-4 bg-theme-surface rounded-2xl shadow">
            <column class="flex-1 gap-0.5">
                <text class="text-base font-semibold text-theme-on-surface">Scale from Center</text>
                <text class="text-sm text-theme-on-surface-variant">Zooms up from the center while fading in</text>
            </column>
            <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
        </row>

        {{-- None --}}
        <row @navigate.none('/transitions/detail', ['via' => 'None', 'color' => '#64748B'])
             class="items-center justify-between p-4 bg-theme-surface rounded-2xl shadow">
            <column class="flex-1 gap-0.5">
                <text class="text-base font-semibold text-theme-on-surface">None</text>
                <text class="text-sm text-theme-on-surface-variant">Instant — no animation</text>
            </column>
            <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
        </row>

    </column>
</scroll-view>
