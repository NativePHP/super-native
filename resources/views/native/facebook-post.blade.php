<column class="w-full h-full bg-theme-background safe-area">

    {{-- Top Bar --}}
    <row class="w-full bg-theme-surface px-4 py-3 items-center gap-3">
        <pressable @tap="back" a11y-label="Back" class="w-[32] h-[32] rounded-full bg-theme-surface-variant items-center justify-center">
            <icon name="arrow_back" :size="20" class="text-theme-on-surface" />
        </pressable>
        <text class="text-[17] font-bold text-theme-on-surface" :maxLines="1">{{ $post['user']['name'] }}'s Post</text>
    </row>

    <scroll-view class="w-full flex-1">
        <column class="w-full gap-0">

            {{-- Post Card --}}
            <column class="w-full bg-theme-surface mt-2">
                {{-- Post Header --}}
                <row class="w-full px-4 pt-3 items-center gap-3">
                    <pressable @tap="viewProfile({{ $post['userId'] }})" a11y-label="View {{ $post['user']['name'] }}'s profile">
                        <image
                            src="{{ $post['user']['avatarUrl'] }}"
                            alt="{{ $post['user']['name'] }}'s profile"
                            class="w-[44] h-[44] rounded-full"
                            :fit="2"
                        />
                    </pressable>
                    <pressable @tap="viewProfile({{ $post['userId'] }})" class="flex-1">
                        <column>
                            <text class="text-[15] font-bold text-theme-on-surface" :maxLines="1">{{ $post['user']['name'] }}</text>
                            <row class="items-center gap-1">
                                <text class="text-[13] text-[#65676B] dark:text-[#B0B3B8]">{{ $post['time'] }} ago ·</text>
                                <icon name="globe" :size="12" class="text-[#65676B] dark:text-[#B0B3B8]" />
                            </row>
                        </column>
                    </pressable>
                    <icon name="more_horiz" :size="22" class="text-[#65676B] dark:text-[#B0B3B8]" />
                </row>

                {{-- Post Text --}}
                <column class="w-full px-4 pt-3">
                    <text class="text-[16] text-theme-on-surface">{{ $post['text'] }}</text>
                </column>

                {{-- Post Image --}}
                @if ($post['imageUrl'])
                    <column class="w-full pt-3">
                        <image
                            src="{{ $post['imageUrl'] }}"
                            alt="Photo by {{ $post['user']['name'] }}"
                            class="w-full h-[300]"
                            :fit="2"
                        />
                    </column>
                @endif

                {{-- Reaction Summary --}}
                <row class="w-full px-4 pt-3 pb-2 items-center justify-between">
                    <row class="items-center gap-1">
                        <column class="w-[18] h-[18] rounded-full bg-[#1877F2] items-center justify-center">
                            <icon name="thumb_up" :size="10" color="#FFFFFF" />
                        </column>
                        <column class="w-[18] h-[18] rounded-full bg-[#F33E58] items-center justify-center ml-[-6]">
                            <icon name="favorite" :size="10" color="#FFFFFF" />
                        </column>
                        <text class="text-[14] text-[#65676B] dark:text-[#B0B3B8]" :maxLines="1">{{ $reactionsFormatted }}</text>
                    </row>
                    <row class="items-center gap-3">
                        <text class="text-[14] text-[#65676B] dark:text-[#B0B3B8]">{{ $post['comments'] }} comments</text>
                        <text class="text-[14] text-[#65676B] dark:text-[#B0B3B8]">{{ $post['shares'] }} shares</text>
                    </row>
                </row>

                <divider class="w-full mx-4" />

                {{-- Action Bar --}}
                <row class="w-full px-2 py-1 justify-between">
                    <row @tap="toggleLike" a11y-label="{{ $isLiked ? 'Unlike' : 'Like' }}" class="items-center gap-1 px-4 py-2 flex-shrink-0">
                        <icon
                            name="{{ $isLiked ? 'thumb_up' : 'thumb_up_off_alt' }}"
                            :size="22"
                            class="{{ $isLiked ? 'text-[#1877F2]' : 'text-[#65676B] dark:text-[#B0B3B8]' }}"
                        />
                        <text class="text-[14] font-semibold {{ $isLiked ? 'text-[#1877F2]' : 'text-[#65676B] dark:text-[#B0B3B8]' }}">Like</text>
                    </row>
                    <row class="items-center gap-1 px-4 py-2 flex-shrink-0">
                        <icon name="chat_bubble_outline" :size="22" class="text-[#65676B] dark:text-[#B0B3B8]" />
                        <text class="text-[14] font-semibold text-[#65676B] dark:text-[#B0B3B8]">Comment</text>
                    </row>
                    <row class="items-center gap-1 px-4 py-2 flex-shrink-0">
                        <icon name="share" :size="22" class="text-[#65676B] dark:text-[#B0B3B8]" />
                        <text class="text-[14] font-semibold text-[#65676B] dark:text-[#B0B3B8]">Share</text>
                    </row>
                </row>
            </column>

            {{-- Comments --}}
            <column class="w-full bg-theme-surface mt-2 px-4 pt-3 pb-4 gap-3">
                <row class="w-full items-center justify-between">
                    <text class="text-[15] font-bold text-theme-on-surface">Most relevant</text>
                    <icon name="expand_more" :size="18" class="text-[#65676B] dark:text-[#B0B3B8]" />
                </row>

                @foreach ($comments as $comment)
                    <row class="w-full gap-2 items-start">
                        {{-- Comment Avatar --}}
                        <pressable @tap="viewProfile({{ $comment['userId'] }})" a11y-label="View {{ $comment['user']['name'] }}'s profile">
                            <image
                                src="{{ $comment['user']['avatarUrl'] }}"
                                alt="{{ $comment['user']['name'] }}'s profile"
                                class="w-[32] h-[32] rounded-full"
                                :fit="2"
                            />
                        </pressable>

                        {{-- Comment Bubble — flex-1 so the bubble grows to fill
                             remaining row width instead of clamping to 280px. --}}
                        <column class="flex-1 gap-1">
                            <column class="bg-theme-surface-variant rounded-2xl px-3 py-2">
                                <text class="text-[13] font-bold text-theme-on-surface">{{ $comment['user']['name'] }}</text>
                                <text class="text-[14] text-theme-on-surface">{{ $comment['text'] }}</text>
                            </column>
                            <row class="items-center gap-3 px-2">
                                <text class="text-[12] text-[#65676B] dark:text-[#B0B3B8]">{{ $comment['time'] }}</text>
                                <text class="text-[12] font-bold text-[#65676B] dark:text-[#B0B3B8]">Like</text>
                                <text class="text-[12] font-bold text-[#65676B] dark:text-[#B0B3B8]">Reply</text>
                                @if ($comment['likes'] > 0)
                                    <row class="items-center gap-1">
                                        <column class="w-[14] h-[14] rounded-full bg-[#1877F2] items-center justify-center">
                                            <icon name="thumb_up" :size="8" color="#FFFFFF" />
                                        </column>
                                        <text class="text-[11] text-[#65676B] dark:text-[#B0B3B8]">{{ $comment['likes'] }}</text>
                                    </row>
                                @endif
                            </row>
                        </column>
                    </row>
                @endforeach
            </column>

            <spacer class="h-[20]" />

        </column>
    </scroll-view>

    {{-- Pinned comment composer --}}
    <divider class="w-full" />
    <row class="w-full bg-theme-surface px-4 py-2 items-center gap-3">
        <image
            src="https://i.pravatar.cc/150?u=fbcurrent"
            alt="Your profile"
            class="w-[32] h-[32] rounded-full"
            :fit="2"
        />
        <column class="flex-1 bg-theme-surface-variant rounded-full px-4 py-2">
            <text class="text-[14] text-[#65676B] dark:text-[#B0B3B8]">Write a comment...</text>
        </column>
    </row>

</column>
