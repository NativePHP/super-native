<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-8">

        <column class="gap-1">
            <text class="text-2xl font-bold">#421 · Composer line limits</text>
            <text class="text-sm opacity-60">
                Type (or paste) more lines than the cap into each field. It must
                stop growing at the cap and scroll internally, as iOS already did.
            </text>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">1. multiline :max-lines="5"</text>
            <text class="text-sm opacity-60">The issue's field. Grew without limit on Android.</text>
            <bare-text-input
                native:key="capped"
                native:model="capped"
                multiline
                :max-lines="5"
                placeholder="Type a long message..."
                class="w-full bg-gray-200 rounded-2xl px-4 py-3" />
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">2. multiline :min-lines="3" :max-lines="4"</text>
            <text class="text-sm opacity-60">Starts three lines tall while empty, stops at four.</text>
            <bare-text-input
                native:key="tall"
                native:model="tall"
                multiline
                :min-lines="3"
                :max-lines="4"
                placeholder="Three lines tall from the start"
                class="w-full bg-gray-200 rounded-2xl px-4 py-3" />
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">3. multiline, no limits set</text>
            <text class="text-sm opacity-60">The shared default is five lines on both platforms. Android ignored it.</text>
            <bare-text-input
                native:key="defaulted"
                native:model="defaulted"
                multiline
                placeholder="Default cap"
                class="w-full bg-gray-200 rounded-2xl px-4 py-3" />
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">Live values</text>
            <text class="text-sm opacity-60 whitespace-pre-line">{{ "1: " . mb_strlen($capped) . " chars\n2: " . mb_strlen($tall) . " chars\n3: " . mb_strlen($defaulted) . " chars" }}</text>
        </column>

        <column class="h-[300]" />
    </column>
</scroll-view>
