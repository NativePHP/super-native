{{-- Header is provided by the framework NavBar (StackLayout) — back arrow + "Instagram" title.
     Action icons (heart, chat) live in navigationOptions() on the component. --}}

<refreshable @refresh="refresh" class="w-full h-full bg-theme-surface">
    <column class="w-full gap-0">

        {{-- Stories --}}
        <scroll-view horizontal>
            <row class="gap-3 px-4 pt-2 pb-3">
                {{-- Your Story --}}
                <column class="items-center gap-1 w-[76]">
                    <stack class="w-[72] h-[72]">
                        <column class="w-[72] h-[72] rounded-full bg-theme-surface-variant items-center justify-center">
                            <image
                                src="https://i.pravatar.cc/150?u=igcurrent"
                                alt="Your story"
                                class="w-[64] h-[64] rounded-full"
                                :fit="2"
                            />
                        </column>
                        <column class="absolute bottom-0 right-0 w-[22] h-[22] rounded-full bg-theme-surface items-center justify-center">
                            <column class="w-[18] h-[18] rounded-full bg-[#0095F6] items-center justify-center">
                                <icon name="add" :size="12" color="#FFFFFF" />
                            </column>
                        </column>
                    </stack>
                    <text class="text-[11] text-theme-on-surface">Your story</text>
                </column>

                {{-- Other Stories — `linear-gradient` via inline style doesn't
                     render natively; use a chunky Instagram-pink ring
                     as a single-color approximation of the gradient. --}}
                @foreach ($stories as $story)
                    <pressable @tap="viewProfile({{ $story['id'] }})" a11y-label="{{ $story['username'] }}'s story">
                        <column class="items-center gap-1 w-[76]">
                            <column class="w-[72] h-[72] rounded-full bg-[#DD2A7B] items-center justify-center">
                                <column class="w-[66] h-[66] rounded-full bg-theme-surface items-center justify-center">
                                    <image
                                        src="{{ $story['avatarUrl'] }}"
                                        alt="{{ $story['username'] }}'s story"
                                        class="w-[62] h-[62] rounded-full"
                                        :fit="2"
                                    />
                                </column>
                            </column>
                            <text class="text-[11] text-theme-on-surface" :maxLines="1">{{ explode('.', $story['username'])[0] }}</text>
                        </column>
                    </pressable>
                @endforeach
            </row>
        </scroll-view>

        <divider class="w-full" />

        {{-- Posts --}}
        @foreach ($posts as $post)
            <column class="w-full pb-3" :native:key="'post-'.$post['id']">
                {{-- Post Header --}}
                <row class="w-full px-3 py-2 items-center gap-2">
                    <pressable @tap="viewProfile({{ $post['userId'] }})" a11y-label="View {{ $post['user']['username'] }}'s profile">
                        <column class="w-[38] h-[38] rounded-full bg-[#DD2A7B] items-center justify-center">
                            <image
                                src="{{ $post['user']['avatarUrl'] }}"
                                alt="{{ $post['user']['username'] }}'s profile"
                                class="w-[34] h-[34] rounded-full"
                                :fit="2"
                            />
                        </column>
                    </pressable>
                    <pressable @tap="viewProfile({{ $post['userId'] }})" class="flex-1">
                        <column>
                            <row class="items-center gap-1">
                                <text class="text-[13] font-bold text-theme-on-surface" :maxLines="1">{{ $post['user']['username'] }}</text>
                                @if ($post['user']['isVerified'])
                                    <icon name="verified" :size="14" color="#3897F0" />
                                @endif
                            </row>
                            @if ($post['location'])
                                <text class="text-[11] text-theme-on-surface-variant" :maxLines="1">{{ $post['location'] }}</text>
                            @endif
                        </column>
                    </pressable>
                    <icon name="more_horiz" :size="20" class="text-theme-on-surface" />
                </row>

                {{-- Post Image --}}
                <pressable @tap="viewPost({{ $post['id'] }})" a11y-label="View post by {{ $post['user']['username'] }}">
                    <image
                        src="{{ $post['imageUrl'] }}"
                        alt="Photo by {{ $post['user']['username'] }}: {{ \Illuminate\Support\Str::limit($post['caption'], 60) }}"
                        class="w-full h-[375] rounded-lg"
                        :fit="2"
                    />
                </pressable>

                {{-- Action Bar — counts sit beside their icons, reels-era style --}}
                <row class="w-full px-3 pt-3 items-center justify-between">
                    <row class="items-center gap-4">
                        <pressable @tap="toggleLike({{ $post['id'] }})" a11y-label="{{ $post['isLiked'] ? 'Unlike' : 'Like' }}">
                            <row class="items-center gap-1">
                                <icon
                                    name="{{ $post['isLiked'] ? 'favorite' : 'favorite_border' }}"
                                    :size="24"
                                    class="{{ $post['isLiked'] ? 'text-[#ED4956]' : 'text-theme-on-surface' }}"
                                />
                                <text class="text-[13] font-semibold text-theme-on-surface">{{ $post['likesFormatted'] }}</text>
                            </row>
                        </pressable>
                        <pressable @tap="viewPost({{ $post['id'] }})" a11y-label="Comments">
                            <row class="items-center gap-1">
                                <icon name="chat_bubble_outline" :size="22" class="text-theme-on-surface" />
                                <text class="text-[13] font-semibold text-theme-on-surface">{{ $post['commentsFormatted'] }}</text>
                            </row>
                        </pressable>
                        <row class="items-center gap-1">
                            <icon name="ios_share" :size="22" class="text-theme-on-surface" />
                            <text class="text-[13] font-semibold text-theme-on-surface">{{ $post['sharesFormatted'] }}</text>
                        </row>
                    </row>
                    <pressable @tap="toggleSave({{ $post['id'] }})" a11y-label="{{ $post['isSaved'] ? 'Unsave' : 'Save' }}">
                        <icon
                            name="{{ $post['isSaved'] ? 'bookmark' : 'bookmark_border' }}"
                            :size="24"
                            class="text-theme-on-surface"
                        />
                    </pressable>
                </row>

                {{-- Caption --}}
                <column class="w-full px-3 pt-2">
                    <text class="text-[13] text-theme-on-surface" :maxLines="2"><text class="font-bold">{{ $post['user']['username'] }}</text> {{ $post['caption'] }}</text>
                </column>

                {{-- View Comments --}}
                @if ($post['commentCount'] > 0)
                    <pressable @tap="viewPost({{ $post['id'] }})" class="w-full px-3 pt-1">
                        <text class="text-[13] text-theme-on-surface-variant">View all {{ number_format($post['commentCount']) }} comments</text>
                    </pressable>
                @endif

                {{-- Time --}}
                <column class="w-full px-3 pt-1">
                    <text class="text-[11] text-theme-on-surface-variant">{{ $post['time'] }} ago</text>
                </column>
            </column>
        @endforeach

        <spacer class="h-[20]" />

    </column>
</refreshable>
