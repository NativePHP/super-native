<column class="w-full h-full items-center justify-center bg-theme-surface-variant gap-8">
    <text @press="testCamera" class="text-[120] font-bold text-theme-on-surface-variant">
        {{ $count * 8}}
    </text>

    <row class="gap-8 ">
        <native:icon @longPress="increment" @press="decrement" :size="40"
                     a11y-label="Decrement"
                     class="text-center text-white px-8 py-4 shadow rounded bg-orange-500"
                     :android="App\Icons\Android::ArrowDropDown"
                     :ios="App\Icons\Ios::ChevronDown"
        />
        <native:icon @press="increment" :size="40" a11y-label="Increment"
                     class="text-center text-white px-8 py-4 shadow rounded bg-blue-500"
                     :android="App\Icons\AndroidOutlined::ArrowDropUp"
                     :ios="App\Icons\Ios::ChevronUp"
        />
    </row>
</column>
