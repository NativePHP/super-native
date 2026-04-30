<native:scroll-view class="w-full h-full bg-theme-background">
    {{-- Title comes from DemoLauncher::navTitle() and renders in the
         NavigationStack toolbar (fixed top bar) provided by NativeStackLayout. --}}
    <native:column class="w-full p-5 gap-3">
        @foreach ($demos as $demo)
            <native:row
                @press="navigate('{{ $demo['url'] }}')"
                class="items-start gap-4 p-4 bg-theme-surface-variant rounded-xl"
            >
                <native:column class="w-[44] h-[44] rounded-full items-center justify-center bg-[{{ $demo['color'] }}]">
                    <native:icon :name="$demo['icon']" :size="22" color="#FFFFFF" />
                </native:column>
                <native:column class="flex-1 gap-0.5">
                    <native:text class="text-base font-semibold text-theme-on-surface">{{ $demo['title'] }}</native:text>
                    <native:text class="text-sm text-theme-on-surface-variant">{{ $demo['subtitle'] }}</native:text>
                </native:column>
                <native:icon name="chevron_right" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
            </native:row>
        @endforeach
    </native:column>
</native:scroll-view>
