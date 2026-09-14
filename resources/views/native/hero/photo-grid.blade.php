@php use App\Support\HeroDemoData; $photos = HeroDemoData::photos(); @endphp

<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-4">

        <text class="text-sm text-theme-on-surface-variant">
            Each tile carries ref="photo-{id}". The detail screen tags its large
            panel with the same name, so the two are one element as far as the renderer is
            concerned. Drawn as shapes, not images — nothing here waits on the network.
        </text>

        {{-- Two-column grid, built as rows of two so the layout stays flex-only. --}}
        @foreach (array_chunk($photos, 2) as $pair)
            <row class="w-full gap-4">
                @foreach ($pair as $photo)
                    <column @navigate.viewTransition('/hero/photos/'.$photo['id'])
                            class="flex-1 gap-2">
                        <column ref="photo-{{ $photo['id'] }}"
                                class="w-full h-[150] rounded-2xl items-center justify-center bg-[{{ $photo['tint'] }}] shadow">
                            <icon :ios="$photo['ios']" :android="$photo['android']" :size="40" color="#FFFFFF" />
                        </column>
                        <column class="gap-0.5 px-0.5">
                            <text class="text-sm font-semibold text-theme-on-surface" :maxLines="1">{{ $photo['title'] }}</text>
                            <text class="text-xs text-theme-on-surface-variant" :maxLines="1">{{ $photo['place'] }}</text>
                        </column>
                    </column>
                @endforeach
            </row>
        @endforeach

    </column>
</scroll-view>
