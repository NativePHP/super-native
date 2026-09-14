@php use App\Icons\Android; use App\Icons\Ios; @endphp
<column class="w-full h-full bg-theme-background safe-area">

    <column class="w-full p-6 pt-14 gap-2">
        <text class="text-2xl font-bold text-theme-on-surface">Four arrivals</text>
        <text class="text-sm text-theme-on-surface-variant">
            They stack vertically here, so each tile travelled a different distance as well as at
            a different speed. Go back and watch the reverse — the stagger runs the other way.
        </text>
    </column>

    <column class="w-full flex-1 px-6 gap-3">

        <column ref="tick-1" morph-duration="220" morph-easing="linear"
                class="w-full h-[64] rounded-2xl items-center justify-center bg-[#6366F1]">
            <text class="text-sm font-bold text-white">220ms linear — landed first</text>
        </column>

        <column ref="tick-2"
                class="w-full h-[64] rounded-2xl items-center justify-center bg-[#0891B2]">
            <text class="text-sm font-bold text-white">350ms — the shared default</text>
        </column>

        <column ref="tick-3" morph-easing="spring"
                class="w-full h-[64] rounded-2xl items-center justify-center bg-[#DB2777]">
            <text class="text-sm font-bold text-white">spring — settled last, after a wobble</text>
        </column>

        <column ref="tick-4" morph-duration="900" morph-easing="ease-out"
                class="w-full h-[64] rounded-2xl items-center justify-center bg-[#EA580C]">
            <text class="text-sm font-bold text-white">900ms ease-out — still arriving</text>
        </column>

    </column>

    <row @navigate.back.viewTransition class="items-center gap-2 px-6 pb-10">
        <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="#6366F1" />
        <text class="text-base font-semibold text-[#6366F1]">Back — stagger in reverse</text>
    </row>

</column>
