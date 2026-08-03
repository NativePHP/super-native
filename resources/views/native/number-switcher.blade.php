<native:scroll-view class="w-full bg-theme-background">
    <native:column class="w-full p-6 gap-6 items-center">

        {{-- Hero: the rolling number --}}
        <native:text class="text-sm text-theme-on-surface-variant">content-transition="numeric"</native:text>
        <native:text
            content-transition="numeric"
            animate-duration="400"
            class="text-7xl font-extrabold text-theme-on-background"
        >{{ number_format($value) }}</native:text>

        <native:row class="gap-3">
            <native:button label="−1" variant="outlined" @press="decrement" />
            <native:button label="+1" variant="outlined" @press="increment" />
            <native:button label="+111" variant="outlined" @press="jump" />
            <native:button label="Random" @press="randomize" />
        </native:row>

        <native:divider class="my-2" />

        {{-- Same value through each mode, side by side --}}
        <native:text class="text-base font-semibold text-theme-on-background">Side by side</native:text>
        <native:row class="w-full gap-4 justify-center">
            <native:column class="flex-1 items-center gap-1">
                <native:text
                    content-transition="numeric"
                    animate-duration="400"
                    class="text-3xl font-bold text-theme-on-background"
                >{{ $value }}</native:text>
                <native:text class="text-xs text-theme-on-surface-variant">numeric</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:text
                    content-transition="opacity"
                    animate-duration="400"
                    class="text-3xl font-bold text-theme-on-background"
                >{{ $value }}</native:text>
                <native:text class="text-xs text-theme-on-surface-variant">opacity</native:text>
            </native:column>
            <native:column class="flex-1 items-center gap-1">
                <native:text class="text-3xl font-bold text-theme-on-background">{{ $value }}</native:text>
                <native:text class="text-xs text-theme-on-surface-variant">none</native:text>
            </native:column>
        </native:row>

        <native:text class="text-xs text-theme-on-surface-variant text-center px-4">
            numeric rolls digits up as the value grows and down as it shrinks.
            iOS uses SwiftUI numericText; Android approximates with a
            directional slide + fade. opacity crossfades on both.
        </native:text>

    </native:column>
</native:scroll-view>
