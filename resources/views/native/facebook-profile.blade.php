<scroll-view class="w-full h-full bg-[#F0F2F5] safe-area">
    <column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <row class="w-full bg-white px-4 py-3 items-center gap-3">
            <column @press="back" a11y-label="Back" class="w-[32] h-[32] rounded-full bg-[#E4E6EB] items-center justify-center">
                <icon name="arrow_back" :size="20" color="#050505" />
            </column>
            <text class="text-[18] font-bold text-[#050505]">{{ $user['name'] }}</text>
        </row>

        {{-- Cover Photo --}}
        <image
            src="{{ $user['coverUrl'] }}"
            alt="{{ $user['name'] }}'s cover photo"
            class="w-full h-[160]"
            :fit="2"
        />

        {{-- Profile Info Card --}}
        <column class="w-full bg-white px-4 pt-3 pb-4 gap-2">
            {{-- Avatar + Name --}}
            <row class="w-full items-end gap-3">
                <image
                    src="{{ $user['avatarUrl'] }}"
                    alt="{{ $user['name'] }}"
                    class="w-[80] h-[80] rounded-full mt-[-40]"
                    :fit="2"
                />
                <column class="pb-1">
                    <text class="text-[22] font-bold text-[#050505]">{{ $user['name'] }}</text>
                </column>
            </row>

            {{-- Bio --}}
            <text class="text-[15] text-[#050505]">{{ $user['bio'] }}</text>

            {{-- Details --}}
            <row class="items-center gap-2">
                <icon name="work" :size="16" color="#65676B" />
                <text class="text-[14] text-[#65676B]">{{ $user['work'] }}</text>
            </row>
            <row class="items-center gap-2">
                <icon name="location_on" :size="16" color="#65676B" />
                <text class="text-[14] text-[#65676B]">Lives in {{ $user['location'] }}</text>
            </row>
            <row class="items-center gap-2">
                <icon name="people" :size="16" color="#65676B" />
                <text class="text-[14] text-[#65676B]">{{ $friendsFormatted }} friends</text>
            </row>

            {{-- Action Buttons --}}
            <row class="w-full gap-2 pt-2">
                <button label="Add Friend" color="#1877F2" labelColor="#FFFFFF" :fontSize="14" />
                <button label="Message" color="#E4E6EB" labelColor="#050505" :fontSize="14" />
            </row>
        </column>

        {{-- Tabs --}}
        <column class="w-full bg-white mt-2">
            <tab-row :selectedIndex="$selectedTab" @change="selectTab">
                <tab label="Posts" />
                <tab label="About" />
                <tab label="Photos" />
            </tab-row>
        </column>

        {{-- User Posts --}}
        @foreach ($postsWithMeta as $post)
            <column class="w-full bg-white mt-2">
                {{-- Post Header --}}
                <row class="w-full px-4 pt-3 items-center gap-3">
                    <image
                        src="{{ $post['user']['avatarUrl'] }}"
                        alt="{{ $post['user']['name'] }}"
                        class="w-[40] h-[40] rounded-full"
                        :fit="2"
                    />
                    <column class="flex-1">
                        <text class="text-[14] font-bold text-[#050505]" :maxLines="1">{{ $post['user']['name'] }}</text>
                        <text class="text-[12] text-[#65676B]" :maxLines="1">{{ $post['time'] }} ago · 🌐</text>
                    </column>
                </row>

                {{-- Post Text --}}
                <column @press="viewPost({{ $post['originalIndex'] }})" class="w-full px-4 pt-2">
                    <text class="text-[15] text-[#050505]">{{ $post['text'] }}</text>
                </column>

                {{-- Post Image --}}
                @if ($post['imageUrl'])
                    <column @press="viewPost({{ $post['originalIndex'] }})" class="w-full pt-3">
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
                    </row>
                </row>

                <divider class="w-full mx-4" />

                {{-- Action Bar --}}
                <row class="w-full px-2 py-1 justify-between">
                    <row class="items-center gap-1 px-4 py-2">
                        <icon name="thumb_up_off_alt" :size="20" color="#65676B" />
                        <text class="text-[13] font-semibold text-[#65676B]">Like</text>
                    </row>
                    <row @press="viewPost({{ $post['originalIndex'] }})" class="items-center gap-1 px-4 py-2">
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

        @if (count($postsWithMeta) === 0)
            <column class="w-full bg-white mt-2 items-center py-8">
                <text class="text-[15] text-[#65676B]">No posts to show</text>
            </column>
        @endif

        <spacer class="h-[20]" />

    </column>
</scroll-view>
