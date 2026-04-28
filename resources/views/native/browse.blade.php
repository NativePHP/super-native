<native:scroll-view class="flex-1 w-full">
    <native:column class="flex-1 p-5 gap-4">
        <native:text class="text-3xl font-bold">Categories</native:text>
        <native:text class="text-sm text-gray-500">Tabs preserve their own state. Switch tabs and come back.</native:text>

        <native:divider />

        @foreach ($categories as $cat)
            <native:row class="items-center gap-3 py-4 px-3 bg-gray-100 rounded-lg">
                <native:icon name="folder" :size="22" color="#6366F1" />
                <native:text class="text-base font-medium flex-1">{{ $cat }}</native:text>
                <native:icon name="chevron_right" :size="18" color="#9CA3AF" />
            </native:row>
        @endforeach
    </native:column>
</native:scroll-view>
