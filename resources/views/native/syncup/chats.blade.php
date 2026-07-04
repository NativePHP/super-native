<column class="w-full h-full bg-theme-background">

    <scroll-view class="w-full flex-1">
        <column class="w-full px-3 py-4 gap-6 pb-4">

            {{-- Search input --}}
            <row class="w-full  items-center gap-2">
                <outlined-text-input
                    leading-icon="search"
                    value="{{ $search }}"
                    placeholder="Search conversations..."
                    @change="updateSearch"
                    :variant="0"
                    class="flex-1 bg-white"
                />
            </row>

            {{-- Filter chips --}}
            <scroll-view horizontal :showsIndicators="false">
                <row class="gap-2 pb-1">
                    @foreach ($filters as $name)
                        @php $active = $activeFilter === $name; @endphp
                        <column
                            @press="setFilter('{{ $name }}')"
                            class="px-5 py-2 rounded-full {{ $active ? 'bg-[#00b4d8]' : 'bg-theme-surface-variant' }}"
                        >
                            <text class="text-[12] font-semibold {{ $active ? 'text-[#00414f]' : 'text-theme-on-surface-variant' }}">{{ $name }}</text>
                        </column>
                    @endforeach
                </row>
            </scroll-view>

            {{-- Conversation card --}}
            <column class="w-full gap-2">
                <text class="text-[12] font-semibold text-theme-on-surface-variant px-1">RECENT CHATS</text>
                <column class="w-full bg-theme-surface rounded-3xl border border-theme-outline">
                    @foreach ($rows as $i => $row)
                        @php $isLast = $i === count($rows) - 1; @endphp

                        {{-- Phase 1 — :native:key gives each chat row a stable id derived
                             from the chat id. Pinning, marking-read, deleting and reordering
                             keep per-row state (any pending swipe, animations, focus)
                             attached to the right chat instead of bleeding to whatever
                             chat happens to occupy the same screen position next frame. --}}
                        <row :native:key="$row['id']" @press="openChat({{ $row['id'] }})" class="w-full px-4 py-3 items-center gap-4">
                            {{-- Avatar (or group icon) with status dot --}}
                            <stack class="w-[56] h-[56]">
                                @if ($row['isGroup'])
                                    <column class="w-[56] h-[56] rounded-full bg-[#cffafe] items-center justify-center">
                                        <icon name="person.3.fill" :size="24" color="#0891b2" />
                                    </column>
                                @else
                                    <image src="{{ $row['avatarUrl'] }}" class="w-[56] h-[56] rounded-full" :fit="2" />
                                    @if (($row['status'] ?? '') === 'online')
                                        <row class="w-[56] h-[56] items-end justify-end">
                                            <column class="w-[14] h-[14] rounded-full bg-[#22c55e] border-2 border-white dark:border-slate-800" />
                                        </row>
                                    @endif
                                @endif
                            </stack>

                            {{-- Name + snippet --}}
                            <column class="flex-1 gap-1">
                                <row class="w-full justify-between items-center">
                                    <text class="text-[16] font-semibold text-theme-on-surface" :maxLines="1">{{ $row['displayName'] }}</text>
                                    <text class="text-[11] {{ $row['status'] === 'unread' ? 'text-[#0891b2] font-semibold' : 'text-theme-on-surface-variant' }}">{{ $row['time'] }}</text>
                                </row>
                                <row class="w-full items-center gap-2">
                                    @if ($row['lastSenderName'])
                                        <text class="text-[14] font-semibold text-theme-on-surface-variant" :maxLines="1">{{ $row['lastSenderName'] }}:</text>
                                    @endif
                                    <text class="flex-1 text-[14] {{ $row['status'] === 'unread' ? 'text-theme-on-surface font-semibold' : 'text-theme-on-surface-variant' }}" :maxLines="1">{{ $row['lastMessage'] }}</text>
                                    @if ($row['status'] === 'unread')
                                        <column class="bg-[#06b6d4] rounded-full px-2 py-px items-center justify-center min-w-[20]">
                                            <text class="text-[10] font-bold text-white">{{ $row['unread'] }}</text>
                                        </column>
                                    @elseif ($row['status'] === 'read')
                                        <icon name="checkmark" :size="16" color="#06b6d4" />
                                    @elseif ($row['status'] === 'sent')
                                        <icon name="checkmark" :size="16" color="#cbd5e1" dark-color="#475569" />
                                    @endif
                                </row>
                            </column>
                        </row>

                        @if (! $isLast)
                            <column class="w-full mx-4 h-px bg-theme-outline" />
                        @endif
                    @endforeach
                </column>
            </column>

            {{-- New connections horizontal --}}
            <column class="w-full gap-3">
                <text class="text-[12] font-semibold text-theme-on-surface-variant px-1">NEW CONNECTIONS</text>
                <scroll-view horizontal :showsIndicators="false">
                    <row class="gap-3 py-1">
                        @foreach ($suggestions as $s)
                            <column class="w-[128] bg-theme-surface p-4 rounded-3xl border border-theme-outline items-center gap-3">
                                <image src="{{ $s['avatarUrl'] }}" class="w-[48] h-[48] rounded-full" :fit="2" />
                                <text class="text-[12] font-semibold text-theme-on-surface" :maxLines="1">{{ $s['name'] }}</text>
                                <column @press="addSuggestion({{ $s['id'] }})" class="w-full py-2 bg-[#ecfeff] dark:bg-[#0e3a44] rounded-lg items-center">
                                    <text class="text-[11] font-semibold text-[#0891b2] dark:text-[#67e8f9]">Add</text>
                                </column>
                            </column>
                        @endforeach
                    </row>
                </scroll-view>
            </column>

        </column>
    </scroll-view>

    {{-- Floating Action Button — absolutely positioned at the bottom-right
         of the screen content. The absolute child only occupies its placed
         (56x56) bounds, so it overlays without blocking scroll touches. --}}
    <column @press="newMessage" a11y-label="New message"
        class="absolute bottom-[20] right-[20] w-[56] h-[56] rounded-full shadow-xl bg-cyan-600 items-center justify-center">
        <native:icon :android="\App\Icons\Android::Message" :ios="\App\Icons\Ios::Message" class="text-white text-3xl" />
    </column>

    {{-- New Message bottom-sheet — friend picker. Tap a row to start a
         chat with that friend. --}}
    <bottom-sheet :visible="$showNewMessage" @dismiss="closeNewMessage" detents="medium,large">
        <column class="w-full">
            <column class="w-full px-5 py-4 gap-1">
                <text class="text-[18] font-bold text-theme-on-surface">New Message</text>
                <text class="text-[14] text-theme-on-surface-variant">Pick a friend to start a chat with.</text>
            </column>
            <divider />
            <scroll-view class="w-full">
                <column class="w-full">
                    @foreach ($friends as $f)
                        <row @press="startChatWith({{ $f['id'] }})" class="w-full px-5 py-3 items-center gap-4">
                            <stack class="w-[44] h-[44]">
                                <image src="{{ $f['avatarUrl'] }}" class="w-[44] h-[44] rounded-full" :fit="2" />
                                @if ($f['status'] === 'online')
                                    <row class="w-[44] h-[44] items-end justify-end">
                                        <column class="w-[12] h-[12] rounded-full bg-[#22c55e] border-2 border-white dark:border-slate-800" />
                                    </row>
                                @endif
                            </stack>
                            <column class="flex-1 gap-1">
                                <text class="text-[16] font-semibold text-theme-on-surface" :maxLines="1">{{ $f['name'] }}</text>
                                <text class="text-[12] text-theme-on-surface-variant" :maxLines="1">{{ $f['statusText'] }}</text>
                            </column>
                            <icon name="chevron.right" :size="18" color="#94a3b8" dark-color="#64748b" />
                        </row>
                        <divider />
                    @endforeach
                </column>
            </scroll-view>
        </column>
    </bottom-sheet>

</column>
