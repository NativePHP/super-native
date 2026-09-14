@php use App\Icons\Android; use App\Icons\Ios; @endphp
<column class="w-full h-full bg-theme-background safe-area items-center">

    <column class="w-full p-6 gap-3 pt-14">
        <text class="text-2xl font-bold text-theme-on-surface">Torn in half</text>
        <text class="text-sm text-theme-on-surface-variant">
            The tagged half is below, having crossed the screen and grown. Its twin never left
            the previous screen — it faded out in place, still sitting where the badge used to be.
        </text>
    </column>

    {{-- The tagged half, now large and alone. --}}
    <column ref="seam-half"
            class="w-[300] h-[200] rounded-3xl items-center justify-center bg-[#0EA5E9] shadow">
        <text class="text-xl font-bold text-white">TAGGED</text>
        <text class="text-sm text-[#FFFFFFCC]">arrived</text>
    </column>

    <column class="w-full p-6 gap-2">
        <text class="text-sm text-theme-on-surface-variant">
            Go back and watch the halves rejoin: the tagged one flies home and lands flush
            against the twin that never moved. The seam closes only at the very last frame.
        </text>
    </column>

    <column class="flex-1 w-full" />

    <row @navigate.back.viewTransition class="items-center gap-2 pb-10">
        <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="#0EA5E9" />
        <text class="text-base font-semibold text-[#0EA5E9]">Back — watch them rejoin</text>
    </row>

</column>
