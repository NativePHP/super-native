{{-- Icon names must exist in the iOS Material→SF map
     (IconHelper.swift) as well as the Android set — e.g. `shuffle` and
     `notifications_none` are Android-only and render blank on iOS. --}}
{{-- Plain full-screen root (outside the NavBar stack group — see
     routes/mobile.php): stack screens sit inside a NavigationStack whose
     container background is the white systemBackground with no override,
     which showed as a white bar in the bottom inset. As a plain screen
     the root fills the window edge-to-edge, so `safe-area` pads the
     content while the dark bg covers the insets. --}}
<scroll-view class="w-full h-full bg-[#121212] safe-area">
    <column class="w-full gap-0">

        {{-- Top Bar — back + filter chips + search. Chips are
             flex-shrink-0 with single-line labels: when the row runs out
             of width, flex shrink squeezes them and the text wraps
             mid-word ("Podcast s"). Keep the item set narrow enough for
             small phones. --}}
        <row class="w-full px-3 pt-3 pb-2 items-center gap-2">
            <column @tap="back" a11y-label="Back" class="w-[34] h-[34] items-center justify-center flex-shrink-0">
                <icon name="arrow_back" :size="24" color="#FFFFFF" />
            </column>
            <column class="px-3 py-[6] rounded-full bg-[#1DB954] flex-shrink-0">
                <text class="text-[13] font-semibold text-black" :maxLines="1">All</text>
            </column>
            <column class="px-3 py-[6] rounded-full bg-[#2A2A2A] flex-shrink-0">
                <text class="text-[13] font-semibold text-white" :maxLines="1">Music</text>
            </column>
            <column class="px-3 py-[6] rounded-full bg-[#2A2A2A] flex-shrink-0">
                <text class="text-[13] font-semibold text-white" :maxLines="1">Podcasts</text>
            </column>
            <spacer />
            <pressable @tap="viewSearch" a11y-label="Search" class="w-[34] h-[34] items-center justify-center flex-shrink-0">
                <icon name="search" :size="22" color="#FFFFFF" />
            </pressable>
        </row>

        {{-- Recently Played Grid --}}
        <column class="w-full px-4 pt-2 gap-2">
            @foreach (array_chunk($recentlyPlayed, 2, true) as $chunk)
                <row class="w-full gap-2">
                    @foreach ($chunk as $index => $playlist)
                        <pressable @tap="viewPlaylist({{ $index }})" class="flex-1 bg-[#2A2A2A] rounded-md">
                            <row class="w-full items-center gap-2">
                                <image
                                    src="{{ $playlist['coverUrl'] }}"
                                    alt="{{ $playlist['name'] }}"
                                    class="w-[56] h-[56] rounded-md"
                                    :fit="2"
                                />
                                <text class="text-[12] font-bold text-white flex-1 pr-1" :maxLines="2">{{ $playlist['name'] }}</text>
                            </row>
                        </pressable>
                    @endforeach
                    @if (count($chunk) === 1)
                        <column class="flex-1" />
                    @endif
                </row>
            @endforeach
        </column>

        {{-- Made For You --}}
        <column class="w-full px-4 pt-6 pb-2">
            <text class="text-[20] font-bold text-white">Made For You</text>
        </column>
        <scroll-view horizontal>
            <row class="gap-3 px-4 pb-4">
                @foreach ($madeForYou as $index => $playlist)
                    <pressable @tap="viewPlaylist({{ $index + 2 }})" a11y-label="{{ $playlist['name'] }}">
                        <column class="w-[150] gap-2">
                            <image
                                src="{{ $playlist['coverUrl'] }}"
                                alt="{{ $playlist['name'] }}"
                                class="w-[150] h-[150] rounded-lg"
                                :fit="2"
                            />
                            <text class="text-[12] text-[#B3B3B3]" :maxLines="2">{{ $playlist['description'] }}</text>
                        </column>
                    </pressable>
                @endforeach
            </row>
        </scroll-view>

        {{-- Popular Artists --}}
        <column class="w-full px-4 pt-2 pb-2">
            <text class="text-[20] font-bold text-white">Popular artists</text>
        </column>
        <scroll-view horizontal>
            <row class="gap-4 px-4 pb-4">
                @foreach ($artists as $artistIndex => $artist)
                    <pressable @tap="viewArtist({{ $artistIndex }})" a11y-label="{{ $artist['name'] }}">
                        <column class="items-center gap-2 w-[120]">
                            <image
                                src="{{ $artist['imageUrl'] }}"
                                alt="{{ $artist['name'] }}"
                                class="w-[120] h-[120] rounded-full"
                                :fit="2"
                            />
                            <text class="text-[13] font-bold text-white text-center">{{ $artist['name'] }}</text>
                            <text class="text-[11] text-[#B3B3B3]">Artist</text>
                        </column>
                    </pressable>
                @endforeach
            </row>
        </scroll-view>

        {{-- Your Top Mixes --}}
        <column class="w-full px-4 pt-2 pb-2">
            <text class="text-[20] font-bold text-white">Your top mixes</text>
        </column>
        <scroll-view horizontal>
            <row class="gap-3 px-4 pb-4">
                @foreach (array_slice($recentlyPlayed, 0, 4) as $pIndex => $playlist)
                    <pressable @tap="viewPlaylist({{ $pIndex }})" a11y-label="{{ $playlist['name'] }}">
                        <column class="w-[150] gap-2">
                            <image
                                src="{{ $playlist['coverUrl'] }}"
                                alt="{{ $playlist['name'] }}"
                                class="w-[150] h-[150] rounded-lg"
                                :fit="2"
                            />
                            <text class="text-[13] font-bold text-white" :maxLines="1">{{ $playlist['name'] }}</text>
                            <text class="text-[11] text-[#B3B3B3]">{{ $playlist['creator'] }}</text>
                        </column>
                    </pressable>
                @endforeach
            </row>
        </scroll-view>

        <spacer class="h-[20] flex-grow-0" />

    </column>
</scroll-view>
