<scroll-view class="w-full h-full bg-[#0F0F0F] safe-area">
    <column class="w-full gap-0">

        {{-- Top Bar — chromeless input inside the pill (the pill row
             supplies all the chrome), like the app's search screen. --}}
        <row class="w-full px-3 pt-2 pb-2 items-center gap-2">
            <column @tap="back" a11y-label="Back" class="w-[36] h-[36] items-center justify-center">
                <icon name="arrow_back" :size="24" color="#FFFFFF" />
            </column>
            <row class="flex-1 bg-[#272727] rounded-full pl-4 pr-1 py-[2] items-center gap-2">
                <bare-text-input
                    @model="query"
                    placeholder="Search YouTube"
                    placeholderColor="#717171"
                    class="flex-1 py-2 text-[15] text-white"
                />
                <pressable @tap="search" a11y-label="Search" class="w-[36] h-[36] rounded-full items-center justify-center">
                    <icon name="search" :size="20" color="#FFFFFF" />
                </pressable>
            </row>
        </row>

        {{-- Search Results — feed-style cards. Duration badges use
             `absolute` with NON-ZERO insets only; both stack renderers
             read a zero bottom/right inset as "unset". --}}
        @if (count($results) > 0)
            <column class="w-full px-4 pt-2 pb-1">
                <text class="text-[13] text-[#AAAAAA]">{{ count($results) }} {{ count($results) === 1 ? 'result' : 'results' }}</text>
            </column>

            @foreach ($results as $video)
                <column class="w-full pt-2 pb-2">
                    <pressable @tap="viewVideo({{ $video['globalIndex'] }})" class="w-full px-2">
                        <stack class="w-full h-[210]">
                            <image
                                src="{{ $video['thumbnailUrl'] }}"
                                alt="{{ $video['title'] }}"
                                class="w-full h-[210] rounded-xl"
                                :fit="2"
                            />
                            <column class="absolute bottom-2 right-3 bg-[#000000CC] rounded-md px-[6] py-[2]">
                                <text class="text-[11] font-semibold text-white">{{ $video['duration'] }}</text>
                            </column>
                        </stack>
                    </pressable>

                    <row class="w-full px-3 pt-3 gap-3">
                        <pressable @tap="viewChannel({{ $video['channelId'] }})" a11y-label="{{ $video['channel']['name'] }}'s channel">
                            <image
                                src="{{ $video['channel']['avatarUrl'] }}"
                                alt="{{ $video['channel']['name'] }}'s channel"
                                class="w-[36] h-[36] rounded-full"
                                :fit="2"
                            />
                        </pressable>
                        <pressable @tap="viewVideo({{ $video['globalIndex'] }})" class="flex-1">
                            <column class="w-full gap-1">
                                <text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</text>
                                <text class="text-[12] text-[#AAAAAA]" :maxLines="1">{{ $video['channel']['name'] }} · {{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</text>
                            </column>
                        </pressable>
                        <icon name="more_vert" :size="18" color="#AAAAAA" />
                    </row>
                </column>
            @endforeach
        @else
            {{-- Default State: Trending --}}
            <row class="w-full px-4 pt-4 pb-2 items-center gap-2">
                <icon name="analytics" :size="22" color="#FFFFFF" />
                <text class="text-[16] font-bold text-white">Trending</text>
            </row>

            @foreach ($trending as $video)
                <pressable @tap="viewVideo({{ $video['globalIndex'] }})" class="w-full">
                    <row class="w-full px-3 py-2 gap-3">
                        <stack class="w-[160] h-[90]">
                            <image
                                src="{{ $video['thumbnailUrl'] }}"
                                alt="{{ $video['title'] }}"
                                class="w-[160] h-[90] rounded-lg"
                                :fit="2"
                            />
                            <column class="absolute bottom-1 right-1 bg-[#000000CC] rounded px-1 py-[1]">
                                <text class="text-[10] font-semibold text-white">{{ $video['duration'] }}</text>
                            </column>
                        </stack>
                        <column class="flex-1 gap-1">
                            <text class="text-[13] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</text>
                            <text class="text-[11] text-[#AAAAAA]" :maxLines="1">{{ $video['channel']['name'] }} · {{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</text>
                        </column>
                        <icon name="more_vert" :size="16" color="#AAAAAA" />
                    </row>
                </pressable>
            @endforeach

            <divider class="w-full mx-4 mt-3 mb-3" color="#272727" />

            {{-- Popular Channels --}}
            <column class="w-full px-4 pb-2">
                <text class="text-[16] font-bold text-white">Popular channels</text>
            </column>

            <scroll-view horizontal>
                <row class="gap-4 px-4 pb-4 pt-2">
                    @foreach ($channels as $cIndex => $ch)
                        <pressable @tap="viewChannel({{ $cIndex }})" a11y-label="{{ $ch['name'] }}'s channel">
                            <column class="items-center gap-2 w-[100]">
                                <image
                                    src="{{ $ch['avatarUrl'] }}"
                                    alt="{{ $ch['name'] }}"
                                    class="w-[80] h-[80] rounded-full"
                                    :fit="2"
                                />
                                <text class="text-[12] font-semibold text-white text-center" :maxLines="1">{{ $ch['name'] }}</text>
                                <text class="text-[11] text-[#AAAAAA]">{{ $ch['handle'] }}</text>
                            </column>
                        </pressable>
                    @endforeach
                </row>
            </scroll-view>
        @endif

        <spacer class="h-[20] flex-grow-0" />

    </column>
</scroll-view>
