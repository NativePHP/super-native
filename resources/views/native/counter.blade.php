<column class="w-full h-full items-center justify-center bg-theme-surface-variant gap-8">
    <text content-transition="numeric" animate-duration="250" class="text-[120] font-bold text-theme-on-surface-variant">
        {{ $count }}
    </text>

    {{-- Tap steps once; press-and-hold repeats with acceleration
         (pressDown arms the poll-driven repeat, pressUp disarms it). --}}
    <row class="gap-8 ">
        <pressable @pressDown="startHold('down')" @pressUp="stopHold" class="text-center px-8 py-4 shadow rounded bg-theme-secondary">
            <native:icon class="text-theme-on-secondary" :size="40" a11y-label="Decrement"
                         :android="App\Icons\Android::ArrowDropDown"
                         :ios="App\Icons\Ios::ChevronDown"/>
        </pressable>
        <pressable @pressDown="startHold('up')" @pressUp="stopHold" class="text-center px-8 py-4 shadow rounded bg-theme-primary">
            <native:icon class="text-theme-on-primary" :size="40" a11y-label="Increment" :android="App\Icons\Android::ArrowDropUp" :ios="App\Icons\Ios::ChevronUp"/>
        </pressable>
    </row>
</column>
