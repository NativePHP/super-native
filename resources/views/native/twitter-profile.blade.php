<scroll-view class="w-full h-full bg-theme-surface safe-area">
    <column class="w-full gap-0">

        {{-- Banner + floating back button + overlapping avatar.
             `absolute` insets, not stack anchor/origin props, which the
             current runtime drops (see StackPositioningDemoTest). Both
             stack renderers only anchor to the bottom/right edges when
             that inset is NON-ZERO (`bottom-0` reads as "unset" and pins
             to the top), and zero opposing insets don't stretch — so
             layers anchor from the top with computed offsets and size
             themselves explicitly. --}}
        <stack class="w-full">
            {{-- Banner layer — sizes the stack: 150 banner + 44 breathing room --}}
            <column class="w-full">
                <image
                    src="{{ $user['bannerUrl'] }}"
                    alt="{{ $user['name'] }}'s banner"
                    class="w-full h-[150]"
                    :fit="2"
                />
                {{-- flex-grow-0: spacer defaults to flex_grow=1, and the
                     flex measurer sizes ANY grow child at 0 under the
                     indefinite proposal a stack measures its layers with —
                     the fixed height only sticks on a non-grow child. --}}
                <spacer class="h-[44] flex-grow-0" />
            </column>

            {{-- Avatar + follow row: 82 tall (74 avatar + 4 ring pad each
                 side), top inset 112 = 194 stack − 82 row → flush with the
                 stack bottom. --}}
            <row class="absolute top-[112] w-full px-4 items-end justify-between">
                <column class="p-[4] bg-theme-surface rounded-full">
                    <image
                        src="{{ $user['avatarUrl'] }}"
                        alt="{{ $user['name'] }}"
                        class="w-[74] h-[74] rounded-full"
                        :fit="2"
                    />
                </column>
                <pressable @tap="toggleFollow" a11y-label="{{ $isFollowing ? 'Unfollow' : 'Follow' }}" class="px-5 py-2 rounded-full {{ $isFollowing ? 'bg-theme-surface border border-theme-outline' : 'bg-theme-on-surface' }}">
                    <text class="text-[14] font-bold {{ $isFollowing ? 'text-theme-on-surface' : 'text-theme-surface' }}">{{ $isFollowing ? 'Following' : 'Follow' }}</text>
                </pressable>
            </row>

            {{-- Floating back button — LAST stack child so it draws (and
                 hit-tests) above the banner and avatar layers. --}}
            <pressable @tap="back" a11y-label="Back" class="absolute top-3 left-3 w-[34] h-[34] rounded-full bg-black/50 items-center justify-center">
                <icon name="arrow_back" :size="20" color="#FFFFFF" />
            </pressable>
        </stack>

        {{-- Profile Info --}}
        <column class="w-full px-4 pt-3 gap-1">
            <row class="items-center gap-1">
                <text class="text-[20] font-bold text-theme-on-surface">{{ $user['name'] }}</text>
                @if ($user['isVerified'])
                    <icon name="verified" :size="18" color="#1D9BF0" />
                @endif
            </row>
            <text class="text-[15] text-[#536471] dark:text-[#71767B]">{{ $user['handle'] }}</text>

            <text class="text-[15] text-theme-on-surface pt-2">{{ $user['bio'] }}</text>

            {{-- Meta row --}}
            <row class="items-center gap-4 pt-2">
                <row class="items-center gap-1">
                    <icon name="globe" :size="15" class="text-[#536471] dark:text-[#71767B]" />
                    <text class="text-[14] text-[#1D9BF0]">{{ strtolower(str_replace(['@', ' '], '', $user['handle'])) }}.dev</text>
                </row>
                <row class="items-center gap-1">
                    <icon name="calendar" :size="15" class="text-[#536471] dark:text-[#71767B]" />
                    <text class="text-[14] text-[#536471] dark:text-[#71767B]">Joined March 2019</text>
                </row>
            </row>

            {{-- Following / Followers --}}
            <row class="items-center gap-4 pt-2 pb-1">
                <row class="items-center gap-1">
                    <text class="text-[14] font-bold text-theme-on-surface">{{ $followingFormatted }}</text>
                    <text class="text-[14] text-[#536471] dark:text-[#71767B]">Following</text>
                </row>
                <row class="items-center gap-1">
                    <text class="text-[14] font-bold text-theme-on-surface">{{ $followersFormatted }}</text>
                    <text class="text-[14] text-[#536471] dark:text-[#71767B]">Followers</text>
                </row>
            </row>
        </column>

        {{-- Tab Row --}}
        <tab-row :selectedIndex="$selectedTab" @change="selectTab" class="mt-2">
            <tab label="Posts" />
            <tab label="Replies" />
            <tab label="Media" />
            <tab label="Likes" />
        </tab-row>

        <divider class="w-full" />

        @if ($selectedTab === 0)
            {{-- User Tweets --}}
            @foreach ($tweetsWithMeta as $tweet)
                <column class="w-full">
                    <row class="w-full px-4 pt-3 gap-3">
                        <image
                            src="{{ $tweet['user']['avatarUrl'] }}"
                            alt="{{ $tweet['user']['name'] }}"
                            class="w-[42] h-[42] rounded-full"
                            :fit="2"
                        />

                        <column class="flex-1 gap-1">
                            <pressable @tap="viewTweet({{ $tweet['originalIndex'] }})" class="w-full">
                                <column class="w-full gap-1">
                                    <row class="items-center gap-1">
                                        <text class="text-[15] font-bold text-theme-on-surface">{{ $tweet['user']['name'] }}</text>
                                        @if ($tweet['user']['isVerified'])
                                            <icon name="verified" :size="16" color="#1D9BF0" />
                                        @endif
                                        <text class="text-[14] text-[#536471] dark:text-[#71767B]">{{ $tweet['user']['handle'] }} · {{ $tweet['time'] }}</text>
                                    </row>

                                    <text class="text-[15] text-theme-on-surface">{{ $tweet['text'] }}</text>

                                    @if ($tweet['imageUrl'])
                                        <image
                                            src="{{ $tweet['imageUrl'] }}"
                                            alt="Photo by {{ $tweet['user']['name'] }}"
                                            class="w-full h-[180] rounded-2xl border border-theme-outline mt-2"
                                            :fit="2"
                                        />
                                    @endif
                                </column>
                            </pressable>

                            {{-- Action Bar --}}
                            <row class="w-full items-center justify-between py-2 pr-4">
                                <row class="items-center gap-1">
                                    <icon name="chat_bubble_outline" :size="17" class="text-[#536471] dark:text-[#71767B]" />
                                    <text class="text-[13] text-[#536471] dark:text-[#71767B]">{{ $tweet['replyFormatted'] }}</text>
                                </row>
                                <row class="items-center gap-1">
                                    <icon name="repeat" :size="17" class="text-[#536471] dark:text-[#71767B]" />
                                    <text class="text-[13] text-[#536471] dark:text-[#71767B]">{{ $tweet['retweetFormatted'] }}</text>
                                </row>
                                <row class="items-center gap-1">
                                    <icon name="favorite_border" :size="17" class="text-[#536471] dark:text-[#71767B]" />
                                    <text class="text-[13] text-[#536471] dark:text-[#71767B]">{{ $tweet['likeFormatted'] }}</text>
                                </row>
                                <icon name="share" :size="17" class="text-[#536471] dark:text-[#71767B]" />
                            </row>
                        </column>
                    </row>
                    <divider class="w-full" />
                </column>
            @endforeach

            @if (count($tweetsWithMeta) === 0)
                <column class="w-full items-center py-10 px-8 gap-1">
                    <text class="text-[17] font-bold text-theme-on-surface">No posts yet</text>
                    <text class="text-[14] text-[#536471] dark:text-[#71767B] text-center">When they post, their posts will show up here.</text>
                </column>
            @endif
        @else
            {{-- Placeholder for Replies / Media / Likes --}}
            <column class="w-full items-center py-12 px-10 gap-1">
                <text class="text-[20] font-bold text-theme-on-surface">Nothing to see here — yet</text>
                <text class="text-[14] text-[#536471] dark:text-[#71767B] text-center">This is a demo, so only the Posts tab has content.</text>
            </column>
        @endif

        <spacer class="h-[20]" />

    </column>
</scroll-view>
