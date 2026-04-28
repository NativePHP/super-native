{{-- @include('native.partials.demo-nav', ['title' => 'Spotify']) --}}

<native:scroll-view class="w-full h-full bg-[#121212]">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:row class="w-full px-4 pt-4 pb-2 items-center justify-between">
            <native:text class="text-[22] font-bold text-white">Good evening</native:text>
            <native:row class="items-center gap-4">
                <native:icon name="notifications_none" :size="24" color="#FFFFFF" />
                <native:icon name="history" :size="24" color="#FFFFFF" />
                <native:column @press="viewSearch" class="w-[32] h-[32] items-center justify-center">
                    <native:icon name="settings" :size="22" color="#FFFFFF" />
                </native:column>
            </native:row>
        </native:row>

        {{-- Recently Played Grid --}}
        <native:column class="w-full px-4 pt-2 gap-2">
            @foreach (array_chunk($recentlyPlayed, 2) as $row)
                <native:row class="w-full gap-2">
                    @foreach ($row as $index => $playlist)
                        <native:row @press="viewPlaylist({{ array_search($playlist, $recentlyPlayed) }})" class="w-[170] h-[56] bg-[#282828] rounded items-center gap-0">
                            <native:image
                                src="{{ $playlist['coverUrl'] }}"
                                class="w-[56] h-[56] rounded-l"
                                :fit="2"
                            />
                            <native:text class="text-[12] font-bold text-white px-2" :maxLines="2">{{ $playlist['name'] }}</native:text>
                        </native:row>
                    @endforeach
                </native:row>
            @endforeach
        </native:column>

        {{-- Made For You --}}
        <native:column class="w-full px-4 pt-6 pb-2">
            <native:text class="text-[20] font-bold text-white">Made For You</native:text>
        </native:column>
        <native:scroll-view horizontal>
            <native:row class="gap-3 px-4 pb-4">
                @foreach ($madeForYou as $index => $playlist)
                    <native:column @press="viewPlaylist({{ $index + 2 }})" class="w-[150] gap-2">
                        <native:image
                            src="{{ $playlist['coverUrl'] }}"
                            class="w-[150] h-[150] rounded"
                            :fit="2"
                        />
                        <native:text class="text-[12] text-[#B3B3B3]" :maxLines="2">{{ $playlist['description'] }}</native:text>
                    </native:column>
                @endforeach
            </native:row>
        </native:scroll-view>

        {{-- Popular Artists --}}
        <native:column class="w-full px-4 pt-4 pb-2">
            <native:text class="text-[20] font-bold text-white">Popular artists</native:text>
        </native:column>
        <native:scroll-view horizontal>
            <native:row class="gap-4 px-4 pb-4">
                @foreach ($artists as $artistIndex => $artist)
                    <native:column @press="viewArtist({{ $artistIndex }})" class="items-center gap-2 w-[120]">
                        <native:image
                            src="{{ $artist['imageUrl'] }}"
                            class="w-[120] h-[120] rounded-full"
                            :fit="2"
                        />
                        <native:text class="text-[13] font-bold text-white text-center">{{ $artist['name'] }}</native:text>
                        <native:text class="text-[11] text-[#B3B3B3]">Artist</native:text>
                    </native:column>
                @endforeach
            </native:row>
        </native:scroll-view>

        {{-- Your Top Mixes --}}
        <native:column class="w-full px-4 pt-4 pb-2">
            <native:text class="text-[20] font-bold text-white">Your top mixes</native:text>
        </native:column>
        <native:scroll-view horizontal>
            <native:row class="gap-3 px-4 pb-4">
                @foreach (array_slice($recentlyPlayed, 0, 4) as $pIndex => $playlist)
                    <native:column @press="viewPlaylist({{ $pIndex }})" class="w-[150] gap-2">
                        <native:image
                            src="{{ $playlist['coverUrl'] }}"
                            class="w-[150] h-[150] rounded"
                            :fit="2"
                        />
                        <native:text class="text-[13] font-bold text-white" :maxLines="1">{{ $playlist['name'] }}</native:text>
                        <native:text class="text-[11] text-[#B3B3B3]">{{ $playlist['creator'] }}</native:text>
                    </native:column>
                @endforeach
            </native:row>
        </native:scroll-view>

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
