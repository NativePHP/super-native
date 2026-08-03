<scroll-view class="w-full h-full bg-theme-background safe-area">
    <column class="w-full px-5 py-10 gap-8 items-center">

        {{-- Header — sync icon block + brand + tagline --}}
        <column class="w-full items-center gap-2">
            <column class="w-[80] h-[80] rounded-2xl bg-theme-surface items-center justify-center mb-2 border border-theme-outline">
                <icon name="arrow.triangle.2.circlepath" :size="36" color="#0891b2" />
            </column>
            <text class="text-2xl font-bold text-cyan-600 ">SyncUp</text>
            <text class="text-base text-theme-on-surface-variant text-center">Connect with your world effortlessly and stay in sync with those who matter most.</text>
        </column>

        {{-- Form card --}}
        <column class="w-full bg-theme-surface rounded-3xl p-6 gap-4 border border-theme-outline">

            {{-- Email field --}}
            <column class="w-full gap-1">
                <text class="text-base font-semibold text-theme-on-surface ">Email Address</text>
                <row class="w-full items-center gap-2 mt-2">
                    <icon name="mail" :size="20" color="#6d797e" dark-color="#94a3b8" />
                    <outlined-text-input
                        value="{{ $email }}"
                        placeholder="name@example.com"
                        @change="updateEmail"
                        :variant="0"
                        class="flex-1"
                    />
                </row>
            </column>

            {{-- Password field --}}
            <column class="w-full gap-1">
                <row class="w-full justify-between items-center ">
                    <text class="text-base font-semibold text-theme-on-surface">Password</text>
                    <text @tap="forgotPassword" class="text-xs font-medium text-cyan-600">Forgot?</text>
                </row>
                <row class="w-full items-center gap-2 mt-1">
                    <icon name="lock" :size="20" color="#6d797e" dark-color="#94a3b8" />
                    <outlined-text-input
                        value="{{ $password }}"
                        placeholder="••••••••"
                        :secure="!$showPassword"
                        @change="updatePassword"
                        :variant="0"
                        class="flex-1"
                    />
                    <column @tap="toggleVisibility" class="px-2 py-2">
                        <icon name="{{ $showPassword ? 'visibility_off' : 'visibility' }}" :size="20" color="#6d797e" dark-color="#94a3b8" />
                    </column>
                </row>
            </column>

            {{-- Login button --}}
            <column @tap="login" class="w-full bg-[#00677d] rounded-xl py-4 items-center mt-2">
                <text class="text-[18] font-semibold text-white">Login</text>
            </column>

            {{-- Divider with label --}}
            <row class="w-full items-center gap-3 mt-4">
                <column class="flex-1 h-px bg-theme-outline" />
                <text class="text-[11] font-medium text-theme-on-surface-variant">OR CONTINUE WITH</text>
                <column class="flex-1 h-px bg-theme-outline" />
            </row>

            {{-- Social buttons --}}
            <row class="w-full gap-3 mt-2">
                <column @tap="loginWithGoogle" class="flex-1 py-3 rounded-xl border border-theme-outline items-center">
                    <text class="text-[12] font-semibold text-theme-on-surface">Google</text>
                </column>
                <column @tap="loginWithApple" class="flex-1 py-3 rounded-xl border border-theme-outline items-center">
                    <text class="text-[12] font-semibold text-theme-on-surface">Apple</text>
                </column>
            </row>
        </column>

        {{-- Footer --}}
        <column class="w-full items-center gap-4">
            <row class="items-center gap-1">
                <text class="text-[14] text-theme-on-surface-variant">Don't have an account?</text>
                <text @tap="createAccount" class="text-[14] font-semibold text-[#00677d] dark:text-[#67e8f9]">Create Account</text>
            </row>

            {{-- Demo-only: skip past login and jump straight into the app. --}}
            <text @tap="skipLogin" class="text-[12] font-medium text-theme-on-surface-variant underline">Skip login →</text>

            <row class="items-center gap-3">
                <text class="text-[11] text-theme-on-surface-variant">Privacy Policy</text>
                <text class="text-[11] text-theme-on-surface-variant">•</text>
                <text class="text-[11] text-theme-on-surface-variant">Terms of Service</text>
            </row>
        </column>

    </column>
</scroll-view>
