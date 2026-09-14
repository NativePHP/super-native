@php use App\Icons\Android; use App\Icons\Ios; @endphp
@php
    $tints = [1 => '#6366F1', 2 => '#0891B2', 3 => '#DB2777'];
    $tint = $tints[$step];
    $next = $step + 1;
@endphp

<column class="w-full h-full bg-theme-background safe-area">

    {{-- STEP 1 — token small, top-left --}}
    @if ($step === 1)
        <column class="w-full p-6 gap-5">
            <row class="w-full items-center gap-4">
                <column ref="chain-token"
                        class="w-[56] h-[56] rounded-xl items-center justify-center bg-[{{ $tint }}]">
                    <text class="text-xl font-bold text-white">1</text>
                </column>
                <text class="flex-1 text-sm text-theme-on-surface-variant">
                    One token, tagged chain-token, on all three screens. It is re-paired at every
                    hop rather than living as one long view.
                </text>
            </row>

            <row @navigate.viewTransition('/hero/chain/2')
                 class="items-center justify-between p-4 bg-theme-surface rounded-2xl shadow">
                <text class="text-base font-semibold text-theme-on-surface">Hop to step 2</text>
                <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
            </row>
        </column>
    @endif

    {{-- STEP 2 — token medium, centred --}}
    @if ($step === 2)
        <column class="w-full flex-1 items-center justify-center gap-6 p-6">
            <column ref="chain-token"
                    class="w-[140] h-[140] rounded-3xl items-center justify-center bg-[{{ $tint }}]">
                <text class="text-6xl font-bold text-white">2</text>
            </column>
            <text class="text-sm text-theme-on-surface-variant text-center">
                It crossed from the top-left corner to the middle, and grew two and a half times.
                A fresh pairing — not a continuation of the first leg.
            </text>
            <row @navigate.viewTransition('/hero/chain/3')
                 class="items-center justify-between w-full p-4 bg-theme-surface rounded-2xl shadow">
                <text class="text-base font-semibold text-theme-on-surface">Hop to step 3</text>
                <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
            </row>
        </column>
    @endif

    {{-- STEP 3 — token wide, pinned to the bottom --}}
    @if ($step === 3)
        <column class="w-full flex-1 p-6 gap-5">
            <text class="text-sm text-theme-on-surface-variant">
                Last hop: the token stopped being a square altogether and stretched into a bar
                across the bottom. Walk back through with the button below and each leg reverses.
            </text>
            <column class="flex-1 w-full" />
            <column ref="chain-token"
                    class="w-full h-[110] rounded-2xl items-center justify-center bg-[{{ $tint }}]">
                <text class="text-5xl font-bold text-white">3</text>
            </column>
        </column>
    @endif

    @if ($step > 1)
        <row @navigate.back.viewTransition class="items-center gap-2 px-6 pb-10">
            <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="{{ $tint }}" />
            <text class="text-base font-semibold text-[{{ $tint }}]">Back one hop — in reverse</text>
        </row>
    @endif

</column>
