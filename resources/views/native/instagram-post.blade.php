<scroll-view class="w-full h-full bg-white safe-area">
    <column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <row class="w-full px-4 py-3 items-center gap-3">
            <column @press="back" a11y-label="Back" class="w-[32] h-[32] items-center justify-center">
                <icon name="arrow_back" :size="24" color="#262626" />
            </column>
            <text class="text-[16] font-bold text-[#262626]">Post</text>
        </row>

        <divider class="w-full" />

        {{-- Post Header --}}
        <row class="w-full px-3 py-2 items-center gap-2">
            <image
                @press="viewProfile({{ $post['userId'] }})"
                src="{{ $post['user']['avatarUrl'] }}"
                alt="{{ $post['user']['username'] }}'s profile"
                class="w-[36] h-[36] rounded-full"
                :fit="2"
            />
            <column @press="viewProfile({{ $post['userId'] }})">
                <row class="items-center gap-1">
                    <text class="text-[14] font-bold text-[#262626]">{{ $post['user']['username'] }}</text>
                    @if ($post['user']['isVerified'])
                        <icon name="verified" :size="14" color="#3897F0" />
                    @endif
                </row>
                @if ($post['location'])
                    <text class="text-[12] text-[#262626]">{{ $post['location'] }}</text>
                @endif
            </column>
        </row>

        {{-- Post Image --}}
        <image
            src="{{ $post['imageUrl'] }}"
            alt="Photo by {{ $post['user']['username'] }}: {{ \Illuminate\Support\Str::limit($post['caption'], 60) }}"
            class="w-full h-[375]"
            :fit="2"
        />

        {{-- Action Bar --}}
        <row class="w-full px-3 mt-5 items-center justify-between">
            <row class="items-center gap-4">
                <column @press="toggleLike" a11y-label="Like">
                    <icon
                        name="{{ $isLiked ? 'favorite' : 'favorite_border' }}"
                        :size="28"
                        color="{{ $isLiked ? '#ED4956' : '#262626' }}"
                    />
                </column>
                <icon name="chat_bubble_outline" :size="26" color="#262626" />
                <icon name="send" :size="26" color="#262626" />
            </row>
            <column @press="toggleSave" a11y-label="Save">
                <icon
                    name="{{ $isSaved ? 'bookmark' : 'bookmark_border' }}"
                    :size="28"
                    color="#262626"
                />
            </column>
        </row>

        {{-- Likes --}}
        <column class="w-full px-3 pt-2">
            <text class="text-[14] font-bold text-[#262626]">{{ $likesFormatted }} likes</text>
        </column>

        {{-- Caption --}}
        <column class="w-full px-3 pt-2 pb-2">
            <text class="text-[14] text-[#262626]"><text class="text-[14] font-bold text-[#262626]">{{ $post['user']['username'] }}</text> {{ $post['caption'] }}</text>
        </column>

        {{-- Time --}}
        <column class="w-full px-3 pb-3">
            <text class="text-[12] text-[#8E8E8E]">{{ $post['time'] }} ago</text>
        </column>

        <divider class="w-full" />

        {{-- Comments --}}
        <column class="w-full px-3 pt-3 gap-3 pb-4">
            @foreach ($comments as $comment)
                <row class="w-full gap-2 items-start">
                    <image
                        @press="viewProfile({{ $comment['userId'] }})"
                        src="{{ $comment['user']['avatarUrl'] }}"
                        alt="{{ $comment['user']['username'] }}'s profile"
                        class="w-[32] h-[32] rounded-full"
                        :fit="2"
                    />
                    <column class="flex-1 gap-1">
                        <text class="text-[13] text-[#262626]"><text class="text-[13] font-bold text-[#262626]">{{ $comment['user']['username'] }}</text> {{ $comment['text'] }}</text>
                        <row class="items-center gap-3">
                            <text class="text-[11] text-[#8E8E8E]">{{ $comment['time'] }}</text>
                            <text class="text-[11] font-semibold text-[#8E8E8E]">{{ $comment['likes'] }} likes</text>
                            <text class="text-[11] font-semibold text-[#8E8E8E]">Reply</text>
                        </row>
                    </column>
                    <icon name="favorite_border" :size="12" color="#8E8E8E" />
                </row>
            @endforeach
        </column>

        <divider class="w-full" />

        {{-- Comment Input --}}
        <row class="w-full px-3 py-3 items-center gap-3">
            <image
                src="https://i.pravatar.cc/150?u=igcurrent"
                alt="Your profile"
                class="w-[32] h-[32] rounded-full"
                :fit="2"
            />
            <text class="text-[14] text-[#8E8E8E]">Add a comment...</text>
        </row>

        <spacer class="h-[20]" />

    </column>
</scroll-view>
