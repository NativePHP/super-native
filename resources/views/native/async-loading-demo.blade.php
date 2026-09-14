{{-- Loading states around a slow API call, three ways. Read this next to
     AsyncLoadingDemo.php — the comments there explain the run loop. --}}
<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        <column class="w-full gap-2">
            <text class="text-sm opacity-60">
                One PHP thread runs render → publish → wait → handler → repeat.
                A frame only reaches the screen at "publish", so a handler that
                blocks can never show its own loading state.
            </text>
            <outlined-text-input native:model="email" label="Email" keyboard="email" />
        </column>

        {{-- ── 1. Blocking ───────────────────────────────────────────── --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">1 · Blocking</text>
            <text class="text-sm opacity-60">
                Sets $blockingBusy = true, then calls the API in the same
                handler. No publish happens in between, so the button sits
                there looking idle for the whole request.
            </text>

            <row class="items-center gap-3 mt-2">
                <button @tap="signInBlocking" :disabled="$blockingBusy">
                    {{ $blockingBusy ? 'Signing in…' : 'Sign in (blocking)' }}
                </button>
                @if ($blockingBusy)
                    <activity-indicator />
                @endif
            </row>

            @if ($blockingResult !== '')
                <text class="text-sm {{ $blockingOk ? 'text-green-600' : 'text-red-500' }}">{{ $blockingResult }}</text>
            @endif

            <text class="text-sm text-amber-700">You never see the spinner above. That is the bug being reported.</text>
        </column>

        {{-- ── 2. Deferred ───────────────────────────────────────────── --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">2 · Deferred</text>
            <text class="text-sm opacity-60">
                The handler only flips the flag and returns. The loop
                publishes the spinner frame, then #[Poll(100)] tick() runs the
                request on the next pass. No queue, no extra latency.
            </text>

            <row class="items-center gap-3 mt-2">
                <button @tap="signInDeferred" :disabled="$deferredBusy">
                    {{ $deferredBusy ? 'Signing in…' : 'Sign in (deferred)' }}
                </button>
                @if ($deferredBusy)
                    <activity-indicator />
                @endif
            </row>

            @if ($deferredResult !== '')
                <text class="text-sm {{ $deferredOk ? 'text-green-600' : 'text-red-500' }}">{{ $deferredResult }}</text>
            @endif

            <text class="text-sm text-amber-700">
                The spinner renders — but the loop is still blocked during the
                request, so taps queue up until it returns. Right for a login
                button, wrong for anything the user should be able to cancel.
            </text>
        </column>

        {{-- ── 3. Queued ─────────────────────────────────────────────── --}}
        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">3 · Queued</text>
            <text class="text-sm opacity-60">
                DemoApiLogin::dispatch() hands the work to the background queue
                worker — its own PHP runtime, on its own thread. The UI loop
                never blocks, so the counter below keeps ticking and the other
                two buttons stay live.
            </text>

            <row class="items-center gap-3 mt-2">
                <button @tap="signInQueued" :disabled="$queuedBusy">
                    {{ $queuedBusy ? 'Waiting…' : 'Sign in (queued)' }}
                </button>
                @if ($queuedBusy)
                    <activity-indicator />
                    <text class="text-sm text-theme-primary">{{ $queuedWaitedMs }}ms</text>
                @endif
            </row>

            @if ($queuedResult !== '')
                <text class="text-sm {{ $queuedOk ? 'text-green-600' : 'text-red-500' }}">{{ $queuedResult }}</text>
            @endif

            <text class="text-sm text-amber-700">
                The result comes back via Cache::pull() in the same tick(). A
                Laravel event fired inside the job would dispatch on the
                worker's container and never reach this component — shared
                state is the only channel across runtimes.
            </text>
        </column>

        <column class="w-full p-5 gap-2 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">Which one</text>
            <text class="text-sm opacity-60">
                Login and other sub-second-to-a-few-second calls: deferred. It
                shows the spinner immediately and adds nothing to the round
                trip.
            </text>
            <text class="text-sm opacity-60">
                Long uploads, sync, anything cancellable or survivable across
                app restarts: queued. Note the counter — the worker sleeps up
                to 3s between polls, so expect that much pickup latency before
                the job even starts.
            </text>
        </column>

    </column>
</scroll-view>
