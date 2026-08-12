<native:row class="w-full h-full bg-slate-950">

    {{-- side_nav + side_nav_header + side_nav_item + side_nav_group --}}
    {{-- pt-8 because the window hides its title bar and draws content to the
         top edge, so without it the pinned header sits under the traffic lights. --}}
    <native:side-nav class="h-full pt-8 bg-slate-900" dark="true" label-visibility="labeled">
        <native:side-nav-header
            title="side_nav_header"
            subtitle="pinned, stays put"
            icon="square.grid.2x2"
            pinned="true" />

        <native:side-nav-item label="side_nav_item (active)" icon="house" active="true" @press="pick('side_nav_item active')" />
        <native:side-nav-item label="side_nav_item (badge)" icon="tray.full" badge="3" badge-color="lime" @press="pick('side_nav_item badge')" />

        <native:side-nav-group heading="side_nav_group" icon="folder" expanded="true">
            <native:side-nav-item label="nested item A" icon="doc" @press="pick('nested A')" />
            <native:side-nav-item label="nested item B" icon="doc" @press="pick('nested B')" />
        </native:side-nav-group>

        <native:divider />

        <native:side-nav-group heading="side_nav_group (collapsed)" icon="archivebox">
            <native:side-nav-item label="hidden until opened" icon="doc" @press="pick('hidden')" />
        </native:side-nav-group>
    </native:side-nav>

    <native:column class="w-full h-full p-6 gap-4">

        <native:column class="gap-1">
            <native:text class="text-xl font-bold text-white">Renderer batch 1 — 14 element types</native:text>
            <native:text class="text-xs text-slate-400">
                Every block is labelled with the wire type it renders. Last side-nav / gesture action: {{ $lastNav }}
            </native:text>
        </native:column>

        {{--
            Platform variants. The shell declares NATIVEPHP_PLATFORM before PHP
            boots, so core resolves `macos` with no bridge call and this row
            should be emerald and say so. Every ios:/android: class here targets
            an alarming red on purpose: if any of them leaked, this block turns
            red rather than failing quietly.
        --}}
        <native:row class="gap-3 items-center rounded-lg p-3 macos:bg-emerald-950 ios:bg-red-700 android:bg-red-700">
            <native:text class="text-xs font-bold macos:text-emerald-400 ios:text-white android:text-white">
                platform variants
            </native:text>
            <native:text class="text-xs macos:text-emerald-200 ios:text-white android:text-white">
                System::platform() = {{ \SupaNative\Desktop\Facades\System::platform() ?? 'unknown' }} — every colour on
                this row comes from a macos: class. The ios:/android: class beside each one did not apply.
            </native:text>
        </native:row>

        {{-- column, button, toggle --}}
        <native:row class="gap-4 items-start">

            <native:column class="bg-slate-900 rounded-lg p-4 gap-2">
                <native:text class="text-xs font-bold text-emerald-400">column</native:text>
                <native:text class="text-xs text-slate-300">its own case now,</native:text>
                <native:text class="text-xs text-slate-300">not the default fallthrough</native:text>
            </native:column>

            <native:column class="bg-slate-900 rounded-lg p-4 gap-2">
                <native:text class="text-xs font-bold text-emerald-400">button</native:text>
                <native:button @press="press">Pressed {{ $presses }}×</native:button>
                <native:button variant="secondary" @press="press">secondary</native:button>
                <native:button variant="destructive" @press="press">destructive</native:button>
            </native:column>

            <native:column class="bg-slate-900 rounded-lg p-4 gap-2">
                <native:text class="text-xs font-bold text-emerald-400">toggle</native:text>
                <native:toggle label="flip me" :value="$flag" @change="flip" />
                <native:text class="text-xs text-slate-300">PHP holds: {{ $flag ? 'on' : 'off' }}</native:text>
            </native:column>

            <native:column class="bg-slate-900 rounded-lg p-4 gap-2">
                <native:text class="text-xs font-bold text-emerald-400">activity_indicator</native:text>
                <native:row class="gap-4 items-center">
                    <native:activity-indicator size="sm" />
                    <native:activity-indicator size="md" />
                    <native:activity-indicator size="lg" />
                </native:row>
            </native:column>

        </native:row>

        {{-- text_input, canvas + rect + circle + line, gesture_area --}}
        <native:row class="gap-4 items-start">

            <native:column class="bg-slate-900 rounded-lg p-4 gap-2 w-72">
                <native:text class="text-xs font-bold text-emerald-400">text_input</native:text>
                <native:text-input placeholder="type here…" :value="$typed" @change="typing" @submit="submitted" />
                <native:text class="text-xs text-slate-300">PHP holds: "{{ $typed }}"</native:text>
            </native:column>

            <native:column class="bg-slate-900 rounded-lg p-4 gap-2">
                <native:text class="text-xs font-bold text-emerald-400">canvas + rect + circle + line</native:text>
                <native:canvas class="w-56 h-28 bg-slate-950 rounded">
                    <native:rect class="w-20 h-10 bg-indigo-500 rounded" left="12" top="14" />
                    <native:circle class="w-14 h-14 bg-amber-400" left="120" top="10" />
                    <native:line from="12,80" to="200,100" class="border-2 border-emerald-400" />
                </native:canvas>
            </native:column>

            <native:column class="bg-slate-900 rounded-lg p-4 gap-2">
                <native:text class="text-xs font-bold text-emerald-400">gesture_area</native:text>
                <native:gesture-area :pan-y="$drag" @press="tapped" @longPress="held">
                    <native:column class="w-40 h-20 bg-slate-800 rounded items-center justify-center gap-1">
                        <native:text class="text-xs text-white">tap / hold / drag</native:text>
                        <native:text class="text-xs text-slate-400">me</native:text>
                    </native:column>
                </native:gesture-area>
            </native:column>

        </native:row>

        {{-- lazy_grid --}}
        <native:column class="w-full bg-slate-900 rounded-lg p-4 gap-2">
            <native:text class="text-xs font-bold text-emerald-400">lazy_grid (4 columns)</native:text>
            <native:lazy-grid :columns="4" :gap="8" class="w-full h-24">
                @foreach ($cells as $cell)
                    <native:column class="bg-slate-800 rounded p-3 items-center">
                        <native:text class="text-xs text-slate-200">cell {{ $cell }}</native:text>
                    </native:column>
                @endforeach
            </native:lazy-grid>
        </native:column>

    </native:column>

</native:row>
