<native:scroll-view class="w-full h-full bg-white safe-area">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full px-4 py-3 items-center justify-between">
            <native:row class="items-center gap-2">
                <native:column @press="back" class="w-[32] h-[32] items-center justify-center">
                    <native:icon name="arrow_back" :size="24" color="#262626" />
                </native:column>
                <native:row class="items-center gap-1">
                    <native:text class="text-[18] font-bold text-[#262626]">{{ $user['username'] }}</native:text>
                    @if ($user['isVerified'])
                        <native:icon name="verified" :size="16" color="#3897F0" />
                    @endif
                </native:row>
            </native:row>
            <native:icon name="more_horiz" :size="24" color="#262626" />
        </native:row>

        {{-- Profile Header — gradient classes don't render natively;
             fall back to a solid Instagram-pink ring around the avatar. --}}
        <native:row class="w-full px-4 pt-2 items-center gap-5">
            {{-- Avatar — 4-px Instagram-pink ring matches the feed stories. --}}
            <native:column class="w-[88] h-[88] rounded-full bg-[#DD2A7B] items-center justify-center">
                <native:column class="w-[80] h-[80] rounded-full bg-white items-center justify-center">
                    <native:image
                        src="{{ $user['avatarUrl'] }}"
                        class="w-[76] h-[76] rounded-full"
                        :fit="2"
                    />
                </native:column>
            </native:column>

            {{-- Stats — flex-1 row so each column splits remaining width evenly. --}}
            <native:row class="flex-1 items-center justify-around">
                <native:column class="items-center">
                    <native:text class="text-[16] font-bold text-[#262626]">{{ $postsFormatted }}</native:text>
                    <native:text class="text-[13] text-[#262626]">Posts</native:text>
                </native:column>
                <native:column class="items-center">
                    <native:text class="text-[16] font-bold text-[#262626]">{{ $followersFormatted }}</native:text>
                    <native:text class="text-[13] text-[#262626]">Followers</native:text>
                </native:column>
                <native:column class="items-center">
                    <native:text class="text-[16] font-bold text-[#262626]">{{ $followingFormatted }}</native:text>
                    <native:text class="text-[13] text-[#262626]">Following</native:text>
                </native:column>
            </native:row>
        </native:row>

        {{-- Bio --}}
        <native:column class="w-full px-4 pt-3 gap-1">
            <native:text class="text-[14] font-bold text-[#262626]">{{ $user['displayName'] }}</native:text>
            <native:text class="text-[14] text-[#262626]">{{ $user['bio'] }}</native:text>
            @if ($user['website'])
                <native:text class="text-[14] font-semibold text-[#00376B]">{{ $user['website'] }}</native:text>
            @endif
        </native:column>

        {{-- Action Buttons --}}
        <native:row class="w-full px-4 pt-3 gap-2">
            <native:button label="Follow" color="#3897F0" labelColor="#FFFFFF" :fontSize="14" />
            <native:button label="Message" color="#EFEFEF" labelColor="#262626" :fontSize="14" />
        </native:row>

        {{-- Story Highlights --}}
        <native:scroll-view horizontal class="pt-3">
            <native:row class="gap-4 px-4 pb-3">
                @foreach ($highlights as $highlight)
                    <native:column class="items-center gap-1 w-[64]">
                        <native:column class="w-[58] h-[58] rounded-full bg-[#EFEFEF] items-center justify-center">
                            <native:icon name="auto_awesome" :size="24" color="#8E8E8E" />
                        </native:column>
                        <native:text class="text-[11] text-[#262626]">{{ $highlight }}</native:text>
                    </native:column>
                @endforeach
            </native:row>
        </native:scroll-view>

        <native:divider class="w-full" />

        {{-- Grid / List Toggle --}}
        <native:row class="w-full justify-center py-2 gap-10">
            <native:icon name="grid_on" :size="24" color="#262626" />
            <native:icon name="person_pin" :size="24" color="#8E8E8E" />
        </native:row>

        <native:divider class="w-full" />

        {{-- Photo Grid --}}
        <native:column class="w-full gap-1 pb-4">
            @foreach (array_chunk($postsWithIndex, 3) as $row)
                <native:row class="w-full gap-1 justify-start">
                    @foreach ($row as $post)
                        <native:column @press="viewPost({{ $post['originalIndex'] }})">
                            <native:image
                                src="{{ $post['imageUrl'] }}"
                                class="w-[125] h-[125]"
                                :fit="2"
                            />
                        </native:column>
                    @endforeach
                </native:row>
            @endforeach
        </native:column>

        @if (count($postsWithIndex) === 0)
            <native:column class="w-full items-center py-8 gap-2">
                <native:icon name="camera_alt" :size="48" color="#8E8E8E" />
                <native:text class="text-[15] text-[#8E8E8E]">No posts yet</native:text>
            </native:column>
        @endif

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
