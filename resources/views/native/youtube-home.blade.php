{{-- Plain full-screen root (outside the NavBar stack group — see
     routes/mobile.php): the screen fills the window edge-to-edge, so
     `safe-area` pads the content while the dark bg covers the insets.
     Duration badges and corner overlays use `absolute` with NON-ZERO
     insets only (bottom-2 right-3 etc.) — both stack renderers read a
     zero bottom/right inset as "unset" and pin to the top/left. --}}
<scroll-view class="w-full h-full bg-[#0F0F0F] safe-area">
    <column class="w-full gap-0">

        {{-- Top Bar — back + YouTube brand + cast / notifications / search --}}
        <row class="w-full px-3 pt-2 pb-1 items-center gap-2">
            <column @tap="back" a11y-label="Back" class="w-[34] h-[34] items-center justify-center">
                <icon name="arrow_back" :size="24" color="#FFFFFF" />
            </column>
            <icon name="play_circle_filled" :size="26" color="#FF0000" />
            <text class="text-[19] font-bold text-white">YouTube</text>
            <spacer />
            <column @tap="castDevice" a11y-label="Cast" class="w-[34] h-[34] items-center justify-center">
                <icon name="cast" :size="20" color="#FFFFFF" />
            </column>
            <column @tap="viewNotifications" a11y-label="Notifications" class="w-[34] h-[34] items-center justify-center">
                <icon name="notifications" :size="20" color="#FFFFFF" />
            </column>
            <column @tap="viewSearch" a11y-label="Search" class="w-[34] h-[34] items-center justify-center">
                <icon name="search" :size="20" color="#FFFFFF" />
            </column>
        </row>

        {{-- Category Chips --}}
        <scroll-view horizontal>
            <row class="gap-2 px-3 py-2 items-center">
                <column class="w-[34] h-[32] rounded-lg bg-[#272727] items-center justify-center">
                    <icon name="dashboard" :size="18" color="#FFFFFF" />
                </column>
                @foreach ($categories as $name => $color)
                    <column
                        @tap="selectCategory('{{ $name }}')"
                        class="px-3 py-[6] rounded-lg {{ $activeCategory === $name ? 'bg-white' : 'bg-[#272727]' }}"
                    >
                        <text class="text-[13] font-semibold {{ $activeCategory === $name ? 'text-black' : 'text-white' }}">{{ $name }}</text>
                    </column>
                @endforeach
            </row>
        </scroll-view>

        {{-- Video Feed --}}
        @foreach (array_slice($videos, 0, 4) as $index => $video)
            <column class="w-full pt-2 pb-4">
                {{-- Thumbnail --}}
                <pressable @tap="viewVideo({{ $index }})" class="w-full px-2">
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

                {{-- Video Info --}}
                <row class="w-full px-3 pt-3 gap-3">
                    <pressable @tap="viewChannel({{ $video['channelId'] }})" a11y-label="{{ $video['channel']['name'] }}'s channel">
                        <image
                            src="{{ $video['channel']['avatarUrl'] }}"
                            alt="{{ $video['channel']['name'] }}'s channel"
                            class="w-[36] h-[36] rounded-full"
                            :fit="2"
                        />
                    </pressable>
                    <pressable @tap="viewVideo({{ $index }})" class="flex-1">
                        <column class="w-full gap-1">
                            <text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</text>
                            <text class="text-[12] text-[#AAAAAA]" :maxLines="1">{{ $video['channel']['name'] }} · {{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</text>
                        </column>
                    </pressable>
                    <icon name="more_vert" :size="18" color="#AAAAAA" />
                </row>
            </column>
        @endforeach

        {{-- Shorts Section --}}
        <row class="w-full px-3 pt-1 pb-2 items-center gap-2">
            <icon name="play_circle_filled" :size="24" color="#FF0000" />
            <text class="text-[17] font-bold text-white">Shorts</text>
        </row>

        <scroll-view horizontal>
            <row class="gap-2 px-3 pb-4">
                @foreach ($shorts as $short)
                    <stack class="w-[150] h-[260]">
                        <image
                            src="{{ $short['thumbnailUrl'] }}"
                            alt="{{ $short['title'] }}"
                            class="w-[150] h-[260] rounded-xl"
                            :fit="2"
                        />
                        {{-- Bottom title overlay. Full-size layer (not
                             absolute) because zero opposing insets don't
                             stretch an absolute child across the card. --}}
                        <column class="w-[150] h-[260] justify-end p-2 gap-[2]">
                            <text class="text-[12] font-semibold text-white" :maxLines="2">{{ $short['title'] }}</text>
                            <text class="text-[11] text-[#DDDDDD]">{{ $short['viewsFormatted'] }} views</text>
                        </column>
                        <column class="absolute top-2 right-2">
                            <icon name="more_vert" :size="18" color="#FFFFFF" />
                        </column>
                    </stack>
                @endforeach
            </row>
        </scroll-view>

        {{-- More Videos --}}
        @foreach (array_slice($videos, 4, null, true) as $index => $video)
            <column class="w-full pb-4">
                <pressable @tap="viewVideo({{ $index }})" class="w-full px-2">
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
                    <pressable @tap="viewVideo({{ $index }})" class="flex-1">
                        <column class="w-full gap-1">
                            <text class="text-[14] font-semibold text-white" :maxLines="2">{{ $video['title'] }}</text>
                            <text class="text-[12] text-[#AAAAAA]" :maxLines="1">{{ $video['channel']['name'] }} · {{ $video['viewsFormatted'] }} views · {{ $video['uploadedAt'] }}</text>
                        </column>
                    </pressable>
                    <icon name="more_vert" :size="18" color="#AAAAAA" />
                </row>
            </column>
        @endforeach

        <spacer class="h-[20] flex-grow-0" />

    </column>
</scroll-view>
