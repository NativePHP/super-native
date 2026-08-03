@php
    // Outline colour for the container being measured, and for the anchored child.
    $box = $showBounds ? 'border border-red-500' : '';
    $chip = $showBounds ? 'border border-blue-500' : '';
@endphp

<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-8">

        <column class="gap-1">
            <text class="text-2xl font-bold">Stack &amp; Positioning</text>
            <text class="text-sm opacity-60">
                Red outline = the container's measured box. Blue = the anchored child.
                Compare iOS and Android side by side — sections marked ⚠️ are expected to differ today.
            </text>
            <button variant="secondary" size="sm" @tap="toggleBounds">
                {{ $showBounds ? 'Hide outlines' : 'Show outlines' }}
            </button>
        </column>

        @if($show === [] || in_array(1, $show, true))
        {{-- ─────────────────────────────────────────────────────────────
             1. Stack sizing — does a bare stack wrap its largest child?
             This is the headline claim: "the stack sizes to its largest
             child (ZStack/wrap-content), so no explicit size is needed."

             iOS `sizeThatFits` does `width: proposal.width ?? maxWidth`.
             A column parent proposes (width: crossAvail, height: nil), so
             width is FINITE and the union is discarded → the stack fills
             the column's width. Height has a nil proposal, so it wraps.
             Android's Box carries no size modifier in WRAP mode → wraps
             on BOTH axes.

             Expected on device: the red outline hugs the text on Android
             and spans the full width on iOS.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">1. Stack sizing — wrap vs fill ⚠️</text>
            <text class="text-sm opacity-60">
                A bare stack with one child. If wrap-content holds, the red box hugs the text.
            </text>

            <stack class="{{ $box }}">
                <text class="text-xl font-bold">Pinkary</text>
            </stack>

            <text class="text-sm opacity-60 pt-2">
                The README example — a dot anchored to the wordmark's top-right corner,
                drawing half outside it. If the stack fills instead of wrapping, the dot
                lands at the far right of the screen rather than on the letter "y".
            </text>

            <stack class="{{ $box }}">
                <text class="text-xl font-bold">Pinkary</text>
                <column anchor="top-right" class="w-[14] h-[14] rounded-full bg-red-500 {{ $chip }}" />
            </stack>

            <text class="text-sm opacity-60 pt-2">Same stack, but given an explicit size — should fill regardless.</text>

            <stack class="w-[200] h-[60] {{ $box }}">
                <text class="text-xl font-bold">Pinkary</text>
                <column anchor="top-right" class="w-[14] h-[14] rounded-full bg-red-500 {{ $chip }}" />
            </stack>
        </column>

        @endif

        @if($show === [] || in_array(2, $show, true))
        {{-- ─────────────────────────────────────────────────────────────
             2. Attribute ↔ class parity. All three rows must be identical.
             NOTE: the short attribute spellings are read by
             buildLayoutArray(), which only runs for the six builtin
             streaming types (column/row/stack/scroll_view/pressable/canvas).
             The <text> row below therefore does NOT position — it's here
             deliberately to show the gap.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">2. Attribute ↔ class parity</text>
            <text class="text-sm opacity-60">Three spellings of the same thing — the blue chips must land identically.</text>

            <row class="gap-3">
                <column class="w-[96] h-[64] relative {{ $box }}">
                    <column class="absolute top-0 right-0 w-[20] h-[20] bg-blue-500 {{ $chip }}" />
                </column>
                <column class="w-[96] h-[64] relative {{ $box }}">
                    <column absolute top="0" right="0" class="w-[20] h-[20] bg-blue-500 {{ $chip }}" />
                </column>
                <column class="w-[96] h-[64] relative {{ $box }}">
                    <column position="absolute" :top="0" :right="0" class="w-[20] h-[20] bg-blue-500 {{ $chip }}" />
                </column>
            </row>
            <row class="gap-3">
                <text class="text-xs opacity-60 w-[96]">class="absolute top-0 right-0"</text>
                <text class="text-xs opacity-60 w-[96]">absolute top="0" right="0"</text>
                <text class="text-xs opacity-60 w-[96]">position="absolute" :top :right</text>
            </row>

            <text class="text-sm opacity-60 pt-2">
                ⚠️ Same short attributes on a non-container element. `applyLayout()` (the Element
                path) never learned them, so this one does NOT move — it should sit top-left.
            </text>
            <column class="w-[200] h-[64] relative {{ $box }}">
                <text absolute top="0" right="0" class="text-xs bg-amber-400 px-1">text absolute</text>
            </column>
        </column>

        @endif

        @if($show === [] || in_array(3, $show, true))
        {{-- ─────────────────────────────────────────────────────────────
             3. All nine anchors, origin defaulting to center.
             The child's CENTRE lands on the parent's anchor point, so
             every chip draws half outside the box. That's intended.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">3. Nine anchors (origin = center)</text>
            <text class="text-sm opacity-60">
                Child centre pinned to the parent point, so each chip straddles the edge.
            </text>

            @foreach($this->pointRows() as $rowIndex => $row)
                <row :native:key="'anchor-row-'.$rowIndex" class="gap-3 py-2">
                    @foreach($row as $point)
                        <column :native:key="'anchor-'.$point['name']" class="gap-1">
                            <stack class="w-[96] h-[56] {{ $box }}">
                                <column :anchor="$point['name']" class="w-[18] h-[18] rounded-full bg-blue-500 {{ $chip }}" />
                            </stack>
                            <text class="text-xs opacity-60">{{ $point['name'] }} ({{ $point['enum'] }})</text>
                        </column>
                    @endforeach
                </row>
            @endforeach
        </column>

        @endif

        @if($show === [] || in_array(4, $show, true))
        {{-- ─────────────────────────────────────────────────────────────
             4. All nine origins with the anchor pinned to center. The chip
             pivots around the parent's centre point.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">4. Nine origins (anchor = center)</text>
            <text class="text-sm opacity-60">
                Which point ON THE CHILD lands on the parent's centre. origin="top-left"
                pushes the chip down-right; origin="bottom-right" pushes it up-left.
            </text>

            @foreach($this->pointRows() as $rowIndex => $row)
                <row :native:key="'origin-row-'.$rowIndex" class="gap-3 py-2">
                    @foreach($row as $point)
                        <column :native:key="'origin-'.$point['name']" class="gap-1">
                            <stack class="w-[96] h-[56] {{ $box }}">
                                <column anchor="center" :origin="$point['name']" class="w-[24] h-[24] bg-emerald-500 {{ $chip }}" />
                            </stack>
                            <text class="text-xs opacity-60">{{ $point['name'] }}</text>
                        </column>
                    @endforeach
                </row>
            @endforeach
        </column>

        @endif

        @if($show === [] || in_array(5, $show, true))
        {{-- ─────────────────────────────────────────────────────────────
             5. The two-point combos that motivate the feature — a badge
             hooked onto a corner three different ways.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">5. Two-point badge combos</text>
            <text class="text-sm opacity-60">Same anchor (top-right), three different origins.</text>

            <row class="gap-4 py-3">
                <column class="gap-1">
                    <stack class="w-[80] h-[56] {{ $box }}">
                        <column anchor="top-right" origin="top-right" class="w-[22] h-[22] rounded-full bg-purple-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">origin=top-right</text>
                    <text class="text-xs opacity-40">fully inside</text>
                </column>
                <column class="gap-1">
                    <stack class="w-[80] h-[56] {{ $box }}">
                        <column anchor="top-right" origin="center" class="w-[22] h-[22] rounded-full bg-purple-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">origin=center</text>
                    <text class="text-xs opacity-40">half outside (default)</text>
                </column>
                <column class="gap-1">
                    <stack class="w-[80] h-[56] {{ $box }}">
                        <column anchor="top-right" origin="bottom-left" class="w-[22] h-[22] rounded-full bg-purple-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">origin=bottom-left</text>
                    <text class="text-xs opacity-40">fully outside</text>
                </column>
            </row>
        </column>

        @endif

        @if($show === [] || in_array(6, $show, true))
        {{-- ─────────────────────────────────────────────────────────────
             6. Utility-class form must equal the attribute form.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">6. anchor-* / origin-* classes</text>
            <text class="text-sm opacity-60">Class form vs attribute form — these two must be identical.</text>

            <row class="gap-3">
                <column class="gap-1">
                    <stack class="w-[96] h-[56] {{ $box }}">
                        <column class="anchor-bottom-right origin-bottom-right w-[20] h-[20] bg-orange-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">classes</text>
                </column>
                <column class="gap-1">
                    <stack class="w-[96] h-[56] {{ $box }}">
                        <column anchor="bottom-right" origin="bottom-right" class="w-[20] h-[20] bg-orange-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">attributes</text>
                </column>
                <column class="gap-1">
                    <stack class="w-[96] h-[56] {{ $box }}">
                        <column origin="top-left" class="anchor-top-left w-[20] h-[20] bg-orange-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">mixed</text>
                </column>
            </row>
        </column>

        @endif

        @if($show === [] || in_array(7, $show, true))
        {{-- ─────────────────────────────────────────────────────────────
             7. Insets as a nudge on top of the anchor.

             iOS placeAbsolute (two-point branch):  x += left - right
             Android stack:  offsetX = if (right > 0) -right else left

             Identical when only one side is set. They diverge when BOTH
             are set (iOS +6, Android −4 from centre) and on a negative
             `right` (iOS shifts +6, Android ignores it entirely).
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">7. Inset nudge on an anchor ⚠️</text>
            <text class="text-sm opacity-60">
                Anchor is center for all four. The last two are where iOS and Android disagree.
            </text>

            <row class="gap-3 py-2">
                <column class="gap-1">
                    <stack class="w-[80] h-[56] {{ $box }}">
                        <column anchor="center" left="10" class="w-[18] h-[18] bg-cyan-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">left=10</text>
                    <text class="text-xs opacity-40">agree</text>
                </column>
                <column class="gap-1">
                    <stack class="w-[80] h-[56] {{ $box }}">
                        <column anchor="center" right="4" class="w-[18] h-[18] bg-cyan-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">right=4</text>
                    <text class="text-xs opacity-40">agree</text>
                </column>
                <column class="gap-1">
                    <stack class="w-[80] h-[56] {{ $box }}">
                        <column anchor="center" left="10" right="4" class="w-[18] h-[18] bg-pink-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">left=10 right=4</text>
                    <text class="text-xs opacity-40">iOS +6 / Android −4</text>
                </column>
                <column class="gap-1">
                    <stack class="w-[80] h-[56] {{ $box }}">
                        <column anchor="center" :right="-6" class="w-[18] h-[18] bg-pink-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">right=-6</text>
                    <text class="text-xs opacity-40">iOS +6 / Android 0</text>
                </column>
            </row>
        </column>

        @endif

        @if($show === [] || in_array(8, $show, true))
        {{-- ─────────────────────────────────────────────────────────────
             8. Regression guard — a NON-stack container with absolute
             children and no anchor/origin must keep the legacy
             inset-corner behaviour byte for byte. The fourth chip opts
             into the two-point model from inside a non-stack parent.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">8. Legacy absolute (non-stack) — unchanged</text>
            <text class="text-sm opacity-60">
                No anchor/origin anywhere, so these keep the historical corner logic.
            </text>

            <column class="w-full h-[110] relative {{ $box }}">
                <column class="absolute top-0 left-0 w-[24] h-[24] bg-slate-500 {{ $chip }}" />
                <column class="absolute top-0 right-0 w-[24] h-[24] bg-slate-500 {{ $chip }}" />
                <column class="absolute bottom-0 left-0 w-[24] h-[24] bg-slate-500 {{ $chip }}" />
                <column class="absolute bottom-0 right-0 w-[24] h-[24] bg-slate-500 {{ $chip }}" />
            </column>

            <text class="text-sm opacity-60 pt-2">
                Opting in from a non-stack parent — this one should centre, not corner.
            </text>
            <column class="w-full h-[80] relative {{ $box }}">
                <column class="absolute w-[24] h-[24] bg-yellow-500 {{ $chip }}" anchor="center" />
            </column>
        </column>

        @endif

        @if($show === [] || in_array(9, $show, true))
        {{-- ─────────────────────────────────────────────────────────────
             9. z-order should follow document order — first child at the
             back. Offsets are staggered so the overlap is visible.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">9. z-order = document order</text>
            <text class="text-sm opacity-60">Red is first in the markup, so it should be at the back; blue on top.</text>

            <stack class="w-full h-[90] {{ $box }}">
                <column anchor="center" :left="-30" class="w-[56] h-[56] bg-red-500" />
                <column anchor="center" class="w-[56] h-[56] bg-emerald-500" />
                <column anchor="center" :left="30" class="w-[56] h-[56] bg-blue-500" />
            </stack>
        </column>

        @endif

        @if($show === [] || in_array(10, $show, true))
        {{-- ─────────────────────────────────────────────────────────────
             10. A misspelt anchor resolves to null and the prop is dropped
             silently, so the child falls back to centre. Both chips below
             should look the same — which is exactly the problem.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">10. Unknown anchor name ⚠️</text>
            <text class="text-sm opacity-60">
                A typo is dropped silently and centres. These two are indistinguishable at runtime.
            </text>

            <row class="gap-3">
                <column class="gap-1">
                    <stack class="w-[96] h-[56] {{ $box }}">
                        <column anchor="top-rigth" class="w-[20] h-[20] bg-rose-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">anchor="top-rigth" (typo)</text>
                </column>
                <column class="gap-1">
                    <stack class="w-[96] h-[56] {{ $box }}">
                        <column anchor="center" class="w-[20] h-[20] bg-rose-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">anchor="center"</text>
                </column>
            </row>
        </column>

        @endif

        @if($show === [] || in_array(11, $show, true))
        {{-- Diagnostic: isolate WHY anchors centre inside a stack. --}}
        <column class="gap-2">
            <text class="text-lg font-bold">11. Diagnostic</text>
            <text class="text-sm opacity-60">All four ask for top-right. Which ones obey?</text>

            <row class="gap-3 py-2">
                <column class="gap-1">
                    <stack class="w-[80] h-[56] {{ $box }}">
                        <column anchor="top-right" class="w-[18] h-[18] bg-blue-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">A stack+anchor</text>
                </column>
                <column class="gap-1">
                    <stack class="w-[80] h-[56] {{ $box }}">
                        <column anchor="top-right" class="absolute w-[18] h-[18] bg-blue-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">B stack+abs+anchor</text>
                </column>
                <column class="gap-1">
                    <column class="w-[80] h-[56] relative {{ $box }}">
                        <column anchor="top-right" class="absolute w-[18] h-[18] bg-green-600 {{ $chip }}" />
                    </column>
                    <text class="text-xs opacity-60">C col+abs+anchor</text>
                </column>
                <column class="gap-1">
                    <stack class="w-[80] h-[56] {{ $box }}">
                        <column class="absolute top-0 right-0 w-[18] h-[18] bg-amber-500 {{ $chip }}" />
                    </stack>
                    <text class="text-xs opacity-60">D stack+legacy</text>
                </column>
            </row>

            <text class="text-sm opacity-60 pt-2">Two flow children, no anchor — does the stack overlay them?</text>
            <stack class="{{ $box }}">
                <text class="text-xl font-bold">Pinkary</text>
                <text class="text-xl font-bold">XX</text>
            </stack>
        </column>

        @endif

        <column class="h-[40]" />
    </column>
</scroll-view>
