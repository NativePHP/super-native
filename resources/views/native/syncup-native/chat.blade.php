{{-- Standard chat layout: scroll-view fills available height (flex-1),
     input row pinned at the bottom of the column. SwiftUI's automatic
     keyboard avoidance pushes the whole column up when the keyboard
     appears so the input stays visible above it. No layout-level
     bottomBar slot needed — the bar is part of the screen content. --}}
<native:stack class="w-full h-full bg-theme-background">

    {{-- Messages — flex-1 so they fill the space between the navbar and
         the input bar. --}}
    <native:scroll-view class="w-full h-full">
        <native:column class="w-full px-5 py-4 gap-3 pb-[80]">

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

        </native:column>
    </native:scroll-view>

    {{-- Input bar — fully transparent so the column's bg-theme-background
         extends edge-to-edge through it (iMessage / WhatsApp / Telegram
         pattern: bg fills the screen, input pill floats glass on top).
         No safe-area-bottom — NavigationStack already insets content above
         the home indicator; adding it here doubles the gap. --}}
    {{-- Input bar in a column that fills the stack's height with
         `justify-end`, pushing the row to the bottom edge. The column is
         transparent so scroll content shows through everywhere except
         where the row's glass pills sit. --}}
    <native:column class="w-full h-full justify-end">
    <native:row class="w-full px-8 pb-6 gap-2 items-center">

        <native:pressable @press="increment" class="glass:interactive rounded-full p-2 items-center justify-center">
            <native:icon name="plus.circle" class="text-gray-700"/>
        </native:pressable>

        {{-- Message field: chromeless `<native:bare-text-input>` wrapped in
             a glass pill row. The bare input has no outline / label / fill
             of its own — the surrounding row owns the visible chrome
             (rounded-full + glass material), which is the iMessage /
             WhatsApp / Telegram pattern exactly. --}}
        <native:row class="flex-1 glass rounded-full px-4 py-2 items-center">
            <native:bare-text-input
                native:model="draft"
                placeholder="Message"
                class="flex-1"
                @submit="send"
            />
        </native:row>

        {{-- Mic when field is empty; primary-tinted send when there's text.
             Mirrors iMessage's mic↔send swap. --}}
        @if (trim($draft) === '')
            <native:pressable @press="increment" class="glass:interactive rounded-full p-2 items-center justify-center">
                <native:icon name="mic" class="text-gray-700"/>
            </native:pressable>
        @else
            <native:pressable @press="send" class="glass:interactive rounded-full p-2  items-center justify-center">
                <native:icon name="paperplane.fill" class="text-gray-700"/>
            </native:pressable>
        @endif

    </native:row>
    </native:column>

    {{-- More-actions modal — opened by the NavBar ellipsis. Dismissible. --}}
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

    {{-- Blocking clear-history confirmation. dismissible=false. --}}
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

</native:stack>
