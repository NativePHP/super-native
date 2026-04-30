<native:column class="w-full h-full bg-theme-background">

    <native:scroll-view class="w-full flex-1">
        <native:column class="w-full px-3 py-4 gap-6 pb-4">

            {{-- Search input --}}
            <native:row class="w-full bg-theme-surface border border-theme-outline rounded-2xl  p-1 items-center gap-2">
                <native:outlined-text-input
                    leading-icon="search"
                    value="{{ $search }}"
                    placeholder="Search conversations..."
                    @change="updateSearch"
                    :variant="0"
                    class="flex-1"
                />
            </native:row>

            {{-- Filter chips --}}
            <native:scroll-view horizontal :showsIndicators="false">
                <native:row class="gap-2 pb-1">
                    @foreach ($filters as $name)
                        @php $active = $activeFilter === $name; @endphp
                        <native:column
                            @press="setFilter('{{ $name }}')"
                            class="px-5 py-2 rounded-full {{ $active ? 'bg-[#00b4d8]' : 'bg-theme-surface-variant' }}"
                        >
                            <native:text class="text-[12] font-semibold {{ $active ? 'text-[#00414f]' : 'text-theme-on-surface-variant' }}">{{ $name }}</native:text>
                        </native:column>
                    @endforeach
                </native:row>
            </native:scroll-view>

            {{-- Conversation card --}}
            <native:column class="w-full gap-2">
                <native:text class="text-[12] font-semibold text-theme-on-surface-variant px-1">RECENT CHATS</native:text>
                <native:column class="w-full bg-theme-surface rounded-3xl border border-theme-outline">
                    @foreach ($rows as $i => $row)
                        @php $isLast = $i === count($rows) - 1; @endphp

                        <native:row @press="openChat({{ $row['id'] }})" class="w-full px-4 py-3 items-center gap-4">
                            {{-- Avatar (or group icon) with status dot --}}
                            <native:stack class="w-[56] h-[56]">
                                @if ($row['isGroup'])
                                    <native:column class="w-[56] h-[56] rounded-full bg-[#cffafe] items-center justify-center">
                                        <native:icon name="person.3.fill" :size="24" color="#0891b2" />
                                    </native:column>
                                @else
                                    <native:image src="{{ $row['avatarUrl'] }}" class="w-[56] h-[56] rounded-full" :fit="2" />
                                    @if (($row['status'] ?? '') === 'online')
                                        <native:row class="w-[56] h-[56] items-end justify-end">
                                            <native:column class="w-[14] h-[14] rounded-full bg-[#22c55e] border-2 border-white dark:border-slate-800" />
                                        </native:row>
                                    @endif
                                @endif
                            </native:stack>

                            {{-- Name + snippet --}}
                            <native:column class="flex-1 gap-1">
                                <native:row class="w-full justify-between items-center">
                                    <native:text class="text-[16] font-semibold text-theme-on-surface" :maxLines="1">{{ $row['displayName'] }}</native:text>
                                    <native:text class="text-[11] {{ $row['status'] === 'unread' ? 'text-[#0891b2] font-semibold' : 'text-theme-on-surface-variant' }}">{{ $row['time'] }}</native:text>
                                </native:row>
                                <native:row class="w-full items-center gap-2">
                                    @if ($row['lastSenderName'])
                                        <native:text class="text-[14] font-semibold text-theme-on-surface-variant" :maxLines="1">{{ $row['lastSenderName'] }}:</native:text>
                                    @endif
                                    <native:text class="flex-1 text-[14] {{ $row['status'] === 'unread' ? 'text-theme-on-surface font-semibold' : 'text-theme-on-surface-variant' }}" :maxLines="1">{{ $row['lastMessage'] }}</native:text>
                                    @if ($row['status'] === 'unread')
                                        <native:column class="bg-[#06b6d4] rounded-full px-2 py-px items-center justify-center min-w-[20]">
                                            <native:text class="text-[10] font-bold text-white">{{ $row['unread'] }}</native:text>
                                        </native:column>
                                    @elseif ($row['status'] === 'read')
                                        <native:icon name="checkmark" :size="16" color="#06b6d4" />
                                    @elseif ($row['status'] === 'sent')
                                        <native:icon name="checkmark" :size="16" color="#cbd5e1" dark-color="#475569" />
                                    @endif
                                </native:row>
                            </native:column>
                        </native:row>

                        @if (! $isLast)
                            <native:column class="w-full mx-4 h-px bg-theme-outline" />
                        @endif
                    @endforeach
                </native:column>
            </native:column>

            {{-- New connections horizontal --}}
            <native:column class="w-full gap-3">
                <native:text class="text-[12] font-semibold text-theme-on-surface-variant px-1">NEW CONNECTIONS</native:text>
                <native:scroll-view horizontal :showsIndicators="false">
                    <native:row class="gap-3 py-1">
                        @foreach ($suggestions as $s)
                            <native:column class="w-[128] bg-theme-surface p-4 rounded-3xl border border-theme-outline items-center gap-3">
                                <native:image src="{{ $s['avatarUrl'] }}" class="w-[48] h-[48] rounded-full" :fit="2" />
                                <native:text class="text-[12] font-semibold text-theme-on-surface" :maxLines="1">{{ $s['name'] }}</native:text>
                                <native:column @press="addSuggestion({{ $s['id'] }})" class="w-full py-2 bg-[#ecfeff] dark:bg-[#0e3a44] rounded-lg items-center">
                                    <native:text class="text-[11] font-semibold text-[#0891b2] dark:text-[#67e8f9]">Add</native:text>
                                </native:column>
                            </native:column>
                        @endforeach
                    </native:row>
                </native:scroll-view>
            </native:column>

        </native:column>
    </native:scroll-view>

    {{-- Floating Action Button — absolutely positioned at the bottom-right
         of the screen content. The absolute child only occupies its placed
         (56x56) bounds, so it overlays without blocking scroll touches. --}}
    <native:column @press="newMessage"
        class="absolute bottom-[20] right-[20] w-[56] h-[56] rounded-2xl bg-[#00677d] items-center justify-center">
        <native:icon name="plus.message.fill" :size="24" color="#FFFFFF" />
    </native:column>

    {{-- New Message bottom-sheet — friend picker. Tap a row to start a
         chat with that friend. --}}
    <native:bottom-sheet :visible="$showNewMessage" @dismiss="closeNewMessage" detents="medium,large">
        <native:column class="w-full">
            <native:column class="w-full px-5 py-4 gap-1">
                <native:text class="text-[18] font-bold text-theme-on-surface">New Message</native:text>
                <native:text class="text-[14] text-theme-on-surface-variant">Pick a friend to start a chat with.</native:text>
            </native:column>
            <native:divider />
            <native:scroll-view class="w-full">
                <native:column class="w-full">
                    @foreach ($friends as $f)
                        <native:row @press="startChatWith({{ $f['id'] }})" class="w-full px-5 py-3 items-center gap-4">
                            <native:stack class="w-[44] h-[44]">
                                <native:image src="{{ $f['avatarUrl'] }}" class="w-[44] h-[44] rounded-full" :fit="2" />
                                @if ($f['status'] === 'online')
                                    <native:row class="w-[44] h-[44] items-end justify-end">
                                        <native:column class="w-[12] h-[12] rounded-full bg-[#22c55e] border-2 border-white dark:border-slate-800" />
                                    </native:row>
                                @endif
                            </native:stack>
                            <native:column class="flex-1 gap-1">
                                <native:text class="text-[16] font-semibold text-theme-on-surface" :maxLines="1">{{ $f['name'] }}</native:text>
                                <native:text class="text-[12] text-theme-on-surface-variant" :maxLines="1">{{ $f['statusText'] }}</native:text>
                            </native:column>
                            <native:icon name="chevron.right" :size="18" color="#94a3b8" dark-color="#64748b" />
                        </native:row>
                        <native:divider />
                    @endforeach
                </native:column>
            </native:scroll-view>
        </native:column>
    </native:bottom-sheet>

</native:column>
