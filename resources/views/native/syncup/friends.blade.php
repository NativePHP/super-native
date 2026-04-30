<native:scroll-view class="w-full h-full bg-theme-background">
    <native:column class="w-full px-5 py-6 gap-8 pb-24">

        {{-- Add New Friend bento --}}
        <native:column class="w-full gap-4">
            <native:text class="text-[18] font-semibold text-theme-on-background">Add New Friend</native:text>

            {{-- Top row: QR + Find by ID --}}
            <native:row class="w-full gap-4">
                {{-- QR Code card --}}
                <native:column @press="scanQr" class="flex-1 bg-[#00b4d8] rounded-3xl p-5 items-center gap-3">
                    <native:column class="w-[48] h-[48] bg-white/20 rounded-2xl items-center justify-center">
                        <native:icon name="qrcode.viewfinder" :size="28" color="#FFFFFF" />
                    </native:column>
                    <native:text class="text-[12] font-semibold text-white">Scan QR</native:text>
                </native:column>

                {{-- Find by ID card --}}
                <native:column @press="findById" class="flex-1 bg-theme-surface rounded-3xl p-5 border border-theme-outline items-center gap-3">
                    <native:column class="w-[48] h-[48] bg-[#cde5ff] dark:bg-[#0e2a44] rounded-2xl items-center justify-center">
                        <native:icon name="person.fill.badge.plus" :size="28" color="#006399" dark-color="#7dd3fc" />
                    </native:column>
                    <native:text class="text-[12] font-semibold text-theme-on-surface">Find by ID</native:text>
                </native:column>
            </native:row>

            {{-- Share invite link card (full width) --}}
            <native:row class="w-full bg-theme-surface rounded-3xl p-5 border border-theme-outline items-center justify-between gap-3">
                <native:row class="flex-1 items-center gap-3">
                    <native:column class="w-[40] h-[40] bg-[#a7edff] dark:bg-[#083344] rounded-full items-center justify-center">
                        <native:icon name="link" :size="20" color="#006878" dark-color="#67e8f9" />
                    </native:column>
                    <native:column class="flex-1 gap-1">
                        <native:text class="text-[12] font-semibold text-theme-on-surface">Share Invite Link</native:text>
                        <native:text class="text-[11] text-theme-on-surface-variant" :maxLines="1">syncup.me/u/johndoe</native:text>
                    </native:column>
                </native:row>
                <native:column @press="copyInvite" class="px-4 py-2 bg-[#00677d] rounded-full">
                    <native:text class="text-[12] font-semibold text-white">Copy</native:text>
                </native:column>
            </native:row>
        </native:column>

        {{-- Your Friends list --}}
        <native:column class="w-full gap-4">
            <native:row class="w-full items-center justify-between">
                <native:text class="text-[18] font-semibold text-theme-on-background">Your Friends</native:text>
                <native:column class="px-3 py-1 bg-theme-surface-variant rounded-full">
                    <native:text class="text-[11] font-bold text-theme-on-surface-variant">{{ $onlineCount }} Online</native:text>
                </native:column>
            </native:row>

            <native:column class="w-full gap-1">
                @foreach ($friends as $f)
                    <native:row class="w-full p-3 rounded-2xl items-center justify-between">
                        <native:row class="flex-1 items-center gap-4">
                            <native:stack class="w-[56] h-[56]">
                                <native:image src="{{ $f['avatarUrl'] }}" class="w-[56] h-[56] rounded-full" :fit="2" />
                                <native:row class="w-[56] h-[56] items-end justify-end">
                                    <native:column class="w-[16] h-[16] rounded-full {{ $f['status'] === 'online' ? 'bg-[#22c55e]' : ($f['status'] === 'away' ? 'bg-[#cbd5e1]' : 'bg-[#94a3b8]') }} border-2 border-white dark:border-slate-800" />
                                </native:row>
                            </native:stack>
                            <native:column class="flex-1 gap-1">
                                <native:text class="text-[16] font-semibold text-theme-on-background" :maxLines="1">{{ $f['name'] }}</native:text>
                                <native:text class="text-[14] text-theme-on-surface-variant" :maxLines="1">{{ $f['statusText'] }}</native:text>
                            </native:column>
                        </native:row>
                        <native:column @press="messageFriend({{ $f['id'] }})" class="w-[40] h-[40] items-center justify-center rounded-full">
                            <native:icon name="chat_bubble" :size="20" color="#94a3b8" dark-color="#64748b" />
                        </native:column>
                    </native:row>
                @endforeach
            </native:column>
        </native:column>

        {{-- People You May Know --}}
        <native:column class="w-full gap-4">
            <native:text class="text-[18] font-semibold text-theme-on-background">People You May Know</native:text>
            <native:scroll-view horizontal :showsIndicators="false">
                <native:row class="gap-4 pb-2">
                    @foreach ($suggestions as $s)
                        <native:column class="w-[140] bg-theme-surface p-4 rounded-3xl border border-theme-outline items-center gap-3">
                            <native:image src="{{ $s['avatarUrl'] }}" class="w-[64] h-[64] rounded-full" :fit="2" />
                            <native:column class="items-center gap-1">
                                <native:text class="text-[12] font-semibold text-theme-on-surface" :maxLines="1">{{ $s['name'] }}</native:text>
                                <native:text class="text-[10] text-theme-on-surface-variant">{{ $s['mutuals'] }} mutual friends</native:text>
                            </native:column>
                            <native:column @press="addSuggestion({{ $s['id'] }})" class="w-full py-2 bg-[#ecfeff] dark:bg-[#0e3a44] rounded-xl items-center">
                                <native:text class="text-[12] font-semibold text-[#0891b2] dark:text-[#67e8f9]">Add</native:text>
                            </native:column>
                        </native:column>
                    @endforeach
                </native:row>
            </native:scroll-view>
        </native:column>

    </native:column>
</native:scroll-view>
