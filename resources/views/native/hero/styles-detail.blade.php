@php use App\Icons\Android; use App\Icons\Ios; @endphp
@php
    $modes = ['frame' => 'style-frame', 'position' => 'style-position', 'size' => 'style-size'];
    $ref = $modes[$mode] ?? 'style-frame';
@endphp

<column class="w-full h-full bg-theme-background safe-area">

    <column class="w-full p-6 pt-14 gap-2">
        <text class="text-2xl font-bold text-theme-on-surface">morph="{{ $mode }}"</text>
        <text class="text-sm text-theme-on-surface-variant">
            @if ($mode === 'position')
                Only the POSITION was shared, so it travelled here at 72pt and took its
                destination size on arrival rather than growing along the way.
            @elseif ($mode === 'size')
                Only the SIZE was shared, so it grew from 72pt to full width without sliding —
                the move itself was instant.
            @else
                Position and size were both shared, so it travelled and grew together. This is
                what you get when you say nothing at all.
            @endif
        </text>
    </column>

    {{-- Identical destination geometry for all three, so the difference you
         see is entirely down to the morph style. --}}
    {{-- morph emitted unconditionally: "frame" is the default, so writing it
         out explicitly is a no-op, and a Blade @if inside a tag would be
         parsed as a static attribute rather than evaluated. --}}
    <column ref="{{ $ref }}" morph="{{ $mode }}"
            class="w-full h-[220] items-center justify-center bg-[{{ $tint }}]">
        <icon :ios="Ios::Checkmark" :android="Android::Check" :size="72" color="#FFFFFF" />
    </column>

    <column class="flex-1 w-full" />

    <row @navigate.back.viewTransition class="items-center gap-2 px-6 pb-10">
        <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="{{ $tint }}" />
        <text class="text-base font-semibold text-[{{ $tint }}]">Back — same style, reversed</text>
    </row>

</column>
