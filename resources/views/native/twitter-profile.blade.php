<native:scroll-view class="w-full h-full bg-white safe-area">
    <native:column class="w-full gap-0">

        {{-- Top Bar --}}
        <native:row class="w-full px-4 py-3 items-center gap-3">
            <native:column @press="back" class="w-[32] h-[32] rounded-full items-center justify-center">
                <native:icon name="arrow_back" :size="22" color="#0F1419" />
            </native:column>
            <native:column>
                <native:text class="text-[18] font-bold text-[#0F1419]">{{ $user['name'] }}</native:text>
                <native:text class="text-[13] text-[#536471]">{{ count($tweetsWithMeta) }} posts</native:text>
            </native:column>
        </native:row>

        {{-- Banner + Avatar Overlap --}}
        <native:stack class="w-full">
            {{-- Banner layer --}}
            <native:column class="w-full">
                <native:image
                    src="{{ $user['bannerUrl'] }}"
                    class="w-full h-[220]"
                    :fit="2"
                />
                <native:spacer class="h-[34]" />
            </native:column>
            {{-- Avatar layer --}}
            <native:column class="w-full">
                <native:spacer class="h-[186]" />
                <native:row class="w-full px-4 items-end justify-between">
                    <native:image
                        src="{{ $user['avatarUrl'] }}"
                        class="w-[68] h-[68] rounded-full"
                        :fit="2"
                    />
                    <native:button label="Follow" color="#0F1419" labelColor="#FFFFFF" :fontSize="14" />
                </native:row>
            </native:column>
        </native:stack>

        {{-- Profile Info --}}
        <native:column class="w-full px-4 pt-3 gap-4">

            {{-- Name --}}
            <native:row class="items-center gap-1">
                <native:text class="text-[20] font-bold text-[#0F1419]">{{ $user['name'] }}</native:text>
                <native:icon name="verified" :size="18" color="#1D9BF0" />
            </native:row>
            <native:text class="text-[15] text-[#536471] mt-[-4]">{{ $user['handle'] }}</native:text>

            {{-- Bio --}}
            <native:text class="text-[15] text-[#0F1419]">{{ $user['bio'] }}</native:text>

            {{-- Following / Followers --}}
            <native:row class="items-center gap-3">
                <native:row class="items-center gap-1">
                    <native:text class="text-[14] font-bold text-[#0F1419]">{{ $followingFormatted }}</native:text>
                    <native:text class="text-[14] text-[#536471]">Following</native:text>
                </native:row>
                <native:row class="items-center gap-1">
                    <native:text class="text-[14] font-bold text-[#0F1419]">{{ $followersFormatted }}</native:text>
                    <native:text class="text-[14] text-[#536471]">Followers</native:text>
                </native:row>
            </native:row>
        </native:column>

        {{-- Tab Row --}}
        <native:tab-row :selectedIndex="$selectedTab" @change="selectTab" class="mt-2">
            <native:tab label="Posts" />
            <native:tab label="Replies" />
            <native:tab label="Likes" />
        </native:tab-row>

        <native:divider class="w-full" />

        {{-- User Tweets --}}
        @foreach ($tweetsWithMeta as $tweet)
            <native:column class="w-full">
                <native:row class="w-full px-4 pt-3 gap-3">
                    {{-- Avatar --}}
                    <native:image
                        src="{{ $tweet['user']['avatarUrl'] }}"
                        class="w-[40] h-[40] rounded-full"
                        :fit="2"
                    />

                    {{-- Tweet Content --}}
                    <native:column @press="viewTweet({{ $tweet['originalIndex'] }})" class="w-[300] gap-1">
                        <native:row class="items-center gap-1">
                            <native:text class="text-sm font-bold ">{{ $tweet['user']['name'] }}</native:text>
                            @if ($tweet['user']['isVerified'])
                                <native:icon name="verified" :size="16" color="#1D9BF0" />
                            @endif
                            <native:text class="text-[13] text-[#536471]">{{ $tweet['user']['handle'] }}</native:text>
                            <native:text class="text-[13] text-[#536471]">· {{ $tweet['time'] }}</native:text>
                        </native:row>

                        <native:text class="text-xl">{{ $tweet['text'] }} asdasdasd</native:text>

                        @if ($tweet['imageUrl'])
                            <native:image
                                src="{{ $tweet['imageUrl'] }}"
                                class="w-full h-[180] rounded-xl mt-2"
                                :fit="2"
                            />
                        @endif

                        {{-- Action Bar --}}
                        <native:row class="w-full items-center justify-between py-2 pr-4">
                            <native:row class="items-center gap-1">
                                <native:icon name="chat_bubble_outline" :size="18" color="#536471" />
                                <native:text class="text-[13] text-[#536471]">{{ $tweet['replyFormatted'] }}</native:text>
                            </native:row>
                            <native:row class="items-center gap-1">
                                <native:icon name="repeat" :size="18" color="#536471" />
                                <native:text class="text-[13] text-[#536471]">{{ $tweet['retweetFormatted'] }}</native:text>
                            </native:row>
                            <native:row class="items-center gap-1">
                                <native:icon name="favorite_border" :size="18" color="#536471" />
                                <native:text class="text-[13] text-[#536471]">{{ $tweet['likeFormatted'] }}</native:text>
                            </native:row>
                            <native:icon name="share" :size="18" color="#536471" />
                        </native:row>
                    </native:column>
                </native:row>
                <native:divider class="w-full" />
            </native:column>
        @endforeach

        {{-- Empty State for Replies/Likes tabs --}}
        @if (count($tweetsWithMeta) === 0)
            <native:column class="w-full items-center py-8">
                <native:text class="text-[15] text-[#536471]">No posts yet</native:text>
            </native:column>
        @endif

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
