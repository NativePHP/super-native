@php use App\Support\HeroDemoData; $people = HeroDemoData::people(); @endphp

<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-4">

        <text class="text-sm text-theme-on-surface-variant">
            Each card is tagged, and so is the avatar inside it. The inner element is matched
            independently — it is not just carried along by its parent, so watch it drift to a
            different corner while the card itself is still expanding.
        </text>

        @foreach ($people as $person)
            <column @navigate.viewTransition('/hero/nested/'.$person['id'])
                    ref="nest-card-{{ $person['id'] }}"
                    class="w-full p-4 gap-3 rounded-2xl bg-[{{ $person['tint'] }}] shadow">
                <row class="w-full items-center gap-3">
                    {{-- Inner hero: sits left here, moves right on the detail. --}}
                    <column ref="nest-avatar-{{ $person['id'] }}"
                            class="w-[44] h-[44] rounded-full items-center justify-center bg-[#FFFFFF33]">
                        <text class="text-sm font-bold text-white">{{ $person['initials'] }}</text>
                    </column>
                    <column class="flex-1 gap-0.5">
                        <text class="text-base font-bold text-white" :maxLines="1">{{ $person['name'] }}</text>
                        <text class="text-xs text-[#FFFFFFCC]">{{ $person['role'] }}</text>
                    </column>
                </row>
            </column>
        @endforeach

    </column>
</scroll-view>
