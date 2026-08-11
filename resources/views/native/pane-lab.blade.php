{{-- Chrome-less screen over the persistent background layer (see
     PaneLabLayout for why there's no nav bar). The root is a full-bleed
     STACK: the sheet pane must span the screen so its renderer can pin
     itself to the bottom edge — as a padded flex child it would get a
     small mispositioned slot instead. --}}
<native:stack class="w-full h-full">

    <native:column class="w-full h-full safe-area p-4 gap-3">

        <native:column class="w-full gap-2 rounded-2xl bg-black/55 p-4">
            <native:row class="w-full items-center gap-2">
                <native:pressable @navigate.back class="rounded-full bg-white/15 p-2" a11y-label="Back">
                    <native:icon name="chevron.left" :size="18" class="text-white" />
                </native:pressable>
                <native:text font="bold" class="text-base text-white">Pane Lab</native:text>
            </native:row>
            <native:text class="text-sm text-white">Drag the pane below — it snaps to 180 / 420 / 640 and reports each settle.</native:text>
            <native:row class="w-full items-center gap-3">
                <native:text class="text-sm text-cyan-300">Detent: {{ $lastDetent }}</native:text>
                <native:text class="text-sm text-fuchsia-300">@change fired: {{ $changeCount }}×</native:text>
            </native:row>
            <native:text class="text-xs text-white/60">Settling back on the same detent must NOT bump the counter. Corner badges behind this card are the zero-inset anchor test.</native:text>
            <native:button variant="primary" label="Open permanent sheet" @tap="openPermanentSheet" />
        </native:column>

    </native:column>

    <native:sheet-pane class="w-full h-full" detents="180,420,640" detent="180" @change="paneMoved">
        <native:column class="w-full gap-3 p-4">
            <native:text font="bold" class="text-base">Sheet pane</native:text>
            <native:text class="text-sm leading-relaxed">Always-on, drags natively, spring-snaps to detents. The background layer behind keeps its state while I move.</native:text>
            @foreach (range(1, 8) as $i)
                <native:row class="w-full items-center gap-3 rounded-lg bg-theme-surface-variant p-3" key="row-{{ $i }}">
                    <native:text class="text-sm">Pane row {{ $i }}</native:text>
                </native:row>
            @endforeach
        </native:column>
    </native:sheet-pane>

</native:stack>

<native:bottom-sheet :visible="$showPermanentSheet" permanent background-interaction detents="0.4" @dismiss="closePermanentSheet">
    <native:column class="w-full gap-3 p-6">
        <native:text font="bold" class="text-base">Permanent sheet</native:text>
        <native:text class="text-sm leading-relaxed">Try to swipe me down or (Android) press back — I stay. Only the button closes me. On iOS the view behind stays interactive when background-interaction is on.</native:text>
        <native:button variant="destructive" label="Close" @tap="closePermanentSheet" />
    </native:column>
</native:bottom-sheet>
