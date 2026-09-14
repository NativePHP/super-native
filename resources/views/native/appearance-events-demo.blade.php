<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        <column class="w-full p-5 gap-2 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">Appearance Events</text>
            <text class="text-base text-theme-on-surface">
                Flip the simulator between light and dark (⌘⇧A). Every row below has its own
                #[On(AppearanceChanged)] listener — they must all move together.
            </text>
        </column>

        <column class="w-full p-5 gap-4 bg-theme-surface-variant rounded-2xl">
            <text class="text-xl font-bold uppercase text-theme-on-surface-variant">Screen</text>

            <row class="items-center justify-between">
                <text class="text-xl text-theme-on-surface">AppearanceEventsDemo</text>
                <text class="text-xl font-bold text-theme-primary">{{ $mode }} · {{ $received }}</text>
            </row>
        </column>

        <column class="w-full p-5 gap-4 bg-theme-surface-variant rounded-2xl">
            <text class="text-xl font-bold uppercase text-theme-on-surface-variant">Nested children</text>

            <native:appearance-badge label="Child A" />
            <native:appearance-badge label="Child B" />
        </column>

    </column>
</scroll-view>
