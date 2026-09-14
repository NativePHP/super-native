@php use App\Icons\Android; use App\Icons\Ios; @endphp
<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-5 gap-3">

        <text class="text-sm text-theme-on-surface-variant pb-1">
            Two elements sharing a <text class="font-semibold">ref</text> across two screens morph
            between them when you navigate with <text class="font-semibold">&#64;navigate.viewTransition</text>.
        </text>

        @php
            $demos = [
                ['uri' => '/hero/photos',  'ios' => Ios::PhotoOnRectangle, 'android' => Android::PhotoLibrary, 'tint' => '#0EA5E9',
                 'title' => 'Photo grid → detail',
                 'blurb' => 'The canonical case. A thumbnail grows into a full-bleed hero.'],
                ['uri' => '/hero/cards',   'ios' => Ios::RectangleExpandVertical, 'android' => Android::UnfoldMore, 'tint' => '#6366F1',
                 'title' => 'Card → full page',
                 'blurb' => 'The box travels while its contents change underneath.'],
                ['uri' => '/hero/people',  'ios' => Ios::Person2Fill, 'android' => Android::Group, 'tint' => '#14B8A6',
                 'title' => 'Two elements at once',
                 'blurb' => 'Avatar and name morph along separate paths in one navigation.'],
                ['uri' => '/hero/player',  'ios' => Ios::PlayCircleFill, 'android' => Android::PlayCircleFilled, 'tint' => '#7C3AED',
                 'title' => 'Mini player → full player',
                 'blurb' => 'The one you already know. Three names, three very different paths.'],
                ['uri' => '/hero/nested',  'ios' => Ios::SquareOnSquare, 'android' => Android::FilterNone, 'tint' => '#DB2777',
                 'title' => 'Nested morphs',
                 'blurb' => 'A tagged element inside another — matched independently, opposite directions.'],
                ['uri' => '/hero/chain',   'ios' => Ios::ArrowTriangleTurnUpRightDiamondFill, 'android' => Android::Route, 'tint' => '#0891B2',
                 'title' => 'Three-hop chain',
                 'blurb' => 'One token re-paired at every hop, and reversed on the way back.'],
                ['uri' => '/hero/shape',   'ios' => Ios::AspectratioFill, 'android' => Android::AspectRatio, 'tint' => '#8B5CF6',
                 'title' => 'Shape shift',
                 'blurb' => 'Size, aspect and corner radius interpolating at once. Circle to banner.'],
                ['uri' => '/hero/deep',    'ios' => Ios::ListBulletIndent, 'android' => Android::FormatListBulleted, 'tint' => '#059669',
                 'title' => 'Deep scroll',
                 'blurb' => 'Forty rows — the start frame is wherever you happened to tap.'],
                ['uri' => '/hero/scroll-20k', 'ios' => Ios::SquareGrid2x2Fill, 'android' => Android::GridView, 'tint' => '#DC2626',
                 'title' => '20k Scroll',
                 'blurb' => 'Stress test: twenty thousand image cells in a windowed virtual-list.'],
                ['uri' => '/hero/seam',    'ios' => Ios::Scissors, 'android' => Android::ContentCut, 'tint' => '#E11D48',
                 'title' => 'The seam',
                 'blurb' => 'One object, half tagged. Watch it tear in half mid-navigation.'],
                ['uri' => '/hero/styles',  'ios' => Ios::SliderHorizontal3, 'android' => Android::Tune, 'tint' => '#4F46E5',
                 'title' => 'Morph styles',
                 'blurb' => 'frame, position, size — same start, same end, three different reads.'],
                ['uri' => '/hero/timing',  'ios' => Ios::MetronomeFill, 'android' => Android::AvTimer, 'tint' => '#EA580C',
                 'title' => 'Timing and easing',
                 'blurb' => 'Four heroes, four curves. They leave together and land apart.'],
                ['uri' => '/hero/edges',   'ios' => Ios::ExclamationmarkTriangleFill, 'android' => Android::Warning, 'tint' => '#F59E0B',
                 'title' => 'Edge cases',
                 'blurb' => 'Unmatched, duplicated, off-screen — where the mechanism gives up.'],
            ];
        @endphp

        @foreach ($demos as $demo)
            <row @navigate.viewTransition($demo['uri'])
                 class="items-center gap-3 p-4 bg-theme-surface rounded-2xl shadow">
                <column class="w-[40] h-[40] rounded-xl items-center justify-center bg-[{{ $demo['tint'] }}]">
                    <icon :ios="$demo['ios']" :android="$demo['android']" :size="20" color="#FFFFFF" />
                </column>
                <column class="flex-1 gap-0.5">
                    <text class="text-base font-semibold text-theme-on-surface">{{ $demo['title'] }}</text>
                    <text class="text-sm text-theme-on-surface-variant">{{ $demo['blurb'] }}</text>
                </column>
                <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="20" color="#9CA3AF" dark-color="#94A3B8" />
            </row>
        @endforeach

        {{-- ── The comparison that explains the design choice ──────────── --}}
        <text class="text-sm font-semibold text-theme-on-surface pt-4">Same hero, different transition</text>
        <text class="text-sm text-theme-on-surface-variant">
            All four push the same tagged photo. Only viewTransition morphs it — the others move the
            whole screen, which is why viewTransition holds the screens still and cross-fades instead.
        </text>

        <row class="w-full items-center gap-3 p-4 bg-theme-surface rounded-2xl shadow">
            <column ref="matrix-photo"
                    class="w-[56] h-[56] rounded-xl items-center justify-center bg-[#0EA5E9]">
                <icon :ios="Ios::CheckmarkSealFill" :android="Android::Verified" :size="26" color="#FFFFFF" />
            </column>
            <column class="flex-1 gap-1">
                <text class="text-sm font-semibold text-theme-on-surface">Cliff Path</text>
                <text class="text-xs text-theme-on-surface-variant">Tap a transition below</text>
            </column>
        </row>

        {{-- Written out one row per transition rather than looped: a
             &#64;navigate directive is parsed as a static tag attribute, so it
             cannot be chosen with an @if inside the tag. --}}
        <column class="w-full gap-2">

            <row @navigate.viewTransition('/hero/edges/matched')
                 class="items-center justify-between px-4 py-3 rounded-xl bg-[#EEF2FF] dark:bg-[#312E81]">
                <column class="flex-1 gap-0.5">
                    <text class="text-sm font-semibold text-theme-on-surface">&#64;navigate.viewTransition</text>
                    <text class="text-xs text-theme-on-surface-variant">morphs the photo, screens cross-fade</text>
                </column>
                <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="18" color="#9CA3AF" dark-color="#94A3B8" />
            </row>

            <row @navigate.fade('/hero/edges/matched')
                 class="items-center justify-between px-4 py-3 rounded-xl bg-theme-surface">
                <column class="flex-1 gap-0.5">
                    <text class="text-sm font-semibold text-theme-on-surface">&#64;navigate.fade</text>
                    <text class="text-xs text-theme-on-surface-variant">screens cross-fade, photo does not travel</text>
                </column>
                <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="18" color="#9CA3AF" dark-color="#94A3B8" />
            </row>

            <row @navigate.slideFromRight('/hero/edges/matched')
                 class="items-center justify-between px-4 py-3 rounded-xl bg-theme-surface">
                <column class="flex-1 gap-0.5">
                    <text class="text-sm font-semibold text-theme-on-surface">&#64;navigate.slideFromRight</text>
                    <text class="text-xs text-theme-on-surface-variant">whole screen slides over the photo</text>
                </column>
                <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="18" color="#9CA3AF" dark-color="#94A3B8" />
            </row>

            <row @navigate.none('/hero/edges/matched')
                 class="items-center justify-between px-4 py-3 rounded-xl bg-theme-surface">
                <column class="flex-1 gap-0.5">
                    <text class="text-sm font-semibold text-theme-on-surface">&#64;navigate.none</text>
                    <text class="text-xs text-theme-on-surface-variant">instant cut, no motion at all</text>
                </column>
                <icon :ios="Ios::ChevronRight" :android="Android::ChevronRight" :size="18" color="#9CA3AF" dark-color="#94A3B8" />
            </row>

        </column>

    </column>
</scroll-view>
