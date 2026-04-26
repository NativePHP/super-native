<native:scroll-view class="w-full h-full bg-theme-surface safe-area">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full px-4 py-3 items-center gap-3">
            <native:column @press="back" class="w-[32] h-[32] rounded-full items-center justify-center">
                <native:icon name="arrow_back" :size="22" color="#0F1419" />
            </native:column>
            <native:text class="text-[18] font-bold text-theme-on-surface">Post</native:text>
        </native:row>

        <native:divider class="w-full" />

        {{-- Author Info --}}
        <native:row class="w-full px-4 pt-3 gap-3 items-center">
            <native:image
                @press="viewProfile({{ $tweet['userId'] }})"
                src="{{ $tweet['user']['avatarUrl'] }}"
                class="w-[44] h-[44] rounded-full"
                :fit="2"
            />
            <native:column @press="viewProfile({{ $tweet['userId'] }})">
                <native:row class="items-center gap-1">
                    <native:text class="text-[16] font-bold text-theme-on-surface">{{ $tweet['user']['name'] }}</native:text>
                    @if ($tweet['user']['isVerified'])
                        <native:icon name="verified" :size="16" color="#1D9BF0" />
                    @endif
                </native:row>
                <native:text class="text-[14] text-[#536471]">{{ $tweet['user']['handle'] }}</native:text>
            </native:column>
        </native:row>

        {{-- Tweet Text --}}
        <native:column class="w-full px-4 pt-3">
            <native:text class="text-[17] text-theme-on-surface">{{ $tweet['text'] }}</native:text>
        </native:column>

        {{-- Optional Image --}}
        @if ($tweet['imageUrl'])
            <native:column class="w-full px-4 pt-3">
                <native:image
                    src="{{ $tweet['imageUrl'] }}"
                    class="w-full h-[220] rounded-xl"
                    :fit="2"
                />
            </native:column>
        @endif

        {{-- Timestamp --}}
        <native:column class="w-full px-4 pt-3 pb-3">
            <native:text class="text-[14] text-[#536471]">{{ $tweet['time'] }} ago</native:text>
        </native:column>

        <native:divider class="w-full" />

        {{-- Engagement Stats --}}
        <native:row class="w-full px-4 py-3 gap-4">
            <native:row class="items-center gap-1">
                <native:text class="text-[14] font-bold text-theme-on-surface">{{ $retweetFormatted }}</native:text>
                <native:text class="text-[14] text-[#536471]">Reposts</native:text>
            </native:row>
            <native:row class="items-center gap-1">
                <native:text class="text-[14] font-bold text-theme-on-surface">{{ $likeFormatted }}</native:text>
                <native:text class="text-[14] text-[#536471]">Likes</native:text>
            </native:row>
        </native:row>

        <native:divider class="w-full" />

        {{-- Action Bar --}}
        <native:row class="w-full px-8 py-3 justify-between items-center">
            <native:icon name="chat_bubble_outline" :size="22" color="#536471" />
            <native:column @press="toggleRetweet">
                <native:icon name="repeat" :size="22" color="{{ $isRetweeted ? '#00BA7C' : '#536471' }}" />
            </native:column>
            <native:column @press="toggleLike">
                <native:icon
                    name="{{ $isLiked ? 'favorite' : 'favorite_border' }}"
                    :size="22"
                    color="{{ $isLiked ? '#F91880' : '#536471' }}"
                />
            </native:column>
            <native:icon name="bookmark_border" :size="22" color="#536471" />
            <native:icon name="share" :size="22" color="#536471" />
        </native:row>

        <native:divider class="w-full" />

        {{-- Replies --}}
        @foreach ($replies as $reply)
            <native:column class="w-full">
                <native:row class="w-full px-4 pt-3 pb-3 gap-3">
                    {{-- Reply Avatar --}}
                    <native:image
                        @press="viewProfile({{ $reply['userId'] }})"
                        src="{{ $reply['user']['avatarUrl'] }}"
                        class="w-[36] h-[36] rounded-full"
                        :fit="2"
                    />

                    {{-- Reply Content --}}
                    <native:column class="flex-1 gap-1">
                        <native:row class="items-center gap-1">
                            <native:text class="text-[14] font-bold text-theme-on-surface">{{ $reply['user']['name'] }}</native:text>
                            @if ($reply['user']['isVerified'])
                                <native:icon name="verified" :size="14" color="#1D9BF0" />
                            @endif
                            <native:text class="text-[13] text-[#536471]">{{ $reply['user']['handle'] }}</native:text>
                            <native:text class="text-[13] text-[#536471]">· {{ $reply['time'] }}</native:text>
                        </native:row>

                        <native:text class="text-[14] text-theme-on-surface">{{ $reply['text'] }}</native:text>

                        {{-- Reply Actions --}}
                        <native:row class="items-center gap-4 pt-1">
                            <native:icon name="chat_bubble_outline" :size="16" color="#536471" />
                            <native:icon name="repeat" :size="16" color="#536471" />
                            <native:row class="items-center gap-1">
                                <native:icon name="favorite_border" :size="16" color="#536471" />
                                <native:text class="text-[12] text-[#536471]">{{ $reply['likeFormatted'] }}</native:text>
                            </native:row>
                            <native:icon name="share" :size="16" color="#536471" />
                        </native:row>
                    </native:column>
                </native:row>
                <native:divider class="w-full" />
            </native:column>
        @endforeach

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
