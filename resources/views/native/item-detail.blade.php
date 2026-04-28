<native:column class="flex-1 w-full p-5 gap-4">
    <native:column class="w-full h-[160] rounded-xl bg-blue-500 items-center justify-center">
        <native:text class="text-white text-5xl font-bold">#{{ $id }}</native:text>
    </native:column>

    <native:text class="text-2xl font-bold">{{ $title }}</native:text>
    <native:text class="text-sm text-gray-500">
        This is a pushed detail screen. Tap the back arrow in the top bar,
        or swipe from the left edge to pop.
    </native:text>

    <native:divider />

    <native:button label="Go back" @press="back" class="bg-gray-200 rounded-lg px-5 py-3 mt-2" />
</native:column>
