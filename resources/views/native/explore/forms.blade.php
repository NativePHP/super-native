<native:scroll-view class="w-full bg-theme-surface">
    <native:column class="w-full p-5 gap-5">

        {{-- TEXT INPUT --}}
        <native:text class="text-lg font-semibold">Text Input — Outlined</native:text>
        <native:outlined-text-input class="w-full" label="Name"     placeholder="Jane Doe" native:model="name" />
        <native:outlined-text-input class="w-full" label="Email"    placeholder="you@example.com" keyboard="email" leading-icon="email" native:model="email" />
        <native:outlined-text-input class="w-full" label="Password" placeholder="••••••••" secure leading-icon="lock"/>
        <native:outlined-text-input class="w-full" label="Bio"      placeholder="Tell us about yourself..." multiline :max-lines="4"/>

        <native:text class="text-lg font-semibold mt-4">Text Input — Filled</native:text>
        <native:filled-text-input class="w-full" label="Search"  placeholder="Search anything..." leading-icon="search"/>
        <native:filled-text-input class="w-full" label="Price"   prefix="$" suffix=".00" keyboard="decimal"/>

        <native:divider class="my-2" />

        {{-- SLIDER --}}
        <native:text class="text-lg font-semibold">Slider</native:text>

        <native:column class="gap-1">
            <native:text class="text-sm text-gray-600">Live (every drag tick)</native:text>
            <native:slider native:model.live="slideValue" :min="0" :max="100" class="w-full"/>
            <native:text class="text-base">Value: {{ number_format($slideValue, 1) }}</native:text>
        </native:column>

        <native:column class="gap-1">
            <native:text class="text-sm text-gray-600">Debounced (150ms)</native:text>
            <native:slider native:model.debounce.150ms="slideDebounced" :min="0" :max="100" class="w-full"/>
            <native:text class="text-base">Value: {{ number_format($slideDebounced, 1) }}</native:text>
        </native:column>

        <native:column class="gap-1">
            <native:text class="text-sm text-gray-600">On release (blur)</native:text>
            <native:slider native:model.blur="slideBlur" :min="0" :max="100" class="w-full"/>
            <native:text class="text-base">Value: {{ number_format($slideBlur, 1) }}</native:text>
        </native:column>

        <native:divider class="my-2" />

        {{-- TOGGLE --}}
        <native:text class="text-lg font-semibold">Toggle</native:text>
        <native:toggle native:model="notificationsOn" label="Notifications"            class="w-full"/>
        <native:toggle native:model="subscribed"      label="Subscribe to newsletter"  class="w-full"/>
        <native:toggle :value="true" label="Disabled (always on)" disabled              class="w-full"/>

        <native:divider class="my-2" />

        {{-- CHECKBOX --}}
        <native:text class="text-lg font-semibold">Checkbox (composed)</native:text>
        @foreach ([
            ['field' => 'subscribed',    'label' => 'Subscribe to newsletter'],
            ['field' => 'termsAccepted', 'label' => 'I accept the terms and conditions'],
        ] as $row)
            <native:pressable @press="toggleField('{{ $row['field'] }}')">
                <native:row class="items-center gap-2">
                    <native:icon
                        :name="$this->{$row['field']} ? 'check_box' : 'check_box_outline'"
                        :size="22"
                        :color="$this->{$row['field']} ? '#0F766E' : '#475569'"/>
                    <native:text>{{ $row['label'] }}</native:text>
                </native:row>
            </native:pressable>
        @endforeach
        <native:text class="text-sm text-gray-500">
            subscribed: {{ $subscribed ? 'yes' : 'no' }} · terms: {{ $termsAccepted ? 'yes' : 'no' }}
        </native:text>

        <native:divider class="my-2" />

        {{-- SELECT --}}
        <native:text class="text-lg font-semibold">Select</native:text>
        <native:select
            native:model="favoriteLanguage"
            label="Favorite language"
            placeholder="Pick one..."
            :options="['PHP', 'Swift', 'Kotlin', 'TypeScript', 'Rust', 'Go']"
            class="w-full"
        />
        <native:text class="text-sm text-gray-500">Selected: {{ $favoriteLanguage }}</native:text>

        <native:divider class="my-2" />

        {{-- RADIO GROUP --}}
        <native:text class="text-lg font-semibold">Radio Group (composed)</native:text>
        <native:column class="gap-2 w-full">
            <native:text class="text-sm text-gray-500">Pricing plan</native:text>

            @foreach ([
                ['value' => 'free', 'label' => 'Free — $0/mo'],
                ['value' => 'pro',  'label' => 'Pro — $19/mo'],
                ['value' => 'team', 'label' => 'Team — $49/mo'],
            ] as $row)
                @php $checked = $pricingPlan === $row['value']; @endphp
                <native:pressable @press="selectPricingPlan('{{ $row['value'] }}')">
                    <native:row class="items-center gap-2">
                        <native:icon
                            :name="$checked ? 'radio_button_checked' : 'radio_button_unchecked'"
                            :size="22"
                            :color="$checked ? '#0F766E' : '#475569'"/>
                        <native:text>{{ $row['label'] }}</native:text>
                    </native:row>
                </native:pressable>
            @endforeach
        </native:column>
        <native:text class="text-sm text-gray-500">Chosen: {{ $pricingPlan }}</native:text>

    </native:column>
</native:scroll-view>
