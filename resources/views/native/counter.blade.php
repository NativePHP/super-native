{{--
    A screen that is genuinely shared: this is the phone's counter, and it grows a
    permanent sidebar on a Mac without a second template or a platform check in
    PHP. The `<row>` root and the `@desktop` block are the whole mechanism — on a
    phone the block's contents are never rendered, so the row has one child and
    the screen is exactly what it always was.
--}}
<row class="w-full h-full bg-theme-surface-variant">

    @desktop
        @include('native.partials.desktop-sidebar', ['active' => 'counter'])
    @enddesktop

    <column class="w-full h-full items-center justify-center gap-8">
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

        {{-- The inverse block. A bottom nav belongs on a phone and not beside a
             sidebar, so this line is the shape that argument takes: present on
             mobile, absent on desktop. --}}
        @mobile
            <text class="text-xs text-theme-on-surface-variant">Tap or hold ±</text>
        @endmobile
    </column>

</row>
