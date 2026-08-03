<scroll-view class="w-full h-full bg-theme-surface safe-area">
    <column class="w-full gap-0">

        {{-- Top Bar --}}
        <row class="w-full px-4 py-3 items-center justify-between">
            <row class="items-center gap-2">
                <pressable @tap="back" a11y-label="Back" class="w-[32] h-[32] items-center justify-center">
                    <icon name="arrow_back" :size="24" class="text-theme-on-surface" />
                </pressable>
                <row class="items-center gap-1">
                    <text class="text-[18] font-bold text-theme-on-surface">{{ $user['username'] }}</text>
                    @if ($user['isVerified'])
                        <icon name="verified" :size="16" color="#3897F0" />
                    @endif
                </row>
            </row>
            <icon name="more_horiz" :size="24" class="text-theme-on-surface" />
        </row>

        {{-- Profile Header — gradient classes don't render natively;
             fall back to a solid Instagram-pink ring around the avatar. --}}
        <row class="w-full px-4 pt-2 items-center gap-5">
            <column class="w-[92] h-[92] rounded-full bg-[#DD2A7B] items-center justify-center">
                <column class="w-[84] h-[84] rounded-full bg-theme-surface items-center justify-center">
                    <image
                        src="{{ $user['avatarUrl'] }}"
                        alt="{{ $user['username'] }}"
                        class="w-[80] h-[80] rounded-full"
                        :fit="2"
                    />
                </column>
            </column>

            {{-- Stats — flex-1 row so each column splits remaining width evenly. --}}
            <row class="flex-1 items-center justify-around">
                <column class="items-center">
                    <text class="text-[17] font-bold text-theme-on-surface">{{ $postsFormatted }}</text>
                    <text class="text-[13] text-theme-on-surface">posts</text>
                </column>
                <column class="items-center">
                    <text class="text-[17] font-bold text-theme-on-surface">{{ $followersFormatted }}</text>
                    <text class="text-[13] text-theme-on-surface">followers</text>
                </column>
                <column class="items-center">
                    <text class="text-[17] font-bold text-theme-on-surface">{{ $followingFormatted }}</text>
                    <text class="text-[13] text-theme-on-surface">following</text>
                </column>
            </row>
        </row>

        {{-- Bio --}}
        <column class="w-full px-4 pt-3 gap-1">
            <text class="text-[14] font-bold text-theme-on-surface">{{ $user['displayName'] }}</text>
            <text class="text-[14] text-theme-on-surface">{{ $user['bio'] }}</text>
            @if ($user['website'])
                <row class="items-center gap-1">
                    <icon name="link" :size="14" class="text-[#00376B] dark:text-[#E0F1FF]" />
                    <text class="text-[14] font-semibold text-[#00376B] dark:text-[#E0F1FF]">{{ $user['website'] }}</text>
                </row>
            @endif
        </column>

        {{-- Action Buttons --}}
        <row class="w-full px-4 pt-3 gap-2">
            <pressable @tap="toggleFollow" a11y-label="{{ $isFollowing ? 'Unfollow' : 'Follow' }}" class="flex-1 py-2 rounded-lg items-center {{ $isFollowing ? 'bg-theme-surface-variant' : 'bg-[#0095F6]' }}">
                <text class="text-[14] font-semibold {{ $isFollowing ? 'text-theme-on-surface' : 'text-white' }}">{{ $isFollowing ? 'Following' : 'Follow' }}</text>
            </pressable>
            <column class="flex-1 py-2 rounded-lg items-center bg-theme-surface-variant">
                <text class="text-[14] font-semibold text-theme-on-surface">Message</text>
            </column>
            <column class="px-3 py-2 rounded-lg items-center bg-theme-surface-variant">
                <icon name="person_add" :size="18" class="text-theme-on-surface" />
            </column>
        </row>

        {{-- Story Highlights --}}
        <scroll-view horizontal class="pt-3">
            <row class="gap-4 px-4 pb-3">
                @foreach ($highlights as $highlight)
                    <column class="items-center gap-1 w-[64]">
                        <column class="w-[60] h-[60] rounded-full border border-theme-outline bg-theme-surface-variant items-center justify-center">
                            <icon name="auto_awesome" :size="24" class="text-theme-on-surface-variant" />
                        </column>
                        <text class="text-[11] text-theme-on-surface">{{ $highlight }}</text>
                    </column>
                @endforeach
            </row>
        </scroll-view>

        <divider class="w-full" />

        {{-- Grid / Reels / Tagged toggle --}}
        <row class="w-full justify-around py-2">
            <icon name="grid_on" :size="24" class="text-theme-on-surface" />
            <icon name="video_library" :size="24" class="text-theme-on-surface-variant" />
            <icon name="person_pin" :size="24" class="text-theme-on-surface-variant" />
        </row>

        <divider class="w-full" />

        {{-- Photo Grid --}}
        <column class="w-full gap-[2] pb-4">
            @foreach (array_chunk($postsWithIndex, 3) as $row)
                <row class="w-full gap-[2]">
                    @foreach ($row as $post)
                        <pressable @tap="viewPost({{ $post['originalIndex'] }})" class="flex-1" a11y-label="View post">
                            <image
                                src="{{ $post['imageUrl'] }}"
                                alt="Photo by {{ $user['username'] }}: {{ \Illuminate\Support\Str::limit($post['caption'] ?? '', 60) }}"
                                class="w-full h-[130]"
                                :fit="2"
                            />
                        </pressable>
                    @endforeach
                    @for ($i = count($row); $i < 3; $i++)
                        <column class="flex-1" />
                    @endfor
                </row>
            @endforeach
        </column>

        @if (count($postsWithIndex) === 0)
            <column class="w-full items-center py-10 gap-2">
                <column class="w-[72] h-[72] rounded-full border border-theme-outline items-center justify-center">
                    <icon name="camera_alt" :size="36" class="text-theme-on-surface" />
                </column>
                <text class="text-[20] font-bold text-theme-on-surface">No posts yet</text>
            </column>
        @endif

        <spacer class="h-[20]" />

    </column>
</scroll-view>
