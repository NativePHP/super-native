<stack class="w-full h-full bg-theme-background safe-area">

    <refreshable @refresh="refresh" class="w-full h-full">
        <column class="w-full gap-0">

            {{-- Top Bar --}}
            <row class="w-full bg-theme-surface px-4 py-2 items-center justify-between">
                <text class="text-[26] font-bold text-[#1877F2]">facebook</text>
                <row class="items-center gap-2">
                    <pressable @tap="createPost" a11y-label="Create post" class="w-[36] h-[36] rounded-full bg-theme-surface-variant items-center justify-center">
                        <icon name="add" :size="20" class="text-theme-on-surface" />
                    </pressable>
                    <column class="w-[36] h-[36] rounded-full bg-theme-surface-variant items-center justify-center">
                        <icon name="search" :size="18" class="text-theme-on-surface" />
                    </column>
                    <column class="w-[36] h-[36] rounded-full bg-theme-surface-variant items-center justify-center">
                        <icon name="chat" :size="18" class="text-theme-on-surface" />
                    </column>
                </row>
            </row>

            {{-- Create Post Bar --}}
            <column class="w-full bg-theme-surface mt-2 px-4 py-3">
                <row class="w-full items-center gap-3">
                    <image
                        src="https://i.pravatar.cc/150?u=fbcurrent"
                        alt="Your profile"
                        class="w-[40] h-[40] rounded-full"
                        :fit="2"
                    />
                    <pressable @tap="createPost" class="flex-1" a11y-label="Create a post">
                        <column class="w-full border border-theme-outline rounded-full px-4 py-2">
                            <text class="text-[15] text-theme-on-surface-variant">What's on your mind?</text>
                        </column>
                    </pressable>
                    <icon name="photo" :size="24" color="#45BD62" />
                </row>
            </column>

            {{-- Stories — vertical reels-era cards --}}
            <column class="w-full bg-theme-surface mt-2 py-3">
                <scroll-view horizontal>
                    <row class="gap-2 px-4">
                        {{-- Create Story --}}
                        <pressable @tap="createPost" a11y-label="Create story">
                            <column class="w-[104] h-[170] rounded-xl bg-theme-surface-variant">
                                <image
                                    src="https://i.pravatar.cc/300?u=fbcurrent"
                                    alt="Your profile"
                                    class="w-full h-[110] rounded-xl"
                                    :fit="2"
                                />
                                <column class="flex-1 w-full items-center justify-end pb-2 gap-1">
                                    <text class="text-[12] font-semibold text-theme-on-surface">Create story</text>
                                </column>
                                <column class="absolute top-[94] left-[34] w-[36] h-[36] rounded-full bg-theme-surface items-center justify-center">
                                    <column class="w-[30] h-[30] rounded-full bg-[#1877F2] items-center justify-center">
                                        <icon name="add" :size="20" color="#FFFFFF" />
                                    </column>
                                </column>
                            </column>
                        </pressable>

                        {{-- Friend Stories --}}
                        @foreach ($stories as $story)
                            <pressable @tap="viewProfile({{ $story['id'] }})" a11y-label="{{ $story['name'] }}'s story">
                                <column class="w-[104] h-[170] rounded-xl">
                                    <image
                                        src="{{ $story['coverUrl'] }}"
                                        alt="{{ $story['name'] }}'s story"
                                        class="w-full h-[170] rounded-xl"
                                        :fit="2"
                                    />
                                    {{-- Avatar bubble --}}
                                    <column class="absolute top-2 left-2 w-[36] h-[36] rounded-full bg-[#1877F2] items-center justify-center">
                                        <image
                                            src="{{ $story['avatarUrl'] }}"
                                            alt="{{ $story['name'] }}"
                                            class="w-[32] h-[32] rounded-full"
                                            :fit="2"
                                        />
                                    </column>
                                    {{-- Name --}}
                                    <column class="absolute bottom-1 left-1 right-1 bg-black/50 rounded-lg px-2 py-1">
                                        <text class="text-[12] font-semibold text-white" :maxLines="1">{{ explode(' ', $story['name'])[0] }}</text>
                                    </column>
                                </column>
                            </pressable>
                        @endforeach
                    </row>
                </scroll-view>
            </column>

            {{-- Posts --}}
            @foreach ($posts as $post)
                <column class="w-full bg-theme-surface mt-2" :native:key="'post-'.$post['id']">
                    {{-- Post Header --}}
                    <row class="w-full px-4 pt-3 items-center gap-3">
                        <pressable @tap="viewProfile({{ $post['userId'] }})" a11y-label="View {{ $post['user']['name'] }}'s profile">
                            <image
                                src="{{ $post['user']['avatarUrl'] }}"
                                alt="{{ $post['user']['name'] }}'s profile"
                                class="w-[40] h-[40] rounded-full"
                                :fit="2"
                            />
                        </pressable>
                        <pressable @tap="viewProfile({{ $post['userId'] }})" class="flex-1">
                            <column>
                                <text class="text-[15] font-bold text-theme-on-surface" :maxLines="1">{{ $post['user']['name'] }}</text>
                                <row class="items-center gap-1">
                                    <text class="text-[12] text-[#65676B] dark:text-[#B0B3B8]">{{ $post['time'] }} ago ·</text>
                                    <icon name="globe" :size="12" class="text-[#65676B] dark:text-[#B0B3B8]" />
                                </row>
                            </column>
                        </pressable>
                        <row @tap="openPostMenu({{ $post['id'] }})" a11y-label="Post options" class="w-[32] h-[32] items-center justify-center">
                            <icon name="more_horiz" :size="22" class="text-[#65676B] dark:text-[#B0B3B8]" />
                        </row>
                    </row>

                    {{-- Post Text --}}
                    <pressable @tap="viewPost({{ $post['id'] }})" class="w-full">
                        <column class="w-full px-4 pt-2">
                            <text class="text-[15] text-theme-on-surface">{{ $post['text'] }}</text>
                        </column>
                    </pressable>

                    {{-- Post Image --}}
                    @if ($post['imageUrl'])
                        <pressable @tap="viewPost({{ $post['id'] }})" class="w-full">
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
                            <column class="w-[18] h-[18] rounded-full bg-[#F33E58] items-center justify-center ml-[-6]">
                                <icon name="favorite" :size="10" color="#FFFFFF" />
                            </column>
                            <text class="text-[13] text-[#65676B] dark:text-[#B0B3B8]" :maxLines="1">{{ $post['reactionsFormatted'] }}</text>
                        </row>
                        <row class="items-center gap-3">
                            <text class="text-[13] text-[#65676B] dark:text-[#B0B3B8]">{{ $post['comments'] }} comments</text>
                            <text class="text-[13] text-[#65676B] dark:text-[#B0B3B8]">{{ $post['shares'] }} shares</text>
                        </row>
                    </row>

                    <divider class="w-full mx-4" />

                    {{-- Action Bar --}}
                    <row class="w-full px-2 py-1 justify-between">
                        <row @tap="toggleLike({{ $post['id'] }})" a11y-label="{{ $post['isLiked'] ? 'Unlike' : 'Like' }}" class="items-center gap-1 px-4 py-2 flex-shrink-0">
                            <icon
                                name="{{ $post['isLiked'] ? 'thumb_up' : 'thumb_up_off_alt' }}"
                                :size="20"
                                class="{{ $post['isLiked'] ? 'text-[#1877F2]' : 'text-[#65676B] dark:text-[#B0B3B8]' }}"
                            />
                            <text class="text-[13] font-semibold {{ $post['isLiked'] ? 'text-[#1877F2]' : 'text-[#65676B] dark:text-[#B0B3B8]' }}">Like</text>
                        </row>
                        <row @tap="viewPost({{ $post['id'] }})" a11y-label="Comment" class="items-center gap-1 px-4 py-2 flex-shrink-0">
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

            <spacer class="h-[20]" />

        </column>
    </refreshable>

    {{-- Post actions sheet --}}
    <bottom-sheet :visible="$menuPostId !== null" @dismiss="closePostMenu" detents="small">
        <column class="w-full p-5 gap-4">
            <row class="items-center gap-3">
                <icon name="bookmark" :size="22" class="text-theme-on-surface" />
                <column>
                    <text class="text-[15] font-semibold text-theme-on-surface">Save post</text>
                    <text class="text-[13] text-theme-on-surface-variant">Add this to your saved items.</text>
                </column>
            </row>
            <row class="items-center gap-3">
                <icon name="close" :size="22" class="text-theme-on-surface" />
                <column>
                    <text class="text-[15] font-semibold text-theme-on-surface">Hide post</text>
                    <text class="text-[13] text-theme-on-surface-variant">See fewer posts like this.</text>
                </column>
            </row>
            <row class="items-center gap-3">
                <icon name="warning" :size="22" class="text-theme-on-surface" />
                <column>
                    <text class="text-[15] font-semibold text-theme-on-surface">Report post</text>
                    <text class="text-[13] text-theme-on-surface-variant">We won't let anyone know who reported this.</text>
                </column>
            </row>
            <pressable @tap="closePostMenu" class="w-full py-3 rounded-xl bg-theme-surface-variant items-center mt-1">
                <text class="text-[15] font-semibold text-theme-on-surface">Close</text>
            </pressable>
        </column>
    </bottom-sheet>

</stack>
