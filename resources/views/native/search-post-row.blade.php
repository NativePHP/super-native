<native:row class="items-start gap-3 px-4 py-3"
            @press="openPost({{ $post['id'] }})">
    <native:column class="w-10 h-10 rounded-full bg-green-100
                                  items-center justify-center">
        <native:text class="text-green-700 font-semibold">P</native:text>
    </native:column>
    <native:column class="flex-1 gap-1">
        <native:text class="font-semibold">{{ $post['title'] }}</native:text>
        <native:text class="text-sm text-gray-500">
            {{ \Illuminate\Support\Str::limit($post['body'], 120) }}
        </native:text>
    </native:column>
    <native:text class="text-xs text-gray-400 px-2 py-1 rounded bg-gray-100">
        #{{ $post['id'] }}
    </native:text>
</native:row>
