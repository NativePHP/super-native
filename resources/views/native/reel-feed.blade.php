@php use App\Icons\Android; use App\Icons\Ios; @endphp
{{-- Vertical snap feed. Native lays out $loaded pages (plus a loading
     page while $hasMore); only [$from..$to] are rendered here, every
     other page is a placeholder until the next render brings it in.
     The @include sees this scope, so each page reads $items / $liked
     directly — no shared view data needed.

     Edge to edge: the route has no layout (no NavigationStack insets) and
     a floating back button is overlaid here. Overlays use `absolute` with
     NON-ZERO insets only — both stack renderers read a zero inset as
     "unset" and pin to the top/left. --}}
<stack class="w-full h-full bg-black">
    <native:reel
        class="w-full h-full"
        :count="$loaded"
        :page="$page"
        :from="$from"
        :to="$to"
        :has-more="$hasMore"
        :placeholders="$placeholders"
        on-page-change="onReelPage"
        a11y-label="Video feed"
    >
        @for ($index = $from; $index <= $to; $index++)
            @include('native.reel-feed-page', ['index' => $index])
        @endfor
    </native:reel>

    {{-- LAST stack child so it draws (and hit-tests) on top --}}
    <pressable @navigate.back a11y-label="Back" class="absolute top-16 left-4 w-[36] h-[36] rounded-full bg-[#00000066] items-center justify-center">
        <icon :ios="Ios::ChevronLeft" :android="Android::ArrowBack" :size="20" color="#FFFFFF" />
    </pressable>

    {{-- Comments — always in the tree, visibility driven by the tapped page --}}
    <bottom-sheet :visible="$commentsFor !== null" detents="medium,large" @dismiss="closeComments">
        @if ($commentsFor !== null)
            <column class="w-full h-full bg-theme-surface">
                <text class="text-[15] font-semibold text-theme-on-surface text-center pt-4 pb-2">{{ count($comments) }} comments</text>
                <scroll-view class="w-full flex-1 px-4">
                    <column class="w-full gap-4 py-2">
                        @foreach ($comments as $c)
                            <row :native:key="'c-'.$loop->index" class="w-full gap-3 items-start">
                                <column class="w-[36] h-[36] rounded-full bg-theme-primary items-center justify-center">
                                    <text class="text-[14] font-bold text-theme-on-primary">{{ strtoupper(substr($c['handle'], 1, 1)) }}</text>
                                </column>
                                <column class="flex-1 gap-1">
                                    <row class="items-center gap-2">
                                        <text class="text-[13] font-semibold text-theme-on-surface">{{ $c['handle'] }}</text>
                                        <text class="text-[12] text-theme-on-surface-variant">{{ $c['when'] }}</text>
                                    </row>
                                    <text class="text-[14] text-theme-on-surface">{{ $c['text'] }}</text>
                                </column>
                            </row>
                        @endforeach
                    </column>
                </scroll-view>
                <row class="w-full items-center gap-2 px-4 py-3">
                    <outlined-text-input
                        value="{{ $draft }}"
                        placeholder="Add a comment…"
                        class="flex-1"
                        @change="draftComment"
                        @submit="postComment"
                    />
                    <button label="Post" @tap="postComment" />
                </row>
            </column>
        @endif
    </bottom-sheet>
</stack>
