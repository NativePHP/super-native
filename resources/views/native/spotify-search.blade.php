<scroll-view class="w-full h-full bg-[#121212] safe-area">
    <column class="w-full gap-0">

        {{-- Top Bar --}}
        <row class="w-full px-4 pt-4 pb-2 items-center gap-3">
            <column @tap="back" a11y-label="Back" class="w-[32] h-[32] items-center justify-center">
                <icon name="arrow_back" :size="24" color="#FFFFFF" />
            </column>
            <text class="text-[22] font-bold text-white">Search</text>
        </row>

        {{-- Search Bar --}}
        <column class="w-full px-4 pt-2 pb-4">
            <row class="w-full bg-white rounded-md px-3 py-3 items-center gap-3">
                <icon name="search" :size="22" color="#121212" />
                <text class="text-[15] text-[#121212] font-semibold">What do you want to listen to?</text>
            </row>
        </column>

        {{-- Browse all — flexed 2-up colored genre cards --}}
        <column class="w-full px-4 pb-2">
            <text class="text-[16] font-bold text-white">Browse all</text>
        </column>

        <column class="w-full px-4 gap-3 pb-4">
            @foreach (array_chunk(array_keys($genres), 2) as $chunk)
                <row class="w-full gap-3">
                    @foreach ($chunk as $genreName)
                        <column class="flex-1 h-[90] rounded-lg px-3 pt-3 bg-[{{ $genres[$genreName] }}]">
                            <text class="text-[16] font-bold text-white">{{ $genreName }}</text>
                        </column>
                    @endforeach
                    @if (count($chunk) === 1)
                        <column class="flex-1" />
                    @endif
                </row>
            @endforeach
        </column>

        {{-- Popular playlists --}}
        <column class="w-full px-4 pt-2 pb-2">
            <text class="text-[16] font-bold text-white">Popular playlists</text>
        </column>

        <scroll-view horizontal>
            <row class="gap-3 px-4 pb-4">
                @foreach (array_slice($playlists, 0, 4) as $pIndex => $playlist)
                    <pressable @tap="viewPlaylist({{ $pIndex }})" a11y-label="{{ $playlist['name'] }}">
                        <column class="w-[140] gap-2">
                            <image
                                src="{{ $playlist['coverUrl'] }}"
                                alt="{{ $playlist['name'] }}"
                                class="w-[140] h-[140] rounded-lg"
                                :fit="2"
                            />
                            <text class="text-[12] text-[#B3B3B3]" :maxLines="2">{{ $playlist['name'] }}</text>
                        </column>
                    </pressable>
                @endforeach
            </row>
        </scroll-view>

        {{-- Popular Artists --}}
        <column class="w-full px-4 pt-2 pb-2">
            <text class="text-[16] font-bold text-white">Popular artists</text>
        </column>

        <column class="w-full px-4 gap-0 pb-4">
            @foreach (array_slice($artists, 0, 4) as $aIndex => $artist)
                <pressable @tap="viewArtist({{ $aIndex }})" class="w-full">
                    <row class="w-full py-2 items-center gap-3">
                        <image
                            src="{{ $artist['imageUrl'] }}"
                            alt="{{ $artist['name'] }}"
                            class="w-[48] h-[48] rounded-full"
                            :fit="2"
                        />
                        <column class="flex-1">
                            <text class="text-[14] text-white font-semibold">{{ $artist['name'] }}</text>
                            <text class="text-[12] text-[#B3B3B3]">Artist · {{ $artist['genre'] }}</text>
                        </column>
                        <icon name="chevron_right" :size="18" color="#B3B3B3" />
                    </row>
                </pressable>
            @endforeach
        </column>

        <spacer class="h-[20] flex-grow-0" />

    </column>
</scroll-view>
