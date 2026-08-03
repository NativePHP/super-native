@php
    // NativePHP brand palette
    $bg = $darkMode ? '#050714' : '#FFFFFF';
    $fg = $darkMode ? '#F8FAFC' : '#272d48';
    $muted = $darkMode ? '#94A3B8' : '#64748B';
    $card = $darkMode ? '#0F1629' : '#FFFFFF';
    $border = $darkMode ? '#1E293B' : '#E2E8F0';
    $accent = '#7C3AED';
    $accentText = $darkMode ? '#A78BFA' : '#7C3AED';
    $navy = '#272d48';
    $teal = $darkMode ? '#3edad7' : '#00aaa6';
    $indigo = $darkMode ? '#8696ed' : '#505b93';
@endphp

@include('native.partials.demo-nav', ['title' => 'Component Demo'])
<scroll-view class="w-full h-full"   :bg="$bg">
    <column class="w-full gap-0 safe-area">

        {{-- Header --}}
        <column class="w-full px-6  pb-3 gap-2 items-center">
            <text class="text-3xl font-extrabold text-center" :color="$accentText">
                EDGE Component Demo
            </text>
            <text class="text-base text-center" :color="$muted">
                Every native UI element rendered from PHP
            </text>
        </column>

        {{-- 1. Text Styles --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">1. Text</text>
            <spacer class="h-2"/>
            <column class="gap-1">
                <text class="text-lg font-thin" :color="$fg">Thin (1)</text>
                <text class="text-lg font-light" :color="$fg">Light (2)</text>
                <text class="text-lg font-normal" :color="$fg">Normal (3)</text>
                <text class="text-lg font-medium" :color="$fg">Medium (4)</text>
                <text class="text-lg font-semibold" :color="$indigo">SemiBold (5)</text>
                <text class="text-lg font-bold" :color="$accentText">Bold (6)</text>
                <text class="text-lg font-extrabold" :color="$teal">ExtraBold (7)</text>
            </column>
            <row class="w-full justify-between">
                <text class="text-lg" :color="$muted">Start</text>
                <text class="text-lg" :color="$muted">Center</text>
                <text class="text-lg" :color="$muted">End</text>
            </row>
            <text class="text-lg" :color="$muted" :maxLines="1">This text has maxLines set to 1 so it will be
                truncated with an ellipsis if it overflows the available space in the container
            </text>
            <text class="text-lg font-semibold" :color="$accentText" @tap="tap">Tappable text — tap me!
            </text>
        </column>

        {{-- 2. Buttons --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">2. Buttons</text>
            <spacer class="h-2"/>
            <row class="gap-2 justify-center">
                <button class="bg-[#272d48] rounded-full text-white text-lg" @tap="tap">Tap Me</button>
                <button class="bg-[#7C3AED] rounded-full text-white text-lg" @tap="tap" @longTap="longTap">Long Press</button>
            </row>
            <row class="gap-4 justify-center">
                <text class="text-lg font-semibold" :color="$accentText">Taps: {{ $tapCount }}</text>
                <text class="text-lg font-semibold" :color="$teal">Long: {{ $longPressCount }}</text>
            </row>
            <row class="gap-2 justify-center">
                <button label="Reset" @tap="resetCounters" color="{{ $darkMode ? '#94A3B8' : '#64748B' }}"
                               labelColor="#FFFFFF"/>
                <button label="Disabled" disabled color="#CBD5E1" labelColor="#94A3B8"/>
            </row>
        </column>

        {{-- 3. Text Input --}}
{{--        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">--}}
{{--            <text class="text-2xl font-bold" :color="$fg">3. Text Input</text>--}}
{{--            <text class="text-base" :color="$muted">Full M3 TextField — outlined/filled, label, icons,--}}
{{--                prefix/suffix, supporting, error, keyboard types--}}
{{--            </text>--}}
{{--            <spacer class="h-2"/>--}}

{{--            Interactive: onChange + onSubmit--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Live round-trip</text>--}}
{{--            <outlined-text-input class="w-full" :value="$inputText" label="Your text" placeholder="Type something..."--}}
{{--                               :textColor="$fg" color="#7C3AED" @change="onType" @submit="onSubmit"/>--}}
{{--            <row class="gap-2 items-center">--}}
{{--                <text class="text-base" :color="$muted">Live:</text>--}}
{{--                <text class="text-lg font-semibold"--}}
{{--                             :color="strlen($inputText) > 0 ? $accentText : '#CBD5E1'">{{ strlen($inputText) > 0 ? strtoupper($inputText) : '(empty)' }}</text>--}}
{{--            </row>--}}
{{--            @if(strlen($submittedText) > 0)--}}
{{--                <text class="text-lg font-bold" :color="$teal">Submitted: {{ $submittedText }}</text>--}}
{{--            @else--}}
{{--                <text class="text-base" :color="$muted">Press Done/Enter to submit</text>--}}
{{--            @endif--}}

{{--            <divider class="w-full"/>--}}

{{--            Variants: Outlined vs Filled--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Variants</text>--}}
{{--            <outlined-text-input class="w-full" label="Outlined (default)" placeholder="This is the default..."--}}
{{--                               :textColor="$fg" color="#7C3AED"/>--}}
{{--            <outlined-text-input class="w-full" label="Filled variant" placeholder="Filled style..." :variant="1"--}}
{{--                               :textColor="$fg" color="#7C3AED" :containerColor="$darkMode ? '#1A2332' : '#F1F5F9'"/>--}}

{{--            <divider class="w-full"/>--}}

{{--            Label + Placeholder--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Floating label</text>--}}
{{--            <outlined-text-input class="w-full" label="Email address" placeholder="you@example.com" leadingIcon="email"--}}
{{--                               :keyboard="2" :textColor="$fg" color="#7C3AED"/>--}}

{{--            <divider class="w-full"/>--}}

{{--            Icons--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Leading & trailing icons</text>--}}
{{--            <outlined-text-input class="w-full" label="Search" placeholder="Search..." leadingIcon="search"--}}
{{--                               :textColor="$fg" color="#7C3AED"/>--}}
{{--            <outlined-text-input class="w-full" label="Password" placeholder="Enter password..." secure leadingIcon="lock"--}}
{{--                               trailingIcon="visibility_off" :textColor="$fg" color="#7C3AED"/>--}}

{{--            <divider class="w-full"/>--}}

{{--            Prefix & Suffix--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Prefix & suffix</text>--}}
{{--            <outlined-text-input class="w-full" label="Price" prefix="$" suffix=".00" :keyboard="5" :textColor="$fg"--}}
{{--                               color="#7C3AED"/>--}}
{{--            <outlined-text-input class="w-full" label="Website" prefix="https://" suffix=".com" :keyboard="4"--}}
{{--                               :textColor="$fg" color="#7C3AED"/>--}}

{{--            <divider class="w-full"/>--}}

{{--            Supporting text + Error state--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Supporting text & error</text>--}}
{{--            <outlined-text-input class="w-full" label="Username" supporting="Must be 3-20 characters" leadingIcon="person"--}}
{{--                               :textColor="$fg" color="#7C3AED"/>--}}
{{--            <outlined-text-input class="w-full" label="Email" value="not-an-email" isError--}}
{{--                               supporting="Please enter a valid email address" leadingIcon="error" :textColor="$fg"/>--}}

{{--            <divider class="w-full"/>--}}

{{--            Disabled & ReadOnly--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Disabled & read-only</text>--}}
{{--            <outlined-text-input class="w-full" label="Disabled field" value="Can't edit this" disabled :textColor="$fg"/>--}}
{{--            <outlined-text-input class="w-full" label="Read-only field" value="Read but not edit" readOnly--}}
{{--                               :textColor="$fg" color="#7C3AED"/>--}}

{{--            <divider class="w-full"/>--}}

{{--            Max length--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Max length (10 chars)</text>--}}
{{--            <outlined-text-input class="w-full" label="Short code" placeholder="Max 10..." :maxLength="10"--}}
{{--                               supporting="Limited to 10 characters" :textColor="$fg" color="#7C3AED"/>--}}

{{--            <divider class="w-full"/>--}}

{{--            Multiline--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Multiline</text>--}}
{{--            <outlined-text-input class="w-full" label="Bio" placeholder="Tell us about yourself..." multiline--}}
{{--                               :minLines="3" :maxLines="6" supporting="Min 3 lines, max 6 lines" :textColor="$fg"--}}
{{--                               color="#7C3AED"/>--}}

{{--            <divider class="w-full"/>--}}

{{--            Keyboard types--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Keyboard types</text>--}}
{{--            <outlined-text-input class="w-full" label="Number" placeholder="123" leadingIcon="pin" :keyboard="1"--}}
{{--                               :textColor="$fg" color="#7C3AED"/>--}}
{{--            <outlined-text-input class="w-full" label="Phone" placeholder="+1 (555) 000-0000" leadingIcon="phone"--}}
{{--                               :keyboard="3" :textColor="$fg" color="#7C3AED"/>--}}
{{--            <outlined-text-input class="w-full" label="Decimal" placeholder="0.00" :keyboard="5" :textColor="$fg"--}}
{{--                               color="#7C3AED"/>--}}

{{--            <divider class="w-full"/>--}}

{{--            Secure input--}}
{{--            <text class="text-lg font-semibold" :color="$fg">Secure input</text>--}}
{{--            <outlined-text-input class="w-full" :value="$secureText" label="Password" placeholder="Enter password..."--}}
{{--                               secure leadingIcon="lock" :textColor="$fg" color="#7C3AED" @change="onSecureType"/>--}}

{{--            <button label="Clear all" @tap="clearInput" color="{{ $darkMode ? '#94A3B8' : '#64748B' }}"--}}
{{--                           labelColor="#FFFFFF"/>--}}
{{--        </column>--}}

        {{-- 4. Toggle --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">4. Toggle</text>
            <spacer class="h-2"/>
            <row class="w-full justify-between items-center">
                <text class="text-lg" :color="$fg">Dark mode</text>
                <toggle :value="$darkMode" @change="toggleDark"/>
            </row>
            <row class="w-full justify-between items-center">
                <text class="text-lg" :color="$fg">Prompt for bio</text>
                <toggle :value="$notifications" @change="makeAlert"/>
            </row>
            <row class="w-full justify-between items-center">
                <text class="text-lg" :color="$muted">Disabled toggle</text>
                <toggle :value="true" disabled/>
            </row>
            <text class="text-base" :color="$muted">Dark: {{ $darkMode ? 'ON' : 'OFF' }} ·
                Security: {{ $notifications ? 'ON' : 'OFF' }}</text>
        </column>

        {{-- 5. Checkbox --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">5. Checkbox</text>
            <spacer class="h-2"/>
            <checkbox :value="$agreeTerms" label="I agree to the terms" :labelColor="$fg" @change="toggleTerms"/>
            <checkbox :value="$newsletter" label="Subscribe to newsletter" :labelColor="$fg"
                             @change="toggleNewsletter"/>
            <checkbox :value="true" label="Disabled checkbox" :labelColor="$muted" disabled/>
            <text class="text-base" :color="$muted">Terms: {{ $agreeTerms ? 'YES' : 'NO' }} ·
                Newsletter: {{ $newsletter ? 'YES' : 'NO' }}</text>
        </column>

        {{-- 6. Slider --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">6. Slider</text>
            <spacer class="h-2"/>
            <text class="text-lg" :color="$fg">Volume: {{ $volume }}</text>
            <slider class="w-full" :value="$volume" :min="0" :max="100" :step="1" @change="onVolumeChange"/>
            <text class="text-lg" :color="$fg">Brightness: {{ $brightness }}</text>
            <slider class="w-full" :value="$brightness" :min="0" :max="1" :step="0.05"
                           @change="onBrightnessChange"/>
            <text class="text-base" :color="$muted">Disabled slider:</text>
            <slider class="w-full" :value="0.5" :min="0" :max="1" disabled/>
        </column>

        {{-- 7. Progress Bar --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">7. Progress Bar</text>
            <spacer class="h-2"/>
            <text class="text-lg" :color="$fg">Default ({{ round($brightness * 100) }}% — linked to brightness
                slider):
            </text>
            <progress-bar class="w-full" :value="$brightness"/>
            <text class="text-lg" :color="$fg">Custom colors:</text>
            <progress-bar class="w-full" :value="0.75" color="{{ $teal }}"
                                 trackColor="{{ $darkMode ? '#0F2B2A' : '#F0FDFA' }}"/>
            <progress-bar class="w-full" :value="0.33" color="{{ $accentText }}"
                                 trackColor="{{ $darkMode ? '#1E1338' : '#F5F3FF' }}"/>
        </column>

        {{-- 8. Activity Indicator --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">8. Activity Indicator</text>
            <spacer class="h-2"/>
            <row class="w-full gap-6 justify-center items-center">
                <column class="gap-1 items-center">
                    <activity-indicator size="small" color="#7C3AED"/>
                    <text class="text-base" :color="$muted">Small</text>
                </column>
                <column class="gap-1 items-center">
                    <activity-indicator :color="$indigo"/>
                    <text class="text-base" :color="$muted">Medium</text>
                </column>
                <column class="gap-1 items-center">
                    <activity-indicator size="large" :color="$teal"/>
                    <text class="text-base" :color="$muted">Large</text>
                </column>
            </row>
        </column>

        {{-- 9. Image --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">9. Image</text>
            <spacer class="h-2"/>
            <row class="w-full gap-2 justify-center items-center">
                <column class="gap-1 items-center">
                    <image class="w-[120] h-20 rounded-lg" src="https://picsum.photos/seed/nativephp1/240/160"/>
                    <text class="text-base" :color="$muted">Fit (default)</text>
                </column>
                <column class="gap-1 items-center">
                    <image class="w-20 h-20 rounded-[40]" src="https://picsum.photos/seed/nativephp2/160/160"
                                  :fit="2"/>
                    <text class="text-base" :color="$muted">Crop circle</text>
                </column>
                <column class="gap-1 items-center">
                    <image class="w-20 h-20 rounded-lg" src="https://picsum.photos/seed/nativephp3/160/160"
                                  :fit="2"/>
                    <text class="text-base" :color="$muted">Crop rounded</text>
                </column>
            </row>
            <text class="text-base" :color="$muted">Images loaded from picsum.photos with seeded URLs
            </text>
        </column>

        {{-- 10. Radio Group --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">10. Radio Group</text>
            <spacer class="h-2"/>
            <text class="text-lg" :color="$fg">Select size:</text>
            <radio-group class="w-full" :value="$selectedSize" @change="onSizeChange">
                <radio radioValue="small" label="Small" :labelColor="$fg"/>
                <radio radioValue="medium" label="Medium" :labelColor="$fg"/>
                <radio radioValue="large" label="Large" :labelColor="$fg"/>
                <radio radioValue="xl" label="Extra Large" :labelColor="$muted" disabled/>
            </radio-group>
            <text class="text-base" :color="$muted">Selected: {{ $selectedSize }}</text>
        </column>

        {{-- 11. Select (Dropdown) --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">11. Select</text>
            <spacer class="h-2"/>
            <select class="w-full" :value="$selectedColor" placeholder="Choose a color..."
                           :options="['Red', 'Green', 'Blue', 'Purple', 'Orange']" @change="onColorChange"/>
            <text class="text-base" :color="$muted">Selected: {{ $selectedColor ?: '(none)' }}</text>
            <text class="text-base" :color="$muted">Disabled select:</text>
            <select class="w-full" value="Locked" :options="['Locked']" disabled/>
        </column>

        {{-- 12. Icon --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">12. Icon</text>
            <spacer class="h-2"/>
            <row class="w-full gap-4 justify-center items-center">
                <icon name="home" :size="32" color="#7C3AED"/>
                <icon name="star" :size="32" :color="$teal"/>
                <icon name="heart" :size="32" :color="$indigo"/>
                <icon name="search" :size="32" :color="$fg"/>
                <icon name="settings" :size="32" :color="$muted"/>
            </row>
        </column>

        {{-- 13. Badge --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">13. Badge</text>
            <spacer class="h-2"/>
            <row class="w-full gap-4 justify-center items-center">
                <row class="gap-2 items-center">
                    <text class="text-lg" :color="$fg">Messages</text>
                    <badge :count="3"/>
                </row>
                <row class="gap-2 items-center">
                    <text class="text-lg" :color="$fg">Alerts</text>
                    <badge :count="42" :color="$teal"/>
                </row>
                <row class="gap-2 items-center">
                    <text class="text-lg" :color="$fg">Overflow</text>
                    <badge :count="150" color="#7C3AED"/>
                </row>
            </row>
        </column>

        {{-- 14. Row & Column Layout --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">14. Row & Column</text>
            <spacer class="h-2"/>
            <text class="text-base" :color="$muted">Row with gap + center:</text>
            <row class="w-full gap-2 justify-center">
                <column class="w-10 h-10 bg-[#272d48] rounded-lg"/>
                <column class="w-10 h-10 bg-[#505b93] rounded-lg"/>
                <column class="w-10 h-10 bg-[#7C3AED] rounded-lg"/>
                <column class="w-10 h-10 bg-[#00aaa6] rounded-lg"/>
            </row>
            <text class="text-base" :color="$muted">Row with space-between:</text>
            <row class="w-full justify-between">
                <column class="w-10 h-10 bg-[#272d48] rounded-lg"/>
                <column class="w-10 h-10 bg-[#7C3AED] rounded-lg"/>
                <column class="w-10 h-10 bg-[#00aaa6] rounded-lg"/>
            </row>
            <text class="text-base" :color="$muted">Row with space-evenly:</text>
            <row class="w-full justify-evenly">
                <column class="w-10 h-10 bg-[#272d48] rounded-lg"/>
                <column class="w-10 h-10 bg-[#505b93] rounded-lg"/>
                <column class="w-10 h-10 bg-[#00aaa6] rounded-lg"/>
            </row>
        </column>

        {{-- 15. Stack (overlay) --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">15. Stack</text>
            <spacer class="h-2"/>
            <stack class="w-full h-[100] items-center justify-center">
                <column class="w-[200] h-[100] bg-[#272d48] rounded-xl"/>
                <column class="w-[150] h-[75] bg-[#505b93] rounded-xl"/>
                <column class="w-[100] h-[50] bg-[#7C3AED] rounded-xl"/>
            </stack>
        </column>

        {{-- 16. Styling --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">16. Styling</text>
            <spacer class="h-2"/>
            <row class="w-full gap-2 justify-center">
                <column class="w-20 h-[50] bg-[#272d48] rounded-2xl" center>
                    <text class="text-base text-white text-center">Rounded</text>
                </column>
                <column class="w-20 h-[50] border-2 border-[#7C3AED] rounded-lg" center>
                    <text class="text-base text-[#7C3AED] text-center">Border</text>
                </column>
                <column class="w-20 h-[50] bg-[#505b93] rounded-lg opacity-50" center>
                    <text class="text-base text-white text-center">50%</text>
                </column>
            </row>
            <row class="w-full gap-2 justify-center">
                <column class="w-[100] h-[50] shadow-lg rounded-lg" :bg="$card" center>
                    <text class="text-base text-center" :color="$fg">Elevated</text>
                </column>
                <column class="w-[100] h-10 bg-[#00aaa6] rounded-[20]" center>
                    <text class="text-base text-white text-center">Pill</text>
                </column>
            </row>
        </column>

        {{-- 17. Divider & Spacer --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">17. Divider & Spacer</text>
            <spacer class="h-2"/>
            <text class="text-lg" :color="$fg">Above divider</text>
            <divider class="w-full"/>
            <text class="text-lg" :color="$fg">Below divider</text>
            <text class="text-base" :color="$muted">Below is a 32dp spacer:</text>
            <spacer class="h-8"/>
            <text class="text-lg" :color="$fg">After the spacer</text>
        </column>

        {{-- 18. Horizontal Scroll --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">18. Horizontal Scroll</text>
            <spacer class="h-2"/>
            <scroll-view horizontal>
                <row class="gap-2">
                    @foreach(['#272d48', '#505b93', '#7C3AED', '#A78BFA', '#00aaa6', '#3edad7', '#8696ed', '#64748B'] as $color)
                        <column class="w-20 h-20 rounded-lg" :bg="$color"/>
                    @endforeach
                </row>
            </scroll-view>
        </column>

        {{-- 20. Form Validation (@nativeError directive) --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">19. Form Validation</text>
            <text class="text-base" :color="$muted">@@nativeError directive — inline error text from $errors
            </text>
            <spacer class="h-2"/>

            <text class="text-lg font-semibold" :color="$fg">Name</text>
            <outlined-text-input class="w-full" :value="$formName" placeholder="Enter your name..." :textColor="$fg"
                               color="#7C3AED" @change="onFormName"/>
            @nativeError('name')

            <text class="text-lg font-semibold" :color="$fg">Email</text>
            <outlined-text-input class="w-full" :value="$formEmail" placeholder="you@example.com" :textColor="$fg"
                               color="#7C3AED" @change="onFormEmail" :keyboard="2"/>
            @nativeError('email', '#EF4444')

            <row class="gap-2 justify-center">
                <button label="Submit" @tap="submitForm" color="#272d48" labelColor="#FFFFFF"/>
                <button label="Reset" @tap="resetForm" color="{{ $darkMode ? '#94A3B8' : '#64748B' }}"
                               labelColor="#FFFFFF"/>
            </row>

            @if($formSubmitted)
                <column class="w-full p-3 rounded-lg gap-1" :bg="$darkMode ? '#0D2818' : '#ECFDF5'">
                    <text class="text-lg font-bold" :color="$teal">Form submitted!</text>
                    <text class="text-base" :color="$teal">Name: {{ $formName }} ·
                        Email: {{ $formEmail }}</text>
                </column>
            @endif

            <text class="text-base" :color="$muted">Try submitting empty, short name, or email without @@
            </text>
        </column>

        {{-- 21. Card --}}
                <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
                    <text class="text-2xl font-bold" :color="$fg">20. Card</text>
                    <spacer class="h-2" />
                    <column class="w-full p-4 gap-1 bg-theme-surface-variant rounded-2xl">
                        <text class="text-lg font-semibold" :color="$fg">Filled</text>
                        <text class="text-base" :color="$muted">surface-variant background, no stroke</text>
                    </column>
                    <column class="w-full p-4 gap-1 bg-theme-surface rounded-2xl border border-theme-outline">
                        <text class="text-lg font-semibold" :color="$fg">Outlined</text>
                        <text class="text-base" :color="$muted">surface background + outline stroke</text>
                    </column>
                    <column class="w-full p-4 gap-1 bg-theme-surface rounded-2xl shadow">
                        <text class="text-lg font-semibold" :color="$fg">Elevated</text>
                        <text class="text-base" :color="$muted">surface + soft shadow</text>
                    </column>
                    <pressable @tap="tap" class="w-full">
                        <column class="w-full p-4 gap-1 bg-theme-surface-variant rounded-2xl">
                            <text class="text-lg font-semibold" :color="$accentText">Tappable</text>
                            <text class="text-base" :color="$muted">wrap in `<pressable>` for taps</text>
                        </column>
                    </pressable>
                </column>

        {{-- 22. List Item --}}
                <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
                    <text class="text-2xl font-bold" :color="$fg">21. List Item</text>
                    <text class="text-base" :color="$muted">M3 spec — leading/trailing content types, callbacks, styling, elevation</text>
                    <spacer class="h-2" />

                     Basic
                    <text class="text-lg font-semibold" :color="$fg">Basic</text>
                    <list-item class="w-full" headline="Simple headline" headlineColor="{{ $fg }}" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="With supporting text" supporting="Secondary text below the headline" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="With overline" supporting="Supporting text" overline="CATEGORY" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" overlineColor="{{ $accentText }}" />

                    <divider class="w-full" />
                    <spacer class="h-2" />

                     Leading content types
                    <text class="text-lg font-semibold" :color="$fg">Leading content</text>
                    <list-item class="w-full" headline="Leading icon" supporting="Material icon in leading slot" leadingIcon="person" trailingIcon="chevron_right" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" leadingIconColor="{{ $accentText }}" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Avatar" supporting="40dp circle from URL" leadingAvatar="https://i.pravatar.cc/80?img=3" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Monogram" supporting="Initials in a colored circle" leadingMonogram="SR" leadingMonogramColor="{{ $accent }}" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Image thumbnail" supporting="56dp rounded rect from URL" leadingImage="https://picsum.photos/seed/listdemo/112/112" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Leading checkbox" supporting="{{ $listCheckbox ? 'Checked' : 'Unchecked' }}" :leadingCheckbox="$listCheckbox" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" @leadingChange="onListCheckbox" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Leading radio" supporting="{{ $listRadio ? 'Selected' : 'Not selected' }}" :leadingRadio="$listRadio" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" @leadingChange="onListRadio" />

                    <divider class="w-full" />
                    <spacer class="h-2" />

                     Trailing content types
                    <text class="text-lg font-semibold" :color="$fg">Trailing content</text>
                    <list-item class="w-full" headline="Trailing icon" leadingIcon="mail" trailingIcon="chevron_right" headlineColor="{{ $fg }}" trailingIconColor="{{ $muted }}" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Trailing text" supporting="Metadata in trailing slot" leadingIcon="event" trailingText="Mar 15" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" trailingTextColor="{{ $muted }}" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Trailing checkbox" supporting="{{ $listTrailingCheckbox ? 'Enabled' : 'Disabled' }}" leadingIcon="notifications" :trailingCheckbox="$listTrailingCheckbox" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" @trailingChange="onListTrailingCheckbox" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Trailing switch" supporting="{{ $listSwitch ? 'ON' : 'OFF' }}" leadingIcon="wifi" :trailingSwitch="$listSwitch" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" @trailingChange="onListSwitch" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Trailing icon button" supporting="Taps: {{ $trailingPressCount }}" leadingIcon="share" trailingIconButton="more_vert" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" @trailingPress="onTrailingPress" />

                    <divider class="w-full" />
                    <spacer class="h-2" />

                     Styling
                    <text class="text-lg font-semibold" :color="$fg">Styling & states</text>
                    <list-item class="w-full" headline="Container color" supporting="Tinted background" leadingIcon="palette" containerColor="{{ $darkMode ? '#1A1A2E' : '#F5F3FF' }}" headlineColor="{{ $accentText }}" supportingColor="{{ $muted }}" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Tonal elevation" supporting="2dp tonal + 1dp shadow" leadingIcon="layers" :tonalElevation="2" :shadowElevation="1" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Disabled item" supporting="Interactions blocked" leadingIcon="block" trailingIcon="chevron_right" headlineColor="{{ $muted }}" supportingColor="{{ $muted }}" disabled />
                    <divider class="w-full" />
                    <list-item class="w-full" headline="Tap + long press" supporting="Tap: {{ $tapCount }} · Long: {{ $longPressCount }}" leadingIcon="touch_app" trailingIcon="chevron_right" headlineColor="{{ $fg }}" supportingColor="{{ $muted }}" @tap="tap" @longTap="longTap" />
                </column>

        {{-- 23. Tabs --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">22. Tabs</text>
            <spacer class="h-2"/>
            <tab-row class="w-full" :selectedIndex="$selectedTab" @change="onTabChange">
                <tab label="Home" icon="home"/>
                <tab label="Search" icon="search"/>
                <tab label="Profile" icon="person"/>
            </tab-row>
            <column class="p-3 gap-1">
                @if($selectedTab === 0)
                    <text class="text-lg font-semibold" :color="$fg">Home tab selected</text>
                    <text class="text-base" :color="$muted">Welcome to the home tab!</text>
                @elseif($selectedTab === 1)
                    <text class="text-lg font-semibold" :color="$fg">Search tab selected</text>
                    <text class="text-base" :color="$muted">Search for something...</text>
                @else
                    <text class="text-lg font-semibold" :color="$fg">Profile tab selected</text>
                    <text class="text-base" :color="$muted">Your profile info here</text>
                @endif
            </column>
            <text class="text-base" :color="$muted">Selected tab index: {{ $selectedTab }}</text>
        </column>

        {{-- 24. Bottom Sheet --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">23. Bottom Sheet</text>
            <spacer class="h-2"/>
            <button @tap="showSheet" class="bg-[#272d48] text-white w-full rounded-full">Open Bottom Sheet
            </button>
            <text class="text-base" :color="$muted">Sheet
                visible: {{ $sheetVisible ? 'YES' : 'NO' }}</text>
            <bottom-sheet :visible="$sheetVisible" @dismiss="hideSheet">
                <column class="w-full p-6 gap-3 rounded-t-2xl" :bg="$card">
                    <row class="w-full justify-center">
                        <column class="w-10 h-1 rounded-full" :bg="$darkMode ? '#334155' : '#CBD5E1'"/>
                    </row>
                    <text class="text-2xl font-bold" :color="$fg">Bottom Sheet Content</text>
                    <text class="text-lg" :color="$muted">This is a modal bottom sheet. Swipe down or tap outside
                        to dismiss.
                    </text>
                    <divider class="w-full"/>
                    <list-item class="w-full" headline="Option 1" supporting="First option"
                                      leadingAvatar="https://i.pravatar.cc/80?img=5" trailingText="Just now"
                                      headlineColor="{{ $fg }}" supportingColor="{{ $muted }}"
                                      trailingTextColor="{{ $muted }}"/>
                    <list-item class="w-full" headline="Option 2" supporting="Second option" leadingMonogram="AB"
                                      leadingMonogramColor="{{ $teal }}" trailingIcon="chevron_right"
                                      headlineColor="{{ $fg }}" supportingColor="{{ $muted }}"/>
                    <list-item class="w-full" headline="Option 3" supporting="Third option"
                                      leadingIcon="settings" trailingIconButton="more_vert" headlineColor="{{ $fg }}"
                                      supportingColor="{{ $muted }}" @trailingPress="onTrailingPress"/>
                    <spacer class="h-4"/>
                    <button label="Close Sheet" @tap="hideSheet" color="#7C3AED" labelColor="#FFFFFF"/>
                </column>
            </bottom-sheet>
        </column>

        {{-- 25. Reusable Partials (@include) --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            @include('native.partials.card-header', ['number' => '24', 'title' => 'Reusable Partials', 'subtitle' => '@include for DRY templates — renders inline, stack stays balanced', 'fg' => $fg, 'muted' => $muted])

            <text class="text-base" :color="$muted">These status dots are rendered via @@includepartials:
            </text>
            <row class="gap-4 justify-center">
                @include('native.partials.status-dot', ['dotColor' => $teal, 'dotLabel' => 'Online'])
                @include('native.partials.status-dot', ['dotColor' => '#F59E0B', 'dotLabel' => 'Away'])
                @include('native.partials.status-dot', ['dotColor' => '#EF4444', 'dotLabel' => 'Offline'])
            </row>

            <divider class="w-full"/>
            <text class="text-base" :color="$muted">The card header above was also rendered via @@include — same
                partial, different data:
            </text>
            <column class="w-full p-3 rounded-lg gap-2" :bg="$darkMode ? '#1A2332' : '#F1F5F9'">
                @include('native.partials.card-header', ['number' => 'X', 'title' => 'Nested Example', 'subtitle' => 'Same partial, different data', 'fg' => $fg, 'muted' => $muted])
                <text class="text-base" :color="$fg">Works at any nesting depth.</text>
            </column>
        </column>

        {{-- 26. Chip (UI Plugin) --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">25. Chip (Plugin)</text>
            <spacer class="h-2"/>
            <row class="gap-2 justify-center">
                <chip label="Featured" :selected="$chipA" icon="star" @change="toggleChipA"/>
                <chip label="Popular" :selected="$chipB" icon="trending_up" @change="toggleChipB"/>
                <chip label="New" :selected="$chipC" @change="toggleChipC"/>
            </row>
            <text class="text-base" :color="$muted">Featured: {{ $chipA ? 'ON' : 'OFF' }}
                · Popular: {{ $chipB ? 'ON' : 'OFF' }} · New: {{ $chipC ? 'ON' : 'OFF' }}</text>
        </column>

        {{-- 19. Navigation --}}
        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">26. Navigation</text>
            <text class="text-base" :color="$muted">navigate(), back(), replace(), exitToWeb()</text>
            <divider class="w-full"/>
            <text class="text-lg font-semibold" :color="$fg">Wizard — replace() for linear flows</text>
            <button @tap="openWizard" class="bg-[#272d48] text-white w-full rounded-full text-lg">Start
                Wizard
            </button>
        </column>

        <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
            <text class="text-2xl font-bold" :color="$fg">27. Laravel</text>
            <divider class="w-full"/>
            <text class="text-lg font-semibold" :color="$fg">dd() & Exceptions</text>
            <row class="gap-2 justify-center">
                <button @tap="fireDd" class="bg-[#272d48] w-1/2 text-white rounded-full text-lg">dd()
                </button>
                <button @tap="fireException" class="bg-[#272d48] w-[50%]] text-white rounded-full text-lg">
                    Exceptions
                </button>
            </row>
        </column>

        {{-- 27. Button Group (Segmented Buttons) --}}
                <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
                    <text class="text-2xl font-bold" :color="$fg">27. Button Group</text>
                    <spacer class="h-2" />
                    <button-group :options="['Day', 'Week', 'Month']" :selectedIndex="$selectedSegment" @change="onSegmentChange" />
                    <text class="text-base" :color="$muted">Selected: {{ ['Day', 'Week', 'Month'][$selectedSegment] ?? '?' }} (index {{ $selectedSegment }})</text>
                    <text class="text-base" :color="$muted">Disabled button group:</text>
                    <button-group :options="['On', 'Off']" :selectedIndex="0" disabled />
                </column>

                {{-- 28. Carousel --}}
                {{-- Visual regression test for RenderNode modifier-forwarding fix:    --}}
                {{--   the carousel applies an extraLarge clip per item via its child  --}}
                {{--   modifier. Pre-fix that modifier was silently dropped on Android  --}}
                {{--   (items showed only their own rounded-2xl). Post-fix the carousel --}}
                {{--   slot clipping is visible, and child styles still apply on top.   --}}
                <column class="w-full p-4 mx-4 mb-3 rounded-2xl gap-3 border border-[{{ $border }}]" :bg="$card">
                    <text class="text-2xl font-bold" :color="$fg">28. Carousel</text>
                    <spacer class="h-2" />
                    <text class="text-base" :color="$muted">Multi-browse (default):</text>
                    {{-- Multi-browse animates slot width across expand/collapse states; --}}
                    {{-- children fill the slot (w-full) and crop-fill (fit=2) so the   --}}
                    {{-- image covers the full slot regardless of its animated aspect.  --}}
                    <carousel item-width="100" item-spacing="8">
                        @foreach(['nativephp4', 'nativephp5', 'nativephp6', 'nativephp7', 'nativephp8'] as $seed)
                            <image class="" fit="2" src="https://picsum.photos/seed/{{ $seed }}/400/300" />
                        @endforeach
                    </carousel>
                    <spacer class="h-2" />
                    <text class="text-base" :color="$muted">Uncontained variant:</text>
                    <carousel item-width="150" item-spacing="8" variant="uncontained">
                        @foreach(['carousel1', 'carousel2', 'carousel3', 'carousel4', 'carousel5'] as $seed)
                            <image class="w-full h-[150]" src="https://picsum.photos/seed/{{ $seed }}/300/300" />
                        @endforeach
                    </carousel>
                </column>

        {{-- Footer --}
        {{--        <column class="w-full pt-4 px-6 pb-8 gap-2 items-center">--}}
        {{--            <divider class="w-full" />--}}
        {{--            <text class="text-base text-center" :color="$muted">End of EDGE demo — 28 components</text>--}}
        {{--            <text class="text-base text-center" :color="$muted">All UI rendered natively via shared memory</text>--}}
        {{--        </column>--}}

    </column>
</scroll-view>
