{{--
    A screen that is genuinely shared: this is the phone's counter, and on a Mac
    it is the same screen with a sidebar beside it — which this file says nothing
    about, and neither does any of the other 83. The sidebar is window furniture
    now (SupaNative\Desktop\Edge\SidebarChrome), applied once per published frame
    by the host, so a screen never has to leave room for it, include it, or make
    its root a `<row>` to hold it.

    What is left here is the `@desktop` / `@mobile` pair doing what they are
    actually for: one word of copy that differs between a tap and a click. On the
    platform that skips a block, its contents are never rendered at all — the
    directive compiles to a runtime `if`, not a compile-time splice.
--}}
<column class="w-full h-full items-center justify-center gap-8 bg-theme-surface-variant">
    <text content-transition="numeric" animate-duration="250" class="text-[120] font-bold text-theme-on-surface-variant">
        {{ $count }}
    </text>

    {{-- Tap steps once; press-and-hold accelerates.

         `@hold` fires on contact and then keeps firing — 1, 2, 4, 8, 16
         times a second as the hold continues — each event carrying a
         `speed` the handler multiplies its step by. The timing is the
         renderer's, not PHP's: there is no poll on this screen and no tick
         counter behind it. `@release` fires when the press ends, and the
         held button dims until it does. --}}
    <row class="gap-8 ">
        <pressable @hold="hold('down')" @release="release" class="text-center px-8 py-4 shadow rounded bg-theme-secondary {{ $holding === 'down' ? 'opacity-70' : '' }}">
            <native:icon class="text-theme-on-secondary" :size="40" a11y-label="Decrement"
                         :android="App\Icons\Android::ArrowDropDown"
                         :ios="App\Icons\Ios::ChevronDown"/>
        </pressable>
        <pressable @hold="hold('up')" @release="release" class="text-center px-8 py-4 shadow rounded bg-theme-primary {{ $holding === 'up' ? 'opacity-70' : '' }}">
            <native:icon class="text-theme-on-primary" :size="40" a11y-label="Increment" :android="App\Icons\Android::ArrowDropUp" :ios="App\Icons\Ios::ChevronUp"/>
        </pressable>
    </row>

    @mobile
        <text class="text-xs text-theme-on-surface-variant">Tap or hold ±</text>
    @endmobile

    @desktop
        <text class="text-xs text-theme-on-surface-variant">Click or hold ±</text>
    @enddesktop
</column>
