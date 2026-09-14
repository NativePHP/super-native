@php use App\Icons\Android; use App\Icons\Ios; @endphp
<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-4">

        <text class="text-sm text-theme-on-surface-variant">
            Every row below pushes with viewTransition. They differ in how the destination is
            tagged. These are the cases where a shared element cannot resolve — worth seeing,
            because none of them should look broken.
        </text>

        {{-- CONTROL ─────────────────────────────────────────────── --}}
        <column @navigate.viewTransition('/hero/edges/matched')
                class="w-full gap-2 p-4 bg-theme-surface rounded-2xl shadow">
            <row class="items-center gap-3">
                <column ref="edge-hero"
                        class="w-[52] h-[52] rounded-xl items-center justify-center bg-[#0EA5E9]">
                    <icon :ios="Ios::CheckmarkSealFill" :android="Android::Verified" :size="24" color="#FFFFFF" />
                </column>
                <column class="flex-1 gap-0.5">
                    <text class="text-base font-semibold text-theme-on-surface">Matched — the control</text>
                    <text class="text-sm text-theme-on-surface-variant">Both sides tag edge-hero. It morphs.</text>
                </column>
            </row>
        </column>

        {{-- UNMATCHED ───────────────────────────────────────────── --}}
        <column @navigate.viewTransition('/hero/edges/unmatched')
                class="w-full gap-2 p-4 bg-theme-surface rounded-2xl shadow">
            <row class="items-center gap-3">
                <column ref="edge-orphan"
                        class="w-[52] h-[52] rounded-xl items-center justify-center bg-[#F59E0B]">
                    <icon :ios="Ios::QuestionmarkCircleFill" :android="Android::Help" :size="24" color="#FFFFFF" />
                </column>
                <column class="flex-1 gap-0.5">
                    <text class="text-base font-semibold text-theme-on-surface">Unmatched name</text>
                    <text class="text-sm text-theme-on-surface-variant">
                        Destination tags nothing. No partner, so it just cross-fades.
                    </text>
                </column>
            </row>
        </column>

        {{-- DUPLICATE ───────────────────────────────────────────── --}}
        <column @navigate.viewTransition('/hero/edges/duplicate')
                class="w-full gap-2 p-4 bg-theme-surface rounded-2xl shadow">
            <row class="items-center gap-3">
                <column ref="edge-dupe"
                        class="w-[52] h-[52] rounded-xl items-center justify-center bg-[#EC4899]">
                    <icon :ios="Ios::SquareOnSquare" :android="Android::FilterNone" :size="24" color="#FFFFFF" />
                </column>
                <column class="flex-1 gap-0.5">
                    <text class="text-base font-semibold text-theme-on-surface">Duplicated name</text>
                    <text class="text-sm text-theme-on-surface-variant">
                        Destination uses edge-dupe twice. One pairing wins; which is not contractual.
                    </text>
                </column>
            </row>
        </column>

        {{-- ASPECT CHANGE ───────────────────────────────────────── --}}
        <column @navigate.viewTransition('/hero/edges/resized')
                class="w-full gap-2 p-4 bg-theme-surface rounded-2xl shadow">
            <row class="items-center gap-3">
                <column ref="edge-shape"
                        class="w-[52] h-[52] rounded-xl items-center justify-center bg-[#8B5CF6]">
                    <icon :ios="Ios::AspectratioFill" :android="Android::AspectRatio" :size="24" color="#FFFFFF" />
                </column>
                <column class="flex-1 gap-0.5">
                    <text class="text-base font-semibold text-theme-on-surface">Extreme shape change</text>
                    <text class="text-sm text-theme-on-surface-variant">
                        Square thumbnail to a wide, short banner. Watch the aspect distort in flight.
                    </text>
                </column>
            </row>
        </column>

        {{-- OFF-SCREEN PARTNER ──────────────────────────────────── --}}
        <column @navigate.viewTransition('/hero/edges/offscreen')
                class="w-full gap-2 p-4 bg-theme-surface rounded-2xl shadow">
            <row class="items-center gap-3">
                <column ref="edge-deep"
                        class="w-[52] h-[52] rounded-xl items-center justify-center bg-[#14B8A6]">
                    <icon :ios="Ios::ArrowDownCircleFill" :android="Android::ArrowCircleDown" :size="24" color="#FFFFFF" />
                </column>
                <column class="flex-1 gap-0.5">
                    <text class="text-base font-semibold text-theme-on-surface">Partner below the fold</text>
                    <text class="text-sm text-theme-on-surface-variant">
                        The match sits far down a scroll view and has never been laid out.
                    </text>
                </column>
            </row>
        </column>

        <text class="text-xs text-theme-on-surface-variant pt-2">
            A name with no partner is inert by design — the element is simply left to the
            screen-level cross-fade rather than raising an error.
        </text>

    </column>
</scroll-view>
