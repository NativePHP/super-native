@php use App\Icons\Android; use App\Icons\Ios; @endphp
<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-4">

        <text class="text-sm text-theme-on-surface-variant">
            Three identical tiles, low on the screen. All three land in the same full-width panel
            at the TOP, so the travel is long on purpose — over a short hop the styles look alike.
        </text>

        {{-- Fixed spacer, not flex-1: a greedy spacer in a fixed-height column
             squeezed the rows below into overlapping each other. --}}
        <column class="w-full h-[300]" />

        {{-- frame — travels AND resizes (the default) --}}
        <row @navigate.viewTransition('/hero/styles/frame') class="w-full items-center gap-4">
            <column ref="style-frame"
                    class="w-[72] h-[72] rounded-2xl items-center justify-center bg-[#6366F1]">
                <icon :ios="Ios::ArrowUpLeftAndArrowDownRight" :android="Android::OpenInFull" :size="26" color="#FFFFFF" />
            </column>
            <column class="flex-1 gap-0.5">
                <text class="text-base font-semibold text-theme-on-surface">morph="frame"</text>
                <text class="text-sm text-theme-on-surface-variant">
                    Default. Travels and resizes together.
                </text>
            </column>
        </row>

        {{-- position — travels, keeps its own size --}}
        <row @navigate.viewTransition('/hero/styles/position') class="w-full items-center gap-4">
            <column ref="style-position" morph="position"
                    class="w-[72] h-[72] rounded-2xl items-center justify-center bg-[#0891B2]">
                <icon :ios="Ios::ArrowUpAndDownAndArrowLeftAndRight" :android="Android::OpenWith" :size="26" color="#FFFFFF" />
            </column>
            <column class="flex-1 gap-0.5">
                <text class="text-base font-semibold text-theme-on-surface">morph="position"</text>
                <text class="text-sm text-theme-on-surface-variant">
                    Arrives already at destination size; only the move is animated.
                </text>
            </column>
        </row>

        {{-- size — resizes in place, does not travel --}}
        <row @navigate.viewTransition('/hero/styles/size') class="w-full items-center gap-4">
            <column ref="style-size" morph="size"
                    class="w-[72] h-[72] rounded-2xl items-center justify-center bg-[#DB2777]">
                <icon :ios="Ios::SquareResizeUp" :android="Android::OpenInFull" :size="26" color="#FFFFFF" />
            </column>
            <column class="flex-1 gap-0.5">
                <text class="text-base font-semibold text-theme-on-surface">morph="size"</text>
                <text class="text-sm text-theme-on-surface-variant">
                    Grows where it stands; the position snaps instead of sliding.
                </text>
            </column>
        </row>

        <text class="text-xs text-theme-on-surface-variant pt-1">
            A fourth value, morph="none", skips the effect entirely — for a ref that exists only
            as a test handle and must never travel.
        </text>

    </column>
</scroll-view>
