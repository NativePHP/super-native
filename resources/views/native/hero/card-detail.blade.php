@php use App\Icons\Android; use App\Icons\Ios; @endphp
<column class="w-full h-full bg-theme-background">

    {{-- The same ref as the list card. The container morphs from a
         compact tile to this full-bleed header while its children change. --}}
    <column ref="card-{{ $card['id'] }}"
            class="w-full p-6 pt-16 gap-3 bg-[{{ $card['tint'] }}] safe-area">
        <row class="items-center gap-3">
            <column class="w-[44] h-[44] rounded-xl items-center justify-center bg-[#FFFFFF33]">
                <icon :ios="$card['ios']" :android="$card['android']" :size="22" color="#FFFFFF" />
            </column>
            <text class="text-xs font-semibold text-white uppercase">{{ $card['kicker'] }}</text>
        </row>
        <text class="text-3xl font-bold text-white">{{ $card['title'] }}</text>
    </column>

    <scroll-view class="flex-1 w-full">
        <column class="w-full p-6 gap-4">
            <text class="text-base text-theme-on-surface">{{ $card['body'] }}</text>
            <text class="text-sm text-theme-on-surface-variant">
                Watch the tile's corners and colour block: it expanded rather than cross-faded.
                The summary line was replaced mid-flight.
            </text>
            <row @navigate.back.viewTransition class="items-center gap-2 pt-2">
                <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="{{ $card['tint'] }}" />
                <text class="text-base font-semibold text-[{{ $card['tint'] }}]">Back to cards</text>
            </row>
        </column>
    </scroll-view>

</column>
