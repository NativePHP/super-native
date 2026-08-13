{{--
    Nothing here mentions the sidebar, and that is the point: it is window
    furniture the host puts beside every screen (SupaNative\Desktop\Edge\
    SidebarChrome), not markup a screen carries. This file used to open with a
    `<row>` root and a `@desktop` include, which is what a nav has to look like
    when it belongs to the screen rather than to the window.
--}}
<native:column class="w-full h-full p-8 gap-6 bg-slate-950">

    <native:column class="gap-1">
        <native:text class="text-2xl font-bold text-white">{{ config('app.name') }} — desktop</native:text>
        <native:text class="text-sm text-slate-400">
            Laravel {{ app()->version() }} on PHP {{ PHP_VERSION }}, {{ $surfaces }} surface(s) live — rendered from Blade.
        </native:text>
    </native:column>

    {{-- COUNTER — this window's own state --}}
    <native:column class="w-full bg-slate-900 rounded-xl p-6 gap-4">
        <native:text class="text-xs font-semibold text-slate-400">COUNTER — this window's own state</native:text>
        <native:text class="text-5xl font-bold text-indigo-400">{{ $count }}</native:text>
        <native:row class="gap-3">
            <native:pressable class="px-5 py-2 rounded bg-slate-800" @press="decrement">
                <native:text class="text-base font-semibold text-white">−</native:text>
            </native:pressable>
            <native:pressable class="px-5 py-2 rounded bg-indigo-600" @press="increment">
                <native:text class="text-base font-semibold text-white">+</native:text>
            </native:pressable>
        </native:row>
    </native:column>

    {{-- WINDOWS — one process, one event loop --}}
    <native:column class="w-full bg-slate-900 rounded-xl p-6 gap-4">
        <native:text class="text-xs font-semibold text-slate-400">WINDOWS — one process, one event loop</native:text>
        <native:row class="gap-3">
            <native:pressable class="px-5 py-2 rounded bg-emerald-600" @press="openSettings">
                <native:text class="text-base font-semibold text-white">Open settings window</native:text>
            </native:pressable>
            <native:pressable class="px-5 py-2 rounded bg-slate-800" @press="closeSettings">
                <native:text class="text-base font-semibold text-white">Close it</native:text>
            </native:pressable>
        </native:row>
        @foreach ($windows as $key => $surface)
            <native:text class="text-xs text-slate-400">{{ $key }} → surface {{ $surface }}</native:text>
        @endforeach
    </native:column>

    <native:spacer />

    <native:row class="gap-3 items-center">
        <native:pressable class="px-5 py-2 rounded bg-rose-700" @press="quit">
            <native:text class="text-base font-semibold text-white">Quit</native:text>
        </native:pressable>
        <native:text class="text-xs text-slate-500">Last action: {{ $last }}</native:text>
    </native:row>

</native:column>
