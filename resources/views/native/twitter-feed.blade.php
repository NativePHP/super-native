<stack class="w-full h-full bg-theme-surface safe-area">

    <refreshable @refresh="refresh" class="w-full h-full">
        <column class="w-full gap-0">

            {{-- Top Bar --}}
            <row class="w-full px-4 py-2 items-center justify-between">
                <image
                    src="https://i.pravatar.cc/150?u=currentuser"
                    alt="Your profile"
                    class="w-[32] h-[32] rounded-full"
                    :fit="2"
                />
                <text class="text-[26] font-bold text-theme-on-surface">𝕏</text>
                <column class="w-[32] h-[32] items-center justify-center">
                    <icon name="settings" :size="20" class="text-theme-on-surface" />
                </column>
            </row>

            {{-- Tab Row --}}
            <tab-row :selectedIndex="$selectedTab" @change="selectTab">
                <tab label="For You" />
                <tab label="Following" />
            </tab-row>

            <divider class="w-full" />

            {{-- Tweet Feed --}}
            @foreach ($tweets as $tweet)
                <column class="w-full" :native:key="'tweet-'.$tweet['id']">
                    <row class="w-full px-4 pt-3 gap-3">
                        {{-- Avatar --}}
                        <pressable @tap="viewProfile({{ $tweet['userId'] }})" a11y-label="View {{ $tweet['user']['name'] }}'s profile">
                            <image
                                src="{{ $tweet['user']['avatarUrl'] }}"
                                alt="{{ $tweet['user']['name'] }}'s profile"
                                class="w-[42] h-[42] rounded-full"
                                :fit="2"
                            />
                        </pressable>

                        {{-- Tweet Content --}}
                        <column class="flex-1 gap-1">
                            <pressable @tap="viewTweet({{ $tweet['id'] }})" class="w-full">
                                <column class="w-full gap-1">
                                    {{-- Name Row --}}
                                    <row class="w-full items-center gap-1">
                                        <text class="text-[15] font-bold text-theme-on-surface" :maxLines="1">{{ $tweet['user']['name'] }}</text>
                                        @if ($tweet['user']['isVerified'])
                                            <icon name="verified" :size="16" color="#1D9BF0" />
                                        @endif
                                        <text class="text-[14] text-[#536471] dark:text-[#71767B]" :maxLines="1">{{ $tweet['user']['handle'] }} · {{ $tweet['time'] }}</text>
                                        <spacer />
                                        <icon name="more_horiz" :size="16" class="text-[#536471] dark:text-[#71767B]" />
                                    </row>

                                    {{-- Tweet Text --}}
                                    <text class="text-[15] text-theme-on-surface">{{ $tweet['text'] }}</text>

                                    {{-- Optional Image --}}
                                    @if ($tweet['imageUrl'])
                                        <image
                                            src="{{ $tweet['imageUrl'] }}"
                                            alt="Photo by {{ $tweet['user']['name'] }}"
                                            class="w-full h-[190] rounded-2xl border border-theme-outline mt-2"
                                            :fit="2"
                                        />
                                    @endif
                                </column>
                            </pressable>

                            {{-- Action Bar --}}
                            <row class="w-full items-center justify-between py-2">
                                {{-- Reply --}}
                                <row @tap="viewTweet({{ $tweet['id'] }})" a11y-label="Reply" class="items-center gap-1 flex-shrink-0">
                                    <icon name="chat_bubble_outline" :size="17" class="text-[#536471] dark:text-[#71767B]" />
                                    <text class="text-[13] text-[#536471] dark:text-[#71767B]" :maxLines="1">{{ $tweet['replyFormatted'] }}</text>
                                </row>
                                {{-- Repost --}}
                                <row class="items-center gap-1 flex-shrink-0">
                                    <icon name="repeat" :size="17" class="text-[#536471] dark:text-[#71767B]" />
                                    <text class="text-[13] text-[#536471] dark:text-[#71767B]" :maxLines="1">{{ $tweet['retweetFormatted'] }}</text>
                                </row>
                                {{-- Like --}}
                                <row @tap="toggleLike({{ $tweet['id'] }})" a11y-label="{{ $tweet['isLiked'] ? 'Unlike' : 'Like' }}" class="items-center gap-1 flex-shrink-0">
                                    <icon
                                        name="{{ $tweet['isLiked'] ? 'favorite' : 'favorite_border' }}"
                                        :size="17"
                                        class="{{ $tweet['isLiked'] ? 'text-[#F91880]' : 'text-[#536471] dark:text-[#71767B]' }}"
                                    />
                                    <text class="text-[13] {{ $tweet['isLiked'] ? 'text-[#F91880]' : 'text-[#536471] dark:text-[#71767B]' }}" :maxLines="1">{{ $tweet['likeFormatted'] }}</text>
                                </row>
                                {{-- Views --}}
                                <row class="items-center gap-1 flex-shrink-0">
                                    <icon name="analytics" :size="17" class="text-[#536471] dark:text-[#71767B]" />
                                    <text class="text-[13] text-[#536471] dark:text-[#71767B]" :maxLines="1">{{ $tweet['viewFormatted'] }}</text>
                                </row>
                                {{-- Share --}}
                                <icon name="share" :size="17" class="text-[#536471] dark:text-[#71767B]" />
                            </row>
                        </column>
                    </row>
                    <divider class="w-full" />
                </column>
            @endforeach

            <spacer class="h-[90]" />

        </column>
    </refreshable>

    {{-- Compose FAB — `absolute` insets, not stack anchor/origin props,
         which the current runtime drops (see StackPositioningDemoTest). --}}
    <pressable @tap="composeTweet" a11y-label="Compose post" class="absolute bottom-5 right-5 w-[56] h-[56] rounded-full bg-[#1D9BF0] items-center justify-center shadow">
        <icon name="add" :size="28" color="#FFFFFF" />
    </pressable>

</stack>
