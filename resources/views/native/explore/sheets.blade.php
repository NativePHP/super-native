<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        {{-- Header --}}
        <column class="w-full gap-1">
            <text class="text-lg font-semibold text-theme-on-background">Bottom Sheets</text>
            <text class="text-sm text-theme-on-surface-variant">Tap to open. Swipe down or tap the backdrop to dismiss — `@tap="closeFoo"` keeps `$visible` in sync.</text>
        </column>

        {{-- Bottom-sheet trigger row --}}
        <row class="w-full gap-2">
            <column @tap="openSmallSheet" class="flex-1 px-4 py-3 rounded-xl bg-theme-primary items-center">
                <text class="text-theme-on-primary font-semibold">Small</text>
            </column>
            <column @tap="openMediumSheet" class="flex-1 px-4 py-3 rounded-xl bg-theme-primary items-center">
                <text class="text-theme-on-primary font-semibold">Medium</text>
            </column>
            <column @tap="openCustomSheet" class="flex-1 px-4 py-3 rounded-xl bg-theme-primary items-center">
                <text class="text-theme-on-primary font-semibold">40%</text>
            </column>
        </row>

        <column @tap="openActionSheet" class="w-full px-4 py-3 rounded-xl bg-theme-primary items-center">
            <text class="text-theme-on-primary font-semibold">Action sheet (edit / share / delete)</text>
        </column>

        <divider class="my-2" />

        {{-- Modals --}}
        <column class="w-full gap-1">
            <text class="text-lg font-semibold text-theme-on-background">Modals</text>
            <text class="text-sm text-theme-on-surface-variant">Full-screen overlay. `dismissible` controls whether tapping the backdrop fires `@dismiss`.</text>
        </column>

        <row class="w-full gap-2">
            <column @tap="openDismissibleModal" class="flex-1 px-4 py-3 rounded-xl bg-theme-secondary items-center">
                <text class="text-theme-on-secondary font-semibold">Dismissible</text>
            </column>
            <column @tap="openBlockingModal" class="flex-1 px-4 py-3 rounded-xl bg-theme-destructive items-center">
                <text class="text-theme-on-destructive font-semibold">Blocking</text>
            </column>
        </row>

        <divider class="my-2" />

        {{-- Last-action echo --}}
        <column class="w-full p-4 rounded-xl bg-theme-surface-variant gap-1">
            <text class="text-[11] font-semibold text-theme-on-surface-variant">LAST ACTION</text>
            <text class="text-base text-theme-on-surface">{{ $lastAction !== '' ? $lastAction : '—' }}</text>
        </column>

    </column>

    {{-- ── Bottom sheets ───────────────────────────────────────── --}}

    {{-- Small (≈25% of screen) --}}
    <bottom-sheet :visible="$showSmallSheet" @dismiss="closeSmallSheet" detents="small">
        <column class="w-full p-5 gap-3">
            <text class="text-xl font-bold text-theme-on-surface">Small sheet</text>
            <text class="text-sm text-theme-on-surface-variant">A short ~25%-tall sheet. Good for confirmations and single-prompt input.</text>
            <column @tap="closeSmallSheet" class="w-full px-4 py-3 rounded-xl bg-theme-primary items-center mt-2">
                <text class="text-theme-on-primary font-semibold">Close</text>
            </column>
        </column>
    </bottom-sheet>

    {{-- Medium / large (the default) --}}
    <bottom-sheet :visible="$showMediumSheet" @dismiss="closeMediumSheet" detents="medium,large">
        <column class="w-full p-5 gap-4">
            <text class="text-xl font-bold text-theme-on-surface">Medium sheet</text>
            <text class="text-sm text-theme-on-surface-variant">Drag the grabber up to expand to large. The default detents.</text>

            <outlined-text-input placeholder="Enter something" />

            <row class="w-full gap-2 mt-2">
                <column @tap="closeMediumSheet" class="flex-1 px-4 py-3 rounded-xl bg-theme-surface-variant items-center">
                    <text class="font-semibold text-theme-on-surface">Cancel</text>
                </column>
                <column @tap="closeMediumSheet" class="flex-1 px-4 py-3 rounded-xl bg-theme-primary items-center">
                    <text class="text-theme-on-primary font-semibold">Save</text>
                </column>
            </row>
        </column>
    </bottom-sheet>

    {{-- Custom 40% height --}}
    <bottom-sheet :visible="$showCustomSheet" @dismiss="closeCustomSheet" detents="0.4">
        <column class="w-full p-5 gap-3">
            <text class="text-xl font-bold text-theme-on-surface">Custom (40%)</text>
            <text class="text-sm text-theme-on-surface-variant">Numeric detent: `detents="0.4"` for a sheet that occupies 40% of the screen. Fixed (not draggable to other heights).</text>
            <column @tap="closeCustomSheet" class="w-full px-4 py-3 rounded-xl bg-theme-primary items-center mt-2">
                <text class="text-theme-on-primary font-semibold">Close</text>
            </column>
        </column>
    </bottom-sheet>

    {{-- Action sheet (small detent + a stacked list of pressables) --}}
    <bottom-sheet :visible="$showActionSheet" @dismiss="closeActionSheet" detents="small">
        <column class="w-full pb-4">
            <column @tap="actionEdit" class="w-full px-5 py-4">
                <row class="items-center gap-3">
                    <icon name="edit" :size="22" color="#475569" dark-color="#CBD5E1" />
                    <text class="text-base text-theme-on-surface">Edit</text>
                </row>
            </column>
            <divider />
            <column @tap="actionShare" class="w-full px-5 py-4">
                <row class="items-center gap-3">
                    <icon name="share" :size="22" color="#475569" dark-color="#CBD5E1" />
                    <text class="text-base text-theme-on-surface">Share</text>
                </row>
            </column>
            <divider />
            <column @tap="actionDelete" class="w-full px-5 py-4">
                <row class="items-center gap-3">
                    <icon name="delete" :size="22" color="#EF4444" />
                    <text class="text-base text-theme-destructive">Delete</text>
                </row>
            </column>
        </column>
    </bottom-sheet>

    {{-- ── Modals ──────────────────────────────────────────────── --}}

    {{-- Dismissible: tap-backdrop / swipe fires @dismiss --}}
    <modal :visible="$showDismissibleModal" :dismissible="true" @dismiss="closeDismissibleModal">
        <column class="w-full p-6 gap-4 bg-theme-surface rounded-3xl">
            <text class="text-xl font-bold text-theme-on-surface">Dismissible modal</text>
            <text class="text-sm text-theme-on-surface-variant">Tap the backdrop or swipe to close. The framework fires `@dismiss` for you to flip `visible` back to false.</text>
            <column @tap="closeDismissibleModal" class="w-full px-4 py-3 rounded-xl bg-theme-secondary items-center mt-2">
                <text class="text-theme-on-secondary font-semibold">OK</text>
            </column>
        </column>
    </modal>

    {{-- Blocking: dismissible=false; user must hit confirm or cancel --}}
    <modal :visible="$showBlockingModal" :dismissible="false">
        <column class="w-full p-6 gap-4 bg-theme-surface rounded-3xl">
            <text class="text-xl font-bold text-theme-on-surface">Confirm action?</text>
            <text class="text-sm text-theme-on-surface-variant">This is a blocking modal — `dismissible="false"`. The backdrop is inert; you have to choose Confirm or Cancel.</text>
            <row class="w-full gap-2 mt-2">
                <column @tap="cancelBlockingModal" class="flex-1 px-4 py-3 rounded-xl bg-theme-surface-variant items-center">
                    <text class="font-semibold text-theme-on-surface">Cancel</text>
                </column>
                <column @tap="confirmBlockingModal" class="flex-1 px-4 py-3 rounded-xl bg-theme-destructive items-center">
                    <text class="text-theme-on-destructive font-semibold">Confirm</text>
                </column>
            </row>
        </column>
    </modal>

</scroll-view>
