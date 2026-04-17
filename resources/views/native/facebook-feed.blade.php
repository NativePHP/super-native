@include('native.partials.demo-nav', ['title' => 'Facebook'])

<native:scroll-view class="w-full h-full bg-[#F0F2F5] safe-area">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full bg-white px-4 py-3 items-center justify-between">
            <native:text class="text-[24] font-bold text-[#1877F2]">facebook</native:text>
            <native:row class="items-center gap-3">
                <native:column class="w-[36] h-[36] rounded-full bg-[#E4E6EB] items-center justify-center">
                    <native:icon name="search" :size="20" color="#050505" />
                </native:column>
                <native:column class="w-[36] h-[36] rounded-full bg-[#E4E6EB] items-center justify-center">
                    <native:icon name="chat" :size="20" color="#050505" />
                </native:column>
            </native:row>
        </native:row>

        {{-- Create Post Bar --}}
        <native:column class="w-full bg-white mt-2 px-4 py-3">
            <native:row @press="createPost" class="w-full items-center gap-3">
                <native:image
                    src="https://i.pravatar.cc/150?u=fbcurrent"
                    class="w-[40] h-[40] rounded-full"
                    :fit="2"
                />
                <native:column class="w-[270] bg-[#F0F2F5] rounded-full px-4 py-2">
                    <native:text class="text-[14] text-[#65676B]">What's on your mind?</native:text>
                </native:column>
            </native:row>
            <native:divider class="w-full mt-3" />
            <native:row class="w-full pt-2 justify-between">
                <native:row class="items-center gap-1">
                    <native:icon name="videocam" :size="18" color="#F3425F" />
                    <native:text class="text-[12] text-[#65676B]">Live</native:text>
                </native:row>
                <native:row class="items-center gap-1">
                    <native:icon name="photo_library" :size="18" color="#45BD62" />
                    <native:text class="text-[12] text-[#65676B]">Photo</native:text>
                </native:row>
                <native:row class="items-center gap-1">
                    <native:icon name="mood" :size="18" color="#F7B928" />
                    <native:text class="text-[12] text-[#65676B]">Feeling</native:text>
                </native:row>
            </native:row>
        </native:column>

        {{-- Stories --}}
        <native:column class="w-full bg-white mt-2 px-4 py-3">
            <native:text class="text-[16] font-bold text-[#050505] pb-2">Stories</native:text>
            <native:scroll-view horizontal>
                <native:row class="gap-3">
                    {{-- Create Story --}}
                    <native:column class="items-center gap-1 w-[72]">
                        <native:column class="w-[60] h-[60] rounded-full bg-[#E4E6EB] items-center justify-center">
                            <native:icon name="add" :size="28" color="#1877F2" />
                        </native:column>
                        <native:text class="text-sm text-[#050505]">Create</native:text>
                    </native:column>
                    {{-- User Stories --}}
                    @foreach ($stories as $story)
                        <native:column class="items-center gap-1 w-[72]">
                            <native:column class="w-[60] h-[60] rounded-full bg-[#1877F2] items-center justify-center p-[3]">
                                <native:image
                                    src="{{ $story['avatarUrl'] }}"
                                    class="w-[54] h-[54] rounded-full"
                                    :fit="2"
                                />
                            </native:column>
                            <native:text class="text-sm text-gray-800" :maxLines="1">{{ explode(' ', $story['name'])[0] }}</native:text>
                        </native:column>
                    @endforeach
                </native:row>
            </native:scroll-view>
        </native:column>

        {{-- Posts --}}
        @foreach ($posts as $index => $post)
            <native:column class="w-full bg-white mt-2">
                {{-- Post Header --}}
                <native:row class="w-full px-4 pt-3 items-center gap-3">
                    <native:image
                        @press="viewProfile({{ $post['userId'] }})"
                        src="{{ $post['user']['avatarUrl'] }}"
                        class="w-[40] h-[40] rounded-full"
                        :fit="2"
                    />
                    <native:column @press="viewProfile({{ $post['userId'] }})">
                        <native:text class="text-[14] font-bold text-[#050505]">{{ $post['user']['name'] }}</native:text>
                        <native:text class="text-[12] text-[#65676B]">{{ $post['time'] }} ago · 🌐</native:text>
                    </native:column>
                    <native:spacer />
                    <native:icon name="more_horiz" :size="22" color="#65676B" />
                </native:row>

                {{-- Post Text --}}
                <native:column @press="viewPost({{ $index }})" class="w-full px-4 pt-2">
                    <native:text class="text-[15] text-[#050505]">{{ $post['text'] }}</native:text>
                </native:column>

                {{-- Post Image --}}
                @if ($post['imageUrl'])
                    <native:column @press="viewPost({{ $index }})" class="w-full pt-3">
                        <native:image
                            src="{{ $post['imageUrl'] }}"
                            class="w-full h-[250]"
                            :fit="2"
                        />
                    </native:column>
                @endif

                {{-- Reaction Counts --}}
                <native:row class="w-full px-4 pt-2 pb-2 items-center justify-between">
                    <native:row class="items-center gap-1">
                        <native:icon name="thumb_up" :size="14" color="#1877F2" />
                        <native:text class="text-[13] text-[#65676B]">{{ $post['reactionsFormatted'] }}</native:text>
                    </native:row>
                    <native:row class="items-center gap-3">
                        <native:text class="text-[13] text-[#65676B]">{{ $post['comments'] }} comments</native:text>
                        <native:text class="text-[13] text-[#65676B]">{{ $post['shares'] }} shares</native:text>
                    </native:row>
                </native:row>

                <native:divider class="w-full mx-4" />

                {{-- Action Bar --}}
                <native:row class="w-full px-2 py-1 justify-between">
                    <native:row @press="toggleLike({{ $index }})" class="items-center gap-1 px-4 py-2">
                        <native:icon
                            name="{{ $post['isLiked'] ? 'thumb_up' : 'thumb_up_off_alt' }}"
                            :size="20"
                            color="{{ $post['isLiked'] ? '#1877F2' : '#65676B' }}"
                        />
                        <native:text class="text-[13] font-semibold text-{{ $post['isLiked'] ? '[#1877F2]' : '[#65676B]' }}">Like</native:text>
                    </native:row>
                    <native:row @press="viewPost({{ $index }})" class="items-center gap-1 px-4 py-2">
                        <native:icon name="chat_bubble_outline" :size="20" color="#65676B" />
                        <native:text class="text-[13] font-semibold text-[#65676B]">Comment</native:text>
                    </native:row>
                    <native:row class="items-center gap-1 px-4 py-2">
                        <native:icon name="share" :size="20" color="#65676B" />
                        <native:text class="text-[13] font-semibold text-[#65676B]">Share</native:text>
                    </native:row>
                </native:row>
            </native:column>
        @endforeach

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
