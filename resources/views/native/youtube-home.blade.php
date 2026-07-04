{{-- @include('native.partials.demo-nav', ['title' => 'YouTube']) --}}

{{-- Header is provided by the framework NavBar (StackLayout) — back arrow + "YouTube" title.
     The search action used to live here; promote to NavBar actions via
     navigationOptions() on YouTubeHome if you want it back. --}}

<scroll-view class="w-full h-full bg-[#0F0F0F]">
    <column class="w-full gap-0 ">

        {{-- Category Chips --}}
        <scroll-view horizontal>
            <row class="gap-2 px-4 py-3">
                @foreach ($categories as $name => $color)
                    <column
                        @press="selectCategory('{{ $name }}')"
                        class="px-3 py-2 rounded-lg {{ $activeCategory === $name ? 'bg-white' : 'bg-[#272727]' }}"
                    >
                        <text class="text-[13] font-semibold {{ $activeCategory === $name ? 'text-black' : 'text-white' }}">{{ $name }}</text>
                    </column>
                @endforeach
            </row>
        </scroll-view>

        {{-- Video Feed --}}
        @foreach (array_slice($videos, 0, 4) as $index => $video)
            <column class="w-full pb-3">
                {{-- Thumbnail --}}
                <column @press="viewVideo({{ $index }})" class="w-full">
                    <stack class="w-full h-[210]">
                        <image
                            src="{{ $video['thumbnailUrl'] }}"
                            alt="{{ $video['title'] }}"
                            class="w-full h-[210]"
                            :fit="2"
                        />
                        {{-- Duration Badge --}}
                        <column class="w-full h-[210] items-end justify-end p-2">
                            <column class="bg-[#000000CC] rounded px-1 py-[1]">
                                <text class="text-[11] font-semibold text-white">{{ $video['duration'] }}</text>
                            </column>
                        </column>
                    </stack>
                </column>

                {{-- Video Info --}}
                <row class="w-full px-3 pt-5 pb-3">
                    <column @press="viewChannel({{ $video['channelId'] }})">
                        <image
                            src="{{ $video['channel']['avatarUrl'] }}"
                            alt="{{ $video['channel']['name'] }}'s channel"
                            class="w-[36] h-[36] rounded-full"
                            :fit="2"
                        />
                    </column>
                    <column @press="viewVideo({{ $index }})" class="flex-1 gap-1">
                        <text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</text>
                        <row class="items-center gap-1">
                            <text class="text-[12] text-[#AAAAAA]" :maxLines="1">{{ $video['channel']['name'] }}</text>
                            @if ($video['channel']['isVerified'])
                                <icon name="verified" :size="12" color="#AAAAAA" />
                            @endif
                            <text class="text-[12] text-[#AAAAAA]" :maxLines="1">· {{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</text>
                        </row>
                    </column>
                    <icon name="more_vert" :size="18" color="#AAAAAA" />
                </row>
            </column>
        @endforeach

        {{-- Shorts Section --}}
        <row class="w-full px-4 pt-2 pb-3 items-center gap-2">
            <icon name="play_circle_filled" :size="22" color="#FF0000" />
            <text class="text-[16] font-bold text-white">Shorts</text>
        </row>

        <scroll-view horizontal>
            <row class="gap-2 px-4 pb-4">
                @foreach ($shorts as $short)
                    <column class="w-[140] gap-1">
                        <stack class="w-[140] h-[248] rounded-lg">
                            <image
                                src="{{ $short['thumbnailUrl'] }}"
                                class="w-[140] h-[248] rounded-lg"
                                :fit="2"
                            />
                            <column class="w-[140] h-[248] justify-end p-2">
                                <text class="text-[12] font-bold text-white" :maxLines="2">{{ $short['title'] }}</text>
                                <text class="text-[11] text-[#DDDDDD]">{{ $short['viewsFormatted'] }} views</text>
                            </column>
                        </stack>
                    </column>
                @endforeach
            </row>
        </scroll-view>

        {{-- More Videos --}}
        @foreach (array_slice($videos, 4) as $index => $video)
            <column class="w-full pb-3">
                <column @press="viewVideo({{ $index + 4 }})" class="w-full">
                    <stack class="w-full h-[210]">
                        <image
                            src="{{ $video['thumbnailUrl'] }}"
                            alt="{{ $video['title'] }}"
                            class="w-full h-[210]"
                            :fit="2"
                        />
                        <column class="w-full h-[210] items-end justify-end p-2">
                            <column class="bg-[#000000CC] rounded px-1 py-[1]">
                                <text class="text-[11] font-semibold text-white">{{ $video['duration'] }}</text>
                            </column>
                        </column>
                    </stack>
                </column>

                <row class="w-full px-3 pt-3 gap-3">
                    <column @press="viewChannel({{ $video['channelId'] }})">
                        <image
                            src="{{ $video['channel']['avatarUrl'] }}"
                            alt="{{ $video['channel']['name'] }}'s channel"
                            class="w-[36] h-[36] rounded-full"
                            :fit="2"
                        />
                    </column>
                    <column @press="viewVideo({{ $index + 4 }})" class="w-[290] gap-1">
                        <text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</text>
                        <row class="items-center gap-1">
                            <text class="text-[12] text-[#AAAAAA]">{{ $video['channel']['name'] }}</text>
                            @if ($video['channel']['isVerified'])
                                <icon name="verified" :size="12" color="#AAAAAA" />
                            @endif
                            <text class="text-[12] text-[#AAAAAA]">· {{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</text>
                        </row>
                    </column>
                    <icon name="more_vert" :size="18" color="#AAAAAA" />
                </row>
            </column>
        @endforeach

        <spacer class="h-[20]" />

    </column>
</scroll-view>
