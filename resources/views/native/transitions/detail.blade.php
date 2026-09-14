@php use App\Icons\Android; use App\Icons\Ios; @endphp
<column class="w-full h-full safe-area items-center justify-center gap-6 p-8 bg-[{{ $color }}]">

    <column class="w-[72] h-[72] rounded-full items-center justify-center bg-white shadow">
        <icon :ios="Ios::Checkmark" :android="Android::Check" :size="34" color="{{ $color }}" />
    </column>

    <column class="items-center gap-1">
        <text class="text-base text-white">Arrived via</text>
        <text class="text-3xl font-bold text-white text-center">{{ $via }}</text>
    </column>

    <text class="text-sm text-white text-center px-4">
        Pushed with the {{ $via }} transition. Tap back to pop it off the stack.
    </text>

    <row @navigate.back class="items-center gap-2 mt-2">
        <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="#FFFFFF" />
        <text class="text-base font-semibold text-white">Back</text>
    </row>

</column>
