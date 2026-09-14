@php use App\Icons\Android; use App\Icons\Ios; @endphp
<column class="w-full h-full bg-theme-background items-center safe-area">

    <column class="w-full items-center gap-4 pt-16 pb-8 bg-[{{ $person['tint'] }}1A]">
        {{-- Avatar travels from a 48pt row thumbnail to a 120pt circle... --}}
        <column ref="avatar-{{ $person['id'] }}"
                class="w-[120] h-[120] rounded-full items-center justify-center bg-[{{ $person['tint'] }}] shadow">
            <text class="text-4xl font-bold text-white">{{ $person['initials'] }}</text>
        </column>

        {{-- ...while the name travels from a left-aligned row label to here,
             centred and much larger. Same navigation, independent paths. --}}
        <text ref="name-{{ $person['id'] }}"
              class="text-2xl font-bold text-theme-on-surface">{{ $person['name'] }}</text>

        <text class="text-base text-theme-on-surface-variant">{{ $person['role'] }}</text>
    </column>

    <column class="flex-1 w-full p-6 gap-3">
        <text class="text-sm text-theme-on-surface-variant">
            Nothing coordinates these two morphs with each other. They share only the navigation
            that started them, and the single animation curve every view transition uses.
        </text>
    </column>

    <row @navigate.back.viewTransition class="items-center gap-2 pb-10">
        <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="{{ $person['tint'] }}" />
        <text class="text-base font-semibold text-[{{ $person['tint'] }}]">Back to people</text>
    </row>

</column>
