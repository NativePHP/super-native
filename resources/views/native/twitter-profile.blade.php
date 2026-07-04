<scroll-view class="w-full h-full bg-theme-surface safe-area">
    <column class="w-full gap-0">

        {{-- Top Bar --}}
        <row class="w-full px-4 py-3 items-center gap-3">
            <column @press="back" a11y-label="Back" class="w-[32] h-[32] rounded-full items-center justify-center">
                <icon name="arrow_back" :size="22" color="#0F1419" />
            </column>
            <column>
                <text class="text-[18] font-bold text-theme-on-surface">{{ $user['name'] }}</text>
                <text class="text-[13] text-[#536471]">{{ count($tweetsWithMeta) }} posts</text>
            </column>
        </row>

        {{-- Banner + Avatar Overlap --}}
        <stack class="w-full">
            {{-- Banner layer --}}
            <column class="w-full">
                <image
                    src="{{ $user['bannerUrl'] }}"
                    alt="{{ $user['name'] }}'s banner"
                    class="w-full h-[220]"
                    :fit="2"
                />
                <spacer class="h-[34]" />
            </column>
            {{-- Avatar layer --}}
            <column class="w-full">
                <spacer class="h-[186]" />
                <row class="w-full px-4 items-end justify-between">
                    <image
                        src="{{ $user['avatarUrl'] }}"
                        alt="{{ $user['name'] }}"
                        class="w-[68] h-[68] rounded-full"
                        :fit="2"
                    />
                    <button label="Follow" color="#0F1419" labelColor="#FFFFFF" :fontSize="14" />
                </row>
            </column>
        </stack>

        {{-- Profile Info --}}
        <column class="w-full px-4 pt-3 gap-4">

            {{-- Name --}}
            <row class="items-center gap-1">
                <text class="text-[20] font-bold text-theme-on-surface">{{ $user['name'] }}</text>
                <icon name="verified" :size="18" color="#1D9BF0" />
            </row>
            <text class="text-[15] text-[#536471] mt-[-4]">{{ $user['handle'] }}</text>

            {{-- Bio --}}
            <text class="text-[15] text-theme-on-surface">{{ $user['bio'] }}</text>

            {{-- Following / Followers --}}
            <row class="items-center gap-3">
                <row class="items-center gap-1">
                    <text class="text-[14] font-bold text-theme-on-surface">{{ $followingFormatted }}</text>
                    <text class="text-[14] text-[#536471]">Following</text>
                </row>
                <row class="items-center gap-1">
                    <text class="text-[14] font-bold text-theme-on-surface">{{ $followersFormatted }}</text>
                    <text class="text-[14] text-[#536471]">Followers</text>
                </row>
            </row>
        </column>

        {{-- Tab Row --}}
        <tab-row :selectedIndex="$selectedTab" @change="selectTab" class="mt-2">
            <tab label="Posts" />
            <tab label="Replies" />
            <tab label="Likes" />
        </tab-row>

        <divider class="w-full" />

        {{-- User Tweets --}}
        @foreach ($tweetsWithMeta as $tweet)
            <column class="w-full">
                <row class="w-full px-4 pt-3 gap-3">
                    {{-- Avatar --}}
                    <image
                        src="{{ $tweet['user']['avatarUrl'] }}"
                        alt="{{ $tweet['user']['name'] }}"
                        class="w-[40] h-[40] rounded-full"
                        :fit="2"
                    />

                    {{-- Tweet Content --}}
                    <column @press="viewTweet({{ $tweet['originalIndex'] }})" class="flex-1 gap-1">
                        <row class="items-center gap-1">
                            <text class="text-sm font-bold ">{{ $tweet['user']['name'] }}</text>
                            @if ($tweet['user']['isVerified'])
                                <icon name="verified" :size="16" color="#1D9BF0" />
                            @endif
                            <text class="text-[13] text-[#536471]">{{ $tweet['user']['handle'] }}</text>
                            <text class="text-[13] text-[#536471]">· {{ $tweet['time'] }}</text>
                        </row>

                        <text class="text-sm text-theme-on-surface">{{ $tweet['text'] }}</text>

                        @if ($tweet['imageUrl'])
                            <image
                                src="{{ $tweet['imageUrl'] }}"
                                alt="Photo by {{ $tweet['user']['name'] }}"
                                class="w-full h-[180] rounded-xl mt-2"
                                :fit="2"
                            />
                        @endif

                        {{-- Action Bar --}}
                        <row class="w-full items-center justify-between py-2 pr-4">
                            <row class="items-center gap-1">
                                <icon name="chat_bubble_outline" :size="18" color="#536471" />
                                <text class="text-[13] text-[#536471]">{{ $tweet['replyFormatted'] }}</text>
                            </row>
                            <row class="items-center gap-1">
                                <icon name="repeat" :size="18" color="#536471" />
                                <text class="text-[13] text-[#536471]">{{ $tweet['retweetFormatted'] }}</text>
                            </row>
                            <row class="items-center gap-1">
                                <icon name="favorite_border" :size="18" color="#536471" />
                                <text class="text-[13] text-[#536471]">{{ $tweet['likeFormatted'] }}</text>
                            </row>
                            <icon name="share" :size="18" color="#536471" />
                        </row>
                    </column>
                </row>
                <divider class="w-full" />
            </column>
        @endforeach

        {{-- Empty State for Replies/Likes tabs --}}
        @if (count($tweetsWithMeta) === 0)
            <column class="w-full items-center py-8">
                <text class="text-[15] text-[#536471]">No posts yet</text>
            </column>
        @endif

        <spacer class="h-[20]" />

    </column>
</scroll-view>
