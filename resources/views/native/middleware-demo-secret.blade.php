<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        <column class="w-full p-5 gap-2 bg-theme-primary rounded-2xl">
            <text class="text-2xl font-bold uppercase text-theme-on-primary">Members Only</text>
            <text class="text-base text-theme-on-primary">
                The middleware let this navigation through, so the screen mounted.
            </text>
        </column>

        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-xl font-bold uppercase text-theme-on-surface-variant">Middleware log</text>
            @foreach($log as $line)
                <text class="text-sm text-theme-on-surface">{{ $line }}</text>
            @endforeach
        </column>

    </column>
</scroll-view>
