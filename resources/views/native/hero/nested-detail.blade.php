@php use App\Icons\Android; use App\Icons\Ios; @endphp
<column class="w-full h-full bg-theme-background">

    {{-- Outer hero: the card, now a full-width header. --}}
    <column ref="nest-card-{{ $person['id'] }}"
            class="w-full p-6 pt-16 gap-4 bg-[{{ $person['tint'] }}] safe-area">

        <row class="w-full items-center">
            <column class="flex-1 gap-1">
                <text class="text-3xl font-bold text-white">{{ $person['name'] }}</text>
                <text class="text-sm text-[#FFFFFFCC]">{{ $person['role'] }}</text>
            </column>

            {{-- Inner hero: was on the LEFT at 44pt, is now on the RIGHT at 88pt.
                 Opposite horizontal direction to the card's own growth. --}}
            <column ref="nest-avatar-{{ $person['id'] }}"
                    class="w-[88] h-[88] rounded-full items-center justify-center bg-[#FFFFFF33]">
                <text class="text-2xl font-bold text-white">{{ $person['initials'] }}</text>
            </column>
        </row>

    </column>

    <column class="flex-1 w-full p-6 gap-3">
        <text class="text-sm text-theme-on-surface-variant">
            The card grew downward and outward. The avatar travelled the other way — right and
            slightly up — because it is matched on its own name, not inherited from the card.
            Two matched pairs resolving inside one navigation, neither aware of the other.
        </text>
        <row @navigate.back.viewTransition class="items-center gap-2 pt-2">
            <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="{{ $person['tint'] }}" />
            <text class="text-base font-semibold text-[{{ $person['tint'] }}]">Back — in reverse</text>
        </row>
    </column>

</column>
