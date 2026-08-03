<scroll-view class="flex-1 w-full">
    <column class="flex-1 p-5 gap-4">
        <text class="text-3xl font-bold">Welcome</text>
        <text class="text-sm text-theme-on-surface-variant">Tap a row to push a detail screen.</text>

        <divider />

        @foreach ($items as $item)
            <row @tap="navigate('/item/{{ $item['id'] }}')" class="items-center gap-3 py-3">
                <column class="w-[44] h-[44] rounded-full bg-theme-primary items-center justify-center">
                    <text class="text-theme-on-primary font-bold">{{ $item['id'] }}</text>
                </column>
                <column class="flex-1 gap-0.5">
                    <text class="text-base font-semibold">{{ $item['title'] }}</text>
                    <text class="text-sm text-theme-on-surface-variant">{{ $item['subtitle'] }}</text>
                </column>
                <icon name="chevron_right" :size="20" color="#9CA3AF" />
            </row>
            <divider />
        @endforeach
    </column>
</scroll-view>
