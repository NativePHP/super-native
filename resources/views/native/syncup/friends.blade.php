<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full px-5 py-6 gap-8 pb-24">

        {{-- Add New Friend bento --}}
        <column class="w-full gap-4">
            <text class="text-[18] font-semibold text-theme-on-background">Add New Friend</text>

            {{-- Top row: QR + Find by ID --}}
            <row class="w-full gap-4">
                {{-- QR Code card --}}
                <column @press="scanQr" class="flex-1 bg-[#00b4d8] rounded-3xl p-5 items-center gap-3">
                    <column class="w-[48] h-[48] bg-white/20 rounded-2xl items-center justify-center">
                        <icon name="qrcode.viewfinder" :size="28" color="#FFFFFF" />
                    </column>
                    <text class="text-[12] font-semibold text-white">Scan QR</text>
                </column>

                {{-- Find by ID card --}}
                <column @press="findById" class="flex-1 bg-theme-surface rounded-3xl p-5 border border-theme-outline items-center gap-3">
                    <column class="w-[48] h-[48] bg-[#cde5ff] dark:bg-[#0e2a44] rounded-2xl items-center justify-center">
                        <icon name="person.fill.badge.plus" :size="28" color="#006399" dark-color="#7dd3fc" />
                    </column>
                    <text class="text-[12] font-semibold text-theme-on-surface">Find by ID</text>
                </column>
            </row>

            {{-- Share invite link card (full width) --}}
            <row class="w-full bg-theme-surface rounded-3xl p-5 border border-theme-outline items-center justify-between gap-3">
                <row class="flex-1 items-center gap-3">
                    <column class="w-[40] h-[40] bg-[#a7edff] dark:bg-[#083344] rounded-full items-center justify-center">
                        <icon name="link" :size="20" color="#006878" dark-color="#67e8f9" />
                    </column>
                    <column class="flex-1 gap-1">
                        <text class="text-[12] font-semibold text-theme-on-surface">Share Invite Link</text>
                        <text class="text-[11] text-theme-on-surface-variant" :maxLines="1">syncup.me/u/johndoe</text>
                    </column>
                </row>
                <column @press="copyInvite" class="px-4 py-2 bg-[#00677d] rounded-full">
                    <text class="text-[12] font-semibold text-white">Copy</text>
                </column>
            </row>
        </column>

        {{-- Your Friends list --}}
        <column class="w-full gap-4">
            <row class="w-full items-center justify-between">
                <text class="text-[18] font-semibold text-theme-on-background">Your Friends</text>
                <column class="px-3 py-1 bg-theme-surface-variant rounded-full">
                    <text class="text-[11] font-bold text-theme-on-surface-variant">{{ $onlineCount }} Online</text>
                </column>
            </row>

            <column class="w-full gap-1">
                @foreach ($friends as $f)
                    <row class="w-full p-3 rounded-2xl items-center justify-between">
                        <row class="flex-1 items-center gap-4">
                            <stack class="w-[56] h-[56]">
                                <image src="{{ $f['avatarUrl'] }}" class="w-[56] h-[56] rounded-full" :fit="2" />
                                <row class="w-[56] h-[56] items-end justify-end">
                                    <column class="w-[16] h-[16] rounded-full {{ $f['status'] === 'online' ? 'bg-[#22c55e]' : ($f['status'] === 'away' ? 'bg-[#cbd5e1]' : 'bg-[#94a3b8]') }} border-2 border-white dark:border-slate-800" />
                                </row>
                            </stack>
                            <column class="flex-1 gap-1">
                                <text class="text-[16] font-semibold text-theme-on-background" :maxLines="1">{{ $f['name'] }}</text>
                                <text class="text-[14] text-theme-on-surface-variant" :maxLines="1">{{ $f['statusText'] }}</text>
                            </column>
                        </row>
                        <column @press="messageFriend({{ $f['id'] }})" a11y-label="Message {{ $f['name'] }}" class="w-[40] h-[40] items-center justify-center rounded-full">
                            <icon name="chat_bubble" :size="20" color="#94a3b8" dark-color="#64748b" />
                        </column>
                    </row>
                @endforeach
            </column>
        </column>

        {{-- People You May Know --}}
        <column class="w-full gap-4">
            <text class="text-[18] font-semibold text-theme-on-background">People You May Know</text>
            <scroll-view horizontal :showsIndicators="false">
                <row class="gap-4 pb-2">
                    @foreach ($suggestions as $s)
                        <column class="w-[140] bg-theme-surface p-4 rounded-3xl border border-theme-outline items-center gap-3">
                            <image src="{{ $s['avatarUrl'] }}" class="w-[64] h-[64] rounded-full" :fit="2" />
                            <column class="items-center gap-1">
                                <text class="text-[12] font-semibold text-theme-on-surface" :maxLines="1">{{ $s['name'] }}</text>
                                <text class="text-[10] text-theme-on-surface-variant">{{ $s['mutuals'] }} mutual friends</text>
                            </column>
                            <column @press="addSuggestion({{ $s['id'] }})" class="w-full py-2 bg-[#ecfeff] dark:bg-[#0e3a44] rounded-xl items-center">
                                <text class="text-[12] font-semibold text-[#0891b2] dark:text-[#67e8f9]">Add</text>
                            </column>
                        </column>
                    @endforeach
                </row>
            </scroll-view>
        </column>

    </column>
</scroll-view>
