{{-- Stress scroll: 20k local image cells via <virtual-list>. Native owns
     $rowCount logical slots; PHP only materializes [$from..$to].
     Boot frame is ExploreIcons-scale; native:poll expands after first paint. --}}
<column class="flex-1 w-full bg-theme-background">
    {{-- One-shot wake: present only until mega-preload lands, then dropped
         so the render loop blocks on user events instead of re-publishing. --}}
    @if (! $preloaded)
        <text native:poll.80ms class="h-[0] w-[0] opacity-0">.</text>
    @endif

    <virtual-list
        class="w-full flex-1 px-2"
        item="native.hero.scroll-20k-row"
        :count="$rowCount"
        :from="$from"
        :to="$to"
        :estimated-row-height="76"
        :overscan="$overscan"
        on-window-change="setVirtualWindow"
    />
</column>
