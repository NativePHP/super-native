<scroll-view class="safe-area bg-theme-background">
    <column class="w-full p-5 gap-4">

        <text class="text-lg font-semibold text-theme-on-background">Native → PHP event channel</text>

        <column class="gap-1">
            <text class="text-sm text-theme-on-surface-variant">Type or paste into the box. Every change ships the WHOLE field back to PHP through the event channel under test — one-way, so nothing is rendered back to clip it.</text>
            <text class="text-sm text-theme-on-surface-variant">Fastest way past 64KB: copy a big chunk of text on your Mac and ⌘V into the box. Or type a line, select-all → copy → paste repeatedly (it doubles each time).</text>
        </column>

        <outlined-text-input @change="onType" multiline :max-lines="10"
            label="Type / paste here — not rendered back" class="w-full" />

        <column class="gap-1 items-center mt-2">
            <text class="text-4xl font-extrabold font-mono text-theme-on-background">{{ number_format($len) }}</text>
            <text class="text-sm text-theme-on-surface-variant">bytes delivered by the event channel</text>
        </column>

        @if($len > 65535)
            <column class="w-full bg-green-600 rounded-2xl p-4 items-center justify-center">
                <text class="text-sm text-white text-center font-semibold">{{ number_format($len) }} bytes — past the 64KB uint16 ceiling. The channel is unbounded. 🎉</text>
            </column>
        @elseif($len > 4096)
            <column class="w-full bg-blue-600 rounded-2xl p-4 items-center justify-center">
                <text class="text-sm text-white text-center font-semibold">{{ number_format($len) }} bytes — past the old 4KB cap. Keep pasting to cross 64KB.</text>
            </column>
        @elseif($len > 0)
            <column class="w-full bg-amber-500 rounded-2xl p-4 items-center justify-center">
                <text class="text-white text-center font-semibold">{{ number_format($len) }} bytes — paste more to grow it.</text>
            </column>
        @endif

        @if($sample !== '')
            <text class="text-xs text-theme-on-surface-variant font-mono">starts with: {{ $sample }}…</text>
        @endif

        <stack @tap="clearStats" class="bg-theme-surface-variant rounded-xl px-4 py-3 items-center justify-center mt-2">
            <text class="text-theme-on-surface-variant font-semibold">Reset counter</text>
        </stack>

    </column>
</scroll-view>
