<scroll-view class="w-full h-full bg-white safe-area">
    <column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <row class="w-full px-4 py-3 items-center justify-between">
            <row class="items-center gap-2">
                <column @press="back" a11y-label="Back" class="w-[32] h-[32] items-center justify-center">
                    <icon name="arrow_back" :size="24" color="#262626" />
                </column>
                <row class="items-center gap-1">
                    <text class="text-[18] font-bold text-[#262626]">{{ $user['username'] }}</text>
                    @if ($user['isVerified'])
                        <icon name="verified" :size="16" color="#3897F0" />
                    @endif
                </row>
            </row>
            <icon name="more_horiz" :size="24" color="#262626" />
        </row>

        {{-- Profile Header — gradient classes don't render natively;
             fall back to a solid Instagram-pink ring around the avatar. --}}
        <row class="w-full px-4 pt-2 items-center gap-5">
            {{-- Avatar — 4-px Instagram-pink ring matches the feed stories. --}}
            <column class="w-[88] h-[88] rounded-full bg-[#DD2A7B] items-center justify-center">
                <column class="w-[80] h-[80] rounded-full bg-white items-center justify-center">
                    <image
                        src="{{ $user['avatarUrl'] }}"
                        alt="{{ $user['username'] }}"
                        class="w-[76] h-[76] rounded-full"
                        :fit="2"
                    />
                </column>
            </column>

            {{-- Stats — flex-1 row so each column splits remaining width evenly. --}}
            <row class="flex-1 items-center justify-around">
                <column class="items-center">
                    <text class="text-[16] font-bold text-[#262626]">{{ $postsFormatted }}</text>
                    <text class="text-[13] text-[#262626]">Posts</text>
                </column>
                <column class="items-center">
                    <text class="text-[16] font-bold text-[#262626]">{{ $followersFormatted }}</text>
                    <text class="text-[13] text-[#262626]">Followers</text>
                </column>
                <column class="items-center">
                    <text class="text-[16] font-bold text-[#262626]">{{ $followingFormatted }}</text>
                    <text class="text-[13] text-[#262626]">Following</text>
                </column>
            </row>
        </row>

        {{-- Bio --}}
        <column class="w-full px-4 pt-3 gap-1">
            <text class="text-[14] font-bold text-[#262626]">{{ $user['displayName'] }}</text>
            <text class="text-[14] text-[#262626]">{{ $user['bio'] }}</text>
            @if ($user['website'])
                <text class="text-[14] font-semibold text-[#00376B]">{{ $user['website'] }}</text>
            @endif
        </column>

        {{-- Action Buttons --}}
        <row class="w-full px-4 pt-3 gap-2">
            <button label="Follow" color="#3897F0" labelColor="#FFFFFF" :fontSize="14" />
            <button label="Message" color="#EFEFEF" labelColor="#262626" :fontSize="14" />
        </row>

        {{-- Story Highlights --}}
        <scroll-view horizontal class="pt-3">
            <row class="gap-4 px-4 pb-3">
                @foreach ($highlights as $highlight)
                    <column class="items-center gap-1 w-[64]">
                        <column class="w-[58] h-[58] rounded-full bg-[#EFEFEF] items-center justify-center">
                            <icon name="auto_awesome" :size="24" color="#8E8E8E" />
                        </column>
                        <text class="text-[11] text-[#262626]">{{ $highlight }}</text>
                    </column>
                @endforeach
            </row>
        </scroll-view>

        <divider class="w-full" />

        {{-- Grid / List Toggle --}}
        <row class="w-full justify-center py-2 gap-10">
            <icon name="grid_on" :size="24" color="#262626" />
            <icon name="person_pin" :size="24" color="#8E8E8E" />
        </row>

        <divider class="w-full" />

        {{-- Photo Grid --}}
        <column class="w-full gap-1 pb-4">
            @foreach (array_chunk($postsWithIndex, 3) as $row)
                <row class="w-full gap-1 justify-start">
                    @foreach ($row as $post)
                        <column @press="viewPost({{ $post['originalIndex'] }})">
                            <image
                                src="{{ $post['imageUrl'] }}"
                                alt="Photo by {{ $user['username'] }}: {{ \Illuminate\Support\Str::limit($post['caption'] ?? '', 60) }}"
                                class="w-[125] h-[125]"
                                :fit="2"
                            />
                        </column>
                    @endforeach
                </row>
            @endforeach
        </column>

        @if (count($postsWithIndex) === 0)
            <column class="w-full items-center py-8 gap-2">
                <icon name="camera_alt" :size="48" color="#8E8E8E" />
                <text class="text-[15] text-[#8E8E8E]">No posts yet</text>
            </column>
        @endif

        <spacer class="h-[20]" />

    </column>
</scroll-view>
