<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-6">

        {{-- ─────────────────────────────────────────────────────────────
             1. FAQ — native drives, PHP listens (@change)
             ───────────────────────────────────────────────────────────── --}}
        <column class="w-full gap-2">
            <text class="text-xs uppercase tracking-wider font-semibold text-theme-on-surface-variant px-1">
                Uncontrolled — @change reports back
            </text>
            <text class="text-xs text-theme-on-surface-variant px-1">
                The accordion owns its open state; PHP just hears about it.
                {{ $this->openCount() }} of {{ count($faqs) }} open · {{ $changeCount }} events
            </text>

            @foreach ($faqs as $faq)
                <accordion
                    :expanded="$open[$faq['id']]"
                    @change="setOpen('{{ $faq['id'] }}')"
                    class="w-full p-4 rounded-2xl bg-theme-surface"
                >
                    {{-- Android draws the header and its own chevron in a single
                         SpaceBetween Row without weighting the header slot, so a
                         width-filling child (a `<row>` defaults to STRETCH →
                         fillMaxWidth) pushes the chevron off. Harmless here —
                         the whole header row is tappable either way, and iOS
                         uses DisclosureGroup's own chevron regardless. --}}
                    <accordion-header>
                        <row class="items-center gap-3">
                            <icon
                                :name="$open[$faq['id']] ? 'checkmark.circle.fill' : 'questionmark.circle'"
                                :size="18"
                                :color="$open[$faq['id']] ? '#10B981' : '#94A3B8'"
                            />
                            <text class="text-base font-semibold text-theme-on-surface">
                                {{ $faq['question'] }}
                            </text>
                        </row>
                    </accordion-header>

                    <accordion-content>
                        <column class="pt-3 gap-2">
                            <divider />
                            <text class="text-sm leading-5 text-theme-on-surface-variant pt-1">
                                {{ $faq['answer'] }}
                            </text>
                        </column>
                    </accordion-content>
                </accordion>
            @endforeach
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             2. Server-driven — PHP owns the state via `expanded`
             ───────────────────────────────────────────────────────────── --}}
        <column class="w-full gap-2">
            <text class="text-xs uppercase tracking-wider font-semibold text-theme-on-surface-variant px-1">
                Controlled — PHP owns `expanded`
            </text>
            <text class="text-xs text-theme-on-surface-variant px-1">
                One open at a time, because the component's state lives here.
            </text>

            <row class="gap-2 pb-1">
                <button label="Expand all" variant="outlined" size="small" @press="expandAll" />
                <button label="Collapse all" variant="outlined" size="small" @press="collapseAll" />
            </row>

            @foreach ($sections as $section)
                @php($isOpen = $allExpanded || $exclusive === $section['id'])
                <accordion
                    :expanded="$isOpen"
                    @change="openOnly('{{ $section['id'] }}')"
                    class="w-full p-4 rounded-2xl bg-theme-surface"
                >
                    <accordion-header>
                        <row class="items-center gap-3">
                            <icon :name="$section['icon']" :size="18" color="#6366F1" />
                            <text class="text-base font-semibold text-theme-on-surface">
                                {{ $section['title'] }}
                            </text>
                            @if ($isOpen)
                                <badge label="open" />
                            @endif
                        </row>
                    </accordion-header>

                    <accordion-content>
                        <column class="pt-3 gap-1">
                            <divider />
                            @foreach ($section['lines'] as $line)
                                <text class="text-sm text-theme-on-surface-variant pt-1">• {{ $line }}</text>
                            @endforeach
                        </column>
                    </accordion-content>
                </accordion>
            @endforeach
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             3. Rich content — arbitrary children, not just text
             ───────────────────────────────────────────────────────────── --}}
        <column class="w-full gap-2">
            <text class="text-xs uppercase tracking-wider font-semibold text-theme-on-surface-variant px-1">
                Arbitrary content
            </text>

            <accordion expanded="true" class="w-full p-4 rounded-2xl bg-theme-surface">
                <accordion-header>
                    <column>
                        <text class="text-base font-semibold text-theme-on-surface">Trip to Lisbon</text>
                        <text class="text-xs text-theme-on-surface-variant">4 nights · Alfama</text>
                    </column>
                </accordion-header>

                <accordion-content>
                    <column class="pt-3 gap-3">
                        <image
                            src="https://picsum.photos/seed/lisbon/800/400"
                            class="w-full h-[160] rounded-xl"
                            :fit="2"
                        />
                        <row class="gap-2">
                            <chip label="Sea view" />
                            <chip label="Breakfast" />
                            <chip label="Wi-Fi" />
                        </row>
                        <row class="items-center gap-3">
                            <text class="flex-1 text-lg font-bold text-theme-on-surface">€620</text>
                            <button label="Book" size="small" @press="expandAll" />
                        </row>
                    </column>
                </accordion-content>
            </accordion>
        </column>

        <text class="text-xs text-theme-on-surface-variant text-center px-4 pb-6">
            mobile-ui PR #20 — iOS renders a SwiftUI DisclosureGroup,
            Android a clickable header row with a rotating chevron, so the
            chevron sits on opposite sides per platform.
        </text>

    </column>
</scroll-view>
