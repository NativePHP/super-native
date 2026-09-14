@php use App\Icons\Android; use App\Icons\Ios; @endphp
<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5 items-center">

        <text class="text-sm text-theme-on-surface-variant">
            The two ends of this morph disagree about size, aspect ratio AND corner radius.
            All three interpolate together, so the circle does not simply grow — it un-rounds
            and stretches on the way.
        </text>

        {{-- A circle. The destination is a square-cornered, full-width banner. --}}
        <column @navigate.viewTransition('/hero/shape/banner')
                ref="shape-morph"
                class="w-[120] h-[120] rounded-full items-center justify-center bg-[#8B5CF6] shadow">
            <icon :ios="Ios::CircleFill" :android="Android::Circle" :size="44" color="#FFFFFF" />
        </column>

        <text class="text-sm font-semibold text-theme-on-surface">Circle → wide banner</text>

        <column class="w-full h-[1] bg-theme-surface my-2" />

        {{-- Second variant: a tall column becomes a short wide strip — the aspect
             ratio inverts, which is the least forgiving case for a morph. --}}
        <column @navigate.viewTransition('/hero/shape/inverted')
                ref="shape-invert"
                class="w-[90] h-[220] rounded-2xl items-center justify-center bg-[#F59E0B] shadow">
            <icon :ios="Ios::ArrowUpAndDown" :android="Android::SwapVert" :size="38" color="#FFFFFF" />
        </column>

        <text class="text-sm font-semibold text-theme-on-surface">Tall → wide (aspect inverts)</text>

        <text class="text-xs text-theme-on-surface-variant text-center pt-2">
            Tall-to-wide is the harshest of these: the element passes through square on its way
            across, and anything drawn inside it visibly distorts mid-flight.
        </text>

    </column>
</scroll-view>
