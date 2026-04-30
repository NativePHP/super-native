<native:scroll-view class="w-full bg-theme-background">
    <native:column class="w-full p-5 gap-5">

        @php
            $sections = [
                'Navigation'           => ['home', 'menu', 'settings', 'dashboard', 'search', 'filter', 'back', 'forward'],
                'Content'              => ['favorite', 'star', 'bookmark', 'image', 'video', 'folder', 'file', 'edit'],
                'Communication'        => ['chat_bubble', 'message', 'email', 'phone', 'notifications', 'bell', 'share'],
                'Actions'              => ['add', 'delete', 'save', 'refresh', 'check', 'close', 'download', 'upload'],
                'Status'               => ['verified', 'check', 'close', 'warning', 'error', 'info', 'help', 'visibility'],
                'Device'               => ['camera', 'qrcode', 'smartphone', 'fingerprint', 'lightbulb', 'map', 'globe', 'bolt'],
                'Commerce'             => ['cart', 'shop', 'orders', 'products', 'chart'],
                'SF Symbols (direct)'  => ['arrow.right', 'minus.circle.fill', 'square.and.pencil', 'paperplane.fill', 'flame.fill'],
            ];
        @endphp

        @foreach ($sections as $heading => $names)
            <native:text class="text-lg font-semibold text-theme-on-background">{{ $heading }}</native:text>
            <native:scroll-view :horizontal="true" class="w-full">
                <native:row class="gap-3 px-1">
                    @foreach ($names as $n)
                        <native:column class="w-[88] items-center gap-1 p-3 bg-theme-surface-variant rounded-lg">
                            <native:icon :name="$n" :size="28" class="text-slate-800 dark:text-white" />
                            <native:text class="text-xs text-center text-theme-on-surface">{{ $n }}</native:text>
                        </native:column>
                    @endforeach
                </native:row>
            </native:scroll-view>
            <native:divider class="my-1" />
        @endforeach

    </native:column>
</native:scroll-view>
