{{-- Shown by #[Lazy] while ReactivityDemo::mount() runs. --}}
    <native:column class="w-full h-full items-center justify-center p-5 gap-5">

        <native:row class="items-center gap-3">
            <native:activity-indicator />
            <native:text class="text-base font-semibold text-theme-on-surface-variant">Loading…</native:text>
        </native:row>

        {{-- Skeleton cards mirroring the real layout --}}
        @foreach ([1, 2, 3] as $i)
            <native:column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl"
                           :opacity="0.3"
                           :animate-duration="1000"
                           :animate-loop="true"
                           animate-easing="ease-in-out">
                <native:column class="w-[120] h-[14] rounded-full bg-theme-on-surface-variant/20" />
                <native:column class="w-full h-[12] rounded-full bg-theme-on-surface-variant/10" />
                <native:column class="w-3/4 h-[12] rounded-full bg-theme-on-surface-variant/10" />
                <native:column class="w-full h-[40] rounded-xl bg-theme-on-surface-variant/15 mt-2" />
            </native:column>
        @endforeach

    </native:column>
