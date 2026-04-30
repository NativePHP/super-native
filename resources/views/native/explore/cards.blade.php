<native:scroll-view class="w-full bg-theme-background">
    <native:column class="w-full p-5 gap-5">

        {{-- CARD VARIANTS --}}
        <native:text class="text-lg font-semibold text-theme-on-background">Card — variants</native:text>

        <native:column class="w-full p-4 gap-1 bg-theme-surface-variant rounded-xl">
            <native:text class="font-semibold text-theme-on-surface">Filled</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">surface-variant background, no stroke. Medium emphasis — the default.</native:text>
        </native:column>

        <native:column class="w-full p-4 gap-1 bg-theme-surface rounded-xl border border-theme-outline">
            <native:text class="font-semibold text-theme-on-surface">Outlined</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">surface background + outline stroke. Lower emphasis, crisp edges.</native:text>
        </native:column>

        <native:column class="w-full p-4 gap-1 bg-theme-surface rounded-xl shadow">
            <native:text class="font-semibold text-theme-on-surface">Elevated</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">surface + soft shadow. Highest emphasis — floats off the background.</native:text>
        </native:column>

        <native:divider class="my-2" />

        {{-- CHIPS --}}
        <native:text class="text-lg font-semibold text-theme-on-background">Chip (composed)</native:text>
        <native:text class="text-sm text-theme-on-surface-variant">Tap to toggle:</native:text>
        <native:row class="gap-2 flex-wrap">
            @foreach ([
                ['field' => 'subscribed',    'label' => 'Subscribed',     'icon' => 'favorite'],
                ['field' => 'termsAccepted', 'label' => 'Terms accepted', 'icon' => 'check'],
            ] as $row)
                @php $sel = $this->{$row['field']}; @endphp
                <native:pressable @press="toggleField('{{ $row['field'] }}')">
                    <native:row class="items-center gap-1 px-3 py-2 rounded-full {{ $sel ? 'bg-teal-600 border-teal-600' : 'bg-theme-surface-variant border-theme-outline' }} border">
                        <native:icon :name="$row['icon']" :size="14" :color="$sel ? '#FFFFFF' : '#475569'" :dark-color="$sel ? '#FFFFFF' : '#94A3B8'"/>
                        <native:text class="text-sm font-medium {{ $sel ? 'text-white' : 'text-theme-on-surface' }}">{{ $row['label'] }}</native:text>
                    </native:row>
                </native:pressable>
            @endforeach
        </native:row>

        <native:divider class="my-2" />

        {{-- BADGES — bright accent colors stay vivid in both modes --}}
        <native:text class="text-lg font-semibold text-theme-on-background">Badge</native:text>
        <native:row class="gap-2 flex-wrap items-center">
            <native:row class="px-2 py-0.5 rounded-full bg-blue-500 items-center">
                <native:text class="text-xs font-semibold text-white">NEW</native:text>
            </native:row>
            <native:row class="px-2 py-0.5 rounded-full bg-red-500 items-center">
                <native:text class="text-xs font-semibold text-white">3</native:text>
            </native:row>
            <native:row class="px-2 py-0.5 rounded-full bg-green-500 items-center">
                <native:text class="text-xs font-semibold text-white">ONLINE</native:text>
            </native:row>
            <native:row class="px-2 py-0.5 rounded-full bg-amber-500 items-center">
                <native:text class="text-xs font-semibold text-white">PRO</native:text>
            </native:row>
        </native:row>

        <native:divider class="my-2" />

        {{-- PROFILE CARD --}}
        <native:text class="text-lg font-semibold text-theme-on-background">Profile card</native:text>
        <native:column class="w-full p-5 gap-3 bg-theme-surface rounded-2xl shadow">
            <native:row class="w-full gap-3 items-center">
                <native:column class="w-[60] h-[60] rounded-full bg-purple-500 items-center justify-center">
                    <native:text class="text-white text-xl font-bold">SR</native:text>
                </native:column>
                <native:column class="flex-1 gap-0">
                    <native:text class="text-base font-bold text-theme-on-surface">Shane Rosenthal</native:text>
                    <native:text class="text-sm text-theme-on-surface-variant">srosenthal@example.com</native:text>
                </native:column>
            </native:row>
            <native:divider />
            <native:row class="w-full justify-around">
                <native:column class="items-center">
                    <native:text class="text-xl font-bold text-theme-on-surface">142</native:text>
                    <native:text class="text-xs text-theme-on-surface-variant">Posts</native:text>
                </native:column>
                <native:column class="items-center">
                    <native:text class="text-xl font-bold text-theme-on-surface">1.2K</native:text>
                    <native:text class="text-xs text-theme-on-surface-variant">Followers</native:text>
                </native:column>
                <native:column class="items-center">
                    <native:text class="text-xl font-bold text-theme-on-surface">312</native:text>
                    <native:text class="text-xs text-theme-on-surface-variant">Following</native:text>
                </native:column>
            </native:row>
        </native:column>

        <native:divider class="my-2" />

        {{-- LIST ITEMS --}}
        <native:text class="text-lg font-semibold text-theme-on-background">List items</native:text>
        <native:column class="w-full bg-theme-surface rounded-xl">
            @foreach ([
                ['icon' => 'bell',   'title' => 'Notifications',   'sub' => 'Push, email, in-app'],
                ['icon' => 'lock',   'title' => 'Privacy',         'sub' => 'Account & data'],
                ['icon' => 'globe',  'title' => 'Language',        'sub' => 'English (US)'],
                ['icon' => 'help',   'title' => 'Help & support',  'sub' => 'FAQ, contact us'],
            ] as $i => $row)
                <native:row class="items-center gap-3 px-4 py-3">
                    <native:icon :name="$row['icon']" :size="20" color="#475569" dark-color="#CBD5E1" />
                    <native:column class="flex-1 gap-0">
                        <native:text class="text-base font-medium text-theme-on-surface">{{ $row['title'] }}</native:text>
                        <native:text class="text-sm text-theme-on-surface-variant">{{ $row['sub'] }}</native:text>
                    </native:column>
                    <native:icon name="chevron_right" :size="18" color="#9CA3AF" dark-color="#64748B" />
                </native:row>
                @if (! $loop->last)
                    <native:divider />
                @endif
            @endforeach
        </native:column>

    </native:column>
</native:scroll-view>
