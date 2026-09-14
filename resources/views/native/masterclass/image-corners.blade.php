<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-8">

        <column class="gap-1">
            <text class="text-2xl font-bold">#355 · Image corners</text>
            <text class="text-sm opacity-60">
                Each pair is a column (left) and an image (right) with identical
                classes. The two shapes must match. iOS always did; Android is the fix.
            </text>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">1. rounded-3xl rounded-br-none</text>
            <text class="text-sm opacity-60">The chat-bubble tail. Image was fully rounded on Android.</text>
            <row class="w-full gap-4">
                <column class="w-[160] h-[100] rounded-3xl rounded-br-none bg-red-300" />
                <image :src="$src" :fit="2" class="w-[160] h-[100] rounded-3xl rounded-br-none" />
            </row>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">2. rounded-tl-3xl rounded-tr-3xl</text>
            <text class="text-sm opacity-60">No uniform radius to fall back on. Image was fully square on Android.</text>
            <row class="w-full gap-4">
                <column class="w-[160] h-[100] rounded-tl-3xl rounded-tr-3xl bg-red-300" />
                <image :src="$src" :fit="2" class="w-[160] h-[100] rounded-tl-3xl rounded-tr-3xl" />
            </row>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">3. rounded-b-2xl (side pair)</text>
            <row class="w-full gap-4">
                <column class="w-[160] h-[100] rounded-b-2xl bg-red-300" />
                <image :src="$src" :fit="2" class="w-[160] h-[100] rounded-b-2xl" />
            </row>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">4. rounded-2xl (uniform, control)</text>
            <text class="text-sm opacity-60">Worked all along.</text>
            <row class="w-full gap-4">
                <column class="w-[160] h-[100] rounded-2xl bg-red-300" />
                <image :src="$src" :fit="2" class="w-[160] h-[100] rounded-2xl" />
            </row>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">5. rounded-full rounded-bl-none</text>
            <text class="text-sm opacity-60">Avatar with a squared tail — the extreme of the same path.</text>
            <row class="w-full gap-4">
                <column class="w-[100] h-[100] rounded-full rounded-bl-none bg-red-300" />
                <image :src="$src" :fit="2" class="w-[100] h-[100] rounded-full rounded-bl-none" />
            </row>
        </column>

    </column>
</scroll-view>
