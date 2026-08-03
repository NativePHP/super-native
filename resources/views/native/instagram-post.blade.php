<column class="w-full h-full bg-theme-surface safe-area">

    {{-- Top Bar --}}
    <row class="w-full px-4 py-3 items-center gap-3">
        <pressable @tap="back" a11y-label="Back" class="w-[32] h-[32] items-center justify-center">
            <icon name="arrow_back" :size="24" class="text-theme-on-surface" />
        </pressable>
        <column>
            <text class="text-[12] font-semibold text-theme-on-surface-variant">{{ strtoupper($post['user']['username']) }}</text>
            <text class="text-[15] font-bold text-theme-on-surface">Posts</text>
        </column>
    </row>

    <divider class="w-full" />

    <scroll-view class="w-full flex-1">
        <column class="w-full gap-0">

            {{-- Post Header --}}
            <row class="w-full px-3 py-2 items-center gap-2">
                <pressable @tap="viewProfile({{ $post['userId'] }})" a11y-label="View {{ $post['user']['username'] }}'s profile">
                    <column class="w-[40] h-[40] rounded-full bg-[#DD2A7B] items-center justify-center">
                        <image
                            src="{{ $post['user']['avatarUrl'] }}"
                            alt="{{ $post['user']['username'] }}'s profile"
                            class="w-[36] h-[36] rounded-full"
                            :fit="2"
                        />
                    </column>
                </pressable>
                <pressable @tap="viewProfile({{ $post['userId'] }})" class="flex-1">
                    <column>
                        <row class="items-center gap-1">
                            <text class="text-[14] font-bold text-theme-on-surface">{{ $post['user']['username'] }}</text>
                            @if ($post['user']['isVerified'])
                                <icon name="verified" :size="14" color="#3897F0" />
                            @endif
                        </row>
                        @if ($post['location'])
                            <text class="text-[12] text-theme-on-surface-variant">{{ $post['location'] }}</text>
                        @endif
                    </column>
                </pressable>
                <icon name="more_horiz" :size="20" class="text-theme-on-surface" />
            </row>

            {{-- Post Image --}}
            <image
                src="{{ $post['imageUrl'] }}"
                alt="Photo by {{ $post['user']['username'] }}: {{ \Illuminate\Support\Str::limit($post['caption'], 60) }}"
                class="w-full h-[375]"
                :fit="2"
            />

            {{-- Action Bar --}}
            <row class="w-full px-3 pt-3 items-center justify-between">
                <row class="items-center gap-4">
                    <pressable @tap="toggleLike" a11y-label="{{ $isLiked ? 'Unlike' : 'Like' }}">
                        <row class="items-center gap-1">
                            <icon
                                name="{{ $isLiked ? 'favorite' : 'favorite_border' }}"
                                :size="26"
                                class="{{ $isLiked ? 'text-[#ED4956]' : 'text-theme-on-surface' }}"
                            />
                            <text class="text-[14] font-semibold text-theme-on-surface">{{ $likesFormatted }}</text>
                        </row>
                    </pressable>
                    <row class="items-center gap-1">
                        <icon name="chat_bubble_outline" :size="24" class="text-theme-on-surface" />
                        <text class="text-[14] font-semibold text-theme-on-surface">{{ count($comments) }}</text>
                    </row>
                    <icon name="ios_share" :size="24" class="text-theme-on-surface" />
                </row>
                <pressable @tap="toggleSave" a11y-label="{{ $isSaved ? 'Unsave' : 'Save' }}">
                    <icon
                        name="{{ $isSaved ? 'bookmark' : 'bookmark_border' }}"
                        :size="26"
                        class="text-theme-on-surface"
                    />
                </pressable>
            </row>

            {{-- Caption --}}
            <column class="w-full px-3 pt-2 pb-2">
                <text class="text-[14] text-theme-on-surface"><text class="font-bold">{{ $post['user']['username'] }}</text> {{ $post['caption'] }}</text>
            </column>

            {{-- Time --}}
            <column class="w-full px-3 pb-3">
                <text class="text-[12] text-theme-on-surface-variant">{{ $post['time'] }} ago</text>
            </column>

            <divider class="w-full" />

            {{-- Comments --}}
            <column class="w-full px-3 pt-3 gap-3 pb-4">
                @foreach ($comments as $comment)
                    <row class="w-full gap-2 items-start">
                        <pressable @tap="viewProfile({{ $comment['userId'] }})" a11y-label="View {{ $comment['user']['username'] }}'s profile">
                            <image
                                src="{{ $comment['user']['avatarUrl'] }}"
                                alt="{{ $comment['user']['username'] }}'s profile"
                                class="w-[32] h-[32] rounded-full"
                                :fit="2"
                            />
                        </pressable>
                        <column class="flex-1 gap-1">
                            <text class="text-[13] text-theme-on-surface"><text class="font-bold">{{ $comment['user']['username'] }}</text> {{ $comment['text'] }}</text>
                            <row class="items-center gap-3">
                                <text class="text-[11] text-theme-on-surface-variant">{{ $comment['time'] }}</text>
                                <text class="text-[11] font-semibold text-theme-on-surface-variant">{{ $comment['likes'] }} likes</text>
                                <text class="text-[11] font-semibold text-theme-on-surface-variant">Reply</text>
                            </row>
                        </column>
                        <icon name="favorite_border" :size="14" class="text-theme-on-surface-variant" />
                    </row>
                @endforeach
            </column>

            <spacer class="h-[20]" />

        </column>
    </scroll-view>

    {{-- Pinned comment composer --}}
    <divider class="w-full" />
    <column class="w-full">
        {{-- Emoji quick-reactions --}}
        <row class="w-full px-4 pt-2 justify-between">
            @foreach (['❤️', '🙌', '🔥', '👏', '😢', '😍', '😮', '😂'] as $emoji)
                <text class="text-[22]">{{ $emoji }}</text>
            @endforeach
        </row>
        <row class="w-full px-3 py-2 items-center gap-3">
            <image
                src="https://i.pravatar.cc/150?u=igcurrent"
                alt="Your profile"
                class="w-[36] h-[36] rounded-full"
                :fit="2"
            />
            <column class="flex-1 bg-theme-surface-variant rounded-full px-4 py-2">
                <text class="text-[14] text-theme-on-surface-variant">Add a comment for {{ $post['user']['username'] }}...</text>
            </column>
        </row>
    </column>

</column>
