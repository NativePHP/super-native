<native:column class="w-full h-full items-center justify-center bg-white gap-4">
    <native:text class="text-6xl font-bold text-orange-500">{{$count}}</native:text>
    <native:row class="gap-4 justify-center">
        <native:column @press="decrement" class="px-8 py-4 shadow-lg rounded-lg bg-red-400" center>
            <native:text  class="text-center text-2xl text-white">👇</native:text>
        </native:column>
        <native:column @press="increment" class="px-8 py-4 shadow-lg rounded-lg bg-blue-400" center>
            <native:text class="text-center font-bold text-2xl text-white">👆</native:text>
        </native:column>
    </native:row>
</native:column>
