<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-6">

        {{-- ─────────────────────────────────────────────────────────────
             Ask Claude for a script and a view
             ───────────────────────────────────────────────────────────── --}}
        <column class="w-full gap-2">
            <text class="text-xs uppercase tracking-wider font-semibold text-theme-on-surface-variant px-1">
                Ask Claude for a screen
            </text>

            <outlined-text-input
                value="{{ $promptText }}"
                placeholder="e.g. a progress bar at 40% with a badge beside it"
                @change="updatePrompt"
                multiline
                :max-lines="3"
                class="w-full"
            />

            <button label="Generate & run" @press="generate" class="w-full" />

            @if ($error)
                <text class="text-sm text-red-500 px-1">{{ $error }}</text>
            @elseif ($summary)
                <text class="text-sm text-theme-on-surface-variant px-1">{{ $summary }}</text>
            @endif

            <text class="text-xs text-theme-on-surface-variant px-1 leading-4">
                Claude writes the PHP and the native markup, the demo checks both
                and writes them to disk, and the next render executes the one and
                compiles the other into real native views. The screen sits still
                while the model is thinking.
            </text>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             What the generated pair renders — no component state involved.
             capture() builds it detached; attachElement() splices it in here.
             ───────────────────────────────────────────────────────────── --}}
        <column class="w-full gap-2">
            <text class="text-xs uppercase tracking-wider font-semibold text-theme-on-surface-variant px-1">
                Preview
            </text>
            <column class="w-full p-6 rounded-2xl bg-theme-surface items-center">
                @php(\Native\Mobile\Edge\NativeElementCollector::attachElement($this->preview()))
            </column>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             The two files on disk
             ───────────────────────────────────────────────────────────── --}}
        <column class="w-full gap-2">
            <text class="text-xs uppercase tracking-wider font-semibold text-theme-on-surface-variant px-1">
                resources/scripts/greeting.php
            </text>
            <column class="w-full p-4 rounded-2xl bg-theme-surface">
                <text class="text-xs font-mono leading-5 text-theme-on-surface">{{ $this->scriptSource() }}</text>
            </column>
        </column>

        <column class="w-full gap-2">
            <text class="text-xs uppercase tracking-wider font-semibold text-theme-on-surface-variant px-1">
                native/live-code-preview.blade.php
            </text>
            <column class="w-full p-4 rounded-2xl bg-theme-surface">
                <text class="text-xs font-mono leading-5 text-theme-on-surface">{{ $this->viewSource() }}</text>
            </column>
        </column>

        <row class="gap-2">
            <button label="Reset" variant="outlined" size="small" @press="resetScript" />
            <button label="Jello it" variant="outlined" size="small" @press="jello" />
        </row>

        <text class="text-xs text-theme-on-surface-variant text-center px-4 pb-6">
            Nothing here holds the greeting or the layout. The screen changes
            because the code behind it changed.
        </text>

    </column>
</scroll-view>
