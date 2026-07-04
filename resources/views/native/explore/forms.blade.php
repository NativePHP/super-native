    <column class="w-full p-5 gap-5">

        <text class="text-2xl font-semibold text-theme-on-background">Slider</text>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">On release (blur)</text>
            <slider native:model.blur="slideBlur" :min="0" :max="100" a11y-label="On release (blur)" class="w-full"/>
            <text class="text-[20] text-black font-bold bg-gray-300 rounded-full text-center p-2 mt-4">{{ $slideBlur }}</text>
        </column>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Debounced (150ms)</text>
            <slider native:model.debounce.150ms="slideDebounced" :min="0" :max="100" a11y-label="Debounced (150ms)" class="w-full"/>
            <text class="text-[20] text-black font-bold bg-gray-300 rounded-full text-center p-2 mt-4">{{ $slideDebounced }}</text>
        </column>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Live (every drag tick)</text>
            <slider native:model.live="slideValue" :min="0" :max="100" a11y-label="Live (every drag tick)" class="w-full"/>
            <text class="text-[20] text-black font-bold bg-gray-300 rounded-full text-center p-2 mt-4">{{ $slideValue }}</text>
        </column>










        {{-- TEXT INPUT --}}
{{--        <text class="text-xl font-semibold text-theme-on-background">Text Input — Outlined</text>--}}
{{--        <outlined-text-input class="w-full" label="Name"     placeholder="Jane Doe" native:model="name" />--}}
{{--        <outlined-text-input class="w-full" label="Email"    placeholder="you@example.com" keyboard="email" leading-icon="email" native:model="email" />--}}
{{--        <outlined-text-input class="w-full" label="Password" placeholder="••••••••" secure leading-icon="lock"/>--}}
{{--        <outlined-text-input class="w-full" label="Bio"      placeholder="Tell us about yourself..." multiline :max-lines="4"/>--}}

{{--        <text class="text-xl font-semibold mt-4 text-theme-on-background">Text Input — Filled</text>--}}
{{--        <filled-text-input class="w-full" label="Search"  placeholder="Search anything..." leading-icon="search"/>--}}
{{--        <filled-text-input class="w-full" label="Price"   prefix="$" suffix=".00" keyboard="decimal"/>--}}

{{--        <divider class="my-2" />--}}

{{--        --}}{{-- SLIDER --}}
{{--        <text class="text-xl font-semibold text-theme-on-background">Slider</text>--}}

{{--        <column class="gap-1">--}}
{{--            <text class="text-xl text-theme-on-surface-variant">Live (every drag tick)</text>--}}
{{--            <slider native:model.live="slideValue" :min="0" :max="100" class="w-full"/>--}}
{{--            <text class="text-[20] text-theme-on-background">Value 1: {{ number_format($slideValue, 3) }}</text>--}}
{{--            <text class="text-[20] text-theme-on-background">Value 2: {{ number_format($slideValue * 2, 3) }}</text>--}}
{{--        </column>--}}

{{--        <column class="gap-1">--}}
{{--            <text class="text-xl text-theme-on-surface-variant">Debounced (150ms)</text>--}}
{{--            <slider native:model.debounce.150ms="slideDebounced" :min="0" :max="100" class="w-full"/>--}}
{{--            <text class="text-[20] text-theme-on-background">{{ number_format($slideDebounced, 1) }}</text>--}}
{{--        </column>--}}

{{--        <column class="gap-1">--}}
{{--            <text class="text-xl text-theme-on-surface-variant">On release (blur)</text>--}}
{{--            <slider native:model.blur="slideBlur" :min="0" :max="100" class="w-full"/>--}}
{{--            <text class="text-[20] text-theme-on-background">{{ number_format($slideBlur, 1) }}</text>--}}
{{--        </column>--}}

{{--        <divider class="my-2" />--}}

