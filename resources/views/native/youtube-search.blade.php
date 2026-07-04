<scroll-view class="w-full h-full bg-[#0F0F0F] safe-area">
    <column class="w-full gap-0 ">

        {{-- Top Bar — search field flexes to fill remaining width between
             the back arrow and the search button so it adapts to phone width. --}}
        <row class="w-full px-4 pt-3 pb-2 items-center gap-3">
            <column @press="back" a11y-label="Back" class="w-[32] h-[32] items-center justify-center">
                <icon name="arrow_back" :size="24" color="#FFFFFF" />
            </column>
            <row class="flex-1 bg-[#121212] rounded-full px-4 py-3 items-center gap-2 border border-[#303030]">
                <outlined-text-input
                    @model="query"
                    placeholder="Search YouTube"
                    placeholderColor="#717171"
                    class="flex-1 text-[15] text-white bg-transparent"
                />
            </row>
            <column @press="search" a11y-label="Search" class="w-[36] h-[36] rounded-full bg-[#222222] items-center justify-center">
                <icon name="search" :size="20" color="#FFFFFF" />
            </column>
        </row>

        {{-- Search Results --}}
        @if (count($results) > 0)
            <column class="w-full px-4 pt-2 pb-2">
                <text class="text-[14] text-[#AAAAAA]">{{ count($results) }} results</text>
            </column>

            @foreach ($results as $video)
                <column @press="viewVideo({{ $video['globalIndex'] }})" class="w-full pb-3">
                    <stack class="w-full h-[210]">
                        <image
                            src="{{ $video['thumbnailUrl'] }}"
                            class="w-full h-[210]"
                            :fit="2"
                        />
                        <column class="w-full h-[210] items-end justify-end p-2">
                            <column class="bg-[#000000CC] rounded px-1 py-[1]">
                                <text class="text-[11] font-semibold text-white">{{ $video['duration'] }}</text>
                            </column>
                        </column>
                    </stack>

                    <row class="w-full px-3 pt-3 gap-3">
                        <image
                            src="{{ $video['channel']['avatarUrl'] }}"
                            class="w-[36] h-[36] rounded-full"
                            :fit="2"
                        />
                        <column class="flex-1 gap-1">
                            <text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</text>
                            <row class="items-center gap-1">
                                <text class="text-[12] text-[#AAAAAA]" :maxLines="1">{{ $video['channel']['name'] }}</text>
                                @if ($video['channel']['isVerified'])
                                    <icon name="verified" :size="12" color="#AAAAAA" />
                                @endif
                                <text class="text-[12] text-[#AAAAAA]" :maxLines="1">· {{ $video['viewsFormatted'] }} views</text>
                            </row>
                        </column>
                    </row>
                </column>
            @endforeach
        @else
            {{-- Default State: Trending --}}
            <column class="w-full px-4 pt-4 pb-3">
                <row class="items-center gap-2">
                    <icon name="trending_up" :size="22" color="#FFFFFF" />
                    <text class="text-[16] font-bold text-white">Trending</text>
                </row>
            </column>

            @foreach ($trending as $video)
                <row @press="viewVideo({{ $video['globalIndex'] }})" class="w-full px-4 py-2 gap-3">
                    <stack class="w-[160] h-[90]">
                        <image
                            src="{{ $video['thumbnailUrl'] }}"
                            class="w-[160] h-[90] rounded-lg"
                            :fit="2"
                        />
                        <column class="w-[160] h-[90] items-end justify-end p-1">
                            <column class="bg-[#000000CC] rounded px-1 py-[1]">
                                <text class="text-[10] font-semibold text-white">{{ $video['duration'] }}</text>
                            </column>
                        </column>
                    </stack>
                    <column class="flex-1 gap-1">
                        <text class="text-[13] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</text>
                        <row class="items-center gap-1">
                            <text class="text-[11] text-[#AAAAAA]" :maxLines="1">{{ $video['channel']['name'] }}</text>
                            @if ($video['channel']['isVerified'])
                                <icon name="verified" :size="10" color="#AAAAAA" />
                            @endif
                        </row>
                        <text class="text-[11] text-[#AAAAAA]" :maxLines="1">{{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</text>
                    </column>
                </row>
            @endforeach

            <divider class="w-full mx-4 mt-3 mb-3" color="#272727" />

            {{-- Popular Channels --}}
            <column class="w-full px-4 pb-3">
                <text class="text-[16] font-bold text-white">Popular channels</text>
            </column>

            <scroll-view horizontal>
                <row class="gap-4 px-4 pb-4">
                    @foreach ($channels as $cIndex => $ch)
                        <column @press="viewChannel({{ $cIndex }})" class="items-center gap-2 w-[100]">
                            <image
                                src="{{ $ch['avatarUrl'] }}"
                                class="w-[80] h-[80] rounded-full"
                                :fit="2"
                            />
                            <text class="text-[12] font-semibold text-white text-center" :maxLines="1">{{ $ch['name'] }}</text>
                            <text class="text-[11] text-[#AAAAAA]">{{ $ch['handle'] }}</text>
                        </column>
                    @endforeach
                </row>
            </scroll-view>
        @endif

        <spacer class="h-[20]" />

    </column>
</scroll-view>
