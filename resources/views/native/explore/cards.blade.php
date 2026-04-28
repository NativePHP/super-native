<native:scroll-view class="w-full bg-theme-surface">
    <native:column class="w-full p-5 gap-5">

        {{-- CARD VARIANTS --}}
        <native:text class="text-lg font-semibold">Card — variants</native:text>

        <native:column class="w-full p-4 gap-1 bg-slate-100 rounded-xl">
            <native:text class="font-semibold">Filled</native:text>
            <native:text class="text-sm text-gray-600">surface-variant background, no stroke. Medium emphasis — the default.</native:text>
        </native:column>

        <native:column class="w-full p-4 gap-1 bg-white rounded-xl border border-slate-300">
            <native:text class="font-semibold">Outlined</native:text>
            <native:text class="text-sm text-gray-600">surface background + outline stroke. Lower emphasis, crisp edges.</native:text>
        </native:column>

        <native:column class="w-full p-4 gap-1 bg-white rounded-xl shadow">
            <native:text class="font-semibold">Elevated</native:text>
            <native:text class="text-sm text-gray-600">surface + soft shadow. Highest emphasis — floats off the background.</native:text>
        </native:column>

        <native:divider class="my-2" />

        {{-- CHIPS --}}
        <native:text class="text-lg font-semibold">Chip (composed)</native:text>
        <native:text class="text-sm text-gray-600">Tap to toggle:</native:text>
        <native:row class="gap-2 flex-wrap">
            @foreach ([
                ['field' => 'subscribed',    'label' => 'Subscribed',     'icon' => 'favorite'],
                ['field' => 'termsAccepted', 'label' => 'Terms accepted', 'icon' => 'check'],
            ] as $row)
                @php $sel = $this->{$row['field']}; @endphp
                <native:pressable @press="toggleField('{{ $row['field'] }}')">
                    <native:row class="items-center gap-1 px-3 py-2 rounded-full {{ $sel ? 'bg-teal-600' : 'bg-slate-100' }} border {{ $sel ? 'border-teal-600' : 'border-slate-300' }}">
                        <native:icon :name="$row['icon']" :size="14" :color="$sel ? '#FFFFFF' : '#475569'"/>
                        <native:text class="text-sm font-medium {{ $sel ? 'text-white' : 'text-slate-900' }}">{{ $row['label'] }}</native:text>
                    </native:row>
                </native:pressable>
            @endforeach
        </native:row>

        <native:divider class="my-2" />

        {{-- BADGES --}}
        <native:text class="text-lg font-semibold">Badge</native:text>
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
        <native:text class="text-lg font-semibold">Profile card</native:text>
        <native:column class="w-full p-5 gap-3 bg-white rounded-2xl shadow">
            <native:row class="w-full gap-3 items-center">
                <native:column class="w-[60] h-[60] rounded-full bg-purple-500 items-center justify-center">
                    <native:text class="text-white text-xl font-bold">SR</native:text>
                </native:column>
                <native:column class="flex-1 gap-0">
                    <native:text class="text-base font-bold">Shane Rosenthal</native:text>
                    <native:text class="text-sm text-gray-500">srosenthal@example.com</native:text>
                </native:column>
            </native:row>
            <native:divider />
            <native:row class="w-full justify-around">
                <native:column class="items-center">
                    <native:text class="text-xl font-bold">142</native:text>
                    <native:text class="text-xs text-gray-500">Posts</native:text>
                </native:column>
                <native:column class="items-center">
                    <native:text class="text-xl font-bold">1.2K</native:text>
                    <native:text class="text-xs text-gray-500">Followers</native:text>
                </native:column>
                <native:column class="items-center">
                    <native:text class="text-xl font-bold">312</native:text>
                    <native:text class="text-xs text-gray-500">Following</native:text>
                </native:column>
            </native:row>
        </native:column>

        <native:divider class="my-2" />

        {{-- LIST ITEMS --}}
        <native:text class="text-lg font-semibold">List items</native:text>
        <native:column class="w-full bg-white rounded-xl">
            @foreach ([
                ['icon' => 'bell',   'title' => 'Notifications',   'sub' => 'Push, email, in-app'],
                ['icon' => 'lock',   'title' => 'Privacy',         'sub' => 'Account & data'],
                ['icon' => 'globe',  'title' => 'Language',        'sub' => 'English (US)'],
                ['icon' => 'help',   'title' => 'Help & support',  'sub' => 'FAQ, contact us'],
            ] as $i => $row)
                <native:row class="items-center gap-3 px-4 py-3">
                    <native:icon :name="$row['icon']" :size="20" color="#475569" />
                    <native:column class="flex-1 gap-0">
                        <native:text class="text-base font-medium">{{ $row['title'] }}</native:text>
                        <native:text class="text-sm text-gray-500">{{ $row['sub'] }}</native:text>
                    </native:column>
                    <native:icon name="chevron_right" :size="18" color="#9CA3AF" />
                </native:row>
                @if (! $loop->last)
                    <native:divider />
                @endif
            @endforeach
        </native:column>

    </native:column>
</native:scroll-view>
