@php use App\Icons\Android; use App\Icons\Ios; @endphp
@php use App\Support\HeroDemoData; $tracks = HeroDemoData::tracks(); $now = HeroDemoData::track(1); @endphp

<column class="w-full h-full bg-theme-background">

    <scroll-view class="flex-1 w-full">
        <column class="w-full p-5 gap-3">
            <text class="text-sm text-theme-on-surface-variant">
                The bar pinned at the bottom is the shared element. Tap it — the artwork, the
                title and the bar's own surface each travel to a different place.
            </text>

            @foreach ($tracks as $track)
                <row class="items-center gap-3 p-3 bg-theme-surface rounded-2xl">
                    <column class="w-[44] h-[44] rounded-lg items-center justify-center bg-[{{ $track['tint'] }}]">
                        <icon :ios="$track['ios']" :android="$track['android']" :size="20" color="#FFFFFF" />
                    </column>
                    <column class="flex-1 gap-0.5">
                        <text class="text-base font-semibold text-theme-on-surface" :maxLines="1">{{ $track['title'] }}</text>
                        <text class="text-sm text-theme-on-surface-variant" :maxLines="1">{{ $track['artist'] }}</text>
                    </column>
                    <text class="text-sm text-theme-on-surface-variant">{{ $track['len'] }}</text>
                </row>
            @endforeach

            <text class="text-xs text-theme-on-surface-variant pt-2">
                The rows above are ordinary content — untagged, so they simply cross-fade.
            </text>
        </column>
    </scroll-view>

    {{-- ── The mini player. Three tagged elements in one 64pt strip. ── --}}
    <column @navigate.viewTransition('/hero/player/'.$now['id'])
            ref="player-surface"
            class="w-full p-3 bg-[{{ $now['tint'] }}] safe-area">
        <row class="w-full items-center gap-3">
            <column ref="player-art"
                    class="w-[48] h-[48] rounded-lg items-center justify-center bg-[#FFFFFF33]">
                <icon :ios="$now['ios']" :android="$now['android']" :size="22" color="#FFFFFF" />
            </column>
            <column class="flex-1 gap-0.5">
                <text ref="player-title"
                      class="text-base font-semibold text-white" :maxLines="1">{{ $now['title'] }}</text>
                <text class="text-xs text-[#FFFFFFCC]" :maxLines="1">{{ $now['artist'] }}</text>
            </column>
            <icon :ios="Ios::PlayFill" :android="Android::PlayArrow" :size="22" color="#FFFFFF" />
        </row>
    </column>

</column>
