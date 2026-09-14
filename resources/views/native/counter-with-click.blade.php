<scroll-view class="w-full h-full safe-area bg-theme-background">
    <column class="w-full max-w-4xl mx-auto p-5 gap-5">
        <column class="w-full p-5 gap-2 bg-theme-surface-variant rounded-2xl">
            <text class="text-2xl font-bold text-theme-on-surface">Mount + Laravel route binding</text>
            <text class="text-sm text-theme-on-surface-variant">Route: /counter/{click}/{section?}</text>
            <text class="text-lg font-semibold text-theme-primary">Click #{{ $click->getRouteKey() }} · stored count {{ $click->count }}</text>
            <text class="text-sm text-theme-on-surface">Section: {{ $section }}</text>
            <text class="text-sm text-theme-on-surface">{{ $mountResolution }}</text>
            <text class="text-sm {{ $propertyHydratedBeforeMount ? 'text-green-600' : 'text-red-600' }}">
                Typed public $click hydrated before mount: {{ $propertyHydratedBeforeMount ? 'yes' : 'no' }}
            </text>
            <text class="text-xs text-theme-on-surface-variant">#[Locked] click ID: {{ $lockedClickId }}</text>
        </column>

        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-xl font-bold text-theme-on-surface">Action dependency injection</text>
            <text class="text-sm text-theme-on-surface-variant">The button passes two scalars. Native resolves the Click model, service, and backed enum.</text>
            <button variant="primary" @tap="resolveAction({{ $click->getRouteKey() }}, 'inspect')">Resolve action arguments</button>
            <text class="text-sm font-semibold text-theme-primary">{{ $actionResolution }}</text>
        </column>

        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-xl font-bold text-theme-on-surface">Unified nested state pipeline</text>
            <outlined-text-input class="w-full" label="profile.name" native:model="profile.name" />
            <text class="text-sm text-theme-on-surface">Current name: {{ $profile['name'] }}</text>
            <text class="text-xs text-theme-on-surface-variant">Hook order:</text>
            @forelse(array_slice($hookLog, -12) as $entry)
                <text class="text-xs font-mono text-theme-on-surface-variant">{{ $entry }}</text>
            @empty
                <text class="text-xs text-theme-on-surface-variant">Edit the field to run updating* → assignment → updated*.</text>
            @endforelse
        </column>

        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-xl font-bold text-theme-on-surface">Actions and render passes</text>
            <text class="text-sm text-theme-on-surface">Count: {{ $count }}</text>
            <text class="text-xs text-theme-on-surface-variant">Every action paints. Render suppression (#[Renderless] / skipRender()) is deliberately not part of this branch.</text>
            <button variant="primary" @tap="increment">+1</button>
        </column>

        <column class="w-full p-5 gap-3 bg-theme-surface-variant rounded-2xl">
            <text class="text-xl font-bold text-theme-on-surface">Component dispatch</text>
            <text class="text-xs text-theme-on-surface-variant">Each #[On] listener also receives ParityDemoService from the container.</text>
            <row class="w-full gap-2">
                <button class="flex-1" size="sm" @tap="dispatchBubbling">Bubble</button>
                <button class="flex-1" size="sm" @tap="dispatchToSelf">Self</button>
                <button class="flex-1" size="sm" @tap="dispatchToClass">Target class</button>
            </row>
            @forelse($eventLog as $entry)
                <text class="text-xs text-theme-on-surface">{{ $entry }}</text>
            @empty
                <text class="text-xs text-theme-on-surface-variant">No component events dispatched yet.</text>
            @endforelse
        </column>
    </column>
</scroll-view>
