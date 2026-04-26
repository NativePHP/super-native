<native:scroll-view class="w-full h-full bg-[#0F0F0F] safe-area">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full px-4 pt-3 pb-2 items-center gap-3">
            <native:column @press="back" class="w-[32] h-[32] items-center justify-center">
                <native:icon name="arrow_back" :size="24" color="#FFFFFF" />
            </native:column>
            <native:row class="w-[270] bg-[#121212] rounded-full px-4 py-3 items-center gap-2 border border-[#303030]">
                <native:outlined-text-input
                    @model="query"
                    placeholder="Search YouTube"
                    placeholderColor="#717171"
                    class="w-[220] text-[15] text-white bg-transparent"
                />
            </native:row>
            <native:column @press="search" class="w-[36] h-[36] rounded-full bg-[#222222] items-center justify-center">
                <native:icon name="search" :size="20" color="#FFFFFF" />
            </native:column>
        </native:row>

        {{-- Search Results --}}
        @if (count($results) > 0)
            <native:column class="w-full px-4 pt-2 pb-2">
                <native:text class="text-[14] text-[#AAAAAA]">{{ count($results) }} results</native:text>
            </native:column>

            @foreach ($results as $video)
                <native:column @press="viewVideo({{ $video['globalIndex'] }})" class="w-full pb-3">
                    <native:stack class="w-full h-[210]">
                        <native:image
                            src="{{ $video['thumbnailUrl'] }}"
                            class="w-full h-[210]"
                            :fit="2"
                        />
                        <native:column class="w-full h-[210] items-end justify-end p-2">
                            <native:column class="bg-[#000000CC] rounded px-1 py-[1]">
                                <native:text class="text-[11] font-semibold text-white">{{ $video['duration'] }}</native:text>
                            </native:column>
                        </native:column>
                    </native:stack>

                    <native:row class="w-full px-3 pt-3 gap-3">
                        <native:image
                            src="{{ $video['channel']['avatarUrl'] }}"
                            class="w-[36] h-[36] rounded-full"
                            :fit="2"
                        />
                        <native:column class="w-[290] gap-1">
                            <native:text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</native:text>
                            <native:row class="items-center gap-1">
                                <native:text class="text-[12] text-[#AAAAAA]">{{ $video['channel']['name'] }}</native:text>
                                @if ($video['channel']['isVerified'])
                                    <native:icon name="verified" :size="12" color="#AAAAAA" />
                                @endif
                                <native:text class="text-[12] text-[#AAAAAA]">· {{ $video['viewsFormatted'] }} views</native:text>
                            </native:row>
                        </native:column>
                    </native:row>
                </native:column>
            @endforeach
        @else
            {{-- Default State: Trending --}}
            <native:column class="w-full px-4 pt-4 pb-3">
                <native:row class="items-center gap-2">
                    <native:icon name="trending_up" :size="22" color="#FFFFFF" />
                    <native:text class="text-[16] font-bold text-white">Trending</native:text>
                </native:row>
            </native:column>

            @foreach ($trending as $video)
                <native:row @press="viewVideo({{ $video['globalIndex'] }})" class="w-full px-4 py-2 gap-3">
                    <native:stack class="w-[160] h-[90]">
                        <native:image
                            src="{{ $video['thumbnailUrl'] }}"
                            class="w-[160] h-[90] rounded-lg"
                            :fit="2"
                        />
                        <native:column class="w-[160] h-[90] items-end justify-end p-1">
                            <native:column class="bg-[#000000CC] rounded px-1 py-[1]">
                                <native:text class="text-[10] font-semibold text-white">{{ $video['duration'] }}</native:text>
                            </native:column>
                        </native:column>
                    </native:stack>
                    <native:column class="w-[170] gap-1">
                        <native:text class="text-[13] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</native:text>
                        <native:row class="items-center gap-1">
                            <native:text class="text-[11] text-[#AAAAAA]">{{ $video['channel']['name'] }}</native:text>
                            @if ($video['channel']['isVerified'])
                                <native:icon name="verified" :size="10" color="#AAAAAA" />
                            @endif
                        </native:row>
                        <native:text class="text-[11] text-[#AAAAAA]">{{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</native:text>
                    </native:column>
                </native:row>
            @endforeach

            <native:divider class="w-full mx-4 mt-3 mb-3" color="#272727" />

            {{-- Popular Channels --}}
            <native:column class="w-full px-4 pb-3">
                <native:text class="text-[16] font-bold text-white">Popular channels</native:text>
            </native:column>

            <native:scroll-view horizontal>
                <native:row class="gap-4 px-4 pb-4">
                    @foreach ($channels as $cIndex => $ch)
                        <native:column @press="viewChannel({{ $cIndex }})" class="items-center gap-2 w-[100]">
                            <native:image
                                src="{{ $ch['avatarUrl'] }}"
                                class="w-[80] h-[80] rounded-full"
                                :fit="2"
                            />
                            <native:text class="text-[12] font-semibold text-white text-center" :maxLines="1">{{ $ch['name'] }}</native:text>
                            <native:text class="text-[11] text-[#AAAAAA]">{{ $ch['handle'] }}</native:text>
                        </native:column>
                    @endforeach
                </native:row>
            </native:scroll-view>
        @endif

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
