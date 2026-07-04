{{-- @include('native.partials.demo-nav', ['title' => 'Facebook']) --}}

<scroll-view class="w-full h-full bg-[#F0F2F5] safe-area">
    <column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <row class="w-full bg-white px-4 py-3 items-center justify-between">
            <text class="text-[24] font-bold text-[#1877F2]">facebook</text>
            <row class="items-center gap-3">
                <column class="w-[36] h-[36] rounded-full bg-[#E4E6EB] items-center justify-center">
                    <icon name="search" :size="20" color="#050505" />
                </column>
                <column class="w-[36] h-[36] rounded-full bg-[#E4E6EB] items-center justify-center">
                    <icon name="chat" :size="20" color="#050505" />
                </column>
            </row>
        </row>

        {{-- Create Post Bar --}}
        <column class="w-full bg-white mt-2 px-4 py-3">
            <row @press="createPost" class="w-full items-center gap-3">
                <image
                    src="https://i.pravatar.cc/150?u=fbcurrent"
                    alt="Your profile"
                    class="w-[40] h-[40] rounded-full"
                    :fit="2"
                />
                <column class="flex-1 bg-[#F0F2F5] rounded-full px-4 py-2">
                    <text class="text-[14] text-[#65676B]">What's on your mind?</text>
                </column>
            </row>
            <divider class="w-full mt-3" />
            <row class="w-full pt-2 justify-between">
                <row class="items-center gap-1">
                    <icon name="videocam" :size="18" color="#F3425F" />
                    <text class="text-[12] text-[#65676B]">Live</text>
                </row>
                <row class="items-center gap-1">
                    <icon name="photo_library" :size="18" color="#45BD62" />
                    <text class="text-[12] text-[#65676B]">Photo</text>
                </row>
                <row class="items-center gap-1">
                    <icon name="mood" :size="18" color="#F7B928" />
                    <text class="text-[12] text-[#65676B]">Feeling</text>
                </row>
            </row>
        </column>

        {{-- Stories --}}
        <column class="w-full bg-white mt-2 px-4 py-3">
            <text class="text-[16] font-bold text-[#050505] pb-2">Stories</text>
            <scroll-view horizontal>
                <row class="gap-3">
                    {{-- Create Story --}}
                    <column class="items-center gap-1 w-[72]">
                        <column class="w-[60] h-[60] rounded-full bg-[#E4E6EB] items-center justify-center">
                            <icon name="add" :size="28" color="#1877F2" />
                        </column>
                        <text class="text-sm text-[#050505]">Create</text>
                    </column>
                    {{-- User Stories --}}
                    @foreach ($stories as $story)
                        <column class="items-center gap-1 w-[72]">
                            <column class="w-[60] h-[60] rounded-full bg-[#1877F2] items-center justify-center p-[3]">
                                <image
                                    src="{{ $story['avatarUrl'] }}"
                                    alt="{{ $story['name'] }}'s story"
                                    class="w-[54] h-[54] rounded-full"
                                    :fit="2"
                                />
                            </column>
                            <text class="text-sm text-gray-800" :maxLines="1">{{ explode(' ', $story['name'])[0] }}</text>
                        </column>
                    @endforeach
                </row>
            </scroll-view>
        </column>

        {{-- Posts --}}
        @foreach ($posts as $index => $post)
            <column class="w-full bg-white mt-2">
                {{-- Post Header --}}
                <row class="w-full px-4 pt-3 items-center gap-3">
                    <image
                        @press="viewProfile({{ $post['userId'] }})"
                        src="{{ $post['user']['avatarUrl'] }}"
                        alt="{{ $post['user']['name'] }}'s profile"
                        class="w-[40] h-[40] rounded-full"
                        :fit="2"
                    />
                    <column @press="viewProfile({{ $post['userId'] }})" class="flex-1">
                        <text class="text-[14] font-bold text-[#050505]" :maxLines="1">{{ $post['user']['name'] }}</text>
                        <text class="text-[12] text-[#65676B]" :maxLines="1">{{ $post['time'] }} ago · 🌐</text>
                    </column>
                    <icon name="more_horiz" :size="22" color="#65676B" />
                </row>

                {{-- Post Text --}}
                <column @press="viewPost({{ $index }})" class="w-full px-4 pt-2">
                    <text class="text-[15] text-[#050505]">{{ $post['text'] }}</text>
                </column>

                {{-- Post Image --}}
                @if ($post['imageUrl'])
                    <column @press="viewPost({{ $index }})" class="w-full pt-3">
                        <image
                            src="{{ $post['imageUrl'] }}"
                            alt="Photo by {{ $post['user']['name'] }}"
                            class="w-full h-[250]"
                            :fit="2"
                        />
                    </column>
                @endif

                {{-- Reaction Counts --}}
                <row class="w-full px-4 pt-2 pb-2 items-center justify-between">
                    <row class="items-center gap-1">
                        <icon name="thumb_up" :size="14" color="#1877F2" />
                        <text class="text-[13] text-[#65676B]">{{ $post['reactionsFormatted'] }}</text>
                    </row>
                    <row class="items-center gap-3">
                        <text class="text-[13] text-[#65676B]">{{ $post['comments'] }} comments</text>
                        <text class="text-[13] text-[#65676B]">{{ $post['shares'] }} shares</text>
                    </row>
                </row>

                <divider class="w-full mx-4" />

                {{-- Action Bar --}}
                <row class="w-full px-2 py-1 justify-between">
                    <row @press="toggleLike({{ $index }})" class="items-center gap-1 px-4 py-2">
                        <icon
                            name="{{ $post['isLiked'] ? 'thumb_up' : 'thumb_up_off_alt' }}"
                            :size="20"
                            color="{{ $post['isLiked'] ? '#1877F2' : '#65676B' }}"
                        />
                        <text class="text-[13] font-semibold text-{{ $post['isLiked'] ? '[#1877F2]' : '[#65676B]' }}">Like</text>
                    </row>
                    <row @press="viewPost({{ $index }})" class="items-center gap-1 px-4 py-2">
                        <icon name="chat_bubble_outline" :size="20" color="#65676B" />
                        <text class="text-[13] font-semibold text-[#65676B]">Comment</text>
                    </row>
                    <row class="items-center gap-1 px-4 py-2">
                        <icon name="share" :size="20" color="#65676B" />
                        <text class="text-[13] font-semibold text-[#65676B]">Share</text>
                    </row>
                </row>
            </column>
        @endforeach

        <spacer class="h-[20]" />

    </column>
</scroll-view>
