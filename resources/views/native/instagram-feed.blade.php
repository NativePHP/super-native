{{-- @include('native.partials.demo-nav', ['title' => 'Instagram']) --}}

{{-- Header is provided by the framework NavBar (StackLayout) — back arrow + "Instagram" title.
     Action icons (heart, chat) move into navigationOptions() on the screen if needed. --}}

<scroll-view class="w-full h-full bg-white">
    <column class="w-full gap-0 ">

        {{-- Stories --}}
        <scroll-view horizontal>
            <row class="gap-3 px-4 pb-3">
                {{-- Your Story --}}
                <column class="items-center gap-1 w-[72]">
                    <column class="w-[68] h-[68] rounded-full bg-[#DBDBDB] items-center justify-center">
                        <image
                            src="https://i.pravatar.cc/150?u=igcurrent"
                            alt="Your story"
                            class="w-[60] h-[60] rounded-full"
                            :fit="2"
                        />
                    </column>
                    <text class="text-[11] text-[#262626]">Your story</text>
                </column>
                {{-- Other Stories — `linear-gradient` via inline style doesn't
                     render natively; use a chunky 4-px Instagram-pink ring
                     as a single-color approximation of the gradient. --}}
                @foreach ($stories as $story)
                    <column @press="viewProfile({{ array_search($story, $stories) }})" class="items-center gap-1 w-[72]">
                        <column class="w-[68] h-[68] rounded-full bg-[#DD2A7B] items-center justify-center">
                            <column class="w-[60] h-[60] rounded-full bg-white items-center justify-center">
                                <image
                                    src="{{ $story['avatarUrl'] }}"
                                    alt="{{ $story['username'] }}'s story"
                                    class="w-[56] h-[56] rounded-full"
                                    :fit="2"
                                />
                            </column>
                        </column>
                        <text class="text-[11] text-[#262626]" :maxLines="1">{{ explode('.', $story['username'])[0] }}</text>
                    </column>
                @endforeach
            </row>
        </scroll-view>

        <divider class="w-full" />

        {{-- Posts --}}
        @foreach ($posts as $index => $post)
            <column class="w-full">
                {{-- Post Header --}}
                <row class="w-full px-3 py-2 items-center gap-2">
                    <image
                        @press="viewProfile({{ $post['userId'] }})"
                        src="{{ $post['user']['avatarUrl'] }}"
                        alt="{{ $post['user']['username'] }}'s profile"
                        class="w-[32] h-[32] rounded-full"
                        :fit="2"
                    />
                    <column @press="viewProfile({{ $post['userId'] }})" class="flex-1">
                        <row class="items-center gap-1">
                            <text class="text-[13] font-bold text-[#262626]" :maxLines="1">{{ $post['user']['username'] }}</text>
                            @if ($post['user']['isVerified'])
                                <icon name="verified" :size="14" color="#3897F0" />
                            @endif
                        </row>
                        @if ($post['location'])
                            <text class="text-[11] text-[#262626]" :maxLines="1">{{ $post['location'] }}</text>
                        @endif
                    </column>
                    <icon name="more_horiz" :size="20" color="#262626" />
                </row>

                {{-- Post Image --}}
                <image
                    @press="viewPost({{ $index }})"
                    src="{{ $post['imageUrl'] }}"
                    alt="Photo by {{ $post['user']['username'] }}: {{ \Illuminate\Support\Str::limit($post['caption'], 60) }}"
                    class="w-full h-[375]"
                    :fit="2"
                />

                {{-- Action Bar --}}
                <row class="w-full px-3 mt-5 items-center justify-between">
                    <row class="items-center gap-4">
                        <column @press="toggleLike({{ $index }})" a11y-label="Like">
                            <icon
                                name="{{ $post['isLiked'] ? 'favorite' : 'favorite_border' }}"
                                :size="26"
                                color="{{ $post['isLiked'] ? '#ED4956' : '#262626' }}"
                            />
                        </column>
                        <column @press="viewPost({{ $index }})" a11y-label="Comments">
                            <icon name="chat_bubble_outline" :size="24" color="#262626" />
                        </column>
                        <icon name="send" :size="24" color="#262626" />
                    </row>
                    <column @press="toggleSave({{ $index }})" a11y-label="Save">
                        <icon
                            name="{{ $post['isSaved'] ? 'bookmark' : 'bookmark_border' }}"
                            :size="26"
                            color="#262626"
                        />
                    </column>
                </row>

                {{-- Likes --}}
                <column class="w-full px-3 pt-1">
                    <text class="text-[13] font-bold text-[#262626]">{{ $post['likesFormatted'] }} likes</text>
                </column>

                {{-- Caption --}}
                <column class="w-full px-3 pt-1 pb-1">
                    <text class="text-sm text-theme-on-surface"><text class="text-[13] font-bold text-[#262626]">{{ $post['user']['username'] }}</text> {{ $post['caption'] }}</text>
                </column>

                {{-- View Comments --}}
                @if ($post['commentCount'] > 0)
                    <column @press="viewPost({{ $index }})" class="w-full px-3 pb-1">
                        <text class="text-[13] text-[#8E8E8E]">View all {{ number_format($post['commentCount']) }} comments</text>
                    </column>
                @endif

                {{-- Time --}}
                <column class="w-full px-3 pb-3">
                    <text class="text-[11] text-[#8E8E8E]">{{ $post['time'] }} ago</text>
                </column>
            </column>
        @endforeach

        <spacer class="h-[20]" />

    </column>
</scroll-view>
