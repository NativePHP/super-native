<native:scroll-view class="w-full h-full bg-[#F0F2F5] safe-area">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full bg-white px-4 py-3 items-center gap-3">
            <native:column @press="back" class="w-[32] h-[32] rounded-full bg-[#E4E6EB] items-center justify-center">
                <native:icon name="arrow_back" :size="20" color="#050505" />
            </native:column>
            <native:text class="text-[18] font-bold text-[#050505]">{{ $post['user']['name'] }}'s Post</native:text>
        </native:row>

        {{-- Post Card --}}
        <native:column class="w-full bg-white mt-2">
            {{-- Post Header --}}
            <native:row class="w-full px-4 pt-3 items-center gap-3">
                <native:image
                    @press="viewProfile({{ $post['userId'] }})"
                    src="{{ $post['user']['avatarUrl'] }}"
                    class="w-[44] h-[44] rounded-full"
                    :fit="2"
                />
                <native:column @press="viewProfile({{ $post['userId'] }})" class="flex-1">
                    <native:text class="text-[15] font-bold text-[#050505]" :maxLines="1">{{ $post['user']['name'] }}</native:text>
                    <native:text class="text-[13] text-[#65676B]" :maxLines="1">{{ $post['time'] }} ago · 🌐</native:text>
                </native:column>
            </native:row>

            {{-- Post Text --}}
            <native:column class="w-full px-4 pt-3">
                <native:text class="text-[16] text-[#050505]">{{ $post['text'] }}</native:text>
            </native:column>

            {{-- Post Image --}}
            @if ($post['imageUrl'])
                <native:column class="w-full pt-3">
                    <native:image
                        src="{{ $post['imageUrl'] }}"
                        class="w-full h-[300]"
                        :fit="2"
                    />
                </native:column>
            @endif

            {{-- Reaction Counts --}}
            <native:row class="w-full px-4 pt-3 pb-2 items-center justify-between">
                <native:row class="items-center gap-1">
                    <native:icon name="thumb_up" :size="16" color="#1877F2" />
                    <native:icon name="favorite" :size="16" color="#F33E58" />
                    <native:text class="text-[14] text-[#65676B]">{{ $reactionsFormatted }}</native:text>
                </native:row>
                <native:row class="items-center gap-3">
                    <native:text class="text-[14] text-[#65676B]">{{ $post['comments'] }} comments</native:text>
                    <native:text class="text-[14] text-[#65676B]">{{ $post['shares'] }} shares</native:text>
                </native:row>
            </native:row>

            <native:divider class="w-full mx-4" />

            {{-- Action Bar --}}
            <native:row class="w-full px-2 py-1 justify-between">
                <native:row @press="toggleLike" class="items-center gap-1 px-4 py-2">
                    <native:icon
                        name="{{ $isLiked ? 'thumb_up' : 'thumb_up_off_alt' }}"
                        :size="22"
                        color="{{ $isLiked ? '#1877F2' : '#65676B' }}"
                    />
                    <native:text class="text-[14] font-semibold text-{{ $isLiked ? '[#1877F2]' : '[#65676B]' }}">Like</native:text>
                </native:row>
                <native:row class="items-center gap-1 px-4 py-2">
                    <native:icon name="chat_bubble_outline" :size="22" color="#65676B" />
                    <native:text class="text-[14] font-semibold text-[#65676B]">Comment</native:text>
                </native:row>
                <native:row class="items-center gap-1 px-4 py-2">
                    <native:icon name="share" :size="22" color="#65676B" />
                    <native:text class="text-[14] font-semibold text-[#65676B]">Share</native:text>
                </native:row>
            </native:row>
        </native:column>

        {{-- Comments Section --}}
        <native:column class="w-full bg-white mt-2 px-4 pt-3 pb-2">
            <native:text class="text-[15] font-bold text-[#050505] pb-2">Comments</native:text>
        </native:column>

        @foreach ($comments as $comment)
            <native:column class="w-full bg-white">
                <native:row class="w-full px-4 pb-3 gap-2">
                    {{-- Comment Avatar --}}
                    <native:image
                        @press="viewProfile({{ $comment['userId'] }})"
                        src="{{ $comment['user']['avatarUrl'] }}"
                        class="w-[32] h-[32] rounded-full"
                        :fit="2"
                    />

                    {{-- Comment Bubble — flex-1 so the bubble grows to fill
                         remaining row width instead of clamping to 280px. --}}
                    <native:column class="flex-1 gap-1">
                        <native:column class="bg-[#F0F2F5] rounded-2xl px-3 py-2">
                            <native:text class="text-[13] font-bold text-[#050505]">{{ $comment['user']['name'] }}</native:text>
                            <native:text class="text-[14] text-[#050505]">{{ $comment['text'] }}</native:text>
                        </native:column>
                        <native:row class="items-center gap-3 px-2">
                            <native:text class="text-[12] text-[#65676B]">{{ $comment['time'] }}</native:text>
                            <native:text class="text-[12] font-bold text-[#65676B]">Like</native:text>
                            <native:text class="text-[12] font-bold text-[#65676B]">Reply</native:text>
                            @if ($comment['likes'] > 0)
                                <native:row class="items-center gap-1">
                                    <native:icon name="thumb_up" :size="10" color="#1877F2" />
                                    <native:text class="text-[11] text-[#65676B]">{{ $comment['likes'] }}</native:text>
                                </native:row>
                            @endif
                        </native:row>
                    </native:column>
                </native:row>
            </native:column>
        @endforeach

        {{-- Comment Input --}}
        <native:column class="w-full bg-white px-4 py-3 mt-2">
            <native:row class="w-full items-center gap-3">
                <native:image
                    src="https://i.pravatar.cc/150?u=fbcurrent"
                    class="w-[32] h-[32] rounded-full"
                    :fit="2"
                />
                <native:column class="flex-1 bg-[#F0F2F5] rounded-full px-4 py-2">
                    <native:text class="text-[13] text-[#65676B]">Write a comment...</native:text>
                </native:column>
            </native:row>
        </native:column>

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
