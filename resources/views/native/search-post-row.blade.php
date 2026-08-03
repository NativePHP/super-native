<row class="items-start gap-3 px-4 py-3" @tap="openPost({{ $post['id'] }})">
    <column class="w-10 h-10 rounded-full bg-theme-primary items-center justify-center">
        <text class="text-theme-on-primary font-semibold">P</text>
    </column>
    <column class="flex-1 gap-1">
        <text class="font-semibold">{{ str($post['title'])->title()->limit(20) }}</text>
        <text class="text-sm text-theme-on-surface-variant">
            {{ str($post['body'])->limit(100) }}
        </text>
    </column>
    <text class="text-xs text-theme-on-surface-variant px-2 py-1 rounded bg-theme-surface-variant">
        #{{ $post['id'] }}
    </text>
</row>
