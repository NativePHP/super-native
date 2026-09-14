@php
    use App\Icons\Android;
    use App\Icons\Ios;
    $clip = $items[$index];
    $isLiked = isset($liked[$index]);
    $isPaused = isset($paused[$index]);
    $likes = $clip['likes'] + ($isLiked ? 1 : 0);
    $fmt = fn (int $n) => $n >= 1000 ? number_format($n / 1000, 1).'K' : (string) $n;
@endphp
{{-- One reel page: full-bleed video with the caption and action rail
     overlaid. Included once per window index from reel-feed.blade.php
     with $index in scope; $items / $liked come from the parent.
     The video autoplays only while its page is mostly on screen (the
     media-player watches its own visibility), so neighbours sit loaded
     but silent. --}}
{{-- native:key, not key: it is what gives this page (and everything in it)
     an id that does not depend on its slot in the shipped window. Unkeyed,
     the node ids are renumbered on every publish, native rebuilds the
     subtree once the window slides, and the video restarts one round-trip
     after the swipe. --}}
<stack :native:key="'reel-'.$index" class="w-full h-full bg-black">
    {{-- Tap: pause / resume. Double tap: like. Both platforms disambiguate
         the two natively, so a double tap does not also pause. --}}
    <pressable @tap="togglePlay({{ $index }})" @doubleTap="like({{ $index }})" class="w-full h-full">
        <stack class="w-full h-full">
            <video-player
                src="{{ $clip['src'] }}"
                poster="{{ $clip['poster'] ?? '' }}"
                class="w-full h-full object-cover"
                :controls="false"
                :autoplay="true"
                :loop="true"
            />
            {{-- Centred with a full-size child, not `absolute inset-0`: a
                 zero inset reads as "unset" and pins to the top-left. Inside
                 the pressable, so tapping the glyph resumes too. --}}
            @if ($isPaused)
                <column class="w-full h-full items-center justify-center">
                    <icon :ios="Ios::PlayFill" :android="Android::PlayArrow" :size="72" color="#B3FFFFFF" />
                </column>
            @endif
        </stack>
    </pressable>

    {{-- Caption --}}
    <column class="absolute bottom-[40] left-4 right-20 gap-1">
        <text class="text-[15] font-bold text-white">{{ $clip['handle'] }}</text>
        <text class="text-[14] text-white">{{ $clip['caption'] }}</text>
        <row class="items-center gap-2 pt-1">
            <icon :ios="Ios::MusicNote" :android="Android::MusicNote" :size="14" color="#FFFFFF" />
            <text class="text-[12] text-white">Original audio · {{ $clip['title'] }} · #{{ $index + 1 }}</text>
        </row>
    </column>

    {{-- Action rail — LAST so it draws (and hit-tests) on top --}}
    <column class="absolute bottom-[48] right-3 items-center gap-5">
        <pressable @tap="toggleLike({{ $index }})" a11y-label="{{ $isLiked ? 'Unlike' : 'Like' }}" class="items-center gap-1">
            <icon :ios="$isLiked ? Ios::HeartFill : Ios::Heart" :android="$isLiked ? Android::Favorite : Android::FavoriteBorder" :size="32" color="{{ $isLiked ? '#FF2D55' : '#FFFFFF' }}" />
            <text class="text-[12] font-semibold text-white">{{ $fmt($likes) }}</text>
        </pressable>
        <pressable @tap="openComments({{ $index }})" a11y-label="Comments" class="items-center gap-1">
            <icon :ios="Ios::BubbleLeft" :android="Android::ChatBubbleOutline" :size="30" color="#FFFFFF" />
            <text class="text-[12] font-semibold text-white">{{ $fmt($clip['comments']) }}</text>
        </pressable>
        <pressable @tap="share({{ $index }})" a11y-label="Share" class="items-center gap-1">
            <icon :ios="Ios::SquareAndArrowUp" :android="Android::Share" :size="30" color="#FFFFFF" />
            <text class="text-[12] font-semibold text-white">Share</text>
        </pressable>
    </column>
</stack>
