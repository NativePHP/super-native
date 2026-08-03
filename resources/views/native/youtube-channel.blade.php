<scroll-view class="w-full h-full bg-[#0F0F0F] safe-area">
    <column class="w-full gap-0">

        {{-- Top Bar --}}
        <row class="w-full px-4 py-3 items-center gap-4">
            <column @tap="back" a11y-label="Back" class="w-[32] h-[32] items-center justify-center">
                <icon name="arrow_back" :size="24" color="#FFFFFF" />
            </column>
            <spacer />
            <icon name="cast" :size="22" color="#FFFFFF" />
            <icon name="search" :size="22" color="#FFFFFF" />
            <icon name="more_vert" :size="22" color="#FFFFFF" />
        </row>

        {{-- Banner — rounded with side margins, like the app --}}
        <column class="w-full px-3">
            <image
                src="{{ $channel['bannerUrl'] }}"
                alt="{{ $channel['name'] }}'s banner"
                class="w-full h-[80] rounded-xl"
                :fit="2"
            />
        </column>

        {{-- Channel Info --}}
        <column class="w-full px-4 pt-3 gap-3">
            <row class="items-center gap-4">
                <image
                    src="{{ $channel['avatarUrl'] }}"
                    alt="{{ $channel['name'] }}"
                    class="w-[64] h-[64] rounded-full"
                    :fit="2"
                />
                <column class="flex-1 gap-[2]">
                    <row class="items-center gap-1">
                        <text class="text-[22] font-bold text-white" :maxLines="1">{{ $channel['name'] }}</text>
                        @if ($channel['isVerified'])
                            <icon name="verified" :size="15" color="#AAAAAA" />
                        @endif
                    </row>
                    <text class="text-[12] text-[#AAAAAA]" :maxLines="1">{{ $channel['handle'] }} · {{ $subscribersFormatted }} subscribers · {{ $channel['videoCount'] }} videos</text>
                </column>
            </row>

            {{-- Description — one-liner with the app's "…more" hint --}}
            <row class="items-center gap-1">
                <text class="text-[13] text-[#AAAAAA] flex-1" :maxLines="1">{{ $channel['description'] }}</text>
                <icon name="chevron_right" :size="16" color="#AAAAAA" />
            </row>

            {{-- Subscribe Button --}}
            <pressable
                @tap="toggleSubscribe"
                a11y-label="{{ $isSubscribed ? 'Unsubscribe' : 'Subscribe' }}"
                class="w-full py-3 rounded-full items-center {{ $isSubscribed ? 'bg-[#272727]' : 'bg-white' }}"
            >
                <row class="items-center gap-2">
                    @if ($isSubscribed)
                        <icon name="notifications" :size="16" color="#FFFFFF" />
                    @endif
                    <text class="text-[14] font-bold {{ $isSubscribed ? 'text-white' : 'text-black' }}">{{ $isSubscribed ? 'Subscribed' : 'Subscribe' }}</text>
                    @if ($isSubscribed)
                        <icon name="expand_more" :size="16" color="#FFFFFF" />
                    @endif
                </row>
            </pressable>
        </column>

        {{-- Tab Row --}}
        <row class="w-full items-center pt-3">
            <column class="flex-1 items-center pb-2 gap-[6]">
                <text class="text-[14] font-semibold text-white">Videos</text>
                <column class="w-[48] h-[2] bg-white" />
            </column>
            <column class="flex-1 items-center pb-2">
                <text class="text-[14] text-[#AAAAAA]">Shorts</text>
            </column>
            <column class="flex-1 items-center pb-2">
                <text class="text-[14] text-[#AAAAAA]">Playlists</text>
            </column>
        </row>

        <divider class="w-full" color="#272727" />

        {{-- Channel Videos — feed-style cards. Duration badges use
             `absolute` with NON-ZERO insets only; both stack renderers
             read a zero bottom/right inset as "unset". --}}
        @foreach ($videosWithMeta as $vIndex => $video)
            <column class="w-full pt-3 pb-1">
                <pressable @tap="viewVideo({{ $vIndex }})" class="w-full px-2">
                    <stack class="w-full h-[210]">
                        <image
                            src="{{ $video['thumbnailUrl'] }}"
                            alt="{{ $video['title'] }}"
                            class="w-full h-[210] rounded-xl"
                            :fit="2"
                        />
                        <column class="absolute bottom-2 right-3 bg-[#000000CC] rounded-md px-[6] py-[2]">
                            <text class="text-[11] font-semibold text-white">{{ $video['duration'] }}</text>
                        </column>
                    </stack>
                </pressable>

                <pressable @tap="viewVideo({{ $vIndex }})" class="w-full">
                    <row class="w-full px-3 pt-2 gap-3">
                        <column class="flex-1 gap-1">
                            <text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</text>
                            <text class="text-[12] text-[#AAAAAA]">{{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</text>
                        </column>
                        <icon name="more_vert" :size="18" color="#AAAAAA" />
                    </row>
                </pressable>
            </column>
        @endforeach

        @if (empty($videosWithMeta))
            <column class="w-full py-8 items-center">
                <icon name="video" :size="48" color="#717171" />
                <text class="text-[14] text-[#717171] pt-2">No videos yet</text>
            </column>
        @endif

        <spacer class="h-[20] flex-grow-0" />

    </column>
</scroll-view>
