{{-- Full-bleed artist header with the name overlaid at the bottom of
     the image, like the app. Overlays use `absolute` with NON-ZERO
     insets only — both stack renderers read a zero bottom/right inset
     as "unset" and pin to the top/left. `shuffle` isn't in the iOS
     Material→SF icon map, so shuffle affordances use `repeat`. --}}
<scroll-view class="w-full h-full bg-[#121212] safe-area">
    <column class="w-full gap-0">

        {{-- Artist Image + overlaid name + floating back button --}}
        <stack class="w-full">
            <column class="w-full">
                <image
                    src="{{ $artist['imageUrl'] }}"
                    alt="{{ $artist['name'] }}"
                    class="w-full h-[300]"
                    :fit="2"
                />
            </column>

            <column class="absolute bottom-2 left-4">
                <text class="text-[40] font-bold text-white">{{ $artist['name'] }}</text>
            </column>

            {{-- LAST stack child so it draws (and hit-tests) on top --}}
            <pressable @tap="back" a11y-label="Back" class="absolute top-3 left-3 w-[34] h-[34] rounded-full bg-[#00000066] items-center justify-center">
                <icon name="arrow_back" :size="20" color="#FFFFFF" />
            </pressable>
        </stack>

        {{-- Listeners + Action Row --}}
        <column class="w-full px-4 pt-3 gap-1">
            <text class="text-[13] text-[#B3B3B3]">{{ $listenersFormatted }} monthly listeners</text>
        </column>

        <row class="w-full px-4 py-3 items-center gap-4">
            <pressable
                @tap="toggleFollow"
                a11y-label="{{ $isFollowing ? 'Unfollow' : 'Follow' }}"
                class="px-4 py-[6] rounded-md border {{ $isFollowing ? 'border-[#1DB954] bg-[#1DB954]' : 'border-[#B3B3B3]' }}"
            >
                <text class="text-[13] font-bold {{ $isFollowing ? 'text-black' : 'text-white' }}">{{ $isFollowing ? 'Following' : 'Follow' }}</text>
            </pressable>
            <icon name="more_horiz" :size="24" color="#B3B3B3" />
            <spacer />
            <icon name="repeat" :size="24" color="#1DB954" />
            <pressable @tap="playTrack(0)" a11y-label="Play" class="w-[52] h-[52] rounded-full bg-[#1DB954] items-center justify-center">
                <icon name="play_arrow" :size="30" color="#000000" />
            </pressable>
        </row>

        {{-- Popular Tracks — ranked, like the app's artist page --}}
        <column class="w-full px-4 pt-1 pb-2">
            <text class="text-[16] font-bold text-white">Popular</text>
        </column>

        <column class="w-full px-4 gap-0">
            @foreach ($tracksWithMeta as $trackIndex => $track)
                <pressable @tap="playTrack({{ $trackIndex }})" class="w-full">
                    <row class="w-full py-3 items-center gap-3">
                        <column class="w-[24] items-center">
                            <text class="text-[14] text-[#B3B3B3]">{{ $trackIndex + 1 }}</text>
                        </column>
                        <column class="flex-1 gap-[2]">
                            <text class="text-[15] text-white" :maxLines="1">{{ $track['title'] }}</text>
                            <text class="text-[12] text-[#B3B3B3]">{{ $track['playsFormatted'] }} plays</text>
                        </column>
                        <text class="text-[13] text-[#B3B3B3]">{{ $track['duration'] }}</text>
                        <icon name="more_vert" :size="18" color="#B3B3B3" />
                    </row>
                </pressable>
            @endforeach
        </column>

        <divider class="w-full mx-4 my-3" color="#2A2A2A" />

        {{-- About --}}
        <column class="w-full px-4 gap-2 pb-4">
            <text class="text-[16] font-bold text-white">About</text>
            <text class="text-[14] text-[#B3B3B3]">{{ $artist['bio'] }}</text>
            <row class="items-center gap-2 pt-1">
                <text class="text-[13] text-white font-bold">{{ $followersFormatted }}</text>
                <text class="text-[13] text-[#B3B3B3]">followers</text>
                <text class="text-[13] text-[#B3B3B3]">·</text>
                <text class="text-[13] text-[#B3B3B3]">{{ $artist['genre'] }}</text>
            </row>
        </column>

        <spacer class="h-[20] flex-grow-0" />

    </column>
</scroll-view>
