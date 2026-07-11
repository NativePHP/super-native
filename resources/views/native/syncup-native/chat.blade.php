@php
    use Native\Mobile\Edge\Layouts\Builders\NavAction;
    use App\Icons\Android;
    use App\Icons\Ios;

    $pressableMenu = [
        NavAction::make('record')
            ->label('Record audio')
            ->icon(ios: Ios::Mic, android: Android::Mic)
            ->press('logRecord'),
        NavAction::make('upload')
            ->label('Upload file')
            ->icon(ios: Ios::ArrowUp, android: Android::ArrowUpward)
            ->press('logUpload'),
        NavAction::divider(),
        NavAction::make('settings')
            ->label('Audio settings')
            ->icon(ios: Ios::Gear, android: Android::Settings)
            ->press('logSettings'),
    ];
@endphp
{{-- Chat layout: a `flex-1` scroll-view of messages with an inline input
     row beneath it, inside a full-height column (same structure as the
     working chats-list screen). NOTE: keyboard avoidance is not yet solved
     for this screen — the `<native:bottom-bar>` safeAreaInset seam collapsed
     the content on this pushed tab-level config, so the input is inline for
     now and the keyboard can overlap it. Revisit once the seam is fixed. --}}
<column native:key="chat-screen" class="w-full h-full bg-theme-background">

    {{-- Messages — `flex-1` so the scroll-view fills the space above the
         inline input row (same pattern as the working chats list). --}}
    <scroll-view class="w-full flex-1" scroll-anchor="bottom">
        <column class="w-full px-5 py-4 gap-3">

            {{-- Date divider --}}
            <row class="w-full justify-center my-2">
                <column class="px-3 py-1 rounded-full bg-theme-surface-variant">
                    <text class="text-[12] font-semibold text-theme-on-surface-variant">TODAY</text>
                </column>
            </row>

            {{-- Messages --}}
            @foreach ($messages as $m)
                @if ($m['fromMe'])
                    {{-- Outgoing — primary bubble, right-aligned --}}
                    <row class="w-full justify-end">
                        <column class="w-[280] bg-[#00677d] rounded-2xl px-4 py-3 gap-1">
                            <text class="text-[14] text-white">{{ $m['text'] }}</text>
                            <row class="items-center justify-end gap-1">
                                <text class="text-[10] text-[#a5f3fc]">{{ $m['time'] }}</text>
                                @if (($m['status'] ?? null) === 'read')
                                    <icon name="checkmark" :size="14" color="#a5f3fc"/>
                                @elseif (($m['status'] ?? null) === 'sent')
                                    <icon name="checkmark" :size="14" color="#7dd3fc"/>
                                @endif
                            </row>
                        </column>
                    </row>
                @else
                    {{-- Incoming — light gray bubble, left-aligned --}}
                    <row class="w-full">
                        <column
                            class="w-[280] bg-theme-surface-variant rounded-2xl px-4 py-3 gap-1 border border-theme-outline">
                            @if (! empty($m['imageUrl']))
                                <image src="{{ $m['imageUrl'] }}" class="w-full h-[180] rounded-xl" :fit="2"/>
                            @endif
                            <text class="text-[14] text-theme-on-surface">{{ $m['text'] }}</text>
                            <row class="justify-end">
                                <text
                                    class="text-[10] text-theme-on-surface-variant">{{ $m['time'] }}</text>
                            </row>
                        </column>
                    </row>
                @endif
            @endforeach

        </column>
    </scroll-view>

    {{-- Input bar — inline as the last child of the column, above the
         `flex-1` scroll-view. Renders as a normal bottom row (no
         safeAreaInset seam, which collapsed this pushed-tab-level screen). --}}
    <row class="w-full px-3 pt-3 pb-4 gap-2 items-center bg-theme-background border-t border-theme-outline">

            <pressable
                :menu="$pressableMenu"
                a11y-label="Add attachment"
                class="glass:interactive android:dark:bg-white text-slate-700 rounded-full p-1 items-center justify-center">
                <icon name="plus.circle" class="text-gray-700"/>
            </pressable>

            {{-- Message field: chromeless `<bare-text-input>` wrapped in
                 a glass pill row. The bare input has no outline / label / fill
                 of its own — the surrounding row owns the visible chrome
                 (rounded-full + glass material), which is the iMessage /
                 WhatsApp / Telegram pattern exactly. --}}
            <bare-text-input
                native:key="chat-message-input"
                native:model="draft"
                placeholder="Message"
                class="flex-1 glass android:dark:bg-white rounded-full px-4 py-2 items-center text-slate-700"
                @submit="send"
                keep-focus-on-submit
            />

            {{-- Mic when field is empty; primary-tinted send when there's text.
                 Mirrors iMessage's mic↔send swap. --}}
            @if (trim($draft) === '')
                <pressable
                    :menu="$pressableMenu"
                    a11y-label="Record voice message"
                    class="glass:interactive android:dark:bg-white text-slate-700 rounded-full p-1 items-center justify-center">
                    <icon name="mic" class="text-gray-700"/>
                </pressable>
            @else
                <pressable @press="send" a11y-label="Send message"
                                  class="glass:interactive android:dark:bg-white text-slate-700   rounded-full p-1  items-center justify-center">
                    <icon name="paperplane.fill" class="text-gray-700"/>
                </pressable>
            @endif

        </row>

    {{-- More-actions modal — opened by the NavBar ellipsis. Dismissible. --}}
    <modal :visible="$showMoreActions" :dismissible="true" @dismiss="closeMoreActions">
        <column class="w-full p-2 bg-theme-surface rounded-3xl">
            <column @press="toggleMute" class="w-full px-5 py-4">
                <row class="items-center gap-3">
                    <icon name="{{ $isMuted ? 'speaker.slash.fill' : 'bell.fill' }}" :size="20" color="#0F172A"
                                 dark-color="#F1F5F9"/>
                    <column class="flex-1 gap-1">
                        <text
                            class="text-base font-semibold text-theme-on-surface">{{ $isMuted ? 'Unmute notifications' : 'Mute notifications' }}</text>
                        <text
                            class="text-[12] text-theme-on-surface-variant">{{ $isMuted ? 'You will hear notifications again.' : 'No banners or sounds for this chat.' }}</text>
                    </column>
                </row>
            </column>
            <divider/>
            <column @press="askClearHistory" class="w-full px-5 py-4">
                <row class="items-center gap-3">
                    <icon name="trash.fill" :size="20" color="#EF4444"/>
                    <column class="flex-1 gap-1">
                        <text class="text-base font-semibold text-[#EF4444]">Clear history</text>
                        <text class="text-[12] text-theme-on-surface-variant">Removes every message in this chat.
                            Cannot be undone.
                        </text>
                    </column>
                </row>
            </column>
            <divider/>
            <column @press="closeMoreActions" class="w-full px-5 py-4">
                <row class="items-center justify-center gap-2">
                    <text class="text-base font-medium text-theme-on-surface-variant">Cancel</text>
                </row>
            </column>
        </column>
    </modal>

    {{-- Blocking clear-history confirmation. dismissible=false. --}}
    <modal :visible="$showClearConfirm" :dismissible="false">
        <column class="w-full p-6 gap-4 bg-theme-surface rounded-3xl">
            <text class="text-xl font-bold text-theme-on-surface">Clear chat history?</text>
            <text class="text-sm text-theme-on-surface-variant">This permanently deletes the message thread.
                There's no undo.
            </text>
            <row class="w-full gap-2 mt-2">
                <column @press="cancelClearHistory"
                               class="flex-1 px-4 py-3 rounded-xl bg-theme-surface-variant items-center">
                    <text class="font-semibold text-theme-on-surface">Cancel</text>
                </column>
                <column @press="confirmClearHistory"
                               class="flex-1 px-4 py-3 rounded-xl bg-[#EF4444] items-center">
                    <text class="text-white font-semibold">Delete</text>
                </column>
            </row>
        </column>
    </modal>

</column>
