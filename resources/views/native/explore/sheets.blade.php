<native:scroll-view class="w-full h-full bg-theme-background">
    <native:column class="w-full p-5 gap-5">

        {{-- Header --}}
        <native:column class="w-full gap-1">
            <native:text class="text-lg font-semibold text-theme-on-background">Bottom Sheets</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">Tap to open. Swipe down or tap the backdrop to dismiss — `@press="closeFoo"` keeps `$visible` in sync.</native:text>
        </native:column>

        {{-- Bottom-sheet trigger row --}}
        <native:row class="w-full gap-2">
            <native:column @press="openSmallSheet" class="flex-1 px-4 py-3 rounded-xl bg-[#0EA5E9] items-center">
                <native:text class="text-white font-semibold">Small</native:text>
            </native:column>
            <native:column @press="openMediumSheet" class="flex-1 px-4 py-3 rounded-xl bg-[#0EA5E9] items-center">
                <native:text class="text-white font-semibold">Medium</native:text>
            </native:column>
            <native:column @press="openCustomSheet" class="flex-1 px-4 py-3 rounded-xl bg-[#0EA5E9] items-center">
                <native:text class="text-white font-semibold">40%</native:text>
            </native:column>
        </native:row>

        <native:column @press="openActionSheet" class="w-full px-4 py-3 rounded-xl bg-[#0EA5E9] items-center">
            <native:text class="text-white font-semibold">Action sheet (edit / share / delete)</native:text>
        </native:column>

        <native:divider class="my-2" />

        {{-- Modals --}}
        <native:column class="w-full gap-1">
            <native:text class="text-lg font-semibold text-theme-on-background">Modals</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">Full-screen overlay. `dismissible` controls whether tapping the backdrop fires `@dismiss`.</native:text>
        </native:column>

        <native:row class="w-full gap-2">
            <native:column @press="openDismissibleModal" class="flex-1 px-4 py-3 rounded-xl bg-[#A855F7] items-center">
                <native:text class="text-white font-semibold">Dismissible</native:text>
            </native:column>
            <native:column @press="openBlockingModal" class="flex-1 px-4 py-3 rounded-xl bg-[#EF4444] items-center">
                <native:text class="text-white font-semibold">Blocking</native:text>
            </native:column>
        </native:row>

        <native:divider class="my-2" />

        {{-- Last-action echo --}}
        <native:column class="w-full p-4 rounded-xl bg-theme-surface-variant gap-1">
            <native:text class="text-[11] font-semibold text-theme-on-surface-variant">LAST ACTION</native:text>
            <native:text class="text-base text-theme-on-surface">{{ $lastAction !== '' ? $lastAction : '—' }}</native:text>
        </native:column>

    </native:column>

    {{-- ── Bottom sheets ───────────────────────────────────────── --}}

    {{-- Small (≈25% of screen) --}}
    <native:bottom-sheet :visible="$showSmallSheet" @dismiss="closeSmallSheet" detents="small">
        <native:column class="w-full p-5 gap-3">
            <native:text class="text-xl font-bold text-theme-on-surface">Small sheet</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">A short ~25%-tall sheet. Good for confirmations and single-prompt input.</native:text>
            <native:column @press="closeSmallSheet" class="w-full px-4 py-3 rounded-xl bg-[#0EA5E9] items-center mt-2">
                <native:text class="text-white font-semibold">Close</native:text>
            </native:column>
        </native:column>
    </native:bottom-sheet>

    {{-- Medium / large (the default) --}}
    <native:bottom-sheet :visible="$showMediumSheet" @dismiss="closeMediumSheet" detents="medium,large">
        <native:column class="w-full p-5 gap-4">
            <native:text class="text-xl font-bold text-theme-on-surface">Medium sheet</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">Drag the grabber up to expand to large. The default detents.</native:text>

            <native:outlined-text-input placeholder="Enter something" />

            <native:row class="w-full gap-2 mt-2">
                <native:column @press="closeMediumSheet" class="flex-1 px-4 py-3 rounded-xl bg-theme-surface-variant items-center">
                    <native:text class="font-semibold text-theme-on-surface">Cancel</native:text>
                </native:column>
                <native:column @press="closeMediumSheet" class="flex-1 px-4 py-3 rounded-xl bg-[#0EA5E9] items-center">
                    <native:text class="text-white font-semibold">Save</native:text>
                </native:column>
            </native:row>
        </native:column>
    </native:bottom-sheet>

    {{-- Custom 40% height --}}
    <native:bottom-sheet :visible="$showCustomSheet" @dismiss="closeCustomSheet" detents="0.4">
        <native:column class="w-full p-5 gap-3">
            <native:text class="text-xl font-bold text-theme-on-surface">Custom (40%)</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">Numeric detent: `detents="0.4"` for a sheet that occupies 40% of the screen. Fixed (not draggable to other heights).</native:text>
            <native:column @press="closeCustomSheet" class="w-full px-4 py-3 rounded-xl bg-[#0EA5E9] items-center mt-2">
                <native:text class="text-white font-semibold">Close</native:text>
            </native:column>
        </native:column>
    </native:bottom-sheet>

    {{-- Action sheet (small detent + a stacked list of pressables) --}}
    <native:bottom-sheet :visible="$showActionSheet" @dismiss="closeActionSheet" detents="small">
        <native:column class="w-full pb-4">
            <native:column @press="actionEdit" class="w-full px-5 py-4">
                <native:row class="items-center gap-3">
                    <native:icon name="edit" :size="22" color="#475569" dark-color="#CBD5E1" />
                    <native:text class="text-base text-theme-on-surface">Edit</native:text>
                </native:row>
            </native:column>
            <native:divider />
            <native:column @press="actionShare" class="w-full px-5 py-4">
                <native:row class="items-center gap-3">
                    <native:icon name="share" :size="22" color="#475569" dark-color="#CBD5E1" />
                    <native:text class="text-base text-theme-on-surface">Share</native:text>
                </native:row>
            </native:column>
            <native:divider />
            <native:column @press="actionDelete" class="w-full px-5 py-4">
                <native:row class="items-center gap-3">
                    <native:icon name="delete" :size="22" color="#EF4444" />
                    <native:text class="text-base text-[#EF4444]">Delete</native:text>
                </native:row>
            </native:column>
        </native:column>
    </native:bottom-sheet>

    {{-- ── Modals ──────────────────────────────────────────────── --}}

    {{-- Dismissible: tap-backdrop / swipe fires @dismiss --}}
    <native:modal :visible="$showDismissibleModal" :dismissible="true" @dismiss="closeDismissibleModal">
        <native:column class="w-full p-6 gap-4 bg-theme-surface rounded-3xl">
            <native:text class="text-xl font-bold text-theme-on-surface">Dismissible modal</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">Tap the backdrop or swipe to close. The framework fires `@dismiss` for you to flip `visible` back to false.</native:text>
            <native:column @press="closeDismissibleModal" class="w-full px-4 py-3 rounded-xl bg-[#A855F7] items-center mt-2">
                <native:text class="text-white font-semibold">OK</native:text>
            </native:column>
        </native:column>
    </native:modal>

    {{-- Blocking: dismissible=false; user must hit confirm or cancel --}}
    <native:modal :visible="$showBlockingModal" :dismissible="false">
        <native:column class="w-full p-6 gap-4 bg-theme-surface rounded-3xl">
            <native:text class="text-xl font-bold text-theme-on-surface">Confirm action?</native:text>
            <native:text class="text-sm text-theme-on-surface-variant">This is a blocking modal — `dismissible="false"`. The backdrop is inert; you have to choose Confirm or Cancel.</native:text>
            <native:row class="w-full gap-2 mt-2">
                <native:column @press="cancelBlockingModal" class="flex-1 px-4 py-3 rounded-xl bg-theme-surface-variant items-center">
                    <native:text class="font-semibold text-theme-on-surface">Cancel</native:text>
                </native:column>
                <native:column @press="confirmBlockingModal" class="flex-1 px-4 py-3 rounded-xl bg-[#EF4444] items-center">
                    <native:text class="text-white font-semibold">Confirm</native:text>
                </native:column>
            </native:row>
        </native:column>
    </native:modal>

</native:scroll-view>
