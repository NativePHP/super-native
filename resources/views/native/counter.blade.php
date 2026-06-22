<column class="w-full h-full items-center justify-center bg-white gap-8">
    <text class="text-3xl font-bold text-black">
        {{ $count }}
    </text>
    <row class="gap-8 ">
        <native:icon @longPress="increment" @press="decrement" :size="40" class="text-center text-white px-8 py-4 shadow rounded bg-red-500"
                     :android="App\Icons\Android::ArrowDropDown"
                     :ios="App\Icons\Ios::ChevronDown"
        />
        <native:icon @press="increment" :size="40" class="text-center text-white px-8 py-4 shadow rounded bg-blue-500"
                     :android="App\Icons\AndroidOutlined::ArrowDropUp"
                     :ios="App\Icons\Ios::ChevronUp"
        />
    </row>
</column>
