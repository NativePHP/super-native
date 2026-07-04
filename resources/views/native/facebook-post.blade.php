<scroll-view class="w-full h-full bg-[#F0F2F5] safe-area">
    <column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <row class="w-full bg-white px-4 py-3 items-center gap-3">
            <column @press="back" a11y-label="Back" class="w-[32] h-[32] rounded-full bg-[#E4E6EB] items-center justify-center">
                <icon name="arrow_back" :size="20" color="#050505" />
            </column>
            <text class="text-[18] font-bold text-[#050505]">{{ $post['user']['name'] }}'s Post</text>
        </row>

        {{-- Post Card --}}
        <column class="w-full bg-white mt-2">
            {{-- Post Header --}}
            <row class="w-full px-4 pt-3 items-center gap-3">
                <image
                    @press="viewProfile({{ $post['userId'] }})"
                    src="{{ $post['user']['avatarUrl'] }}"
                    alt="{{ $post['user']['name'] }}'s profile"
                    class="w-[44] h-[44] rounded-full"
                    :fit="2"
                />
                <column @press="viewProfile({{ $post['userId'] }})" class="flex-1">
                    <text class="text-[15] font-bold text-[#050505]" :maxLines="1">{{ $post['user']['name'] }}</text>
                    <text class="text-[13] text-[#65676B]" :maxLines="1">{{ $post['time'] }} ago · 🌐</text>
                </column>
            </row>

            {{-- Post Text --}}
            <column class="w-full px-4 pt-3">
                <text class="text-[16] text-[#050505]">{{ $post['text'] }}</text>
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

            {{-- Reaction Counts --}}
            <row class="w-full px-4 pt-3 pb-2 items-center justify-between">
                <row class="items-center gap-1">
                    <icon name="thumb_up" :size="16" color="#1877F2" />
                    <icon name="favorite" :size="16" color="#F33E58" />
                    <text class="text-[14] text-[#65676B]">{{ $reactionsFormatted }}</text>
                </row>
                <row class="items-center gap-3">
                    <text class="text-[14] text-[#65676B]">{{ $post['comments'] }} comments</text>
                    <text class="text-[14] text-[#65676B]">{{ $post['shares'] }} shares</text>
                </row>
            </row>

            <divider class="w-full mx-4" />

            {{-- Action Bar --}}
            <row class="w-full px-2 py-1 justify-between">
                <row @press="toggleLike" class="items-center gap-1 px-4 py-2">
                    <icon
                        name="{{ $isLiked ? 'thumb_up' : 'thumb_up_off_alt' }}"
                        :size="22"
                        color="{{ $isLiked ? '#1877F2' : '#65676B' }}"
                    />
                    <text class="text-[14] font-semibold text-{{ $isLiked ? '[#1877F2]' : '[#65676B]' }}">Like</text>
                </row>
                <row class="items-center gap-1 px-4 py-2">
                    <icon name="chat_bubble_outline" :size="22" color="#65676B" />
                    <text class="text-[14] font-semibold text-[#65676B]">Comment</text>
                </row>
                <row class="items-center gap-1 px-4 py-2">
                    <icon name="share" :size="22" color="#65676B" />
                    <text class="text-[14] font-semibold text-[#65676B]">Share</text>
                </row>
            </row>
        </column>

        {{-- Comments Section --}}
        <column class="w-full bg-white mt-2 px-4 pt-3 pb-2">
            <text class="text-[15] font-bold text-[#050505] pb-2">Comments</text>
        </column>

        @foreach ($comments as $comment)
            <column class="w-full bg-white">
                <row class="w-full px-4 pb-3 gap-2">
                    {{-- Comment Avatar --}}
                    <image
                        @press="viewProfile({{ $comment['userId'] }})"
                        src="{{ $comment['user']['avatarUrl'] }}"
                        alt="{{ $comment['user']['name'] }}'s profile"
                        class="w-[32] h-[32] rounded-full"
                        :fit="2"
                    />

                    {{-- Comment Bubble — flex-1 so the bubble grows to fill
                         remaining row width instead of clamping to 280px. --}}
                    <column class="flex-1 gap-1">
                        <column class="bg-[#F0F2F5] rounded-2xl px-3 py-2">
                            <text class="text-[13] font-bold text-[#050505]">{{ $comment['user']['name'] }}</text>
                            <text class="text-[14] text-[#050505]">{{ $comment['text'] }}</text>
                        </column>
                        <row class="items-center gap-3 px-2">
                            <text class="text-[12] text-[#65676B]">{{ $comment['time'] }}</text>
                            <text class="text-[12] font-bold text-[#65676B]">Like</text>
                            <text class="text-[12] font-bold text-[#65676B]">Reply</text>
                            @if ($comment['likes'] > 0)
                                <row class="items-center gap-1">
                                    <icon name="thumb_up" :size="10" color="#1877F2" />
                                    <text class="text-[11] text-[#65676B]">{{ $comment['likes'] }}</text>
                                </row>
                            @endif
                        </row>
                    </column>
                </row>
            </column>
        @endforeach

        {{-- Comment Input --}}
        <column class="w-full bg-white px-4 py-3 mt-2">
            <row class="w-full items-center gap-3">
                <image
                    src="https://i.pravatar.cc/150?u=fbcurrent"
                    alt="Your profile"
                    class="w-[32] h-[32] rounded-full"
                    :fit="2"
                />
                <column class="flex-1 bg-[#F0F2F5] rounded-full px-4 py-2">
                    <text class="text-[13] text-[#65676B]">Write a comment...</text>
                </column>
            </row>
        </column>

        <spacer class="h-[20]" />

    </column>
</scroll-view>
