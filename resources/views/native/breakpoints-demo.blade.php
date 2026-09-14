<column class="flex-1 w-full bg-theme-background">
    <text class="text-xl md:text-3xl font-bold px-5 pt-5">Breakpoints</text>
    <text class="text-sm text-theme-on-surface-variant px-5 pb-3">Phone: stacked. md (768+): sidebar + 2 cols. lg (1024+): 3 cols.</text>

    {{-- Column on a phone, row from md up: the sidebar sits beside the grid. --}}
    <column class="flex-1 w-full md:flex-row gap-3 px-5">
        <column class="w-full md:w-[240] gap-2 p-4 rounded-2xl bg-theme-primary">
            <text class="text-base font-semibold text-theme-on-primary">Sidebar</text>
            <text class="text-sm text-theme-on-primary">Full width on a phone, a fixed 240pt rail from md up.</text>
        </column>

        <lazy-grid class="flex-1 w-full grid-cols-1 md:grid-cols-2 lg:grid-cols-3" :gap="12">
            @foreach ($projects as $project)
                <column class="w-full gap-1 p-4 rounded-2xl bg-theme-surface-variant md:bg-[#DDE7FF] lg:bg-[#DFF5E1]">
                    <text class="text-base font-semibold">{{ $project['name'] }}</text>
                    <text class="text-sm text-theme-on-surface-variant">{{ $project['status'] }}</text>
                </column>
            @endforeach
        </lazy-grid>
    </column>
</column>
