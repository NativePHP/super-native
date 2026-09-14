@php use App\Icons\Android; use App\Icons\Ios; @endphp
<scroll-view class="flex-1 w-full">
    <column class="flex-1 p-5 gap-4">
        <text class="text-3xl font-bold">Categories</text>
        <text class="text-sm text-theme-on-surface-variant">Tabs preserve their own state. Switch tabs and come back.</text>

        <divider />

        @foreach ($categories as $cat)
            <row class="items-center gap-3 py-4 px-3 bg-theme-surface-variant rounded-lg">
                <icon :ios="Ios::Folder" :android="Android::Folder" :size="22" color="#6366F1" />
                <text class="text-base font-medium flex-1">{{ $cat }}</text>
                <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="18" color="#9CA3AF" />
            </row>
        @endforeach
    </column>
</scroll-view>
