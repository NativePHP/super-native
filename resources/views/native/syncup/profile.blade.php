<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full px-5 py-6 gap-8 pb-24">

        {{-- Avatar with camera FAB overlay --}}
        <column class="w-full items-center gap-3">
            <stack class="w-[128] h-[128]">
                {{-- Outer gradient ring substitute (solid primary as placeholder for the gradient) --}}
                <column class="w-[128] h-[128] rounded-full bg-[#00b4d8] items-center justify-center">
                    <column class="w-[120] h-[120] rounded-full bg-theme-background items-center justify-center">
                        <image src="https://i.pravatar.cc/300?u=suelena" class="w-[112] h-[112] rounded-full" :fit="2" />
                    </column>
                </column>
                {{-- Camera FAB pinned bottom-right --}}
                <row class="w-[128] h-[128] items-end justify-end">
                    <column @press="editPhoto" a11y-label="Edit photo" class="w-[36] h-[36] rounded-full bg-[#00677d] items-center justify-center border-4 border-theme-background">
                        <icon name="camera.fill" :size="16" color="#FFFFFF" />
                    </column>
                </row>
            </stack>
            <text class="text-[24] font-bold text-theme-on-background tracking-tight">Edit Profile</text>
            <text class="text-[14] text-theme-on-surface-variant">Personalize your digital presence</text>
        </column>

        {{-- Form fields --}}
        <column class="w-full gap-6">
            {{-- Full Name --}}
            <column class="w-full gap-1">
                <text class="text-[12] font-semibold text-[#00677d] dark:text-[#67e8f9] ml-1">Full Name</text>
                <outlined-text-input
                    value="{{ $name }}"
                    placeholder="Your name"
                    @change="updateName"
                    :variant="0"
                    class="w-full"
                />
            </column>

            {{-- Bio --}}
            <column class="w-full gap-1">
                <text class="text-[12] font-semibold text-[#00677d] dark:text-[#67e8f9] ml-1">Bio</text>
                <outlined-text-input
                    value="{{ $bio }}"
                    placeholder="Tell people about yourself"
                    @change="updateBio"
                    :variant="0"
                    :multiline="true"
                    class="w-full"
                />
                <row class="w-full justify-end">
                    <text class="text-[10] text-theme-on-surface-variant">{{ strlen($bio) }} / 160</text>
                </row>
            </column>
        </column>

        {{-- My SyncUp Code card --}}
        <column class="w-full bg-theme-surface border border-theme-outline rounded-3xl p-6 gap-4">
            <row class="w-full justify-center">
                <text class="text-[18] font-semibold text-theme-on-surface">My SyncUp Code</text>
            </row>

            {{-- QR placeholder, centered via row --}}
            <row class="w-full justify-center">
                <column class="w-[192] h-[192] bg-theme-surface border border-theme-outline rounded-2xl items-center justify-center">
                    <icon name="qrcode" :size="120" color="#0891b2" />
                </column>
            </row>

            {{-- Share Link primary --}}
            <row @press="shareLink" class="w-full bg-[#00677d] rounded-xl py-4 items-center justify-center gap-2">
                <icon name="share" :size="18" color="#FFFFFF" />
                <text class="text-[16] font-semibold text-white">Share Link</text>
            </row>

            {{-- "Or copy link" divider --}}
            <row class="w-full items-center gap-3">
                <column class="flex-1 h-px bg-theme-outline" />
                <text class="text-[11] font-medium text-theme-on-surface-variant">OR COPY LINK</text>
                <column class="flex-1 h-px bg-theme-outline" />
            </row>

            {{-- Copy field --}}
            <row class="w-full bg-theme-surface-variant border border-theme-outline rounded-xl px-3 py-2 items-center gap-2">
                <text class="flex-1 px-2 text-[12] font-medium text-theme-on-surface" :maxLines="1">syncup.me/elena_rod</text>
                <column @press="copyLink" a11y-label="Copy link" class="w-[36] h-[36] rounded-lg bg-theme-surface border border-theme-outline items-center justify-center">
                    <icon name="doc.on.doc" :size="16" color="#00677d" dark-color="#67e8f9" />
                </column>
            </row>
        </column>

        {{-- Save button --}}
        <column @press="saveProfile" class="w-full bg-[#67bafd] dark:bg-[#1d4ed8] rounded-2xl py-4 items-center">
            <text class="text-[16] font-semibold text-[#004972] dark:text-white">{{ $saved ? 'Saved ✓' : 'Save Changes' }}</text>
        </column>

        {{-- Sign out --}}
        <column @press="signOut" class="w-full items-center pt-2">
            <text class="text-[12] text-theme-on-surface-variant">Sign out</text>
        </column>

    </column>
</scroll-view>
