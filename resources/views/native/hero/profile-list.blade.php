@php use App\Icons\Android; use App\Icons\Ios; @endphp
@php use App\Support\HeroDemoData; $people = HeroDemoData::people(); @endphp

<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-3">

        <text class="text-sm text-theme-on-surface-variant">
            Two names per row — one on the avatar, one on the person's name. A single navigation
            moves both, along different paths, at different distances.
        </text>

        @foreach ($people as $person)
            <row @navigate.viewTransition('/hero/people/'.$person['id'])
                 class="items-center gap-3 p-3 bg-theme-surface rounded-2xl shadow">
                <column ref="avatar-{{ $person['id'] }}"
                        class="w-[48] h-[48] rounded-full items-center justify-center bg-[{{ $person['tint'] }}]">
                    <text class="text-base font-bold text-white">{{ $person['initials'] }}</text>
                </column>
                <column class="flex-1 gap-0.5">
                    <text ref="name-{{ $person['id'] }}"
                          class="text-base font-semibold text-theme-on-surface">{{ $person['name'] }}</text>
                    <text class="text-sm text-theme-on-surface-variant">{{ $person['role'] }}</text>
                </column>
                <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="18" color="#9CA3AF" dark-color="#94A3B8" />
            </row>
        @endforeach

    </column>
</scroll-view>
