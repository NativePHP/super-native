<column class="w-full h-full items-center justify-center bg-theme-surface-variant gap-8">
    <text class="text-[120] font-bold text-theme-on-surface-variant">
        {{ $count }}
    </text>
    @if($photo)
        <image :src="photo" class="w-full h-full" />
    @endif
    <row class="gap-8 ">
        <pressable @press="decrement" class="text-center text-white px-8 py-4 shadow rounded bg-orange-500">
            <native:icon class="text-white" :size="40" a11y-label="Decrement"
                         :android="App\Icons\Android::ArrowDropDown"
                         :ios="App\Icons\Ios::ChevronDown"/>
        </pressable>
        <pressable @press="increment" class="text-center text-white px-8 py-4 shadow rounded bg-blue-500">
            <native:icon class="text-white" :size="40" a11y-label="Decrement" :android="App\Icons\Android::ArrowDropUp" :ios="App\Icons\Ios::ChevronUp"/>
        </pressable>
    </row>
</column>
