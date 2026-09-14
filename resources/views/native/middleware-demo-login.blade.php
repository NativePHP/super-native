<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        <column class="w-full p-5 gap-2 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-surface-variant">Sign In</text>
            <text class="text-base text-theme-on-surface">
                DemoAuth returned redirect('/middleware-demo/login'). That path is a native
                route, so the guard turned it into an in-app replace instead of exiting to
                the web view. Note the log: the guarded screen's mount() never ran.
            </text>
        </column>

        <column class="w-full p-5 gap-4 bg-theme-surface-variant rounded-2xl">
            <button @tap="signIn">Sign in and continue</button>
        </column>

        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-xl font-bold uppercase text-theme-on-surface-variant">Middleware log</text>
            @foreach($log as $line)
                <text class="text-sm text-theme-on-surface">{{ $line }}</text>
            @endforeach
        </column>

    </column>
</scroll-view>
