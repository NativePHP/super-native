@php use App\Icons\Android; use App\Icons\Ios; @endphp
<column class="w-full h-full bg-theme-background safe-area">

    <column ref="deep-{{ $row['id'] }}"
            class="w-full h-[240] rounded-none items-center justify-center bg-[{{ $row['tint'] }}] mt-14">
        <text class="text-7xl font-bold text-white">{{ $row['id'] }}</text>
    </column>

    <column class="w-full p-6 gap-2">
        <text class="text-2xl font-bold text-theme-on-surface">{{ $row['label'] }}</text>
        <text class="text-sm text-theme-on-surface-variant">
            This tile flew from wherever row {{ $row['id'] }} happened to be sitting when you
            tapped it — a few pixels below the header, or half-clipped at the bottom edge.
            Nothing about that start frame is known ahead of time; it is read live.

            Going back is the honest half: the list reopens at the TOP rather than at your old
            scroll offset, so for a row far down there is no partner on screen to fly to and the
            tile simply cross-fades. Restoring scroll position is a router concern, not a
            shared-element one — the morph degrades rather than misbehaving.
        </text>
    </column>

    <column class="flex-1 w-full" />

    <row @navigate.back.viewTransition class="items-center gap-2 px-6 pb-10">
        <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="{{ $row['tint'] }}" />
        <text class="text-base font-semibold text-[{{ $row['tint'] }}]">Back to the list</text>
    </row>

</column>
