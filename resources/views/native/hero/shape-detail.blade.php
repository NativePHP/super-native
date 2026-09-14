@php use App\Icons\Android; use App\Icons\Ios; @endphp
<column class="w-full h-full bg-theme-background safe-area">

    @if ($variant === 'inverted')
        {{-- 90x220 tall → full-width 120 tall. Aspect ratio inverts. --}}
        <column ref="shape-invert"
                class="w-full h-[120] rounded-none items-center justify-center bg-[#F59E0B] mt-16">
            <icon :ios="Ios::ArrowLeftAndRight" :android="Android::SwapHoriz" :size="44" color="#FFFFFF" />
        </column>
        <column class="w-full p-6 gap-2">
            <text class="text-2xl font-bold text-theme-on-surface">Aspect inverted</text>
            <text class="text-sm text-theme-on-surface-variant">
                It went from taller-than-wide to wider-than-tall, passing through roughly square
                halfway. The icon inside is not re-laid-out during the flight, so it stretches
                with the box and snaps back at the end — worth knowing before tagging elements
                whose proportions differ this much.
            </text>
        </column>
    @else
        {{-- 120 circle → full-width square-cornered banner. --}}
        <column ref="shape-morph"
                class="w-full h-[200] rounded-none items-center justify-center bg-[#8B5CF6] mt-16">
            <icon :ios="Ios::RectangleFill" :android="Android::Rectangle" :size="56" color="#FFFFFF" />
        </column>
        <column class="w-full p-6 gap-2">
            <text class="text-2xl font-bold text-theme-on-surface">Un-rounded</text>
            <text class="text-sm text-theme-on-surface-variant">
                The corner radius travelled from fully round to square along with the frame, so
                the circle visibly unwinds into a banner rather than cross-fading into one.
            </text>
        </column>
    @endif

    <column class="flex-1 w-full" />

    <row @navigate.back.viewTransition class="items-center gap-2 px-6 pb-10">
        <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="#6366F1" />
        <text class="text-base font-semibold text-[#6366F1]">Back — watch it re-round</text>
    </row>

</column>
