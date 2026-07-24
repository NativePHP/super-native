<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        {{-- Proof the UI thread never blocks: hammer this while tasks run. --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">UI stays live</text>
            <text class="text-base text-theme-on-surface-variant">
                Tap while tasks are running — the counter keeps moving, so PHP is not blocked.
            </text>

            <row class="items-center justify-between mt-2">
                <text class="text-xl text-theme-on-surface">Taps</text>
                <text class="text-2xl font-bold text-theme-accent">{{ $taps }}</text>
            </row>

            <row class="gap-3 mt-2">
                <button @press="tap">Tap me</button>
                <spacer />
                <button @press="reset" variant="ghost">Reset</button>
            </row>
        </column>

        {{-- 1. finished() --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">1 · finished()</text>
            <text class="text-base text-theme-on-surface-variant">
                A 2s task on a background PHP thread. The result lands back on this component.
            </text>

            @if ($reportRunning)
                <row class="items-center gap-3 mt-2">
                    <activity-indicator />
                    <text class="text-lg text-theme-on-surface-variant">Building report…</text>
                </row>
            @elseif ($reportResult)
                <row class="items-center justify-between mt-2">
                    <text class="text-lg text-theme-on-surface">{{ $reportResult }}</text>
                    <text class="text-base text-theme-on-surface-variant">{{ (int) $reportTookMs }}ms</text>
                </row>
            @else
                <text class="text-lg text-theme-on-surface-variant mt-2">Not run yet</text>
            @endif

            <button @press="runReport" class="mt-2" :disabled="$reportRunning">Run report</button>
        </column>

        {{-- 2. failed() --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">2 · failed()</text>
            <text class="text-base text-theme-on-surface-variant">
                The task throws. The exception crosses back as an AsyncTaskException.
            </text>

            @if ($failRunning)
                <row class="items-center gap-3 mt-2">
                    <activity-indicator />
                    <text class="text-lg text-theme-on-surface-variant">Calling upstream…</text>
                </row>
            @elseif ($failMessage)
                <column class="gap-1 mt-2">
                    <text class="text-lg font-semibold text-theme-destructive">{{ $failMessage }}</text>
                    <text class="text-base text-theme-on-surface-variant">thrown as {{ $failClass }}</text>
                </column>
            @else
                <text class="text-lg text-theme-on-surface-variant mt-2">Not run yet</text>
            @endif

            <button @press="runFailing" class="mt-2" variant="destructive" :disabled="$failRunning">Run failing task</button>
        </column>

        {{-- 3. Concurrency --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">3 · Concurrency</text>
            <text class="text-base text-theme-on-surface-variant">
                Three tasks dispatched together, sleeping 3s / 1s / 2s. They land fastest-first —
                so they ran side by side, not in a queue.
            </text>

            @if (count($parallel))
                <column class="gap-2 mt-2">
                    @foreach ($parallel as $entry)
                        <row class="items-center justify-between">
                            <text class="text-lg text-theme-on-surface">{{ $entry['result'] }}</text>
                            <text class="text-base text-theme-accent">+{{ $entry['at'] }}ms</text>
                        </row>
                    @endforeach
                </column>
            @endif

            @if ($parallelRunning)
                <row class="items-center gap-3 mt-2">
                    <activity-indicator />
                    <text class="text-lg text-theme-on-surface-variant">{{ count($parallel) }}/3 done…</text>
                </row>
            @elseif (! count($parallel))
                <text class="text-lg text-theme-on-surface-variant mt-2">Not run yet</text>
            @endif

            <button @press="runParallel" class="mt-2" :disabled="$parallelRunning">Run 3 at once</button>
        </column>

        {{-- 4. shared() --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">4 · shared()</text>
            <text class="text-base text-theme-on-surface-variant">
                Delivered as a named event, not a screen-scoped callback. Start it, navigate back,
                then return — the result still arrives. A plain finished() would have been dropped.
            </text>

            @if ($sharedRunning)
                <row class="items-center gap-3 mt-2">
                    <activity-indicator />
                    <text class="text-lg text-theme-on-surface-variant">Syncing (2.5s)…</text>
                </row>
            @elseif ($sharedResult)
                <text class="text-lg font-semibold text-theme-primary mt-2">{{ $sharedResult }}</text>
            @else
                <text class="text-lg text-theme-on-surface-variant mt-2">Not run yet</text>
            @endif

            <button @press="runShared" class="mt-2" variant="secondary" :disabled="$sharedRunning">Run shared task</button>
        </column>

        {{-- 5. Static-closure guard --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">5 · Static guard</text>
            <text class="text-base text-theme-on-surface-variant">
                Dispatching a closure that captures $this is rejected immediately — in the handler,
                not silently in a background log.
            </text>

            @if ($guardMessage)
                <text class="text-base text-theme-destructive mt-2">{{ $guardMessage }}</text>
            @else
                <text class="text-lg text-theme-on-surface-variant mt-2">Not run yet</text>
            @endif

            <button @press="tryBoundClosure" class="mt-2" variant="outlined">Dispatch a bound closure</button>
        </column>

    </column>
</scroll-view>
