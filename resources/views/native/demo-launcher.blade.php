<native:scroll-view class="w-full h-full bg-theme-background">

{{--    <native:stack class="w-full h-full items-center justify-center">--}}
{{--        <native:scroll-view axis="both" class="w-full h-full">--}}
{{--            <native:image src="https://images.nationalgeographic.org/image/upload/v1638892520/EducationHub/photos/stream-in-colorado.jpg"--}}
{{--                          class="w-[2400] h-[1600]"/>--}}
{{--        </native:scroll-view>--}}

{{--        <native:column class="w-full h-full px-10">--}}
{{--            <native:text class="px-4 text-center py-2 my-64 font-bold rounded-full text-2xl glass:clear:interactive">This is amazing!</native:text>--}}
{{--        </native:column>--}}
{{--    </native:stack>--}}
{{--    <native:stack>--}}
{{--        <native:image--}}
{{--            src="https://picsum.photos/seed/super-native/800/400"--}}
{{--            class="w-full h-[500]"--}}
{{--            :fit="2" />--}}
{{--        <native:column class="w-full gap-2 px-4 items-center justify-center">--}}
{{--            <native:card class="glass:clear:interactive bg-purple-400/40">--}}
{{--                <native:column class="w-full p-5 gap-2 ">--}}
{{--                    <native:text class="text-lg font-semibold text-theme-on-surface">Welcome to The Vibes</native:text>--}}
{{--                    <native:text class="text-sm text-black">We are building the future one day, one component at a time!</native:text>--}}
{{--                </native:column>--}}
{{--            </native:card>--}}
{{--            <native:button class="px-4 text-center py-2 mt-8 font-bold rounded-full text-2xl text-red-500">Hello World</native:button>--}}
{{--        </native:column>--}}
{{--    </native:stack>--}}

{{--    <native:stack>--}}
{{--        <native:image--}}
{{--            src="https://picsum.photos/seed/nativephp/800/400"--}}
{{--            class="w-full h-[600]"--}}
{{--            :fit="2"--}}
{{--        />--}}
{{--        <native:column class="w-full gap-2 px-4">--}}
{{--            <native:card class="glass:clear:interactive bg-purple-400/30">--}}
{{--                <native:column class="w-full p-5 gap-2 ">--}}
{{--                    <native:text class="text-lg font-semibold text-theme-on-surface">Glass card · clear</native:text>--}}
{{--                    <native:text class="text-sm text-theme-on-surface-variant">--}}
{{--                        `.glassEffect(.clear)` (iOS 26+) / `.ultraThinMaterial` (older).--}}
{{--                        Reads transparent — best over a colorful or photographic backdrop.--}}
{{--                    </native:text>--}}
{{--                </native:column>--}}
{{--            </native:card>--}}
{{--            <native:text class="px-4 text-center py-2 mt-8 font-bold rounded-full glass:interactive text-2xl text-red-500 ">Action</native:text>--}}
{{--        </native:column>--}}
{{--    </native:stack>--}}
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
