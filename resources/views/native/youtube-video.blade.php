<scroll-view class="w-full h-full bg-[#0F0F0F] safe-area">
    <column class="w-full gap-0 ">

        {{-- Video Player Area — overlay icons sit on stronger dark
             scrims so they don't fight with the thumbnail behind them.
             Z-order matters: interactive children must render LAST so
             their hit area isn't covered by a non-interactive sibling.
             Each `<column class="w-full h-[220] ...">` here
             spans the entire stack, so a non-interactive overlay
             declared after the back-button row would swallow taps
             before they reach the row. Order:
                image → play overlay → duration → controls (top). --}}
        <stack class="w-full h-[220] bg-black">
            <image
                src="{{ $video['thumbnailUrl'] }}"
                class="w-full h-[220]"
                :fit="2"
            />
            {{-- Centered Play Button — large but clearly distinguishable
                 from the thumbnail thanks to a near-opaque dark disc. --}}
            <column class="w-full h-[220] items-center justify-center">
                <column class="w-[64] h-[64] rounded-full bg-[#000000CC] items-center justify-center">
                    <icon name="play_arrow" :size="40" color="#FFFFFF" />
                </column>
            </column>
            {{-- Duration sits bottom-right with the same opaque scrim. --}}
            <column class="w-full h-[220] items-end justify-end p-2">
                <column class="bg-[#000000CC] rounded px-2 py-[2]">
                    <text class="text-[12] font-semibold text-white">{{ $video['duration'] }}</text>
                </column>
            </column>
            {{-- Top controls (back / settings) — declared LAST so they
                 sit above the other overlay layers and receive taps. --}}
            <row class="w-full px-3 pt-3 items-center justify-between">
                <column @press="back" a11y-label="Back" class="w-[36] h-[36] rounded-full bg-[#000000AA] items-center justify-center">
                    <icon name="arrow_back" :size="20" color="#FFFFFF" />
                </column>
                <column class="w-[36] h-[36] rounded-full bg-[#000000AA] items-center justify-center">
                    <icon name="settings" :size="18" color="#FFFFFF" />
                </column>
            </row>
        </stack>

        {{-- Video Title & Info — pt-4 gives clear breathing room below
             the player so the title doesn't visually butt into it. --}}
        <column @press="toggleDescription" class="w-full px-3 pt-4 gap-1">
            <text class="text-[16] font-bold text-white" :maxLines="$showDescription ? 10 : 2">{{ $video['title'] }}</text>
            <row class="items-center gap-1">
                <text class="text-[12] text-[#AAAAAA]">{{ $viewsFormatted }} views · {{ $video['uploadedAt'] }}</text>
                <icon name="{{ $showDescription ? 'expand_less' : 'expand_more' }}" :size="16" color="#AAAAAA" />
            </row>
        </column>

        {{-- Expandable Description --}}
        @if ($showDescription)
            <column class="w-full px-3 pt-2 pb-2">
                <text class="text-[13] text-[#CCCCCC]">{{ $video['description'] }}</text>
            </column>
        @endif

        {{-- Action Buttons --}}
        <scroll-view horizontal>
            <row class="px-3 pt-3 pb-2 gap-2">
                {{-- Like / Dislike — explicit white-on-gray for the
                     idle dislike icon so it's actually visible against
                     the dark gray pill (was #AAAAAA, near-invisible). --}}
                <row @press="toggleLike" class="bg-[#272727] rounded-full px-4 py-2 items-center gap-2">
                    <icon
                        name="{{ $isLiked ? 'thumb_up' : 'thumb_up_off_alt' }}"
                        :size="20"
                        color="#FFFFFF"
                    />
                    <text class="text-[13] font-semibold text-white">{{ $likesFormatted }}</text>
                    <text class="text-[15] text-[#5A5A5A]">|</text>
                    <column @press="toggleDislike" a11y-label="Dislike">
                        <icon
                            name="{{ $isDisliked ? 'thumb_down' : 'thumb_down_off_alt' }}"
                            :size="20"
                            color="#FFFFFF"
                        />
                    </column>
                </row>

                {{-- Share --}}
                <row class="bg-[#272727] rounded-full px-4 py-2 items-center gap-2">
                    <icon name="share" :size="20" color="#AAAAAA" />
                    <text class="text-[13] font-semibold text-white">Share</text>
                </row>

                {{-- Download --}}
                <row class="bg-[#272727] rounded-full px-4 py-2 items-center gap-2">
                    <icon name="download" :size="20" color="#AAAAAA" />
                    <text class="text-[13] font-semibold text-white">Download</text>
                </row>

                {{-- Save --}}
                <row class="bg-[#272727] rounded-full px-4 py-2 items-center gap-2">
                    <icon name="playlist_add" :size="20" color="#AAAAAA" />
                    <text class="text-[13] font-semibold text-white">Save</text>
                </row>
            </row>
        </scroll-view>

        <divider class="w-full" color="#272727" />

        {{-- Channel Info --}}
        <row class="w-full px-3 py-3 items-center gap-3">
            <column @press="viewChannel({{ $video['channelId'] }})">
                <image
                    src="{{ $channel['avatarUrl'] }}"
                    alt="{{ $channel['name'] }}'s channel"
                    class="w-[40] h-[40] rounded-full"
                    :fit="2"
                />
            </column>
            <column @press="viewChannel({{ $video['channelId'] }})" class="flex-1 gap-0">
                <row class="items-center gap-1">
                    <text class="text-[14] font-semibold text-white" :maxLines="1">{{ $channel['name'] }}</text>
                    @if ($channel['isVerified'])
                        <icon name="verified" :size="14" color="#AAAAAA" />
                    @endif
                </row>
                <text class="text-[12] text-[#AAAAAA]" :maxLines="1">{{ $subscribersFormatted }} subscribers</text>
            </column>
            <column
                @press="toggleSubscribe"
                class="px-4 py-2 rounded-full {{ $isSubscribed ? 'bg-[#272727]' : 'bg-white' }}"
            >
                <text class="text-[13] font-bold {{ $isSubscribed ? 'text-white' : 'text-black' }}">{{ $isSubscribed ? 'Subscribed' : 'Subscribe' }}</text>
            </column>
        </row>

        <divider class="w-full" color="#272727" />

        {{-- Comments Section --}}
        <row @press="toggleDescription" class="w-full px-3 pt-3 pb-2 items-center justify-between">
            <row class="items-center gap-2">
                <text class="text-[15] font-bold text-white">Comments</text>
                <text class="text-[13] text-[#AAAAAA]">{{ $commentCountFormatted }}</text>
            </row>
        </row>

        {{-- Comment List --}}
        @foreach (array_slice($comments, 0, 4) as $comment)
            <row class="w-full px-3 py-2 gap-3">
                <image
                    src="{{ $comment['avatarUrl'] }}"
                    class="w-[28] h-[28] rounded-full"
                    :fit="2"
                />
                <column class="flex-1 gap-1">
                    <row class="items-center gap-2">
                        <text class="text-[12] text-[#AAAAAA]" :maxLines="1">{{ $comment['username'] }}</text>
                        <text class="text-[11] text-[#717171]">{{ $comment['time'] }}</text>
                    </row>
                    <text class="text-[13] text-white">{{ $comment['text'] }}</text>
                    <row class="items-center gap-3 pt-1">
                        <row class="items-center gap-1">
                            <icon name="thumb_up_off_alt" :size="14" color="#AAAAAA" />
                            <text class="text-[11] text-[#AAAAAA]">{{ \App\NativeComponents\Concerns\HasYouTubeData::formatYtCount($comment['likes']) }}</text>
                        </row>
                        <icon name="thumb_down_off_alt" :size="14" color="#AAAAAA" />
                        <text class="text-[11] text-[#AAAAAA]">{{ $comment['replies'] }} replies</text>
                    </row>
                </column>
            </row>
        @endforeach

        <divider class="w-full mt-2" color="#272727" />

        {{-- Suggested Videos --}}
        <column class="w-full px-3 pt-3 pb-2">
            <text class="text-[15] font-bold text-white">Up next</text>
        </column>

        @foreach ($suggested as $sVideo)
            <row @press="viewVideo({{ $sVideo['index'] }})" class="w-full px-3 py-2 gap-3">
                <stack class="w-[160] h-[90]">
                    <image
                        src="{{ $sVideo['thumbnailUrl'] }}"
                        class="w-[160] h-[90] rounded-lg"
                        :fit="2"
                    />
                    <column class="w-[160] h-[90] items-end justify-end p-1">
                        <column class="bg-[#000000CC] rounded px-1 py-[1]">
                            <text class="text-[10] font-semibold text-white">{{ $sVideo['duration'] }}</text>
                        </column>
                    </column>
                </stack>
                <column class="flex-1 gap-1">
                    <text class="text-[13] font-semibold text-white" :maxLines="2">{{ $sVideo['title'] }}</text>
                    <row class="items-center gap-1">
                        <text class="text-[11] text-[#AAAAAA]" :maxLines="1">{{ $sVideo['channel']['name'] }}</text>
                        @if ($sVideo['channel']['isVerified'])
                            <icon name="verified" :size="10" color="#AAAAAA" />
                        @endif
                    </row>
                    <text class="text-[11] text-[#AAAAAA]" :maxLines="1">{{ $sVideo['viewsFormatted'] }} views · {{ $sVideo['uploadedAt'] }}</text>
                </column>
            </row>
        @endforeach

        <spacer class="h-[20]" />

    </column>
</scroll-view>
