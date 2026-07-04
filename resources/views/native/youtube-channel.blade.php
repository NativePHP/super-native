<scroll-view class="w-full h-full bg-[#0F0F0F] safe-area">
    <column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <row class="w-full px-4 py-3 items-center gap-3">
            <column @press="back" a11y-label="Back" class="w-[32] h-[32] items-center justify-center">
                <icon name="arrow_back" :size="24" color="#FFFFFF" />
            </column>
            <spacer />
            <icon name="cast" :size="22" color="#FFFFFF" />
            <icon name="search" :size="22" color="#FFFFFF" />
            <icon name="more_vert" :size="22" color="#FFFFFF" />
        </row>

        {{-- Banner --}}
        <image
            src="{{ $channel['bannerUrl'] }}"
            alt="{{ $channel['name'] }}'s banner"
            class="w-full h-[90]"
            :fit="2"
        />

        {{-- Channel Info --}}
        <column class="w-full px-4 pt-4 gap-3">
            <row class="items-center gap-4">
                <image
                    src="{{ $channel['avatarUrl'] }}"
                    alt="{{ $channel['name'] }}"
                    class="w-[72] h-[72] rounded-full"
                    :fit="2"
                />
                <column class="flex-1 gap-1">
                    <row class="items-center gap-1">
                        <text class="text-[22] font-bold text-white" :maxLines="1">{{ $channel['name'] }}</text>
                        @if ($channel['isVerified'])
                            <icon name="verified" :size="16" color="#AAAAAA" />
                        @endif
                    </row>
                    <text class="text-[13] text-[#AAAAAA]" :maxLines="1">{{ $channel['handle'] }}</text>
                    <row class="items-center gap-1">
                        <text class="text-[13] text-[#AAAAAA]" :maxLines="1">{{ $subscribersFormatted }} subscribers · {{ $channel['videoCount'] }} videos</text>
                    </row>
                </column>
            </row>

            {{-- Description --}}
            <text class="text-[13] text-[#AAAAAA]" :maxLines="2">{{ $channel['description'] }}</text>

            {{-- Subscribe Button --}}
            <column
                @press="toggleSubscribe"
                class="w-full py-3 rounded-full items-center {{ $isSubscribed ? 'bg-[#272727]' : 'bg-white' }}"
            >
                <text class="text-[14] font-bold {{ $isSubscribed ? 'text-white' : 'text-black' }}">{{ $isSubscribed ? 'Subscribed' : 'Subscribe' }}</text>
            </column>
        </column>

        <divider class="w-full mt-4" color="#272727" />

        {{-- Tab Row --}}
        <row class="w-full items-center justify-around py-3">
            <column class="items-center px-4 pb-2 gap-1">
                <text class="text-[14] font-semibold text-white">Videos</text>
                <column class="w-full h-[2] bg-white" />
            </column>
            <column class="items-center px-4 pb-2">
                <text class="text-[14] text-[#AAAAAA]">Shorts</text>
            </column>
            <column class="items-center px-4 pb-2">
                <text class="text-[14] text-[#AAAAAA]">Playlists</text>
            </column>
        </row>

        <divider class="w-full" color="#272727" />

        {{-- Channel Videos --}}
        @foreach ($videosWithMeta as $vIndex => $video)
            <column @press="viewVideo({{ $vIndex }})" class="w-full pb-3">
                <stack class="w-full h-[210]">
                    <image
                        src="{{ $video['thumbnailUrl'] }}"
                        class="w-full h-[210]"
                        :fit="2"
                    />
                    <column class="w-full h-[210] items-end justify-end p-2">
                        <column class="bg-[#000000CC] rounded px-1 py-[1]">
                            <text class="text-[11] font-semibold text-white">{{ $video['duration'] }}</text>
                        </column>
                    </column>
                </stack>

                <column class="w-full px-3 pt-3 gap-1">
                    <text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</text>
                    <text class="text-[12] text-[#AAAAAA]">{{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</text>
                </column>
            </column>
        @endforeach

        @if (empty($videosWithMeta))
            <column class="w-full py-8 items-center">
                <icon name="video_library" :size="48" color="#717171" />
                <text class="text-[14] text-[#717171] pt-2">No videos yet</text>
            </column>
        @endif

        <spacer class="h-[20]" />

    </column>
</scroll-view>
