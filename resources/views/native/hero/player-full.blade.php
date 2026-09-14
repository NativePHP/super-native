@php use App\Icons\Android; use App\Icons\Ios; @endphp
{{-- The surface that was a 64pt bar is now the entire screen. --}}
<column ref="player-surface"
        class="w-full h-full items-center bg-[{{ $track['tint'] }}] safe-area">

    {{-- ref here is purely a test handle: this control is icon-only, so a UI
         driver has no text to target. No partner on the other screen, so it
         never pairs. --}}
    <row @navigate.back.viewTransition ref="player-close"
         class="w-full items-center px-5 pt-4">
        <icon :ios="Ios::ChevronDown" :android="Android::ExpandMore" :size="24" color="#FFFFFF" />
        <column class="flex-1" />
    </row>

    {{-- Artwork: crossed the screen and grew from 48pt to 260pt. --}}
    <column ref="player-art"
            class="w-[260] h-[260] rounded-3xl items-center justify-center bg-[#FFFFFF33] mt-10">
        <icon :ios="$track['ios']" :android="$track['android']" :size="110" color="#FFFFFF" />
    </column>

    {{-- Title: left-aligned in a cramped bar, now centred and twice the size. --}}
    <text ref="player-title"
          class="text-3xl font-bold text-white mt-8">{{ $track['title'] }}</text>

    <text class="text-base text-[#FFFFFFCC] mt-1">{{ $track['artist'] }}</text>

    <column class="flex-1 w-full" />

    <row class="w-full items-center justify-center gap-10 pb-6">
        <icon :ios="Ios::BackwardFill" :android="Android::FastRewind" :size="28" color="#FFFFFF" />
        <column class="w-[64] h-[64] rounded-full items-center justify-center bg-[#FFFFFF33]">
            <icon :ios="Ios::PauseFill" :android="Android::Pause" :size="30" color="#FFFFFF" />
        </column>
        <icon :ios="Ios::ForwardFill" :android="Android::FastForward" :size="28" color="#FFFFFF" />
    </row>

    <text class="text-xs text-[#FFFFFFCC] pb-8 px-8 text-center">
        Three names, three paths, one navigation — and the return leg runs it backwards.
    </text>

</column>
