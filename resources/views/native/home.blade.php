<native:scroll-view class="flex-1 w-full">
    <native:column class="flex-1 p-5 gap-4">
        <native:text class="text-3xl font-bold">Welcome</native:text>
        <native:text class="text-sm text-gray-500">Tap a row to push a detail screen.</native:text>

        <native:divider />

        @foreach ($items as $item)
            <native:row @press="navigate('/item/{{ $item['id'] }}')" class="items-center gap-3 py-3">
                <native:column class="w-[44] h-[44] rounded-full bg-blue-500 items-center justify-center">
                    <native:text class="text-white font-bold">{{ $item['id'] }}</native:text>
                </native:column>
                <native:column class="flex-1 gap-0.5">
                    <native:text class="text-base font-semibold">{{ $item['title'] }}</native:text>
                    <native:text class="text-sm text-gray-500">{{ $item['subtitle'] }}</native:text>
                </native:column>
                <native:icon name="chevron_right" :size="20" color="#9CA3AF" />
            </native:row>
            <native:divider />
        @endforeach
    </native:column>
</native:scroll-view>
