{{--@include('native.partials.demo-nav', ['title' => 'Twitter / X'])--}}

<native:scroll-view >
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full px-4 py-3 items-center justify-between">
            <native:image
                src="https://i.pravatar.cc/150?u=currentuser"
                class="w-[32] h-[32] rounded-full"
                :fit="2"
            />
            <native:text class="text-[30] font-bold text-theme-on-surface">𝕏</native:text>
            <native:column @press="composeTweet" class="w-[32] h-[32] rounded-full items-center justify-center">
                <native:icon name="edit" :size="18" color="#FFFFFF" />
            </native:column>
        </native:row>

        {{-- Tab Row --}}
        <native:tab-row :selectedIndex="$selectedTab" @change="selectTab">
            <native:tab label="For You" />
            <native:tab label="Following" />
        </native:tab-row>

        <native:divider class="w-full" />

        {{-- Tweet Feed --}}
        @foreach ($tweets as $index => $tweet)
            <native:column class="w-full">
                <native:row class="w-full px-4 pt-3 gap-3">
                    {{-- Avatar --}}
                    <native:image
                        @press="viewProfile({{ $tweet['userId'] }})"
                        src="{{ $tweet['user']['avatarUrl'] }}"
                        class="w-[40] h-[40] rounded-full"
                        :fit="2"
                    />

                    {{-- Tweet Content --}}
                    <native:column @press="viewTweet({{ $index }})" class="flex-1 gap-1">
                        {{-- Name Row --}}
                        <native:row class="items-center gap-1">
                            <native:text class="text-[15] font-bold text-theme-on-surface">{{ $tweet['user']['name'] }}</native:text>
                            @if ($tweet['user']['isVerified'])
                                <native:icon name="verified" :size="16" color="#1D9BF0" />
                            @endif
                            <native:text class="text-[13] text-[#536471]">{{ $tweet['user']['handle'] }}</native:text>
                            <native:text class="text-[13] text-[#536471]">· {{ $tweet['time'] }}</native:text>
                        </native:row>

                        {{-- Tweet Text --}}
                        <native:text class="text-sm text-theme-on-surface">{{ $tweet['text'] }}</native:text>

                        {{-- Optional Image --}}
                        @if ($tweet['imageUrl'])
                            <native:image
                                src="{{ $tweet['imageUrl'] }}"
                                class="w-full h-[180] rounded-xl mt-2"
                                :fit="2"
                            />
                        @endif

                        {{-- Action Bar --}}
                        <native:row class="w-full items-center justify-between py-2 pr-4">
                            {{-- Reply --}}
                            <native:row class="items-center gap-1">
                                <native:icon name="chat_bubble_outline" :size="18" color="#536471" />
                                <native:text class="text-[13] text-[#536471]">{{ $tweet['replyFormatted'] }}</native:text>
                            </native:row>
                            {{-- Retweet --}}
                            <native:row class="items-center gap-1">
                                <native:icon name="repeat" :size="18" color="#536471" />
                                <native:text class="text-[13] text-[#536471]">{{ $tweet['retweetFormatted'] }}</native:text>
                            </native:row>
                            {{-- Like --}}
                            <native:row @press="toggleLike({{ $index }})" class="items-center gap-1">
                                <native:icon
                                    name="{{ $tweet['isLiked'] ? 'favorite' : 'favorite_border' }}"
                                    :size="18"
                                    color="{{ $tweet['isLiked'] ? '#F91880' : '#536471' }}"
                                />
                                <native:text class="text-[13] {{ $tweet['isLiked'] ? 'text-[#F91880]' : 'text-[#536471]' }}">{{ $tweet['likeFormatted'] }}</native:text>
                            </native:row>
                            {{-- Share --}}
                            <native:icon name="share" :size="18" color="#536471" />
                        </native:row>
                    </native:column>
                </native:row>
                <native:divider class="w-full" />
            </native:column>
        @endforeach

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
