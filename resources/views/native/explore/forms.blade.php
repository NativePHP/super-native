<scroll-view class="w-full h-full">
    <column class="w-full p-5 gap-5">

        <text class="text-2xl font-semibold text-theme-on-background">Slider</text>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">On release (blur)</text>
            <slider native:model.blur="slideBlur" :min="0" :max="100" a11y-label="On release (blur)" class="w-full"/>
            <text font="accent" class="text-[20] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2 mt-4">{{ $slideBlur }}</text>
        </column>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Debounced (150ms)</text>
            <slider native:model.debounce.150ms="slideDebounced" :min="0" :max="100" a11y-label="Debounced (150ms)" class="w-full"/>
            <text class="text-[20] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2 mt-4">{{ $slideDebounced }}</text>
        </column>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Live (every drag tick)</text>
            <slider native:model.live="slideValue" :min="0" :max="100" a11y-label="Live (every drag tick)" class="w-full"/>
            <text class="text-[20] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2 mt-4">{{ number_format($slideValue * 10000000, 2) }}</text>
        </column>

        <divider class="my-2" />

        {{-- TOGGLE --}}
        <text class="text-xl font-semibold text-theme-on-background">Toggle</text>
        <toggle native:model="notificationsOn" label="Notifications"            class="w-full"/>
        <toggle native:model="subscribed"      label="Subscribe to newsletter"  class="w-full"/>
        <toggle :value="true" label="Disabled (always on)" disabled              class="w-full"/>

        <divider class="my-2" />

        {{-- CHECKBOX --}}
        <text class="text-xl font-semibold text-theme-on-background">Checkbox</text>
        <checkbox native:model="subscribed"    label="Subscribe to newsletter"           class="w-full"/>
        <checkbox native:model="termsAccepted" label="I accept the terms and conditions" class="w-full"/>
        <text class="text-xl text-theme-on-surface-variant">
            subscribed: {{ $subscribed ? 'yes' : 'no' }} - terms: {{ $termsAccepted ? 'yes' : 'no' }}
        </text>

        <divider class="my-2" />

        {{-- SELECT --}}
        <text class="text-xl font-semibold text-theme-on-background">Select</text>
        <select
            native:model="favoriteLanguage"
            label="Favorite language"
            placeholder="Pick one..."
            :options="['PHP', 'Swift', 'Kotlin', 'TypeScript', 'Rust', 'Go']"
            class="w-full"
        />
        <text class="text-xl text-theme-on-surface-variant">Selected: {{ $favoriteLanguage }}</text>

        <divider class="my-2" />

        {{-- RADIO GROUP --}}
        <text class="text-xl font-semibold text-theme-on-background">Radio Group</text>
        <radio-group native:model="pricingPlan" label="Pricing plan" class="w-full gap-2">
            <radio value="free" label="Free - $0/mo" />
            <radio value="pro"  label="Pro - $19/mo" />
            <radio value="team" label="Team - $49/mo" />
        </radio-group>
        <text class="text-xl text-theme-on-surface-variant">Chosen: {{ $pricingPlan }}</text>

        <divider class="my-2" />

        {{-- TEXT INPUT --}}
        <text class="text-xl font-semibold text-theme-on-background">Text Input - Outlined</text>
        <outlined-text-input class="w-full" label="Name"     placeholder="Jane Doe" native:model="name" />
        <outlined-text-input class="w-full" label="Email"    placeholder="you@example.com" keyboard="email" leading-icon="email" native:model="email" />
        <outlined-text-input class="w-full" label="Password" placeholder="********" secure leading-icon="lock"/>
        <outlined-text-input class="w-full" label="Bio"      placeholder="Tell us about yourself..." multiline :max-lines="4"/>

        <text class="text-xl font-semibold mt-4 text-theme-on-background">Text Input - Filled</text>
        <filled-text-input class="w-full" label="Search"  placeholder="Search anything..." leading-icon="search"/>
        <filled-text-input class="w-full" label="Price"   prefix="$" suffix=".00" keyboard="decimal"/>

    </column>
</scroll-view>
