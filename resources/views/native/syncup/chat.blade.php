<native:column class="w-full h-full bg-theme-background gap-4">

    {{-- Message thread --}}
    <native:scroll-view class="w-full flex-1">
        <native:column class="w-full px-5 py-4 gap-3">

            {{-- Date divider --}}
            <native:row class="w-full justify-center my-2">
                <native:column class="px-3 py-1 rounded-full bg-theme-surface-variant">
                    <native:text class="text-[12] font-semibold text-theme-on-surface-variant">TODAY</native:text>
                </native:column>
            </native:row>

            {{-- Messages --}}
            @foreach ($messages as $m)
                @if ($m['fromMe'])
                    {{-- Outgoing — primary bubble, right-aligned --}}
                    <native:row class="w-full justify-end">
                        <native:column class="w-[280] bg-[#00677d] rounded-2xl px-4 py-3 gap-1">
                            <native:text class="text-[14] text-white">{{ $m['text'] }}</native:text>
                            <native:row class="items-center justify-end gap-1">
                                <native:text class="text-[10] text-[#a5f3fc]">{{ $m['time'] }}</native:text>
                                @if (($m['status'] ?? null) === 'read')
                                    <native:icon name="checkmark" :size="14" color="#a5f3fc"/>
                                @elseif (($m['status'] ?? null) === 'sent')
                                    <native:icon name="checkmark" :size="14" color="#7dd3fc"/>
                                @endif
                            </native:row>
                        </native:column>
                    </native:row>
                @else
                    {{-- Incoming — light gray bubble, left-aligned --}}
                    <native:row class="w-full">
                        <native:column class="w-[280] bg-theme-surface-variant rounded-2xl px-4 py-3 gap-1 border border-theme-outline">
                            @if (! empty($m['imageUrl']))
                                <native:image src="{{ $m['imageUrl'] }}" class="w-full h-[180] rounded-xl" :fit="2"/>
                            @endif
                            <native:text class="text-[14] text-theme-on-surface">{{ $m['text'] }}</native:text>
                            <native:row class="justify-end">
                                <native:text class="text-[10] text-theme-on-surface-variant">{{ $m['time'] }}</native:text>
                            </native:row>
                        </native:column>
                    </native:row>
                @endif
            @endforeach

            {{-- Typing indicator --}}
            <native:row class="w-full items-center gap-1 ml-2">
                <native:column class="w-[8] h-[8] rounded-full bg-[#cbd5e1] dark:bg-slate-600"/>
                <native:column class="w-[8] h-[8] rounded-full bg-[#cbd5e1] dark:bg-slate-600"/>
                <native:column class="w-[8] h-[8] rounded-full bg-[#cbd5e1] dark:bg-slate-600"/>
            </native:row>

        </native:column>
    </native:scroll-view>
    <native:divider/>
    <native:row class="w-full gap-2 w-full bg-theme-surface border-t border-theme-outline px-4 pt-3 items-center justify-center">
        <native:icon name="plus.circle.fill" :size="24" color="#64748b" dark-color="#94a3b8"/>
        <native:outlined-text-input
            value="{{ $draft }}"
            placeholder="Message..."
            @change="setDraft"
            class="flex-1"
            :variant="0"
            :multiline="true"
            leading-icon="face.smiling"
        />
        <native:icon name="paperplane.fill" :size="24" color="#94a3b8" dark-color="#64748b"/>
    </native:row>

    {{-- More-actions modal — opened by the NavBar ellipsis. Dismissible
         (tap backdrop to close). --}}
    <native:modal :visible="$showMoreActions" :dismissible="true" @dismiss="closeMoreActions">
        <native:column class="w-full p-2 bg-theme-surface rounded-3xl">
            <native:column @press="toggleMute" class="w-full px-5 py-4">
                <native:row class="items-center gap-3">
                    <native:icon name="{{ $isMuted ? 'speaker.slash.fill' : 'bell.fill' }}" :size="20" color="#0F172A" dark-color="#F1F5F9" />
                    <native:column class="flex-1 gap-1">
                        <native:text class="text-base font-semibold text-theme-on-surface">{{ $isMuted ? 'Unmute notifications' : 'Mute notifications' }}</native:text>
                        <native:text class="text-[12] text-theme-on-surface-variant">{{ $isMuted ? 'You will hear notifications again.' : 'No banners or sounds for this chat.' }}</native:text>
                    </native:column>
                </native:row>
            </native:column>
            <native:divider />
            <native:column @press="askClearHistory" class="w-full px-5 py-4">
                <native:row class="items-center gap-3">
                    <native:icon name="trash.fill" :size="20" color="#EF4444" />
                    <native:column class="flex-1 gap-1">
                        <native:text class="text-base font-semibold text-[#EF4444]">Clear history</native:text>
                        <native:text class="text-[12] text-theme-on-surface-variant">Removes every message in this chat. Cannot be undone.</native:text>
                    </native:column>
                </native:row>
            </native:column>
            <native:divider />
            <native:column @press="closeMoreActions" class="w-full px-5 py-4">
                <native:row class="items-center justify-center gap-2">
                    <native:text class="text-base font-medium text-theme-on-surface-variant">Cancel</native:text>
                </native:row>
            </native:column>
        </native:column>
    </native:modal>

    {{-- Blocking clear-history confirmation. dismissible=false so the user
         must explicitly choose. --}}
    <native:modal :visible="$showClearConfirm" :dismissible="false">
        <native:column class="w-full p-6 gap-4 bg-theme-surface rounded-3xl">
            <native:text class="text-xl font-bold text-theme-on-surface">Clear chat history?</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">This permanently deletes the message thread. There's no undo.</native:text>
            <native:row class="w-full gap-2 mt-2">
                <native:column @press="cancelClearHistory" class="flex-1 px-4 py-3 rounded-xl bg-theme-surface-variant items-center">
                    <native:text class="font-semibold text-theme-on-surface">Cancel</native:text>
                </native:column>
                <native:column @press="confirmClearHistory" class="flex-1 px-4 py-3 rounded-xl bg-[#EF4444] items-center">
                    <native:text class="text-white font-semibold">Delete</native:text>
                </native:column>
            </native:row>
        </native:column>
    </native:modal>

</native:column>
