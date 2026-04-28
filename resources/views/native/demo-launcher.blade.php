<native:scroll-view class="w-full h-full bg-theme-surface">
    <native:column class="w-full p-5 gap-3 safe-area">
        <native:column class="gap-1 pt-2 pb-3">
            <native:text class="text-3xl font-bold">NativePHP</native:text>
            <native:text class="text-sm text-gray-500">Tap a demo to launch</native:text>
        </native:column>

        <native:divider class="mb-2" />

        @foreach ($demos as $demo)
            <native:row
                @press="navigate('{{ $demo['url'] }}')"
                class="items-start gap-4 p-4 bg-gray-100 rounded-xl"
            >
                <native:column class="w-[44] h-[44] rounded-full items-center justify-center bg-[{{ $demo['color'] }}]">
                    <native:icon :name="$demo['icon']" :size="22" color="#FFFFFF" />
                </native:column>
                <native:column class="flex-1 gap-0.5">
                    <native:text class="text-base font-semibold">{{ $demo['title'] }}</native:text>
                    <native:text class="text-sm text-gray-500">{{ $demo['subtitle'] }}</native:text>
                </native:column>
                <native:icon name="chevron_right" :size="20" color="#9CA3AF" />
            </native:row>
        @endforeach
    </native:column>
</native:scroll-view>
