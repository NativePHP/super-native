<native:column class="flex-1 w-full p-5 gap-4 items-center">
    <native:column class="w-[88] h-[88] rounded-full bg-purple-500 items-center justify-center mt-6">
        <native:text class="text-white text-3xl font-bold">SR</native:text>
    </native:column>

    <native:text class="text-2xl font-bold">{{ $name }}</native:text>
    <native:text class="text-sm text-gray-500">{{ $email }}</native:text>

    <native:row class="gap-8 mt-4">
        <native:column class="items-center">
            <native:text class="text-xl font-bold">{{ $followers }}</native:text>
            <native:text class="text-xs text-gray-500">Followers</native:text>
        </native:column>
        <native:column class="items-center">
            <native:text class="text-xl font-bold">{{ $following }}</native:text>
            <native:text class="text-xs text-gray-500">Following</native:text>
        </native:column>
    </native:row>
</native:column>
