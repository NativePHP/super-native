<native:scroll-view class="w-full h-full bg-[#0F0F0F] safe-area">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full px-4 py-3 items-center gap-3">
            <native:column @press="back" class="w-[32] h-[32] items-center justify-center">
                <native:icon name="arrow_back" :size="24" color="#FFFFFF" />
            </native:column>
            <native:spacer />
            <native:icon name="cast" :size="22" color="#FFFFFF" />
            <native:icon name="search" :size="22" color="#FFFFFF" />
            <native:icon name="more_vert" :size="22" color="#FFFFFF" />
        </native:row>

        {{-- Banner --}}
        <native:image
            src="{{ $channel['bannerUrl'] }}"
            class="w-full h-[90]"
            :fit="2"
        />

        {{-- Channel Info --}}
        <native:column class="w-full px-4 pt-4 gap-3">
            <native:row class="items-center gap-4">
                <native:image
                    src="{{ $channel['avatarUrl'] }}"
                    class="w-[72] h-[72] rounded-full"
                    :fit="2"
                />
                <native:column class="flex-1 gap-1">
                    <native:row class="items-center gap-1">
                        <native:text class="text-[22] font-bold text-white" :maxLines="1">{{ $channel['name'] }}</native:text>
                        @if ($channel['isVerified'])
                            <native:icon name="verified" :size="16" color="#AAAAAA" />
                        @endif
                    </native:row>
                    <native:text class="text-[13] text-[#AAAAAA]" :maxLines="1">{{ $channel['handle'] }}</native:text>
                    <native:row class="items-center gap-1">
                        <native:text class="text-[13] text-[#AAAAAA]" :maxLines="1">{{ $subscribersFormatted }} subscribers · {{ $channel['videoCount'] }} videos</native:text>
                    </native:row>
                </native:column>
            </native:row>

            {{-- Description --}}
            <native:text class="text-[13] text-[#AAAAAA]" :maxLines="2">{{ $channel['description'] }}</native:text>

            {{-- Subscribe Button --}}
            <native:column
                @press="toggleSubscribe"
                class="w-full py-3 rounded-full items-center {{ $isSubscribed ? 'bg-[#272727]' : 'bg-white' }}"
            >
                <native:text class="text-[14] font-bold {{ $isSubscribed ? 'text-white' : 'text-black' }}">{{ $isSubscribed ? 'Subscribed' : 'Subscribe' }}</native:text>
            </native:column>
        </native:column>

        <native:divider class="w-full mt-4" color="#272727" />

        {{-- Tab Row --}}
        <native:row class="w-full items-center justify-around py-3">
            <native:column class="items-center px-4 pb-2 gap-1">
                <native:text class="text-[14] font-semibold text-white">Videos</native:text>
                <native:column class="w-full h-[2] bg-white" />
            </native:column>
            <native:column class="items-center px-4 pb-2">
                <native:text class="text-[14] text-[#AAAAAA]">Shorts</native:text>
            </native:column>
            <native:column class="items-center px-4 pb-2">
                <native:text class="text-[14] text-[#AAAAAA]">Playlists</native:text>
            </native:column>
        </native:row>

        <native:divider class="w-full" color="#272727" />

        {{-- Channel Videos --}}
        @foreach ($videosWithMeta as $vIndex => $video)
            <native:column @press="viewVideo({{ $vIndex }})" class="w-full pb-3">
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

                <native:column class="w-full px-3 pt-3 gap-1">
                    <native:text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</native:text>
                    <native:text class="text-[12] text-[#AAAAAA]">{{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</native:text>
                </native:column>
            </native:column>
        @endforeach

        @if (empty($videosWithMeta))
            <native:column class="w-full py-8 items-center">
                <native:icon name="video_library" :size="48" color="#717171" />
                <native:text class="text-[14] text-[#717171] pt-2">No videos yet</native:text>
            </native:column>
        @endif

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
