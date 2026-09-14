@php use App\Icons\Android; use App\Icons\Ios; @endphp
@php use App\Support\HeroDemoData; $rows = HeroDemoData::deepRows(); @endphp

<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-2">

        <text class="text-sm text-theme-on-surface-variant pb-2">
            Forty tagged rows. Scroll a long way down and tap one near the edge of the screen —
            the morph starts from wherever that row physically is, which is not knowable ahead
            of time.
        </text>

        @foreach ($rows as $row)
            <row @navigate.viewTransition('/hero/deep/'.$row['id'])
                 class="w-full items-center gap-3 p-3 bg-theme-surface rounded-xl">
                <column ref="deep-{{ $row['id'] }}"
                        class="w-[40] h-[40] rounded-lg items-center justify-center bg-[{{ $row['tint'] }}]">
                    <text class="text-sm font-bold text-white">{{ $row['id'] }}</text>
                </column>
                <text class="flex-1 text-base text-theme-on-surface">{{ $row['label'] }}</text>
                <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="16" color="#9CA3AF" dark-color="#94A3B8" />
            </row>
        @endforeach

    </column>
</scroll-view>
