{{-- Theme-token-driven so the page auto-flips in dark mode:
       bg-theme-background   page root
       bg-theme-surface      cards
       text-theme-on-surface         row labels
       text-theme-on-surface-variant section headers
--}}
<native:scroll-view class="w-full h-full bg-theme-background">
    <native:column class="w-full px-4 pt-2 pb-8 gap-6">

        <native:column class="w-full bg-theme-surface rounded-xl">
            <native:row class="w-full px-4 py-3 items-center">
                <native:text class="text-base text-theme-on-surface">Disable buttons</native:text>
                <native:spacer />
                <native:toggle native:model="disabled" />
            </native:row>
        </native:column>

        <native:column class="w-full gap-2">
            <native:text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Variants</native:text>
            <native:column class="w-full bg-theme-surface rounded-xl">
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Primary</native:text>
                    <native:spacer />
                    <native:button variant="primary" size="sm" :disabled="$disabled" @press="tap('primary')">Label</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Secondary</native:text>
                    <native:spacer />
                    <native:button variant="secondary" size="sm" :disabled="$disabled" @press="tap('secondary')">Label</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Destructive</native:text>
                    <native:spacer />
                    <native:button variant="destructive" size="sm" :disabled="$disabled" @press="tap('destructive')">Label</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Accent</native:text>
                    <native:spacer />
                    <native:button variant="accent" size="sm" :disabled="$disabled" @press="tap('accent')">Label</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Ghost</native:text>
                    <native:spacer />
                    <native:button variant="ghost" size="sm" :disabled="$disabled" @press="tap('ghost')">Label</native:button>
                </native:row>
            </native:column>
        </native:column>

        <native:column class="w-full gap-2">
            <native:text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Sizes</native:text>
            <native:column class="w-full bg-theme-surface rounded-xl">
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Small</native:text>
                    <native:spacer />
                    <native:button variant="primary" size="sm" :disabled="$disabled" @press="tap('sm')">Label</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Medium</native:text>
                    <native:spacer />
                    <native:button variant="primary" size="md" :disabled="$disabled" @press="tap('md')">Label</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Large</native:text>
                    <native:spacer />
                    <native:button variant="primary" size="lg" :disabled="$disabled" @press="tap('lg')">Label</native:button>
                </native:row>
            </native:column>
        </native:column>

        <native:column class="w-full gap-2">
            <native:text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Extras</native:text>
            <native:column class="w-full bg-theme-surface rounded-xl">
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">With leading icon</native:text>
                    <native:spacer />
                    <native:button variant="primary" size="sm" icon="add" :disabled="$disabled" @press="tap('with_icon')">Add</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">With trailing icon</native:text>
                    <native:spacer />
                    <native:button variant="secondary" size="sm" icon-trailing="arrow.right" :disabled="$disabled" @press="tap('with_trailing')">Next</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Loading</native:text>
                    <native:spacer />
                    <native:button variant="primary" size="sm" loading :disabled="$disabled" @press="tap('loading')">Saving</native:button>
                </native:row>
            </native:column>
        </native:column>

        {{-- Glass section now spans Button + Text + Pressable + Card + Chip
             so we can verify the new bitflag grammar lands consistently
             across the renderer matrix. iOS 26+ shows real Liquid Glass;
             older iOS falls back to .regularMaterial / bordered styles. --}}
        <native:column class="w-full gap-2">
            <native:text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Glass · buttons (iOS 26+)</native:text>
            <native:column class="w-full bg-theme-surface rounded-xl">
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">glass</native:text>
                    <native:spacer />
                    <native:button class="glass" size="sm" :disabled="$disabled" @press="tap('glass')">Label</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">glass:prominent</native:text>
                    <native:spacer />
                    <native:button class="glass:prominent" variant="primary" size="sm" :disabled="$disabled" @press="tap('glass_prominent')">Label</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">glass:prominent + destructive</native:text>
                    <native:spacer />
                    <native:button class="glass:prominent" variant="destructive" size="sm" :disabled="$disabled" @press="tap('glass_destr')">Label</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">glass:prominent + accent</native:text>
                    <native:spacer />
                    <native:button class="glass:prominent" variant="accent" size="sm" :disabled="$disabled" @press="tap('glass_accent')">Label</native:button>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">glass:prominent:interactive</native:text>
                    <native:spacer />
                    <native:button class="glass:prominent:interactive" variant="primary" size="sm" :disabled="$disabled" @press="tap('glass_prominent_int')">Label</native:button>
                </native:row>
            </native:column>
        </native:column>

        <native:column class="w-full gap-2">
            <native:text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Glass · containers + text</native:text>
            <native:column class="w-full bg-theme-surface rounded-xl">
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Glass text (padded)</native:text>
                    <native:spacer />
                    <native:text class="px-3 py-2 rounded-full text-sm text-theme-on-surface glass">Action</native:text>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Pressable + interactive</native:text>
                    <native:spacer />
                    <native:pressable class="px-3 py-2 rounded-full glass:interactive" @press="tap('pressable_glass')">
                        <native:text class="text-sm text-theme-on-surface">Tap me</native:text>
                    </native:pressable>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Glass · clear (text)</native:text>
                    <native:spacer />
                    <native:text class="px-3 py-2 rounded-full text-sm text-theme-on-surface glass:clear">Action</native:text>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Glass · clear:interactive (pressable)</native:text>
                    <native:spacer />
                    <native:pressable class="px-3 py-2 rounded-full glass:clear:interactive" @press="tap('pressable_clear')">
                        <native:text class="text-sm text-theme-on-surface">Tap</native:text>
                    </native:pressable>
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Chip · glass</native:text>
                    <native:spacer />
                    <native:chip class="glass" label="Filter" :value="false" />
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Chip · glass:clear</native:text>
                    <native:spacer />
                    <native:chip class="glass:clear" label="Filter" :value="false" />
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Badge · glass</native:text>
                    <native:spacer />
                    <native:badge class="glass" label="NEW" variant="accent" />
                </native:row>
                <native:divider class="ml-4" />
                <native:row class="w-full px-4 py-3 items-center">
                    <native:text class="text-base text-theme-on-surface">Badge · glass:clear</native:text>
                    <native:spacer />
                    <native:badge class="glass:clear" label="NEW" variant="accent" />
                </native:row>
            </native:column>
        </native:column>

        <native:column class="w-full gap-2">
            <native:text class="text-xs uppercase font-semibold text-theme-on-surface-variant px-4">Glass · cards</native:text>
            <native:card class="glass">
                <native:column class="w-full p-5 gap-2">
                    <native:text class="text-lg font-semibold text-theme-on-surface">Glass card · regular</native:text>
                    <native:text class="text-sm text-theme-on-surface-variant">
                        Liquid Glass surface (iOS 26+) / `.regularMaterial` (older).
                        The card variant ("filled" / "outlined" / "elevated") is
                        overridden when `class="glass"` is set.
                    </native:text>
                </native:column>
            </native:card>
            <native:card class="glass:clear">
                <native:column class="w-full p-5 gap-2">
                    <native:text class="text-lg font-semibold text-theme-on-surface">Glass card · clear</native:text>
                    <native:text class="text-sm text-theme-on-surface-variant">
                        `.glassEffect(.clear)` (iOS 26+) / `.ultraThinMaterial` (older).
                        Reads transparent — best over a colorful or photographic backdrop.
                    </native:text>
                </native:column>
            </native:card>
            <native:card class="glass:clear bg-red-300/30">
                <native:column class="w-full p-5 gap-2">
                    <native:text class="text-lg font-semibold text-theme-on-surface">Glass card · tinted</native:text>
                    <native:text class="text-sm text-theme-on-surface-variant">
                        `class="glass:clear bg-red-300/30"` — clear glass over a 30%
                        opacity red wash. Tailwind v3+ slash-opacity syntax. Backdrop
                        is still partially visible through the tint.
                    </native:text>
                </native:column>
            </native:card>
        </native:column>

        @if ($taps > 0)
            <native:column class="w-full px-4 pt-2 gap-1">
                <native:text class="text-xs uppercase font-semibold text-theme-on-surface-variant">Last tap</native:text>
                <native:text class="text-sm text-theme-on-surface">{{ $lastTapped }} · {{ $taps }} {{ $taps === 1 ? 'tap' : 'taps' }} total</native:text>
            </native:column>
        @endif

    </native:column>
</native:scroll-view>
