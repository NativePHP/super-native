<scroll-view class="w-full h-full bg-[#0F0F0F] safe-area">
    <column class="w-full gap-0">

        {{-- Video Player Area — overlay icons sit on stronger dark
             scrims so they don't fight with the thumbnail behind them.
             Z-order matters: interactive children must render LAST so
             their hit area isn't covered by a non-interactive sibling.
             Corner overlays use `absolute` with NON-ZERO insets only —
             both stack renderers read a zero bottom/right inset as
             "unset" and pin to the top/left. --}}
        <stack class="w-full h-[220] bg-black">
            <image
                src="{{ $video['thumbnailUrl'] }}"
                alt="{{ $video['title'] }}"
                class="w-full h-[220]"
                :fit="2"
            />
            {{-- Centered Play Button --}}
            <column class="w-full h-[220] items-center justify-center">
                <column class="w-[64] h-[64] rounded-full bg-[#000000CC] items-center justify-center">
                    <icon name="play_arrow" :size="40" color="#FFFFFF" />
                </column>
            </column>
            {{-- Red progress bar hugging the player's bottom edge --}}
            <column class="w-full h-[220] justify-end">
                <row class="w-full h-[3]">
                    <column class="w-2/5 h-[3] bg-[#FF0000]" />
                    <column class="flex-1 h-[3] bg-[#FFFFFF4D]" />
                </row>
            </column>
            {{-- Duration --}}
            <column class="absolute bottom-3 right-2 bg-[#000000CC] rounded-md px-[6] py-[2]">
                <text class="text-[12] font-semibold text-white">{{ $video['duration'] }}</text>
            </column>
            {{-- Top controls (back / settings) — declared LAST so they
                 sit above the other overlay layers and receive taps. --}}
            <row class="w-full px-3 pt-3 items-center justify-between">
                <column @tap="back" a11y-label="Back" class="w-[36] h-[36] rounded-full bg-[#000000AA] items-center justify-center">
                    <icon name="arrow_back" :size="20" color="#FFFFFF" />
                </column>
                <column class="w-[36] h-[36] rounded-full bg-[#000000AA] items-center justify-center">
                    <icon name="settings" :size="18" color="#FFFFFF" />
                </column>
            </row>
        </stack>

        {{-- Title & meta — tap to expand the description, like the app's
             "...more" affordance. --}}
        <pressable @tap="toggleDescription" class="w-full">
            <column class="w-full px-3 pt-3 gap-1">
                <text class="text-[17] font-bold text-white" :maxLines="$showDescription ? 10 : 2">{{ $video['title'] }}</text>
                <row class="items-center gap-1">
                    <text class="text-[12] text-[#AAAAAA]">{{ $viewsFormatted }} views · {{ $video['uploadedAt'] }}</text>
                    <text class="text-[12] font-semibold text-white">{{ $showDescription ? 'Show less' : '...more' }}</text>
                </row>
            </column>
        </pressable>

        {{-- Expandable Description --}}
        @if ($showDescription)
            <column class="w-full px-3 pt-2 pb-1">
                <text class="text-[13] text-[#CCCCCC]">{{ $video['description'] }}</text>
            </column>
        @endif

        {{-- Channel Row --}}
        <row class="w-full px-3 py-3 items-center gap-3">
            <pressable @tap="viewChannel({{ $video['channelId'] }})" a11y-label="{{ $channel['name'] }}'s channel">
                <image
                    src="{{ $channel['avatarUrl'] }}"
                    alt="{{ $channel['name'] }}'s channel"
                    class="w-[36] h-[36] rounded-full"
                    :fit="2"
                />
            </pressable>
            <pressable @tap="viewChannel({{ $video['channelId'] }})" class="flex-1">
                <row class="items-center gap-2">
                    <text class="text-[14] font-semibold text-white" :maxLines="1">{{ $channel['name'] }}</text>
                    @if ($channel['isVerified'])
                        <icon name="verified" :size="13" color="#AAAAAA" />
                    @endif
                    <text class="text-[12] text-[#AAAAAA]">{{ $subscribersFormatted }}</text>
                </row>
            </pressable>
            <pressable
                @tap="toggleSubscribe"
                a11y-label="{{ $isSubscribed ? 'Unsubscribe' : 'Subscribe' }}"
                class="px-4 py-2 rounded-full {{ $isSubscribed ? 'bg-[#272727]' : 'bg-white' }}"
            >
                <row class="items-center gap-1">
                    @if ($isSubscribed)
                        <icon name="notifications" :size="16" color="#FFFFFF" />
                    @endif
                    <text class="text-[13] font-bold {{ $isSubscribed ? 'text-white' : 'text-black' }}">{{ $isSubscribed ? 'Subscribed' : 'Subscribe' }}</text>
                </row>
            </pressable>
        </row>

        {{-- Action Chips --}}
        <scroll-view horizontal>
            <row class="px-3 pb-3 gap-2">
                {{-- Like / Dislike segmented pill --}}
                <row class="bg-[#272727] rounded-full items-center">
                    <pressable @tap="toggleLike" a11y-label="Like" class="pl-4 pr-3 py-2">
                        <row class="items-center gap-2">
                            <icon
                                name="{{ $isLiked ? 'thumb_up' : 'thumb_up_off_alt' }}"
                                :size="20"
                                color="#FFFFFF"
                            />
                            <text class="text-[13] font-semibold text-white">{{ $likesFormatted }}</text>
                        </row>
                    </pressable>
                    <column class="w-[1] h-[24] bg-[#5A5A5A]" />
                    <pressable @tap="toggleDislike" a11y-label="Dislike" class="pl-3 pr-4 py-2">
                        <icon
                            name="{{ $isDisliked ? 'thumb_down' : 'thumb_down_off_alt' }}"
                            :size="20"
                            color="#FFFFFF"
                        />
                    </pressable>
                </row>

                <row class="bg-[#272727] rounded-full px-4 py-2 items-center gap-2">
                    <icon name="share" :size="18" color="#FFFFFF" />
                    <text class="text-[13] font-semibold text-white">Share</text>
                </row>

                <row class="bg-[#272727] rounded-full px-4 py-2 items-center gap-2">
                    <icon name="bolt" :size="18" color="#FFFFFF" />
                    <text class="text-[13] font-semibold text-white">Remix</text>
                </row>

                <row class="bg-[#272727] rounded-full px-4 py-2 items-center gap-2">
                    <icon name="download" :size="18" color="#FFFFFF" />
                    <text class="text-[13] font-semibold text-white">Download</text>
                </row>

                <row class="bg-[#272727] rounded-full px-4 py-2 items-center gap-2">
                    <icon name="playlist_add" :size="18" color="#FFFFFF" />
                    <text class="text-[13] font-semibold text-white">Save</text>
                </row>
            </row>
        </scroll-view>

        {{-- Comments preview card — tap to expand inline (the app opens
             a bottom sheet; same idea, kept inline for the demo). --}}
        <pressable @tap="toggleComments" a11y-label="{{ $showComments ? 'Collapse comments' : 'Expand comments' }}" class="w-full px-3 pb-3">
            <column class="w-full bg-[#272727] rounded-xl px-3 py-3 gap-2">
                <row class="items-center gap-2">
                    <text class="text-[14] font-bold text-white">Comments</text>
                    <text class="text-[12] text-[#AAAAAA]">{{ $commentCountFormatted }}</text>
                    <spacer />
                    <icon name="{{ $showComments ? 'expand_less' : 'expand_more' }}" :size="16" color="#AAAAAA" />
                </row>
                @if (! $showComments && count($comments) > 0)
                    <row class="w-full items-center gap-2">
                        <image
                            src="{{ $comments[0]['avatarUrl'] }}"
                            alt="{{ $comments[0]['username'] }}"
                            class="w-[24] h-[24] rounded-full"
                            :fit="2"
                        />
                        <text class="text-[12] text-[#DDDDDD] flex-1" :maxLines="2">{{ $comments[0]['text'] }}</text>
                    </row>
                @endif
            </column>
        </pressable>

        {{-- Expanded comment list --}}
        @if ($showComments)
            @foreach ($comments as $comment)
                <row class="w-full px-3 py-2 gap-3">
                    <image
                        src="{{ $comment['avatarUrl'] }}"
                        alt="{{ $comment['username'] }}"
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
        @endif

        <divider class="w-full" color="#272727" />

        {{-- Up next — feed-style cards like the app's related list --}}
        <column class="w-full px-3 pt-3 pb-1">
            <text class="text-[15] font-bold text-white">Up next</text>
        </column>

        @foreach ($suggested as $sVideo)
            <column class="w-full pb-4">
                <pressable @tap="viewVideo({{ $sVideo['index'] }})" class="w-full px-2">
                    <stack class="w-full h-[200]">
                        <image
                            src="{{ $sVideo['thumbnailUrl'] }}"
                            alt="{{ $sVideo['title'] }}"
                            class="w-full h-[200] rounded-xl"
                            :fit="2"
                        />
                        <column class="absolute bottom-2 right-3 bg-[#000000CC] rounded-md px-[6] py-[2]">
                            <text class="text-[11] font-semibold text-white">{{ $sVideo['duration'] }}</text>
                        </column>
                    </stack>
                </pressable>
                <pressable @tap="viewVideo({{ $sVideo['index'] }})" class="w-full">
                    <row class="w-full px-3 pt-2 gap-3">
                        <image
                            src="{{ $sVideo['channel']['avatarUrl'] }}"
                            alt="{{ $sVideo['channel']['name'] }}'s channel"
                            class="w-[36] h-[36] rounded-full"
                            :fit="2"
                        />
                        <column class="flex-1 gap-1">
                            <text class="text-[14] font-semibold text-white" :maxLines="2">{{ $sVideo['title'] }}</text>
                            <text class="text-[12] text-[#AAAAAA]" :maxLines="1">{{ $sVideo['channel']['name'] }} · {{ $sVideo['viewsFormatted'] }} views · {{ $sVideo['uploadedAt'] }}</text>
                        </column>
                        <icon name="more_vert" :size="18" color="#AAAAAA" />
                    </row>
                </pressable>
            </column>
        @endforeach

        <spacer class="h-[20] flex-grow-0" />

    </column>
</scroll-view>
