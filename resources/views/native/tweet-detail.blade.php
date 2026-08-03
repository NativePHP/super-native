<column class="w-full h-full bg-theme-surface safe-area">

    {{-- Top Bar --}}
    <row class="w-full px-4 py-3 items-center gap-4">
        <pressable @tap="back" a11y-label="Back" class="w-[32] h-[32] rounded-full items-center justify-center">
            <icon name="arrow_back" :size="22" class="text-theme-on-surface" />
        </pressable>
        <text class="text-[19] font-bold text-theme-on-surface">Post</text>
    </row>

    <divider class="w-full" />

    <scroll-view class="w-full flex-1">
        <column class="w-full gap-0">

            {{-- Author Info --}}
            <row class="w-full px-4 pt-3 gap-3 items-center">
                <pressable @tap="viewProfile({{ $tweet['userId'] }})" a11y-label="View {{ $tweet['user']['name'] }}'s profile">
                    <image
                        src="{{ $tweet['user']['avatarUrl'] }}"
                        alt="{{ $tweet['user']['name'] }}'s profile"
                        class="w-[44] h-[44] rounded-full"
                        :fit="2"
                    />
                </pressable>
                <pressable @tap="viewProfile({{ $tweet['userId'] }})" class="flex-1">
                    <column>
                        <row class="items-center gap-1">
                            <text class="text-[16] font-bold text-theme-on-surface">{{ $tweet['user']['name'] }}</text>
                            @if ($tweet['user']['isVerified'])
                                <icon name="verified" :size="16" color="#1D9BF0" />
                            @endif
                        </row>
                        <text class="text-[14] text-[#536471] dark:text-[#71767B]">{{ $tweet['user']['handle'] }}</text>
                    </column>
                </pressable>
                <icon name="more_horiz" :size="20" class="text-[#536471] dark:text-[#71767B]" />
            </row>

            {{-- Tweet Text --}}
            <column class="w-full px-4 pt-3">
                <text class="text-[18] text-theme-on-surface">{{ $tweet['text'] }}</text>
            </column>

            {{-- Optional Image --}}
            @if ($tweet['imageUrl'])
                <column class="w-full px-4 pt-3">
                    <image
                        src="{{ $tweet['imageUrl'] }}"
                        alt="Photo by {{ $tweet['user']['name'] }}"
                        class="w-full h-[220] rounded-2xl border border-theme-outline"
                        :fit="2"
                    />
                </column>
            @endif

            {{-- Timestamp + Views --}}
            <row class="w-full px-4 pt-3 pb-3 items-center gap-1">
                <text class="text-[14] text-[#536471] dark:text-[#71767B]">{{ $tweet['time'] }} ago</text>
                <text class="text-[14] text-[#536471] dark:text-[#71767B]">·</text>
                <text class="text-[14] font-bold text-theme-on-surface">{{ $viewFormatted }}</text>
                <text class="text-[14] text-[#536471] dark:text-[#71767B]">Views</text>
            </row>

            <divider class="w-full" />

            {{-- Engagement Stats --}}
            <row class="w-full px-4 py-3 gap-4">
                <row class="items-center gap-1">
                    <text class="text-[14] font-bold text-theme-on-surface">{{ $retweetFormatted }}</text>
                    <text class="text-[14] text-[#536471] dark:text-[#71767B]">Reposts</text>
                </row>
                <row class="items-center gap-1">
                    <text class="text-[14] font-bold text-theme-on-surface">{{ $likeFormatted }}</text>
                    <text class="text-[14] text-[#536471] dark:text-[#71767B]">Likes</text>
                </row>
                <row class="items-center gap-1">
                    <text class="text-[14] font-bold text-theme-on-surface">{{ $bookmarkFormatted }}</text>
                    <text class="text-[14] text-[#536471] dark:text-[#71767B]">Bookmarks</text>
                </row>
            </row>

            <divider class="w-full" />

            {{-- Action Bar --}}
            <row class="w-full px-8 py-3 justify-between items-center">
                <icon name="chat_bubble_outline" :size="22" class="text-[#536471] dark:text-[#71767B]" />
                <pressable @tap="toggleRetweet" a11y-label="Repost">
                    <icon name="repeat" :size="22" class="{{ $isRetweeted ? 'text-[#00BA7C]' : 'text-[#536471] dark:text-[#71767B]' }}" />
                </pressable>
                <pressable @tap="toggleLike" a11y-label="Like">
                    <icon
                        name="{{ $isLiked ? 'favorite' : 'favorite_border' }}"
                        :size="22"
                        class="{{ $isLiked ? 'text-[#F91880]' : 'text-[#536471] dark:text-[#71767B]' }}"
                    />
                </pressable>
                <pressable @tap="toggleBookmark" a11y-label="Bookmark">
                    <icon
                        name="{{ $isBookmarked ? 'bookmark' : 'bookmark_border' }}"
                        :size="22"
                        class="{{ $isBookmarked ? 'text-[#1D9BF0]' : 'text-[#536471] dark:text-[#71767B]' }}"
                    />
                </pressable>
                <icon name="ios_share" :size="22" class="text-[#536471] dark:text-[#71767B]" />
            </row>

            <divider class="w-full" />

            {{-- Replies --}}
            @foreach ($replies as $reply)
                <column class="w-full">
                    <row class="w-full px-4 pt-3 pb-3 gap-3">
                        <pressable @tap="viewProfile({{ $reply['userId'] }})" a11y-label="View {{ $reply['user']['name'] }}'s profile">
                            <image
                                src="{{ $reply['user']['avatarUrl'] }}"
                                alt="{{ $reply['user']['name'] }}'s profile"
                                class="w-[38] h-[38] rounded-full"
                                :fit="2"
                            />
                        </pressable>

                        <column class="flex-1 gap-1">
                            <row class="items-center gap-1">
                                <text class="text-[14] font-bold text-theme-on-surface">{{ $reply['user']['name'] }}</text>
                                @if ($reply['user']['isVerified'])
                                    <icon name="verified" :size="14" color="#1D9BF0" />
                                @endif
                                <text class="text-[13] text-[#536471] dark:text-[#71767B]">{{ $reply['user']['handle'] }} · {{ $reply['time'] }}</text>
                            </row>

                            <row class="items-center gap-1">
                                <text class="text-[12] text-[#536471] dark:text-[#71767B]">Replying to</text>
                                <text class="text-[12] text-[#1D9BF0]">{{ $tweet['user']['handle'] }}</text>
                            </row>

                            <text class="text-[14] text-theme-on-surface">{{ $reply['text'] }}</text>

                            {{-- Reply Actions --}}
                            <row class="items-center gap-6 pt-1">
                                <icon name="chat_bubble_outline" :size="16" class="text-[#536471] dark:text-[#71767B]" />
                                <icon name="repeat" :size="16" class="text-[#536471] dark:text-[#71767B]" />
                                <row class="items-center gap-1">
                                    <icon name="favorite_border" :size="16" class="text-[#536471] dark:text-[#71767B]" />
                                    <text class="text-[12] text-[#536471] dark:text-[#71767B]">{{ $reply['likeFormatted'] }}</text>
                                </row>
                                <icon name="ios_share" :size="16" class="text-[#536471] dark:text-[#71767B]" />
                            </row>
                        </column>
                    </row>
                    <divider class="w-full" />
                </column>
            @endforeach

            <spacer class="h-[20]" />

        </column>
    </scroll-view>

    {{-- Pinned reply composer --}}
    <divider class="w-full" />
    <row class="w-full px-4 py-2 items-center gap-3">
        <image
            src="https://i.pravatar.cc/150?u=currentuser"
            alt="Your profile"
            class="w-[32] h-[32] rounded-full"
            :fit="2"
        />
        <column class="flex-1 bg-theme-surface-variant rounded-full px-4 py-2">
            <text class="text-[14] text-[#536471] dark:text-[#71767B]">Post your reply</text>
        </column>
    </row>

</column>
