{{-- Icon names must exist in the iOS Material→SF map
     (IconHelper.swift) as well as the Android set — `shuffle` is
     Android-only, so shuffle affordances use the mapped `repeat`. --}}
<scroll-view class="w-full h-full bg-[#121212] safe-area">
    <column class="w-full gap-0">

        {{-- Top Bar --}}
        <row class="w-full px-4 py-3 items-center gap-3">
            <column @tap="back" a11y-label="Back" class="w-[32] h-[32] items-center justify-center">
                <icon name="arrow_back" :size="24" color="#FFFFFF" />
            </column>
        </row>

        {{-- Cover Art --}}
        <column class="w-full items-center py-4">
            <image
                src="{{ $playlist['coverUrl'] }}"
                alt="{{ $playlist['name'] }}"
                class="w-[220] h-[220] rounded-lg shadow-xl"
                :fit="2"
            />
        </column>

        {{-- Playlist Info --}}
        <column class="w-full px-4 gap-1">
            <text class="text-[24] font-bold text-white">{{ $playlist['name'] }}</text>
            <text class="text-[13] text-[#B3B3B3]">{{ $playlist['description'] }}</text>
            <row class="items-center gap-1 pt-1">
                <column class="w-[16] h-[16] rounded-full bg-[#1DB954] items-center justify-center">
                    <icon name="person" :size="10" color="#000000" />
                </column>
                <text class="text-[13] font-semibold text-white">{{ $playlist['creator'] }}</text>
            </row>
            <text class="text-[12] text-[#B3B3B3]">{{ $playlist['trackCount'] }} songs</text>
        </column>

        {{-- Action Row --}}
        <row class="w-full px-4 py-3 items-center justify-between">
            <row class="items-center gap-5">
                <icon name="favorite_border" :size="24" color="#B3B3B3" />
                <icon name="download" :size="24" color="#B3B3B3" />
                <icon name="share" :size="22" color="#B3B3B3" />
                <icon name="more_horiz" :size="24" color="#B3B3B3" />
            </row>
            <row class="items-center gap-4">
                <icon name="repeat" :size="24" color="#1DB954" />
                <pressable @tap="shufflePlay" a11y-label="Shuffle play" class="w-[52] h-[52] rounded-full bg-[#1DB954] items-center justify-center">
                    <icon name="play_arrow" :size="30" color="#000000" />
                </pressable>
            </row>
        </row>

        {{-- Track List — title/artist flex, like the app (no numbers on
             playlist pages) --}}
        <column class="w-full px-4 gap-0">
            @foreach ($tracksWithMeta as $trackIndex => $track)
                <pressable @tap="playTrack({{ $trackIndex }})" class="w-full">
                    <row class="w-full py-3 items-center gap-3">
                        <column class="flex-1 gap-[2]">
                            <text class="text-[15] text-white" :maxLines="1">{{ $track['title'] }}</text>
                            <text class="text-[12] text-[#B3B3B3]" :maxLines="1">{{ $track['artistName'] }} · {{ $track['playsFormatted'] }} plays</text>
                        </column>
                        <text class="text-[13] text-[#B3B3B3]">{{ $track['duration'] }}</text>
                        <icon name="more_vert" :size="18" color="#B3B3B3" />
                    </row>
                </pressable>
            @endforeach
        </column>

        <spacer class="h-[20] flex-grow-0" />

    </column>
</scroll-view>
