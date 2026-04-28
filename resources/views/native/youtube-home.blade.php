{{-- @include('native.partials.demo-nav', ['title' => 'YouTube']) --}}

<native:scroll-view class="w-full h-full bg-[#0F0F0F]">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full px-4 pt-3 pb-2 items-center justify-between">
            <native:row class="items-center gap-2">
                <native:icon name="play_circle_filled" :size="28" color="#FF0000" />
                <native:text class="text-[20] font-bold text-white">YouTube</native:text>
            </native:row>
            <native:row class="items-center gap-4">
                <native:icon name="cast" :size="22" color="#FFFFFF" />
                <native:icon name="notifications_none" :size="24" color="#FFFFFF" />
                <native:column @press="viewSearch" class="w-[32] h-[32] items-center justify-center">
                    <native:icon name="search" :size="24" color="#FFFFFF" />
                </native:column>
            </native:row>
        </native:row>

        {{-- Category Chips --}}
        <native:scroll-view horizontal>
            <native:row class="gap-2 px-4 pb-3">
                @foreach ($categories as $name => $color)
                    <native:column
                        @press="selectCategory('{{ $name }}')"
                        class="px-3 py-2 rounded-lg {{ $activeCategory === $name ? 'bg-white' : 'bg-[#272727]' }}"
                    >
                        <native:text class="text-[13] font-semibold {{ $activeCategory === $name ? 'text-black' : 'text-white' }}">{{ $name }}</native:text>
                    </native:column>
                @endforeach
            </native:row>
        </native:scroll-view>

        {{-- Video Feed --}}
        @foreach (array_slice($videos, 0, 4) as $index => $video)
            <native:column class="w-full pb-3">
                {{-- Thumbnail --}}
                <native:column @press="viewVideo({{ $index }})" class="w-full">
                    <native:stack class="w-full h-[210]">
                        <native:image
                            src="{{ $video['thumbnailUrl'] }}"
                            class="w-full h-[210]"
                            :fit="2"
                        />
                        {{-- Duration Badge --}}
                        <native:column class="w-full h-[210] items-end justify-end p-2">
                            <native:column class="bg-[#000000CC] rounded px-1 py-[1]">
                                <native:text class="text-[11] font-semibold text-white">{{ $video['duration'] }}</native:text>
                            </native:column>
                        </native:column>
                    </native:stack>
                </native:column>

                {{-- Video Info --}}
                <native:row class="w-full px-3 pt-3 gap-3">
                    <native:column @press="viewChannel({{ $video['channelId'] }})">
                        <native:image
                            src="{{ $video['channel']['avatarUrl'] }}"
                            class="w-[36] h-[36] rounded-full"
                            :fit="2"
                        />
                    </native:column>
                    <native:column @press="viewVideo({{ $index }})" class="w-[290] gap-1">
                        <native:text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</native:text>
                        <native:row class="items-center gap-1">
                            <native:text class="text-[12] text-[#AAAAAA]">{{ $video['channel']['name'] }}</native:text>
                            @if ($video['channel']['isVerified'])
                                <native:icon name="verified" :size="12" color="#AAAAAA" />
                            @endif
                            <native:text class="text-[12] text-[#AAAAAA]">· {{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</native:text>
                        </native:row>
                    </native:column>
                    <native:icon name="more_vert" :size="18" color="#AAAAAA" />
                </native:row>
            </native:column>
        @endforeach

        {{-- Shorts Section --}}
        <native:row class="w-full px-4 pt-2 pb-3 items-center gap-2">
            <native:icon name="play_circle_filled" :size="22" color="#FF0000" />
            <native:text class="text-[16] font-bold text-white">Shorts</native:text>
        </native:row>

        <native:scroll-view horizontal>
            <native:row class="gap-2 px-4 pb-4">
                @foreach ($shorts as $short)
                    <native:column class="w-[140] gap-1">
                        <native:stack class="w-[140] h-[248] rounded-lg">
                            <native:image
                                src="{{ $short['thumbnailUrl'] }}"
                                class="w-[140] h-[248] rounded-lg"
                                :fit="2"
                            />
                            <native:column class="w-[140] h-[248] justify-end p-2">
                                <native:text class="text-[12] font-bold text-white" :maxLines="2">{{ $short['title'] }}</native:text>
                                <native:text class="text-[11] text-[#DDDDDD]">{{ $short['viewsFormatted'] }} views</native:text>
                            </native:column>
                        </native:stack>
                    </native:column>
                @endforeach
            </native:row>
        </native:scroll-view>

        {{-- More Videos --}}
        @foreach (array_slice($videos, 4) as $index => $video)
            <native:column class="w-full pb-3">
                <native:column @press="viewVideo({{ $index + 4 }})" class="w-full">
                    <native:stack class="w-full h-[210]">
                        <native:image
                            src="{{ $video['thumbnailUrl'] }}"
                            class="w-full h-[210]"
                            :fit="2"
                        />
                        <native:column class="w-full h-[210] items-end justify-end p-2">
                            <native:column class="bg-[#000000CC] rounded px-1 py-[1]">
                                <native:text class="text-[11] font-semibold text-white">{{ $video['duration'] }}</native:text>
                            </native:column>
                        </native:column>
                    </native:stack>
                </native:column>

                <native:row class="w-full px-3 pt-3 gap-3">
                    <native:column @press="viewChannel({{ $video['channelId'] }})">
                        <native:image
                            src="{{ $video['channel']['avatarUrl'] }}"
                            class="w-[36] h-[36] rounded-full"
                            :fit="2"
                        />
                    </native:column>
                    <native:column @press="viewVideo({{ $index + 4 }})" class="w-[290] gap-1">
                        <native:text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</native:text>
                        <native:row class="items-center gap-1">
                            <native:text class="text-[12] text-[#AAAAAA]">{{ $video['channel']['name'] }}</native:text>
                            @if ($video['channel']['isVerified'])
                                <native:icon name="verified" :size="12" color="#AAAAAA" />
                            @endif
                            <native:text class="text-[12] text-[#AAAAAA]">· {{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</native:text>
                        </native:row>
                    </native:column>
                    <native:icon name="more_vert" :size="18" color="#AAAAAA" />
                </native:row>
            </native:column>
        @endforeach

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
