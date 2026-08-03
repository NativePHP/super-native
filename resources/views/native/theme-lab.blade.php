@use('App\Icons\Ios')
@use('App\Icons\Android')

<stack class="w-full h-full bg-theme-background">
    <scroll-view class="w-full h-full" :showsIndicators="false">
        <column class="w-full px-5 py-5 gap-6">

            {{-- ── Hero ────────────────────────────────────────────── --}}
            <column class="w-full gap-2 rounded-2xl bg-theme-surface-variant p-5">
                <text font="display" class="text-[26] text-theme-shane">THEME LAB</text>
                <text font="grotesk" class="text-[15] leading-relaxed text-theme-on-surface-variant">
                    One config file drives every color, radius, and typeface on this screen.
                    Flip system dark mode right now — every token re-resolves live.
                </text>
            </column>

            {{-- ── Interactivity proof ─────────────────────────────── --}}
            <row class="w-full items-center rounded-xl border border-theme-outline-variant bg-theme-surface p-4">
                <text font="grotesk" class="text-[14] text-theme-on-surface-variant">Button presses recorded</text>
                <spacer/>
                <text font="display" class="text-[20] text-theme-primary">{{ $presses }}</text>
            </row>

            {{-- ── Theme token swatches ────────────────────────────── --}}
            <text font="grotesk-bold" class="text-[22] text-theme-on-background">Theme Tokens</text>
            <column class="w-full gap-3">
                @foreach ($this->swatchTokens() as $token => $label)
                    <row :native:key="'swatch-'.$token" class="w-full items-center rounded-xl bg-theme-{{ $token }} px-4 py-4 border border-theme-outline-variant">
                        <text font="grotesk-bold" class="text-[14] text-theme-on-{{ $token }}">{{ $label }}</text>
                        <spacer/>
                        <text font="grotesk" class="text-[11] text-theme-on-{{ $token }}">bg-theme-{{ $token }}</text>
                    </row>
                @endforeach
            </column>

            {{-- ── Outline vs outline-variant ──────────────────────── --}}
            <text font="grotesk-bold" class="text-[22] text-theme-on-background">Outline vs Outline-Variant</text>
            <row class="w-full gap-4">
                <column class="flex-1 items-center gap-2 rounded-xl border-2 border-theme-outline bg-theme-surface p-4">
                    <text font="grotesk-bold" class="text-[13] text-theme-on-surface">outline</text>
                    <text font="grotesk" class="text-[13] text-theme-on-surface-variant text-center">Field & card borders</text>
                </column>
                <column class="flex-1 items-center gap-2 rounded-xl border-2 border-theme-outline-variant bg-theme-surface p-4">
                    <text font="grotesk-bold" class="text-[13] text-theme-on-surface">outline-variant</text>
                    <text font="grotesk" class="text-[13] text-theme-on-surface-variant text-center">Hairline seams</text>
                </column>
            </row>

            {{-- ── Opacity modifiers on theme classes ──────────────── --}}
            <text font="grotesk-bold" class="text-[22] text-theme-on-background">Opacity Ramps</text>
            <column class="w-full gap-2">
                <row class="w-full gap-2">
                    @foreach ($this->opacitySteps() as $step)
                        <column :native:key="'op-primary-'.$step" class="flex-1 items-center rounded-lg bg-theme-primary/{{ $step }} py-4">
                            <text font="grotesk" class="text-[11] text-theme-on-background">/{{ $step }}</text>
                        </column>
                    @endforeach
                </row>
                <row class="w-full gap-2">
                    @foreach ($this->opacitySteps() as $step)
                        <column :native:key="'op-success-'.$step" class="flex-1 items-center rounded-lg bg-theme-success/{{ $step }} py-4">
                            <text font="grotesk" class="text-[11] text-theme-on-background">/{{ $step }}</text>
                        </column>
                    @endforeach
                </row>
                <text font="grotesk" class="text-[13] text-theme-on-surface-variant">
                    bg-theme-primary/N and bg-theme-success/N — tonal fills straight from the tokens,
                    dark companions included.
                </text>
            </column>

            {{-- ── Button variants (incl. success) ─────────────────── --}}
            <text font="grotesk-bold" class="text-[22] text-theme-on-background">Button Variants</text>
            <column class="w-full gap-3">
                @foreach ($this->buttonVariants() as $buttonVariant)
                    <native:button :native:key="'btn-'.$buttonVariant" variant="{{ $buttonVariant }}" @press="recordPress"
                                   a11y-label="Demo button: {{ $buttonVariant }}" class="w-full">
                        variant="{{ $buttonVariant }}"
                    </native:button>
                @endforeach
                <native:button variant="success" disabled a11y-label="Disabled success button" class="w-full">
                    success + disabled
                </native:button>
                <native:button variant="success" class="glass:prominent w-full" @press="recordPress"
                               a11y-label="Glass success button">
                    success + glass:prominent (iOS 26)
                </native:button>
            </column>

            {{-- ── Badge variants (incl. success) ──────────────────── --}}
            <text font="grotesk-bold" class="text-[22] text-theme-on-background">Badge Variants</text>
            <row class="w-full items-center gap-4 flex-wrap">
                @foreach ($this->badgeVariants() as $badgeVariant)
                    <column :native:key="'badge-'.$badgeVariant" class="items-center gap-2">
                        <native:badge variant="{{ $badgeVariant }}" label="{{ strtoupper($badgeVariant) }}"/>
                        <native:badge variant="{{ $badgeVariant }}" :count="7"/>
                    </column>
                @endforeach
            </row>

            {{-- ── Status pattern from the success token ───────────── --}}
            <text font="grotesk-bold" class="text-[22] text-theme-on-background">Status Patterns</text>
            <row class="w-full rounded-xl overflow-hidden border border-theme-outline-variant bg-theme-surface">
                <column class="w-2 self-stretch bg-theme-success"/>
                <column class="flex-1 p-4 gap-1">
                    <text font="grotesk-bold" class="text-[13] tracking-wide text-theme-on-surface-variant">ALL SYSTEMS GO</text>
                    <row class="items-center gap-2">
                        <icon :size="16" class="text-theme-success" :ios="Ios::CheckmarkSealFill" :android="Android::Verified"/>
                        <text font="grotesk" class="text-[15] text-theme-success">text-theme-success + status bar</text>
                    </row>
                </column>
                <column class="justify-center pr-4">
                    <row class="items-center px-3 py-2 rounded-lg bg-theme-success">
                        <text font="grotesk-bold" class="text-[12] text-theme-on-success">LIVE</text>
                    </row>
                </column>
            </row>

            {{-- ── Font aliases ────────────────────────────────────── --}}
            <text font="grotesk-bold" class="text-[22] text-theme-on-background">Font Aliases</text>
            <column class="w-full gap-4 rounded-xl border border-theme-outline-variant bg-theme-surface p-4 mb-4">
                @foreach ($this->fontSamples() as $alias => $sample)
                    <column :native:key="'font-'.$alias" class="w-full gap-1">
                        <text font="grotesk" class="text-[11] text-theme-on-surface-variant">font="{{ $alias }}"</text>
                        <text font="{{ $alias }}" class="text-[18] text-theme-on-surface">{{ $sample }}</text>
                    </column>
                @endforeach
                <text font="grotesk" class="text-[13] text-theme-on-surface-variant">
                    Semantic names from config/native-ui.php — swap a typeface app-wide with a one-line change.
                </text>
            </column>
        </column>
    </scroll-view>
</stack>
