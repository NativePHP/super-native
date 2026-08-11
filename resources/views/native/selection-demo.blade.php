<scroll-view class="w-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        <text class="text-2xl font-semibold text-theme-on-background">@selectionChange</text>
        <text class="text-theme-on-surface-variant">
            Move the caret, select text, or type @ followed by a name. Offsets are Unicode
            code points; events are coalesced natively (100ms here).
        </text>

        {{-- Main input: multiline + pre-filled, the two device-QA cases. --}}
        <outlined-text-input
            class="w-full"
            label="Message"
            multiline
            :max-lines="5"
            native:model="message"
            @selectionChange="onCaretMove"
            selection-debounce-ms="100"
        />

        @if (count($suggestions))
            <row class="gap-2">
                @foreach ($suggestions as $handle)
                    <button variant="secondary" size="sm" @tap="applyMention('{{ $handle }}')">{{ '@'.$handle }}</button>
                @endforeach
            </row>
        @endif

        <column class="gap-1 bg-theme-surface-variant rounded-xl p-4">
            <text class="text-theme-on-surface-variant">Caret: {{ $caretStart }} – {{ $caretEnd }}</text>
            <text class="text-theme-on-surface-variant">Selected: “{{ $selectedText }}”</text>
            <text class="text-theme-on-surface-variant">Events: {{ $eventCount }}</text>
        </column>

        {{-- Secure input: the callback is never serialized, so this counter stays 0. --}}
        <text class="text-xl font-semibold mt-4 text-theme-on-background">Secure input (suppressed)</text>
        <outlined-text-input
            class="w-full"
            label="Password"
            secure
            native:model="secret"
            @selectionChange="onSecureCaretMove"
        />
        <text class="text-theme-on-surface-variant">
            Secure events: {{ $secureEventCount }} (should stay 0)
        </text>

        {{-- Read-only: reports on Android (focusable for copy), silent on iOS. --}}
        <text class="text-xl font-semibold mt-4 text-theme-on-background">Read-only input</text>
        <outlined-text-input
            class="w-full"
            label="Frozen"
            read-only
            :value="$frozen"
            @selectionChange="onCaretMove"
        />

        <button variant="secondary" class="mt-4" @tap="resetCounters">Reset counters</button>

    </column>
</scroll-view>
