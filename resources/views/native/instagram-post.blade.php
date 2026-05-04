<native:scroll-view class="w-full h-full bg-white safe-area">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full px-4 py-3 items-center gap-3">
            <native:column @press="back" class="w-[32] h-[32] items-center justify-center">
                <native:icon name="arrow_back" :size="24" color="#262626" />
            </native:column>
            <native:text class="text-[16] font-bold text-[#262626]">Post</native:text>
        </native:row>

        <native:divider class="w-full" />

        {{-- Post Header --}}
        <native:row class="w-full px-3 py-2 items-center gap-2">
            <native:image
                @press="viewProfile({{ $post['userId'] }})"
                src="{{ $post['user']['avatarUrl'] }}"
                class="w-[36] h-[36] rounded-full"
                :fit="2"
            />
            <native:column @press="viewProfile({{ $post['userId'] }})">
                <native:row class="items-center gap-1">
                    <native:text class="text-[14] font-bold text-[#262626]">{{ $post['user']['username'] }}</native:text>
                    @if ($post['user']['isVerified'])
                        <native:icon name="verified" :size="14" color="#3897F0" />
                    @endif
                </native:row>
                @if ($post['location'])
                    <native:text class="text-[12] text-[#262626]">{{ $post['location'] }}</native:text>
                @endif
            </native:column>
        </native:row>

        {{-- Post Image --}}
        <native:image
            src="{{ $post['imageUrl'] }}"
            class="w-full h-[375]"
            :fit="2"
        />

        {{-- Action Bar --}}
        <native:row class="w-full px-3 mt-5 items-center justify-between">
            <native:row class="items-center gap-4">
                <native:column @press="toggleLike">
                    <native:icon
                        name="{{ $isLiked ? 'favorite' : 'favorite_border' }}"
                        :size="28"
                        color="{{ $isLiked ? '#ED4956' : '#262626' }}"
                    />
                </native:column>
                <native:icon name="chat_bubble_outline" :size="26" color="#262626" />
                <native:icon name="send" :size="26" color="#262626" />
            </native:row>
            <native:column @press="toggleSave">
                <native:icon
                    name="{{ $isSaved ? 'bookmark' : 'bookmark_border' }}"
                    :size="28"
                    color="#262626"
                />
            </native:column>
        </native:row>

        {{-- Likes --}}
        <native:column class="w-full px-3 pt-2">
            <native:text class="text-[14] font-bold text-[#262626]">{{ $likesFormatted }} likes</native:text>
        </native:column>

        {{-- Caption --}}
        <native:column class="w-full px-3 pt-2 pb-2">
            <native:text class="text-[14] text-[#262626]"><native:text class="text-[14] font-bold text-[#262626]">{{ $post['user']['username'] }}</native:text> {{ $post['caption'] }}</native:text>
        </native:column>

        {{-- Time --}}
        <native:column class="w-full px-3 pb-3">
            <native:text class="text-[12] text-[#8E8E8E]">{{ $post['time'] }} ago</native:text>
        </native:column>

        <native:divider class="w-full" />

        {{-- Comments --}}
        <native:column class="w-full px-3 pt-3 gap-3 pb-4">
            @foreach ($comments as $comment)
                <native:row class="w-full gap-2 items-start">
                    <native:image
                        @press="viewProfile({{ $comment['userId'] }})"
                        src="{{ $comment['user']['avatarUrl'] }}"
                        class="w-[32] h-[32] rounded-full"
                        :fit="2"
                    />
                    <native:column class="flex-1 gap-1">
                        <native:text class="text-[13] text-[#262626]"><native:text class="text-[13] font-bold text-[#262626]">{{ $comment['user']['username'] }}</native:text> {{ $comment['text'] }}</native:text>
                        <native:row class="items-center gap-3">
                            <native:text class="text-[11] text-[#8E8E8E]">{{ $comment['time'] }}</native:text>
                            <native:text class="text-[11] font-semibold text-[#8E8E8E]">{{ $comment['likes'] }} likes</native:text>
                            <native:text class="text-[11] font-semibold text-[#8E8E8E]">Reply</native:text>
                        </native:row>
                    </native:column>
                    <native:icon name="favorite_border" :size="12" color="#8E8E8E" />
                </native:row>
            @endforeach
        </native:column>

        <native:divider class="w-full" />

        {{-- Comment Input --}}
        <native:row class="w-full px-3 py-3 items-center gap-3">
            <native:image
                src="https://i.pravatar.cc/150?u=igcurrent"
                class="w-[32] h-[32] rounded-full"
                :fit="2"
            />
            <native:text class="text-[14] text-[#8E8E8E]">Add a comment...</native:text>
        </native:row>

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
