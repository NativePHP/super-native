<scroll-view class="w-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        <text class="text-2xl font-semibold text-theme-on-background">Per-platform icons</text>
        <text class="text-theme-on-surface-variant">
            Each control names its icon per platform: SF Symbols on iOS, Material on
            Android. The same screen should look native on both. Taps: {{ $taps }}
        </text>

        {{-- Buttons: shared name, per-platform override, alias form, platform-only --}}
        <text class="text-xl font-semibold text-theme-on-background">Buttons — leading</text>
        <column class="gap-3">
            <button variant="primary" icon="star" @tap="tapped">Shared name (star)</button>
            <button variant="primary" icon="wave.3.right" android-icon="nfc" @tap="tapped">Override (wave.3.right / nfc)</button>
            <button variant="secondary" ios="house.fill" android="home" @tap="tapped">Alias form (:ios / :android)</button>
            <button variant="secondary" ios-icon="face.smiling" android-icon="mood" @tap="tapped">Platform-only, no shared icon</button>
        </column>

        {{-- Trailing slot has its own per-platform attributes --}}
        <text class="text-xl font-semibold mt-4 text-theme-on-background">Buttons — trailing</text>
        <column class="gap-3">
            <button variant="primary" icon-trailing="chevron.right" android-icon-trailing="arrow_forward" @tap="tapped">Continue</button>
            <button variant="ghost" icon="paperplane.fill" android-icon="send" ios-icon-trailing="arrow.up.right" android-icon-trailing="open_in_new" @tap="tapped">Both slots</button>
        </column>

        {{-- iOS height parity: tall/short SF Symbols and no-icon should all match --}}
        <text class="text-xl font-semibold mt-4 text-theme-on-background">Height parity (iOS fix)</text>
        <text class="text-theme-on-surface-variant">
            All four should be exactly the same height — the glyph no longer drives it.
        </text>
        <row class="gap-2">
            <button variant="secondary" size="sm" @tap="tapped">None</button>
            <button variant="secondary" size="sm" icon="wave.3.right" android-icon="nfc" @tap="tapped">Tall</button>
            <button variant="secondary" size="sm" icon="minus" android-icon="remove" @tap="tapped">Short</button>
            <button variant="secondary" size="sm" icon="circle.fill" android-icon="circle" @tap="tapped">Round</button>
        </row>

        {{-- Chips --}}
        <text class="text-xl font-semibold mt-4 text-theme-on-background">Chips</text>
        <row class="gap-2">
            <chip label="Wi-Fi" icon="wifi" native:model="wifiChip" />
            <chip label="NFC" icon="wave.3.right" android-icon="nfc" native:model="nfcChip" />
        </row>

        {{-- Tabs --}}
        <text class="text-xl font-semibold mt-4 text-theme-on-background">Tabs</text>
        <tab-row :selectedIndex="$selectedTab" @change="selectTab">
            <tab label="Home" ios-icon="house.fill" android-icon="home" />
            <tab label="Pay" ios-icon="wave.3.right" android-icon="nfc" />
            <tab label="Profile" ios="person.crop.circle" android="account_circle" />
        </tab-row>
        <text class="text-theme-on-surface-variant">Selected tab: {{ $selectedTab }}</text>

    </column>
</scroll-view>
