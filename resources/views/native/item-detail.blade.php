<column class="flex-1 w-full p-5 gap-4">
    <column class="w-full h-[160] rounded-xl bg-theme-primary items-center justify-center">
        <text class="text-theme-on-primary text-5xl font-bold">#{{ $id }}</text>
    </column>

    <text class="text-2xl font-bold">{{ $title }}</text>
    <text class="text-sm text-theme-on-surface-variant">
        This is a pushed detail screen. Tap the back arrow in the top bar,
        or swipe from the left edge to pop.
    </text>

    <divider />

    <button label="Go back" @tap="back" class="bg-theme-surface-variant rounded-lg px-5 py-3 mt-2" />
</column>
