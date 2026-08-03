<scroll-view class="w-full h-full bg-theme-background safe-area">
    <column class="w-full gap-0">

        {{-- Top Bar --}}
        <row class="w-full bg-theme-surface px-4 py-3 items-center gap-3">
            <pressable @tap="back" a11y-label="Back" class="w-[32] h-[32] rounded-full bg-theme-surface-variant items-center justify-center">
                <icon name="arrow_back" :size="20" class="text-theme-on-surface" />
            </pressable>
            <text class="text-[17] font-bold text-theme-on-surface" :maxLines="1">{{ $user['name'] }}</text>
        </row>

        {{-- Cover + overlapping avatar. A negative top margin
             (`mt-[-44]`) can't do this overlap: the flex renderers shrink
             the avatar's flow slot but still draw it full size, so
             following content (the bio) rides up into the avatar's lower
             half. Stack layering instead, with the same conventions as
             twitter-profile: bottom/right anchors need a NON-ZERO inset
             (`bottom-0` reads as "unset" and pins to the top), and zero
             opposing insets don't stretch — so the avatar row anchors from
             the top with a computed offset and an explicit width. --}}
        <column class="w-full bg-theme-surface">
            <stack class="w-full">
                {{-- Cover layer — sizes the stack: 160 cover + 52 for the
                     avatar's below-cover half. The strut needs
                     flex-grow-0: spacer defaults to flex_grow=1, and the
                     flex measurer sizes ANY grow child at 0 under the
                     indefinite proposal a stack measures its layers with —
                     the fixed height only sticks on a non-grow child. --}}
                <column class="w-full">
                    <image
                        src="{{ $user['coverUrl'] }}"
                        alt="{{ $user['name'] }}'s cover photo"
                        class="w-full h-[160]"
                        :fit="2"
                    />
                    <spacer class="h-[52] flex-grow-0" />
                </column>

                {{-- Avatar + name row: 96 tall (88 avatar + 4 ring pad each
                     side), top inset 116 = 212 stack − 96 row → flush with
                     the stack bottom, overlapping the cover by 44. --}}
                <row class="absolute top-[116] w-full px-4 items-end gap-3">
                    <column class="p-[4] bg-theme-surface rounded-full">
                        <image
                            src="{{ $user['avatarUrl'] }}"
                            alt="{{ $user['name'] }}"
                            class="w-[88] h-[88] rounded-full"
                            :fit="2"
                        />
                    </column>
                    <column class="pb-1 flex-1">
                        <text class="text-[22] font-bold text-theme-on-surface" :maxLines="1">{{ $user['name'] }}</text>
                        <text class="text-[14] text-[#65676B] dark:text-[#B0B3B8]">{{ $friendsFormatted }} friends</text>
                    </column>
                </row>
            </stack>

            <column class="w-full px-4 pb-4 gap-2">
                {{-- Bio --}}
                <text class="text-[15] text-theme-on-surface">{{ $user['bio'] }}</text>

                {{-- Action Buttons --}}
                <row class="w-full gap-2 pt-1">
                    <row @tap="toggleFriendRequest" a11y-label="{{ $friendRequested ? 'Cancel friend request' : 'Add friend' }}" class="flex-1 py-2 rounded-lg items-center justify-center gap-1 {{ $friendRequested ? 'bg-theme-surface-variant' : 'bg-[#1877F2]' }}">
                        <icon name="{{ $friendRequested ? 'check' : 'person' }}" :size="16" class="{{ $friendRequested ? 'text-theme-on-surface' : 'text-white' }}" />
                        <text class="text-[14] font-semibold {{ $friendRequested ? 'text-theme-on-surface' : 'text-white' }}">{{ $friendRequested ? 'Requested' : 'Add friend' }}</text>
                    </row>
                    <column class="flex-1 py-2 rounded-lg items-center bg-theme-surface-variant">
                        <row class="items-center gap-1">
                            <icon name="chat" :size="16" class="text-theme-on-surface" />
                            <text class="text-[14] font-semibold text-theme-on-surface">Message</text>
                        </row>
                    </column>
                    <column class="px-3 py-2 rounded-lg items-center justify-center bg-theme-surface-variant">
                        <icon name="more_horiz" :size="18" class="text-theme-on-surface" />
                    </column>
                </row>
            </column>
        </column>

        {{-- Tabs --}}
        <column class="w-full bg-theme-surface mt-2">
            <tab-row :selectedIndex="$selectedTab" @change="selectTab">
                <tab label="Posts" />
                <tab label="About" />
                <tab label="Photos" />
            </tab-row>
        </column>

        @if ($selectedTab === 0)
            {{-- User Posts --}}
            @foreach ($postsWithMeta as $post)
                <column class="w-full bg-theme-surface mt-2">
                    {{-- Post Header --}}
                    <row class="w-full px-4 pt-3 items-center gap-3">
                        <image
                            src="{{ $post['user']['avatarUrl'] }}"
                            alt="{{ $post['user']['name'] }}"
                            class="w-[40] h-[40] rounded-full"
                            :fit="2"
                        />
                        <column class="flex-1">
                            <text class="text-[15] font-bold text-theme-on-surface" :maxLines="1">{{ $post['user']['name'] }}</text>
                            <row class="items-center gap-1">
                                <text class="text-[12] text-[#65676B] dark:text-[#B0B3B8]">{{ $post['time'] }} ago ·</text>
                                <icon name="globe" :size="12" class="text-[#65676B] dark:text-[#B0B3B8]" />
                            </row>
                        </column>
                    </row>

                    {{-- Post Text --}}
                    <pressable @tap="viewPost({{ $post['originalIndex'] }})" class="w-full">
                        <column class="w-full px-4 pt-2">
                            <text class="text-[15] text-theme-on-surface">{{ $post['text'] }}</text>
                        </column>
                    </pressable>

                    {{-- Post Image --}}
                    @if ($post['imageUrl'])
                        <pressable @tap="viewPost({{ $post['originalIndex'] }})" class="w-full">
                            <column class="w-full pt-3">
                                <image
                                    src="{{ $post['imageUrl'] }}"
                                    alt="Photo by {{ $post['user']['name'] }}"
                                    class="w-full h-[250]"
                                    :fit="2"
                                />
                            </column>
                        </pressable>
                    @endif

                    {{-- Reaction Summary --}}
                    <row class="w-full px-4 pt-2 pb-2 items-center justify-between">
                        <row class="items-center gap-1">
                            <column class="w-[18] h-[18] rounded-full bg-[#1877F2] items-center justify-center">
                                <icon name="thumb_up" :size="10" color="#FFFFFF" />
                            </column>
                            <text class="text-[13] text-[#65676B] dark:text-[#B0B3B8]" :maxLines="1">{{ $post['reactionsFormatted'] }}</text>
                        </row>
                        <text class="text-[13] text-[#65676B] dark:text-[#B0B3B8]">{{ $post['comments'] }} comments</text>
                    </row>

                    <divider class="w-full mx-4" />

                    {{-- Action Bar --}}
                    <row class="w-full px-2 py-1 justify-between">
                        <row class="items-center gap-1 px-4 py-2 flex-shrink-0">
                            <icon name="thumb_up_off_alt" :size="20" class="text-[#65676B] dark:text-[#B0B3B8]" />
                            <text class="text-[13] font-semibold text-[#65676B] dark:text-[#B0B3B8]">Like</text>
                        </row>
                        <row @tap="viewPost({{ $post['originalIndex'] }})" a11y-label="Comment" class="items-center gap-1 px-4 py-2 flex-shrink-0">
                            <icon name="chat_bubble_outline" :size="20" class="text-[#65676B] dark:text-[#B0B3B8]" />
                            <text class="text-[13] font-semibold text-[#65676B] dark:text-[#B0B3B8]">Comment</text>
                        </row>
                        <row class="items-center gap-1 px-4 py-2 flex-shrink-0">
                            <icon name="share" :size="20" class="text-[#65676B] dark:text-[#B0B3B8]" />
                            <text class="text-[13] font-semibold text-[#65676B] dark:text-[#B0B3B8]">Share</text>
                        </row>
                    </row>
                </column>
            @endforeach

            @if (count($postsWithMeta) === 0)
                <column class="w-full bg-theme-surface mt-2 items-center py-8">
                    <text class="text-[15] text-[#65676B] dark:text-[#B0B3B8]">No posts to show</text>
                </column>
            @endif
        @elseif ($selectedTab === 1)
            {{-- About --}}
            <column class="w-full bg-theme-surface mt-2 px-4 py-4 gap-3">
                <text class="text-[17] font-bold text-theme-on-surface">Details</text>
                <row class="items-center gap-3">
                    <icon name="inventory" :size="18" class="text-[#65676B] dark:text-[#B0B3B8]" />
                    <text class="text-[14] text-theme-on-surface">{{ $user['work'] }}</text>
                </row>
                <row class="items-center gap-3">
                    <icon name="home" :size="18" class="text-[#65676B] dark:text-[#B0B3B8]" />
                    <text class="text-[14] text-theme-on-surface">Lives in {{ $user['location'] }}</text>
                </row>
                <row class="items-center gap-3">
                    <icon name="person" :size="18" class="text-[#65676B] dark:text-[#B0B3B8]" />
                    <text class="text-[14] text-theme-on-surface">{{ $friendsFormatted }} friends</text>
                </row>
                <row class="items-center gap-3">
                    <icon name="clock" :size="18" class="text-[#65676B] dark:text-[#B0B3B8]" />
                    <text class="text-[14] text-theme-on-surface">Joined June 2012</text>
                </row>
            </column>
        @else
            {{-- Photos --}}
            <column class="w-full bg-theme-surface mt-2 px-4 py-4 gap-3">
                <text class="text-[17] font-bold text-theme-on-surface">Photos</text>
                <column class="w-full gap-[2]">
                    @foreach (array_chunk($photos, 3) as $photoRow)
                        <row class="w-full gap-[2]">
                            @foreach ($photoRow as $photoUrl)
                                <column class="flex-1">
                                    <image
                                        src="{{ $photoUrl }}"
                                        alt="Photo by {{ $user['name'] }}"
                                        class="w-full h-[110] rounded-lg"
                                        :fit="2"
                                    />
                                </column>
                            @endforeach
                            @for ($i = count($photoRow); $i < 3; $i++)
                                <column class="flex-1" />
                            @endfor
                        </row>
                    @endforeach
                </column>
            </column>
        @endif

        <spacer class="h-[20]" />

    </column>
</scroll-view>

