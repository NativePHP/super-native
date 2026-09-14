@php use App\Icons\Android; use App\Icons\Ios; @endphp
<column class="w-full h-full bg-theme-background">

    @if ($case === 'matched')
        {{-- Control: same name as the source. This one morphs. --}}
        <column ref="edge-hero"
                class="w-full h-[320] items-center justify-center bg-[#0EA5E9]">
            <icon :ios="Ios::CheckmarkSealFill" :android="Android::Verified" :size="96" color="#FFFFFF" />
        </column>
        <column class="w-full p-6 gap-2">
            <text class="text-2xl font-bold text-theme-on-surface">Matched</text>
            <text class="text-sm text-theme-on-surface-variant">
                The thumbnail travelled here and grew. This is the behaviour every other case
                on this screen is measured against.
            </text>
        </column>

    @elseif ($case === 'unmatched')
        {{-- Deliberately tags NOTHING. The source's edge-orphan has no partner. --}}
        <column class="w-full h-[320] items-center justify-center bg-[#F59E0B]">
            <icon :ios="Ios::QuestionmarkCircleFill" :android="Android::Help" :size="96" color="#FFFFFF" />
        </column>
        <column class="w-full p-6 gap-2">
            <text class="text-2xl font-bold text-theme-on-surface">Unmatched</text>
            <text class="text-sm text-theme-on-surface-variant">
                The element on this screen carries no ref, so the tagged thumbnail on
                the previous screen had nothing to pair with. It cross-faded instead of
                travelling — degraded, not broken, and no warning was raised.
            </text>
        </column>

    @elseif ($case === 'duplicate')
        {{-- The SAME name twice on one screen. Only one pairing can win. --}}
        <row class="w-full gap-3 p-4">
            <column ref="edge-dupe"
                    class="flex-1 h-[160] rounded-2xl items-center justify-center bg-[#EC4899]">
                <icon :ios="Ios::SquareOnSquare" :android="Android::FilterNone" :size="44" color="#FFFFFF" />
            </column>
            <column ref="edge-dupe"
                    class="flex-1 h-[160] rounded-2xl items-center justify-center bg-[#EC4899]">
                <icon :ios="Ios::SquareOnSquare" :android="Android::FilterNone" :size="44" color="#FFFFFF" />
            </column>
        </row>
        <column class="w-full p-6 gap-2">
            <text class="text-2xl font-bold text-theme-on-surface">Duplicated</text>
            <text class="text-sm text-theme-on-surface-variant">
                Both images above claim edge-dupe. A name is meant to identify ONE element per
                screen, so this is a malformed input: one of them wins the pairing and the other
                is left out. Which one wins is not something to rely on — treat a duplicate name
                as a bug in the markup.
            </text>
        </column>

    @elseif ($case === 'resized')
        {{-- Matched, but a drastic aspect change between the two ends. --}}
        <column ref="edge-shape"
                class="w-full h-[110] items-center justify-center bg-[#8B5CF6]">
            <icon :ios="Ios::AspectratioFill" :android="Android::AspectRatio" :size="48" color="#FFFFFF" />
        </column>
        <column class="w-full p-6 gap-2">
            <text class="text-2xl font-bold text-theme-on-surface">Reshaped</text>
            <text class="text-sm text-theme-on-surface-variant">
                A 52pt square became a full-width 110pt banner. The frame interpolates directly
                between the two, so the image visibly stretches on the way across rather than
                holding its aspect ratio. Worth knowing before tagging elements whose shapes
                differ this much.
            </text>
        </column>

    @else
        {{-- Partner exists but is far down a scroll view, never laid out. --}}
        <scroll-view class="flex-1 w-full">
            <column class="w-full p-6 gap-4">
                <text class="text-2xl font-bold text-theme-on-surface">Partner below the fold</text>
                <text class="text-sm text-theme-on-surface-variant">
                    The element tagged edge-deep is near the bottom of this scroll view. It has
                    never been on screen, so it has no laid-out frame to travel from — scroll
                    down to find it sitting there, already in place.
                </text>
                @for ($i = 0; $i < 12; $i++)
                    <column class="w-full h-[70] rounded-xl bg-theme-surface items-center justify-center">
                        <text class="text-sm text-theme-on-surface-variant">filler {{ $i + 1 }}</text>
                    </column>
                @endfor
                <column ref="edge-deep"
                        class="w-full h-[220] rounded-2xl items-center justify-center bg-[#14B8A6]">
                    <icon :ios="Ios::ArrowDownCircleFill" :android="Android::ArrowCircleDown" :size="64" color="#FFFFFF" />
                </column>
                <text class="text-sm text-theme-on-surface-variant">
                    Here it is. It did not fly, because there was no starting frame for it.
                </text>
            </column>
        </scroll-view>
    @endif

    <row @navigate.back.viewTransition class="items-center gap-2 px-6 pb-10 safe-area">
        <icon :ios="Ios::ChevronLeft" :android="Android::ChevronLeft" :size="20" color="#6366F1" />
        <text class="text-base font-semibold text-[#6366F1]">Back to edge cases</text>
    </row>

</column>
