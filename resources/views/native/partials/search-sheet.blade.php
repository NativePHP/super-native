<bottom-sheet :visible="$showSearch" @dismiss="closeSearch" detents="medium,large">
    <column class="w-full p-6 gap-4">
        <row class="w-full items-center gap-3">
            <icon name="magnifyingglass" class="text-[20] text-theme-primary" />
            <text class="text-2xl font-bold flex-1">Search</text>
            <column @tap="closeSearch" class="px-3 py-1 rounded-full bg-theme-surface-variant">
                <text class="text-sm font-semibold text-theme-on-surface-variant">Close</text>
            </column>
        </row>

        <divider />

        <column class="w-full p-4 rounded-xl bg-theme-surface gap-2">
            <text class="text-base font-semibold text-theme-on-surface">Action-tab pattern</text>
            <text class="text-sm text-theme-on-surface-variant">
                The Search "tab" is a <text class="font-semibold text-theme-on-surface">Tab::action()</text>,
                not a route. Tapping it fires
                <text class="font-semibold text-theme-on-surface">openSearch()</text>
                on whichever tab screen is active — Apple's Photos / Mail pattern,
                where the search affordance is an action rather than navigation.
            </text>
        </column>

        <column class="w-full p-4 rounded-xl bg-theme-surface gap-2">
            <text class="text-base font-semibold text-theme-on-surface">Dismiss</text>
            <text class="text-sm text-theme-on-surface-variant">
                Tap "Close" above, swipe this sheet down, or drag it to the medium detent
                and beyond. <text class="font-semibold text-theme-on-surface">@dismiss</text>
                fires <text class="font-semibold text-theme-on-surface">closeSearch()</text>
                so the parent stays in sync.
            </text>
        </column>
    </column>
</bottom-sheet>
