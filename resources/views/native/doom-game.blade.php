<native:column class="flex-1 w-full bg-zinc-900">
    <native:scroll-view class="flex-1 w-full">
        <native:column class="p-6 gap-5 safe-area items-center">

            <native:spacer class="h-8" />

            {{-- Title --}}
            <native:column class="items-center gap-1">
                <native:text class="text-5xl font-extrabold text-red-500">DOOM</native:text>
                <native:text class="text-base font-bold text-red-400">PHP Edition</native:text>
            </native:column>

            <native:text class="text-xs text-zinc-600">Every enemy is an Eloquent model</native:text>

            <native:spacer class="h-2" />

            {{-- Server Status --}}
            <native:column class="w-full bg-zinc-800 rounded-2xl p-4 gap-3">
                <native:row class="w-full items-center justify-between">
                    <native:text class="text-xs font-bold text-zinc-500">SERVER</native:text>
                    <native:pressable @press="checkServer">
                        <native:text class="text-xs font-bold text-zinc-500">REFRESH</native:text>
                    </native:pressable>
                </native:row>

                <native:row class="w-full items-center gap-3">
                    <native:column class="{{ $serverOnline ? 'bg-green-500' : 'bg-red-500' }} rounded-full w-3 h-3" />
                    <native:column class="flex-1 gap-1">
                        <native:text class="text-sm font-bold {{ $serverOnline ? 'text-green-400' : 'text-red-400' }}">{{ $serverOnline ? 'ONLINE' : 'OFFLINE' }}</native:text>
                        <native:text class="text-xs text-zinc-500">{{ config('doom.server_host', '127.0.0.1') }}:{{ config('doom.server_port', 9001) }}</native:text>
                    </native:column>
                </native:row>
            </native:column>

            {{-- Player Name --}}
            <native:column class="w-full bg-zinc-800 rounded-2xl p-4 gap-2">
                <native:text class="text-xs font-bold text-zinc-500">PLAYER NAME</native:text>
                <native:text class="text-lg font-bold text-white">{{ $playerName }}</native:text>
            </native:column>

            <native:spacer class="h-2" />

            {{-- Multiplayer --}}
            <native:pressable @press="findMatch" class="w-full bg-blue-600 rounded-2xl py-5 items-center {{ $serverOnline ? '' : 'opacity-50' }}">
                <native:text class="text-xl font-extrabold text-white">FIND MATCH</native:text>
                @if(!$serverOnline)
                <native:text class="text-xs text-blue-200">Server offline</native:text>
                @endif
            </native:pressable>

            {{-- Solo --}}
            <native:pressable @press="startGame" class="w-full bg-red-600 rounded-2xl py-5 items-center">
                <native:text class="text-xl font-extrabold text-white">SOLO (vs AI)</native:text>
            </native:pressable>

            @if($matchStatus !== '')
            <native:column class="w-full bg-zinc-800 rounded-2xl p-4 items-center">
                <native:text class="text-sm font-bold text-zinc-300">{{ $matchStatus }}</native:text>
            </native:column>
            @endif

            @if($isMultiplayer)
            <native:pressable @press="disconnectMatch" class="w-full bg-zinc-700 rounded-2xl py-4 items-center">
                <native:text class="text-sm font-bold text-red-400">DISCONNECT</native:text>
            </native:pressable>
            @endif

            <native:spacer class="h-2" />

            {{-- Stats --}}
            <native:column class="w-full bg-zinc-800 rounded-2xl p-4 gap-4">

                <native:row class="w-full items-center justify-between">
                    <native:text class="text-xs font-bold text-zinc-500">CAREER</native:text>
                </native:row>

                <native:row class="w-full gap-3">
                    <native:column class="flex-1 bg-zinc-700 rounded-xl p-3 items-center gap-1">
                        <native:text class="text-2xl font-extrabold text-white">{{ $gamesPlayed }}</native:text>
                        <native:text class="text-xs text-zinc-400">Games</native:text>
                    </native:column>
                    <native:column class="flex-1 bg-zinc-700 rounded-xl p-3 items-center gap-1">
                        <native:text class="text-2xl font-extrabold text-red-400">{{ $totalKills }}</native:text>
                        <native:text class="text-xs text-zinc-400">Kills</native:text>
                    </native:column>
                </native:row>

            </native:column>

            @if($mpKills > 0 || $mpDeaths > 0)
            {{-- PvP Stats --}}
            <native:column class="w-full bg-zinc-800 rounded-2xl p-4 gap-4">

                <native:text class="text-xs font-bold text-zinc-500">LAST MATCH (PvP)</native:text>

                <native:row class="w-full gap-3">
                    <native:column class="flex-1 bg-zinc-700 rounded-xl p-3 items-center gap-1">
                        <native:text class="text-2xl font-extrabold text-red-400">{{ $mpKills }}</native:text>
                        <native:text class="text-xs text-zinc-400">Kills</native:text>
                    </native:column>
                    <native:column class="flex-1 bg-zinc-700 rounded-xl p-3 items-center gap-1">
                        <native:text class="text-2xl font-extrabold text-zinc-400">{{ $mpDeaths }}</native:text>
                        <native:text class="text-xs text-zinc-400">Deaths</native:text>
                    </native:column>
                    <native:column class="flex-1 bg-zinc-700 rounded-xl p-3 items-center gap-1">
                        <native:text class="text-2xl font-extrabold text-yellow-400">{{ $lastScore }}</native:text>
                        <native:text class="text-xs text-zinc-400">Score</native:text>
                    </native:column>
                </native:row>

            </native:column>
            @elseif($lastScore > 0)
            {{-- Solo Stats --}}
            <native:column class="w-full bg-zinc-800 rounded-2xl p-4 gap-4">

                <native:text class="text-xs font-bold text-zinc-500">LAST GAME</native:text>

                <native:row class="w-full gap-3">
                    <native:column class="flex-1 bg-zinc-700 rounded-xl p-3 items-center gap-1">
                        <native:text class="text-2xl font-extrabold text-yellow-400">{{ $lastScore }}</native:text>
                        <native:text class="text-xs text-zinc-400">Score</native:text>
                    </native:column>
                    <native:column class="flex-1 bg-zinc-700 rounded-xl p-3 items-center gap-1">
                        <native:text class="text-2xl font-extrabold text-red-400">{{ $lastKills }}</native:text>
                        <native:text class="text-xs text-zinc-400">Kills</native:text>
                    </native:column>
                </native:row>

            </native:column>
            @endif

            {{-- Sync Button --}}
            <native:pressable @press="checkResults" class="w-full bg-zinc-800 rounded-2xl py-4 items-center">
                <native:text class="text-sm font-bold text-zinc-400">SYNC RESULTS</native:text>
            </native:pressable>

            <native:spacer class="h-4" />

        </native:column>
    </native:scroll-view>
</native:column>
