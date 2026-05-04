{{-- @include('native.partials.demo-nav', ['title' => 'Instagram']) --}}

{{-- Header is provided by the framework NavBar (StackLayout) — back arrow + "Instagram" title.
     Action icons (heart, chat) move into navigationOptions() on the screen if needed. --}}

<native:scroll-view class="w-full h-full bg-white">
    <native:column class="w-full gap-0 ">

        {{-- Stories --}}
        <native:scroll-view horizontal>
            <native:row class="gap-3 px-4 pb-3">
                {{-- Your Story --}}
                <native:column class="items-center gap-1 w-[72]">
                    <native:column class="w-[68] h-[68] rounded-full bg-[#DBDBDB] items-center justify-center">
                        <native:image
                            src="https://i.pravatar.cc/150?u=igcurrent"
                            class="w-[60] h-[60] rounded-full"
                            :fit="2"
                        />
                    </native:column>
                    <native:text class="text-[11] text-[#262626]">Your story</native:text>
                </native:column>
                {{-- Other Stories — `linear-gradient` via inline style doesn't
                     render natively; use a chunky 4-px Instagram-pink ring
                     as a single-color approximation of the gradient. --}}
                @foreach ($stories as $story)
                    <native:column @press="viewProfile({{ array_search($story, $stories) }})" class="items-center gap-1 w-[72]">
                        <native:column class="w-[68] h-[68] rounded-full bg-[#DD2A7B] items-center justify-center">
                            <native:column class="w-[60] h-[60] rounded-full bg-white items-center justify-center">
                                <native:image
                                    src="{{ $story['avatarUrl'] }}"
                                    class="w-[56] h-[56] rounded-full"
                                    :fit="2"
                                />
                            </native:column>
                        </native:column>
                        <native:text class="text-[11] text-[#262626]" :maxLines="1">{{ explode('.', $story['username'])[0] }}</native:text>
                    </native:column>
                @endforeach
            </native:row>
        </native:scroll-view>

        <native:divider class="w-full" />

        {{-- Posts --}}
        @foreach ($posts as $index => $post)
            <native:column class="w-full">
                {{-- Post Header --}}
                <native:row class="w-full px-3 py-2 items-center gap-2">
                    <native:image
                        @press="viewProfile({{ $post['userId'] }})"
                        src="{{ $post['user']['avatarUrl'] }}"
                        class="w-[32] h-[32] rounded-full"
                        :fit="2"
                    />
                    <native:column @press="viewProfile({{ $post['userId'] }})" class="flex-1">
                        <native:row class="items-center gap-1">
                            <native:text class="text-[13] font-bold text-[#262626]" :maxLines="1">{{ $post['user']['username'] }}</native:text>
                            @if ($post['user']['isVerified'])
                                <native:icon name="verified" :size="14" color="#3897F0" />
                            @endif
                        </native:row>
                        @if ($post['location'])
                            <native:text class="text-[11] text-[#262626]" :maxLines="1">{{ $post['location'] }}</native:text>
                        @endif
                    </native:column>
                    <native:icon name="more_horiz" :size="20" color="#262626" />
                </native:row>

                {{-- Post Image --}}
                <native:image
                    @press="viewPost({{ $index }})"
                    src="{{ $post['imageUrl'] }}"
                    class="w-full h-[375]"
                    :fit="2"
                />

                {{-- Action Bar --}}
                <native:row class="w-full px-3 mt-5 items-center justify-between">
                    <native:row class="items-center gap-4">
                        <native:column @press="toggleLike({{ $index }})">
                            <native:icon
                                name="{{ $post['isLiked'] ? 'favorite' : 'favorite_border' }}"
                                :size="26"
                                color="{{ $post['isLiked'] ? '#ED4956' : '#262626' }}"
                            />
                        </native:column>
                        <native:column @press="viewPost({{ $index }})">
                            <native:icon name="chat_bubble_outline" :size="24" color="#262626" />
                        </native:column>
                        <native:icon name="send" :size="24" color="#262626" />
                    </native:row>
                    <native:column @press="toggleSave({{ $index }})">
                        <native:icon
                            name="{{ $post['isSaved'] ? 'bookmark' : 'bookmark_border' }}"
                            :size="26"
                            color="#262626"
                        />
                    </native:column>
                </native:row>

                {{-- Likes --}}
                <native:column class="w-full px-3 pt-1">
                    <native:text class="text-[13] font-bold text-[#262626]">{{ $post['likesFormatted'] }} likes</native:text>
                </native:column>

                {{-- Caption --}}
                <native:column class="w-full px-3 pt-1 pb-1">
                    <native:text class="text-sm text-theme-on-surface"><native:text class="text-[13] font-bold text-[#262626]">{{ $post['user']['username'] }}</native:text> {{ $post['caption'] }}</native:text>
                </native:column>

                {{-- View Comments --}}
                @if ($post['commentCount'] > 0)
                    <native:column @press="viewPost({{ $index }})" class="w-full px-3 pb-1">
                        <native:text class="text-[13] text-[#8E8E8E]">View all {{ number_format($post['commentCount']) }} comments</native:text>
                    </native:column>
                @endif

                {{-- Time --}}
                <native:column class="w-full px-3 pb-3">
                    <native:text class="text-[11] text-[#8E8E8E]">{{ $post['time'] }} ago</native:text>
                </native:column>
            </native:column>
        @endforeach

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
