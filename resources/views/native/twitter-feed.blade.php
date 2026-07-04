{{--@include('native.partials.demo-nav', ['title' => 'Twitter / X'])--}}

<scroll-view >
    <column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <row class="w-full px-4 py-3 items-center justify-between">
            <image
                src="https://i.pravatar.cc/150?u=currentuser"
                alt="Your profile"
                class="w-[32] h-[32] rounded-full"
                :fit="2"
            />
            <text class="text-[30] font-bold text-theme-on-surface">𝕏</text>
            <column @press="composeTweet" a11y-label="Compose post" class="w-[32] h-[32] rounded-full items-center justify-center">
                <icon name="edit" :size="18" color="#FFFFFF" />
            </column>
        </row>

        {{-- Tab Row --}}
        <tab-row :selectedIndex="$selectedTab" @change="selectTab">
            <tab label="For You" />
            <tab label="Following" />
        </tab-row>

        <divider class="w-full" />

        {{-- Tweet Feed --}}
        @foreach ($tweets as $index => $tweet)
            <column class="w-full">
                <row class="w-full px-4 pt-3 gap-3">
                    {{-- Avatar --}}
                    <image
                        @press="viewProfile({{ $tweet['userId'] }})"
                        src="{{ $tweet['user']['avatarUrl'] }}"
                        alt="{{ $tweet['user']['name'] }}'s profile"
                        class="w-[40] h-[40] rounded-full"
                        :fit="2"
                    />

                    {{-- Tweet Content --}}
                    <column @press="viewTweet({{ $index }})" class="flex-1 gap-1">
                        {{-- Name Row --}}
                        <row class="items-center gap-1">
                            <text class="text-[15] font-bold text-theme-on-surface">{{ $tweet['user']['name'] }}</text>
                            @if ($tweet['user']['isVerified'])
                                <icon name="verified" :size="16" color="#1D9BF0" />
                            @endif
                            <text class="text-[13] text-[#536471]">{{ $tweet['user']['handle'] }}</text>
                            <text class="text-[13] text-[#536471]">· {{ $tweet['time'] }}</text>
                        </row>

                        {{-- Tweet Text --}}
                        <text class="text-sm text-theme-on-surface">{{ $tweet['text'] }}</text>

                        {{-- Optional Image --}}
                        @if ($tweet['imageUrl'])
                            <image
                                src="{{ $tweet['imageUrl'] }}"
                                alt="Photo by {{ $tweet['user']['name'] }}"
                                class="w-full h-[180] rounded-xl mt-2"
                                :fit="2"
                            />
                        @endif

                        {{-- Action Bar --}}
                        <row class="w-full items-center justify-between py-2 pr-4">
                            {{-- Reply --}}
                            <row class="items-center gap-1">
                                <icon name="chat_bubble_outline" :size="18" color="#536471" />
                                <text class="text-[13] text-[#536471]">{{ $tweet['replyFormatted'] }}</text>
                            </row>
                            {{-- Retweet --}}
                            <row class="items-center gap-1">
                                <icon name="repeat" :size="18" color="#536471" />
                                <text class="text-[13] text-[#536471]">{{ $tweet['retweetFormatted'] }}</text>
                            </row>
                            {{-- Like --}}
                            <row @press="toggleLike({{ $index }})" class="items-center gap-1">
                                <icon
                                    name="{{ $tweet['isLiked'] ? 'favorite' : 'favorite_border' }}"
                                    :size="18"
                                    color="{{ $tweet['isLiked'] ? '#F91880' : '#536471' }}"
                                />
                                <text class="text-[13] {{ $tweet['isLiked'] ? 'text-[#F91880]' : 'text-[#536471]' }}">{{ $tweet['likeFormatted'] }}</text>
                            </row>
                            {{-- Share --}}
                            <icon name="share" :size="18" color="#536471" />
                        </row>
                    </column>
                </row>
                <divider class="w-full" />
            </column>
        @endforeach

        <spacer class="h-[20]" />

    </column>
</scroll-view>
