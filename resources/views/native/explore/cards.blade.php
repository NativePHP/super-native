<scroll-view class="w-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        {{-- CARD VARIANTS --}}
        <text class="text-lg font-semibold text-theme-on-background">Card — variants</text>

        <column class="w-full p-4 gap-1 bg-theme-surface-variant rounded-xl">
            <text class="font-semibold text-theme-on-surface">Filled</text>
            <text class="text-sm text-theme-on-surface-variant">surface-variant background, no stroke. Medium emphasis — the default.</text>
        </column>

        <column class="w-full p-4 gap-1 bg-theme-surface rounded-xl border border-theme-outline">
            <text class="font-semibold text-theme-on-surface">Outlined</text>
            <text class="text-sm text-theme-on-surface-variant">surface background + outline stroke. Lower emphasis, crisp edges.</text>
        </column>

        <column class="w-full p-4 gap-1 bg-theme-surface rounded-xl shadow">
            <text class="font-semibold text-theme-on-surface">Elevated</text>
            <text class="text-sm text-theme-on-surface-variant">surface + soft shadow. Highest emphasis — floats off the background.</text>
        </column>

        <divider class="my-2" />

        {{-- CHIPS --}}
        <text class="text-lg font-semibold text-theme-on-background">Chip (composed)</text>
        <text class="text-sm text-theme-on-surface-variant">Tap to toggle:</text>
        <row class="gap-2 flex-wrap">
            @foreach ([
                ['field' => 'subscribed',    'label' => 'Subscribed',     'icon' => 'favorite'],
                ['field' => 'termsAccepted', 'label' => 'Terms accepted', 'icon' => 'check'],
            ] as $row)
                @php $sel = $this->{$row['field']}; @endphp
                <pressable @press="toggleField('{{ $row['field'] }}')">
                    <row class="items-center gap-1 px-3 py-2 rounded-full {{ $sel ? 'bg-teal-600 border-teal-600' : 'bg-theme-surface-variant border-theme-outline' }} border">
                        <icon :name="$row['icon']" :size="14" :color="$sel ? '#FFFFFF' : '#475569'" :dark-color="$sel ? '#FFFFFF' : '#94A3B8'"/>
                        <text class="text-sm font-medium {{ $sel ? 'text-white' : 'text-theme-on-surface' }}">{{ $row['label'] }}</text>
                    </row>
                </pressable>
            @endforeach
        </row>

        <divider class="my-2" />

        {{-- BADGES — bright accent colors stay vivid in both modes --}}
        <text class="text-lg font-semibold text-theme-on-background">Badge</text>
        <row class="gap-2 flex-wrap items-center">
            <row class="px-2 py-0.5 rounded-full bg-blue-500 items-center">
                <text class="text-xs font-semibold text-white">NEW</text>
            </row>
            <row class="px-2 py-0.5 rounded-full bg-red-500 items-center">
                <text class="text-xs font-semibold text-white">3</text>
            </row>
            <row class="px-2 py-0.5 rounded-full bg-green-500 items-center">
                <text class="text-xs font-semibold text-white">ONLINE</text>
            </row>
            <row class="px-2 py-0.5 rounded-full bg-amber-500 items-center">
                <text class="text-xs font-semibold text-white">PRO</text>
            </row>
        </row>

        <divider class="my-2" />

        {{-- PROFILE CARD --}}
        <text class="text-lg font-semibold text-theme-on-background">Profile card</text>
        <column class="w-full p-5 gap-3 bg-theme-surface rounded-2xl shadow">
            <row class="w-full gap-3 items-center">
                <column class="w-[60] h-[60] rounded-full bg-purple-500 items-center justify-center">
                    <text class="text-white text-xl font-bold">SR</text>
                </column>
                <column class="flex-1 gap-0">
                    <text class="text-base font-bold text-theme-on-surface">Shane Rosenthal</text>
                    <text class="text-sm text-theme-on-surface-variant">shane@nativephp.com</text>
                </column>
            </row>
            <divider />
            <row class="w-full justify-around">
                <column class="items-center">
                    <text class="text-xl font-bold text-theme-on-surface">142</text>
                    <text class="text-xs text-theme-on-surface-variant">Posts</text>
                </column>
                <column class="items-center">
                    <text class="text-xl font-bold text-theme-on-surface">1.2K</text>
                    <text class="text-xs text-theme-on-surface-variant">Followers</text>
                </column>
                <column class="items-center">
                    <text class="text-xl font-bold text-theme-on-surface">312</text>
                    <text class="text-xs text-theme-on-surface-variant">Following</text>
                </column>
            </row>
        </column>

        <divider class="my-2" />

        {{-- LIST ITEMS --}}
        <text class="text-lg font-semibold text-theme-on-background">List items</text>
        <column class="w-full bg-theme-surface rounded-xl">
            @foreach ([
                ['icon' => 'bell',   'title' => 'Notifications',   'sub' => 'Push, email, in-app'],
                ['icon' => 'lock',   'title' => 'Privacy',         'sub' => 'Account & data'],
                ['icon' => 'globe',  'title' => 'Language',        'sub' => 'English (US)'],
                ['icon' => 'help',   'title' => 'Help & support',  'sub' => 'FAQ, contact us'],
            ] as $i => $row)
                <row class="items-center gap-3 px-4 py-3">
                    <icon :name="$row['icon']" :size="20" color="#475569" dark-color="#CBD5E1" />
                    <column class="flex-1 gap-0">
                        <text class="text-base font-medium text-theme-on-surface">{{ $row['title'] }}</text>
                        <text class="text-sm text-theme-on-surface-variant">{{ $row['sub'] }}</text>
                    </column>
                    <icon name="chevron_right" :size="18" color="#9CA3AF" dark-color="#64748B" />
                </row>
                @if (! $loop->last)
                    <divider />
                @endif
            @endforeach
        </column>

    </column>
</scroll-view>
