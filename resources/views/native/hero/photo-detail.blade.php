@php use App\Icons\Android; use App\Icons\Ios; @endphp
<column class="w-full h-full bg-theme-background">

    {{-- Same ref as the grid tile. That name, and only that name,
         is what pairs these two elements across the navigation. --}}
    <column ref="photo-{{ $photo['id'] }}"
            class="w-full h-[380] items-center justify-center bg-[{{ $photo['tint'] }}]">
        <icon :ios="$photo['ios']" :android="$photo['android']" :size="96" color="#FFFFFF" />
    </column>

    <column class="flex-1 w-full p-6 gap-2">
        <text class="text-3xl font-bold text-theme-on-surface">{{ $photo['title'] }}</text>
        <text class="text-base text-theme-on-surface-variant">{{ $photo['place'] }}</text>
        <text class="text-sm text-theme-on-surface-variant pt-2">
            The tile did not fade into this panel — it travelled here and grew. Go back and
            watch it return to its slot in the grid.
        </text>
    </column>

    <row @navigate.back.viewTransition class="items-center gap-2 px-6 pb-10 safe-area">
        <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="#6366F1" />
        <text class="text-base font-semibold text-[#6366F1]">Back to grid</text>
    </row>

</column>
