{{-- The layout from the issue: a bottom-anchored scroll view filling the
     screen, with a composer pinned underneath it. --}}
<column class="w-full h-full bg-theme-background">

    <column class="w-full px-4 pt-3 gap-1">
        <text class="font-bold">#316 · Bottom-pinned re-pin</text>
        <text class="text-sm opacity-60">
            1. Tap the field — the list should re-pin, "Message 40" just above the keyboard.
            2. Dismiss the keyboard — it should re-pin AGAIN, back to the bottom edge.
        </text>
        <text class="text-sm opacity-60">
            3. The guard: with the keyboard up, DRAG the list up into older messages
            (that also dismisses the keyboard). It must stay where you dragged it,
            not snap back to the bottom.
        </text>
    </column>

    <scroll-view scroll-anchor="bottom" class="w-full grow p-4">
        <column class="w-full gap-2 items-start">
            @foreach ($messages as $message)
                <column class="rounded-2xl rounded-bl-none bg-gray-200 px-4 py-2">
                    <text>{{ $message }}</text>
                </column>
            @endforeach
        </column>
    </scroll-view>

    <row class="w-full p-3 gap-2 items-center bg-theme-surface">
        <column class="grow">
            <outlined-text-input native:model="draft" placeholder="Type a message" @submit="send" />
        </column>
        <button variant="secondary" @tap="send">Send</button>
    </row>

</column>
