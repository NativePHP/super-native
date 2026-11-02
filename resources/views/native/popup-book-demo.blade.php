@php use App\Icons\Android; use App\Icons\Ios; @endphp
{{-- "The Little App": a pop-up book that follows the device. Closed (outer display) it
     is the cover; open the device and it swings open (no on-screen control). Swipe or
     tap the page edges to turn pages. Every frame is native.
     iPhone Duo: no system bars. The canvas runs edge to edge; on the compact outer display
     the cover is full bleed and its title and art stay clear of the camera and the status
     column. Our own controls always respect the safe area. --}}
<stack class="w-full h-full bg-[#1b1626]">
    <skia-canvas native:key="popup-book-canvas" :scene="$scene" :fit="$fit" animated interactive
        canvas-id="popup-book" class="w-full h-full" a11y-label="The Little App, a pop-up bedtime story" />

    @unless($tour ?? false)
        <stack class="absolute top-1 left-1 safe-area">
            <pressable @navigate.back a11y-label="Back" class="m-3 w-[30] h-[30] rounded-full bg-[#00000033] items-center justify-center">
                <icon :ios="Ios::ChevronLeft" :android="Android::ArrowBack" :size="16" color="#FFFFFFAA" />
            </pressable>
        </stack>
    @endunless

    @if($status !== '')
        <stack class="absolute bottom-1 left-1 safe-area">
            <text class="m-4 text-xs text-[#ffb5ce]">{{ $status }}</text>
        </stack>
    @endif
</stack>
