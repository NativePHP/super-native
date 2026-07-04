<scroll-view class="w-full h-full bg-theme-surface safe-area">
    <column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <row class="w-full px-4 py-3 items-center gap-3">
            <column @press="back" a11y-label="Back" class="w-[32] h-[32] rounded-full items-center justify-center">
                <icon name="arrow_back" :size="22" color="#0F1419" />
            </column>
            <text class="text-[18] font-bold text-theme-on-surface">Post</text>
        </row>

        <divider class="w-full" />

        {{-- Author Info --}}
        <row class="w-full px-4 pt-3 gap-3 items-center">
            <image
                @press="viewProfile({{ $tweet['userId'] }})"
                src="{{ $tweet['user']['avatarUrl'] }}"
                alt="{{ $tweet['user']['name'] }}'s profile"
                class="w-[44] h-[44] rounded-full"
                :fit="2"
            />
            <column @press="viewProfile({{ $tweet['userId'] }})">
                <row class="items-center gap-1">
                    <text class="text-[16] font-bold text-theme-on-surface">{{ $tweet['user']['name'] }}</text>
                    @if ($tweet['user']['isVerified'])
                        <icon name="verified" :size="16" color="#1D9BF0" />
                    @endif
                </row>
                <text class="text-[14] text-[#536471]">{{ $tweet['user']['handle'] }}</text>
            </column>
        </row>

        {{-- Tweet Text --}}
        <column class="w-full px-4 pt-3">
            <text class="text-[17] text-theme-on-surface">{{ $tweet['text'] }}</text>
        </column>

        {{-- Optional Image --}}
        @if ($tweet['imageUrl'])
            <column class="w-full px-4 pt-3">
                <image
                    src="{{ $tweet['imageUrl'] }}"
                    alt="Photo by {{ $tweet['user']['name'] }}"
                    class="w-full h-[220] rounded-xl"
                    :fit="2"
                />
            </column>
        @endif

        {{-- Timestamp --}}
        <column class="w-full px-4 pt-3 pb-3">
            <text class="text-[14] text-[#536471]">{{ $tweet['time'] }} ago</text>
        </column>

        <divider class="w-full" />

        {{-- Engagement Stats --}}
        <row class="w-full px-4 py-3 gap-4">
            <row class="items-center gap-1">
                <text class="text-[14] font-bold text-theme-on-surface">{{ $retweetFormatted }}</text>
                <text class="text-[14] text-[#536471]">Reposts</text>
            </row>
            <row class="items-center gap-1">
                <text class="text-[14] font-bold text-theme-on-surface">{{ $likeFormatted }}</text>
                <text class="text-[14] text-[#536471]">Likes</text>
            </row>
        </row>

        <divider class="w-full" />

        {{-- Action Bar --}}
        <row class="w-full px-8 py-3 justify-between items-center">
            <icon name="chat_bubble_outline" :size="22" color="#536471" />
            <column @press="toggleRetweet" a11y-label="Repost">
                <icon name="repeat" :size="22" color="{{ $isRetweeted ? '#00BA7C' : '#536471' }}" />
            </column>
            <column @press="toggleLike" a11y-label="Like">
                <icon
                    name="{{ $isLiked ? 'favorite' : 'favorite_border' }}"
                    :size="22"
                    color="{{ $isLiked ? '#F91880' : '#536471' }}"
                />
            </column>
            <icon name="bookmark_border" :size="22" color="#536471" />
            <icon name="share" :size="22" color="#536471" />
        </row>

        <divider class="w-full" />

        {{-- Replies --}}
        @foreach ($replies as $reply)
            <column class="w-full">
                <row class="w-full px-4 pt-3 pb-3 gap-3">
                    {{-- Reply Avatar --}}
                    <image
                        @press="viewProfile({{ $reply['userId'] }})"
                        src="{{ $reply['user']['avatarUrl'] }}"
                        alt="{{ $reply['user']['name'] }}'s profile"
                        class="w-[36] h-[36] rounded-full"
                        :fit="2"
                    />

                    {{-- Reply Content --}}
                    <column class="flex-1 gap-1">
                        <row class="items-center gap-1">
                            <text class="text-[14] font-bold text-theme-on-surface">{{ $reply['user']['name'] }}</text>
                            @if ($reply['user']['isVerified'])
                                <icon name="verified" :size="14" color="#1D9BF0" />
                            @endif
                            <text class="text-[13] text-[#536471]">{{ $reply['user']['handle'] }}</text>
                            <text class="text-[13] text-[#536471]">· {{ $reply['time'] }}</text>
                        </row>

                        <text class="text-[14] text-theme-on-surface">{{ $reply['text'] }}</text>

                        {{-- Reply Actions --}}
                        <row class="items-center gap-4 pt-1">
                            <icon name="chat_bubble_outline" :size="16" color="#536471" />
                            <icon name="repeat" :size="16" color="#536471" />
                            <row class="items-center gap-1">
                                <icon name="favorite_border" :size="16" color="#536471" />
                                <text class="text-[12] text-[#536471]">{{ $reply['likeFormatted'] }}</text>
                            </row>
                            <icon name="share" :size="16" color="#536471" />
                        </row>
                    </column>
                </row>
                <divider class="w-full" />
            </column>
        @endforeach

        <spacer class="h-[20]" />

    </column>
</scroll-view>
