<native:scroll-view class="w-full h-full bg-[#F0F2F5] safe-area">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full bg-white px-4 py-3 items-center gap-3">
            <native:column @press="back" class="w-[32] h-[32] rounded-full bg-[#E4E6EB] items-center justify-center">
                <native:icon name="arrow_back" :size="20" color="#050505" />
            </native:column>
            <native:text class="text-[18] font-bold text-[#050505]">{{ $user['name'] }}</native:text>
        </native:row>

        {{-- Cover Photo --}}
        <native:image
            src="{{ $user['coverUrl'] }}"
            class="w-full h-[160]"
            :fit="2"
        />

        {{-- Profile Info Card --}}
        <native:column class="w-full bg-white px-4 pt-3 pb-4 gap-2">
            {{-- Avatar + Name --}}
            <native:row class="w-full items-end gap-3">
                <native:image
                    src="{{ $user['avatarUrl'] }}"
                    class="w-[80] h-[80] rounded-full mt-[-40]"
                    :fit="2"
                />
                <native:column class="pb-1">
                    <native:text class="text-[22] font-bold text-[#050505]">{{ $user['name'] }}</native:text>
                </native:column>
            </native:row>

            {{-- Bio --}}
            <native:text class="text-[15] text-[#050505]">{{ $user['bio'] }}</native:text>

            {{-- Details --}}
            <native:row class="items-center gap-2">
                <native:icon name="work" :size="16" color="#65676B" />
                <native:text class="text-[14] text-[#65676B]">{{ $user['work'] }}</native:text>
            </native:row>
            <native:row class="items-center gap-2">
                <native:icon name="location_on" :size="16" color="#65676B" />
                <native:text class="text-[14] text-[#65676B]">Lives in {{ $user['location'] }}</native:text>
            </native:row>
            <native:row class="items-center gap-2">
                <native:icon name="people" :size="16" color="#65676B" />
                <native:text class="text-[14] text-[#65676B]">{{ $friendsFormatted }} friends</native:text>
            </native:row>

            {{-- Action Buttons --}}
            <native:row class="w-full gap-2 pt-2">
                <native:button label="Add Friend" color="#1877F2" labelColor="#FFFFFF" :fontSize="14" />
                <native:button label="Message" color="#E4E6EB" labelColor="#050505" :fontSize="14" />
            </native:row>
        </native:column>

        {{-- Tabs --}}
        <native:column class="w-full bg-white mt-2">
            <native:tab-row :selectedIndex="$selectedTab" @change="selectTab">
                <native:tab label="Posts" />
                <native:tab label="About" />
                <native:tab label="Photos" />
            </native:tab-row>
        </native:column>

        {{-- User Posts --}}
        @foreach ($postsWithMeta as $post)
            <native:column class="w-full bg-white mt-2">
                {{-- Post Header --}}
                <native:row class="w-full px-4 pt-3 items-center gap-3">
                    <native:image
                        src="{{ $post['user']['avatarUrl'] }}"
                        class="w-[40] h-[40] rounded-full"
                        :fit="2"
                    />
                    <native:column class="flex-1">
                        <native:text class="text-[14] font-bold text-[#050505]" :maxLines="1">{{ $post['user']['name'] }}</native:text>
                        <native:text class="text-[12] text-[#65676B]" :maxLines="1">{{ $post['time'] }} ago · 🌐</native:text>
                    </native:column>
                </native:row>

                {{-- Post Text --}}
                <native:column @press="viewPost({{ $post['originalIndex'] }})" class="w-full px-4 pt-2">
                    <native:text class="text-[15] text-[#050505]">{{ $post['text'] }}</native:text>
                </native:column>

                {{-- Post Image --}}
                @if ($post['imageUrl'])
                    <native:column @press="viewPost({{ $post['originalIndex'] }})" class="w-full pt-3">
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
                    </native:row>
                </native:row>

                <native:divider class="w-full mx-4" />

                {{-- Action Bar --}}
                <native:row class="w-full px-2 py-1 justify-between">
                    <native:row class="items-center gap-1 px-4 py-2">
                        <native:icon name="thumb_up_off_alt" :size="20" color="#65676B" />
                        <native:text class="text-[13] font-semibold text-[#65676B]">Like</native:text>
                    </native:row>
                    <native:row @press="viewPost({{ $post['originalIndex'] }})" class="items-center gap-1 px-4 py-2">
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

        @if (count($postsWithMeta) === 0)
            <native:column class="w-full bg-white mt-2 items-center py-8">
                <native:text class="text-[15] text-[#65676B]">No posts to show</native:text>
            </native:column>
        @endif

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
