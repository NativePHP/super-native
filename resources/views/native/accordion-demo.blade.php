<scroll-view class="w-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        <text class="text-2xl font-semibold text-theme-on-background">Accordion</text>
        <text class="text-theme-on-surface-variant">
            DisclosureGroup on iOS, animated expand/collapse on Android.
            Changes: {{ $changes }}
        </text>

        {{-- Each section reports through one handler; the key is a literal
             arg, the new expanded state is appended by the event. --}}
        <column class="gap-3">
            <accordion :expanded="$open['shipping']" @change="toggled('shipping')" class="bg-theme-surface-variant rounded-xl p-4">
                <accordion-header>
                    <text class="text-lg font-semibold text-theme-on-surface-variant">Shipping</text>
                </accordion-header>
                <accordion-content>
                    <text class="text-theme-on-surface-variant pt-2">
                        Orders ship within 2 business days. Tracking arrives by email
                        as soon as the label is printed.
                    </text>
                </accordion-content>
            </accordion>

            <accordion :expanded="$open['returns']" @change="toggled('returns')" class="bg-theme-surface-variant rounded-xl p-4">
                <accordion-header>
                    <text class="text-lg font-semibold text-theme-on-surface-variant">Returns</text>
                </accordion-header>
                <accordion-content>
                    <text class="text-theme-on-surface-variant pt-2">
                        30 days, no questions asked. Start a return from your order
                        history and we cover the postage.
                    </text>
                </accordion-content>
            </accordion>

            <accordion :expanded="$open['warranty']" @change="toggled('warranty')" class="bg-theme-surface-variant rounded-xl p-4">
                <accordion-header>
                    <row class="items-center gap-2">
                        <native:icon ios="checkmark.seal" android="verified" :size="20" class="text-theme-primary" a11y-label="Warranty" />
                        <text class="text-lg font-semibold text-theme-on-surface-variant">Warranty</text>
                    </row>
                </accordion-header>
                <accordion-content>
                    <text class="text-theme-on-surface-variant pt-2">
                        Two years on manufacturing defects. Headers take arbitrary
                        children — this one carries an icon.
                    </text>
                </accordion-content>
            </accordion>
        </column>

        {{-- Server-side pushes of the expanded binding --}}
        <row class="gap-2 mt-2">
            <button variant="secondary" size="sm" @tap="expandAll">Expand all</button>
            <button variant="ghost" size="sm" @tap="collapseAll">Collapse all</button>
        </row>

    </column>
</scroll-view>
