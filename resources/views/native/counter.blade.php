<column class="w-full h-full items-center justify-center gap-8">
    <text class="text-[120] font-bold text-theme-on-surface-variant">
        {{ $count  * 90 }}
    </text>
    <row class="gap-8 ">
        <pressable @tap="decrement" class="text-center px-8 py-4 shadow rounded bg-theme-secondary">
            <native:icon class="text-theme-on-secondary" :size="40" a11y-label="Decrement"
                         :android="App\Icons\Android::ArrowDropDown"
                         :ios="App\Icons\Ios::ChevronDown"/>
        </pressable>
        <pressable @tap="increment" class="text-center px-8 py-4 shadow rounded bg-theme-primary">
            <native:icon class="text-theme-on-primary" :size="40" a11y-label="Increment" :android="App\Icons\Android::ArrowDropUp" :ios="App\Icons\Ios::ChevronUp"/>
        </pressable>
    </row>
</column>
