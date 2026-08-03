
<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full px-4 pt-6 pb-8 gap-6">

        <column class="w-full gap-2">
            <text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Variants</text>
            <column class="w-full bg-theme-surface rounded-xl">
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Primary</text>
                    <spacer />
                    <button variant="primary" size="sm" :disabled="$disabled" @tap="tap('primary')">Label</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Secondary</text>
                    <spacer />
                    <button variant="secondary" size="sm" :disabled="$disabled" @tap="tap('secondary')">Label</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Destructive</text>
                    <spacer />
                    <button variant="destructive" size="sm" :disabled="$disabled" @tap="tap('destructive')">Label</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Accent</text>
                    <spacer />
                    <button variant="accent" size="sm" :disabled="$disabled" @tap="tap('accent')">Label</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Ghost</text>
                    <spacer />
                    <button variant="ghost" size="sm" :disabled="$disabled" @tap="tap('ghost')">Label</button>
                </row>
            </column>
        </column>

        <column class="w-full gap-2">
            <text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Sizes</text>
            <column class="w-full bg-theme-surface rounded-xl">
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Small</text>
                    <spacer />
                    <button variant="primary" size="sm" :disabled="$disabled" @tap="tap('sm')">Label</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Medium</text>
                    <spacer />
                    <button variant="primary" size="md" :disabled="$disabled" @tap="tap('md')">Label</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Large</text>
                    <spacer />
                    <button variant="primary" size="lg" :disabled="$disabled" @tap="tap('lg')">Label</button>
                </row>
            </column>
        </column>

        <column class="w-full gap-2">
            <text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Extras</text>
            <column class="w-full bg-theme-surface rounded-xl">
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">With leading icon</text>
                    <spacer />
                    <button variant="primary" size="sm" icon="add" :disabled="$disabled" @tap="tap('with_icon')">Add</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">With trailing icon</text>
                    <spacer />
                    <button variant="secondary" size="sm" icon-trailing="arrow.right" :disabled="$disabled" @tap="tap('with_trailing')">Next</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Loading</text>
                    <spacer />
                    <button variant="primary" size="sm" loading :disabled="$disabled" @tap="tap('loading')">Saving</button>
                </row>
            </column>
        </column>

        @ios
        <column class="w-full gap-2">
            <text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Glass · buttons (iOS 26+)</text>
            <column class="w-full bg-theme-surface rounded-xl">
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">glass</text>
                    <spacer />
                    <button class="glass" size="sm" :disabled="$disabled" @tap="tap('glass')">Label</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">glass:prominent</text>
                    <spacer />
                    <button class="glass:prominent" variant="primary" size="sm" :disabled="$disabled" @tap="tap('glass_prominent')">Label</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">glass:prominent + destructive</text>
                    <spacer />
                    <button class="glass:prominent" variant="destructive" size="sm" :disabled="$disabled" @tap="tap('glass_destr')">Label</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">glass:prominent + accent</text>
                    <spacer />
                    <button class="glass:prominent" variant="accent" size="sm" :disabled="$disabled" @tap="tap('glass_accent')">Label</button>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">glass:prominent:interactive</text>
                    <spacer />
                    <button class="glass:prominent:interactive" variant="primary" size="sm" :disabled="$disabled" @tap="tap('glass_prominent_int')">Label</button>
                </row>
            </column>
        </column>

        <column class="w-full gap-2">
            <text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Glass · containers + text</text>
            <column class="w-full bg-theme-surface rounded-xl">
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Glass text (padded)</text>
                    <spacer />
                    <text class="px-3 py-2 rounded-full text-sm text-theme-on-surface glass">Action</text>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Pressable + interactive</text>
                    <spacer />
                    <pressable class="px-3 py-2 rounded-full glass:interactive" @tap="tap('pressable_glass')">
                        <text class="text-sm text-theme-on-surface">Tap me</text>
                    </pressable>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Glass · clear (text)</text>
                    <spacer />
                    <text class="px-3 py-2 rounded-full text-sm text-theme-on-surface glass:clear">Action</text>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Glass · clear:interactive (pressable)</text>
                    <spacer />
                    <pressable class="px-3 py-2 rounded-full glass:clear:interactive" @tap="tap('pressable_clear')">
                        <text class="text-sm text-theme-on-surface">Tap</text>
                    </pressable>
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Chip · glass</text>
                    <spacer />
                    <chip class="glass" label="Filter" :value="false" />
                </row>
                <divider class="mx-4" />
                <row class="w-full px-4 py-3 items-center">
                    <text class="text-base text-theme-on-surface">Chip · glass:clear</text>
                    <spacer />
                    <chip class="glass:clear" label="Filter" :value="false" />
                </row>
            </column>
        </column>

        <stack class="w-full h-full items-center justify-center">
            <scroll-view axis="both" class="w-full h-full rounded-lg shadow-lg">
                <image src="https://images.nationalgeographic.org/image/upload/v1638892520/EducationHub/photos/stream-in-colorado.jpg"
                              class="w-[2400] h-[1600]"/>
            </scroll-view>

            <column class="w-full h-full px-10">
                <text class="glass:clear:interactive px-4 text-center py-2 my-64 font-bold rounded-full text-2xl ">Liquid Glass Baby</text>
            </column>
        </stack>
        <column class="w-full gap-2">
            <text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Glass · cards</text>
            <column class="w-full p-5 gap-2 rounded-2xl glass:interactive">
                <text class="text-lg font-semibold text-theme-on-surface">Glass card · regular</text>
                <text class="text-sm text-theme-on-surface-variant">
                    Liquid Glass surface (iOS 26+) / `.regularMaterial` (older).
                    Built from a column — style your own surface with theme
                    tokens + the `glass:*` modifier classes.
                </text>
            </column>
            <column class="w-full p-5 gap-2 rounded-2xl glass:clear:interactive">
                <text class="text-lg font-semibold text-theme-on-surface">Glass card · clear</text>
                <text class="text-sm text-theme-on-surface-variant">
                    `.glassEffect(.clear)` (iOS 26+) / `.ultraThinMaterial` (older).
                    Reads transparent — best over a colorful or photographic backdrop.
                </text>
            </column>
            <column class="w-full p-5 gap-2 rounded-2xl glass:clear:interactive bg-red-300/50">
                <text class="text-lg font-semibold text-theme-on-surface">Glass card · tinted</text>
                <text class="text-sm text-theme-on-surface-variant">
                    `class="glass:clear bg-red-300/30"` — clear glass over a 30%
                    opacity red wash. Tailwind v3+ slash-opacity syntax. Backdrop
                    is still partially visible through the tint.
                </text>
            </column>
        </column>
        @endios
    </column>
</scroll-view>