{{--        --}}{{-- TOGGLE --}}
{{--        <text class="text-xl font-semibold text-theme-on-background">Toggle</text>--}}
{{--        <toggle native:model="notificationsOn" label="Notifications"            class="w-full"/>--}}
{{--        <toggle native:model="subscribed"      label="Subscribe to newsletter"  class="w-full"/>--}}
{{--        <toggle :value="true" label="Disabled (always on)" disabled              class="w-full"/>--}}

{{--        <divider class="my-2" />--}}

{{--        --}}{{-- CHECKBOX --}}
{{--        <text class="text-xl font-semibold text-theme-on-background">Checkbox (composed)</text>--}}
{{--        @foreach ([--}}
{{--            ['field' => 'subscribed',    'label' => 'Subscribe to newsletter'],--}}
{{--            ['field' => 'termsAccepted', 'label' => 'I accept the terms and conditions'],--}}
{{--        ] as $row)--}}
{{--            <pressable @press="toggleField('{{ $row['field'] }}')">--}}
{{--                <row class="items-center gap-2">--}}
{{--                    <icon--}}
{{--                        :name="$this->{$row['field']} ? 'check_box' : 'check_box_outline'"--}}
{{--                        :size="22"--}}
{{--                        :color="$this->{$row['field']} ? '#0F766E' : '#475569'"--}}
{{--                        :dark-color="$this->{$row['field']} ? '#14B8A6' : '#94A3B8'"/>--}}
{{--                    <text class="text-theme-on-background">{{ $row['label'] }}</text>--}}
{{--                </row>--}}
{{--            </pressable>--}}
{{--        @endforeach--}}
{{--        <text class="text-xl text-theme-on-surface-variant">--}}
{{--            subscribed: {{ $subscribed ? 'yes' : 'no' }} · terms: {{ $termsAccepted ? 'yes' : 'no' }}--}}
{{--        </text>--}}

{{--        <divider class="my-2" />--}}

{{--        --}}{{-- SELECT --}}
{{--        <text class="text-xl font-semibold text-theme-on-background">Select</text>--}}
{{--        <select--}}
{{--            native:model="favoriteLanguage"--}}
{{--            label="Favorite language"--}}
{{--            placeholder="Pick one..."--}}
{{--            :options="['PHP', 'Swift', 'Kotlin', 'TypeScript', 'Rust', 'Go']"--}}
{{--            class="w-full"--}}
{{--        />--}}
{{--        <text class="text-xl text-theme-on-surface-variant">Selected: {{ $favoriteLanguage }}</text>--}}

{{--        <divider class="my-2" />--}}

{{--        --}}{{-- RADIO GROUP --}}
{{--        <text class="text-xl font-semibold text-theme-on-background">Radio Group (composed)</text>--}}
{{--        <column class="gap-2 w-full">--}}
{{--            <text class="text-xl text-theme-on-surface-variant">Pricing plan</text>--}}

{{--            @foreach ([--}}
{{--                ['value' => 'free', 'label' => 'Free — $0/mo'],--}}
{{--                ['value' => 'pro',  'label' => 'Pro — $19/mo'],--}}
{{--                ['value' => 'team', 'label' => 'Team — $49/mo'],--}}
{{--            ] as $row)--}}
{{--                @php $checked = $pricingPlan === $row['value']; @endphp--}}
{{--                <pressable @press="selectPricingPlan('{{ $row['value'] }}')">--}}
{{--                    <row class="items-center gap-2">--}}
{{--                        <icon--}}
{{--                            :name="$checked ? 'radio_button_checked' : 'radio_button_unchecked'"--}}
{{--                            :size="22"--}}
{{--                            :color="$checked ? '#0F766E' : '#475569'"--}}
{{--                            :dark-color="$checked ? '#14B8A6' : '#94A3B8'"/>--}}
{{--                        <text class="text-theme-on-background">{{ $row['label'] }}</text>--}}
{{--                    </row>--}}
{{--                </pressable>--}}
{{--            @endforeach--}}
{{--        </column>--}}
{{--        <text class="text-xl text-theme-on-surface-variant">Chosen: {{ $pricingPlan }}</text>--}}

    </column>
