<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        <column class="w-full p-5 gap-2 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">Route Middleware</text>
            <text class="text-base text-theme-on-surface">
                /middleware-demo/secret is registered with ->middleware(DemoAuth::class).
                Tap it while signed out — plain Laravel middleware redirects you to the
                login screen, on an in-app navigation with no HTTP request involved.
            </text>
        </column>

        <column class="w-full p-5 gap-4 bg-theme-surface-variant rounded-2xl">
            <row class="items-center justify-between">
                <text class="text-xl text-theme-on-surface">Status</text>
                <text class="text-xl font-bold {{ $signedIn ? 'text-theme-primary' : 'text-theme-error' }}">
                    {{ $signedIn ? 'Signed in' : 'Signed out' }}
                </text>
            </row>

            <button @navigate('/middleware-demo/secret')>Open Members Only</button>

            @if($signedIn)
                <button @tap="signOut">Sign out</button>
            @endif
        </column>

        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <row class="items-center justify-between">
                <text class="text-xl font-bold uppercase text-theme-on-surface-variant">Middleware log</text>
                <button @tap="clearLog">Clear</button>
            </row>

            @forelse($log as $line)
                <text class="text-sm text-theme-on-surface">{{ $line }}</text>
            @empty
                <text class="text-sm text-theme-on-surface-variant">Nothing yet — tap Open Members Only.</text>
            @endforelse
        </column>

    </column>
</scroll-view>
