<top-bar back :background-color="'3119a2'" :text-color="'FFFFFF'"></top-bar>
<column class="w-full h-full  items-center justify-center gap-12">
    <text class="text-[130] font-bold text-white">{{number_format($count * pi(), 3) }}</text>
    <row class="gap-10">
        <pressable @tap="decrement" class="glass:interactive bg-white p-6 rounded">
            <native:icon size="40" class="text-theme-primary" :ios="\App\Icons\Ios::Minus" :android="\App\Icons\Android::Add" />
        </pressable>
        <pressable @tap="increment" class="glass:interactive bg-red-600 p-6 rounded">
            <native:icon size="40" class="text-white" :ios="\App\Icons\Ios::Plus" :android="\App\Icons\Android::Remove" />
        </pressable>
    </row>
    <row>
        <column class="bg-[#FF3700] w-[30]" />
        <column class="bg-[#00D1FF] w-[30]" />
        <column class="bg-[#FFBFEA] w-[30]" />
        <column class="bg-[#FFF500] w-[30]" />
    </row>
</column>
{{--<stack class="w-full h-full full-bleed items-center justify-center">--}}
{{--    <scroll-view axis="both" class="w-full h-full shadow-lg">--}}
{{--        <image src="https://images.nationalgeographic.org/image/upload/v1638892520/EducationHub/photos/stream-in-colorado.jpg"--}}
{{--               class="w-[2400] h-[1600]"/>--}}
{{--    </scroll-view>--}}

{{--    <column class="w-full h-full px-10">--}}
{{--        <text class="glass:clear:interactive bg-yellow-600/30 px-4 text-center py-2 my-64 font-bold rounded-full text-2xl ">Liquid Glass Baby</text>--}}
{{--    </column>--}}
{{--</stack>--}}
