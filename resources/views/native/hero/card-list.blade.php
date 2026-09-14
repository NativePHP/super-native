@php use App\Support\HeroDemoData; $cards = HeroDemoData::cards(); @endphp

<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-4">

        <text class="text-sm text-theme-on-surface-variant">
            Here the tagged element is the CARD ITSELF, not an image. The two ends hold different
            content — a one-line summary here, full body copy on the detail — so the box has to
            travel while what is inside it changes.
        </text>

        @foreach ($cards as $card)
            <column @navigate.viewTransition('/hero/cards/'.$card['id'])
                    ref="card-{{ $card['id'] }}"
                    class="w-full p-4 gap-3 rounded-2xl bg-[{{ $card['tint'] }}] shadow">
                <row class="items-center gap-3">
                    <column class="w-[36] h-[36] rounded-xl items-center justify-center bg-[#FFFFFF33]">
                        <icon :ios="$card['ios']" :android="$card['android']" :size="18" color="#FFFFFF" />
                    </column>
                    <text class="text-xs font-semibold text-white uppercase">{{ $card['kicker'] }}</text>
                </row>
                <text class="text-lg font-bold text-white">{{ $card['title'] }}</text>
                <text class="text-sm text-[#FFFFFFCC]">{{ $card['summary'] }}</text>
            </column>
        @endforeach

    </column>
</scroll-view>
