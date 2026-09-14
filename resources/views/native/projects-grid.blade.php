<column class="flex-1 w-full bg-theme-background">
    <text class="text-2xl font-bold px-5 pt-5">Projects</text>
    <text class="text-sm text-theme-on-surface-variant px-5 pb-3">min-column-width 360: one column on a phone, more on an iPad.</text>

    <lazy-grid class="flex-1 w-full px-5" min-column-width="360" :gap="12">
        @foreach ($projects as $project)
            <column class="w-full gap-2 p-4 rounded-2xl bg-theme-surface-variant">
                <row class="items-center gap-3">
                    <column class="w-[40] h-[40] rounded-full bg-theme-primary items-center justify-center">
                        <text class="text-theme-on-primary font-bold">{{ $project['id'] }}</text>
                    </column>
                    <column class="flex-1 gap-0.5">
                        <text class="text-base font-semibold">{{ $project['name'] }}</text>
                        <text class="text-sm text-theme-on-surface-variant">{{ $project['status'] }}</text>
                    </column>
                </row>
                <text class="text-sm">{{ $project['summary'] }}</text>
            </column>
        @endforeach
    </lazy-grid>
</column>
