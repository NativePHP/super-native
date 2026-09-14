{{-- One virtual-list row: 5 equal square photo tiles from the scroll20k
     JPEG pool. Srcs are shared absolute paths so the native image cache
     reuses the 8 decoded bitmaps across all cells.

     IMPORTANT: put flex-1 on a COLUMN cell, not on <image>. Bare
     <image class="flex-1 h-[…]"> inside a List-backed virtual-list row
     collapses after the first row — later rows paint as one full-bleed
     short band per list slot. Instagram search + ExploreIcons wrap the
     flex child and give the image w-full + fixed height instead. --}}
@php
    $perRow = $scroll20kPerRow;
    $base = $index * $perRow;
    $srcs = $scroll20kSrcs;
    $srcCount = count($srcs);
@endphp
<row native:key="s20k-{{ $index }}" class="w-full gap-1.5 pb-1.5">
    @for ($col = 0; $col < $perRow; $col++)
        @php $cell = $base + $col; @endphp
        @if ($cell < $scroll20kCellCount)
            <column class="flex-1 h-[68]">
                <image
                    src="{{ $srcs[$cell % $srcCount] }}"
                    class="w-full h-[68] rounded-md"
                    :fit="2"
                />
            </column>
        @else
            <column class="flex-1 h-[68]"/>
        @endif
    @endfor
</row>
