@php
    $hasText = trim($postText) !== '';
@endphp

<column class="w-full h-full bg-theme-surface safe-area">

    {{-- Top Bar --}}
    <row class="w-full px-4 py-3 items-center justify-between">
        <row class="items-center gap-3">
            <pressable @tap="back" a11y-label="Close" class="w-[32] h-[32] items-center justify-center">
                <icon name="close" :size="24" class="text-theme-on-surface" />
            </pressable>
            <text class="text-[18] font-bold text-theme-on-surface">Create post</text>
        </row>
        <pressable @tap="submitPost" a11y-label="Post" class="px-4 py-2 rounded-lg {{ $hasText ? 'bg-[#1877F2]' : 'bg-[#1877F2]/50' }}">
            <text class="text-[14] font-bold text-white">Post</text>
        </pressable>
    </row>

    <divider class="w-full" />

    {{-- Author Info --}}
    <row class="w-full px-4 pt-4 items-center gap-3">
        <image
            src="https://i.pravatar.cc/150?u=fbcurrent"
            alt="Your profile"
            class="w-[44] h-[44] rounded-full"
            :fit="2"
        />
        <column class="gap-1">
            <text class="text-[15] font-bold text-theme-on-surface">You</text>
            <row class="items-center gap-1 bg-theme-surface-variant rounded-md px-2 py-0.5">
                <icon name="globe" :size="12" class="text-[#65676B] dark:text-[#B0B3B8]" />
                <text class="text-[12] font-semibold text-[#65676B] dark:text-[#B0B3B8]">Public</text>
                <icon name="expand_more" :size="12" class="text-[#65676B] dark:text-[#B0B3B8]" />
            </row>
        </column>
    </row>

    {{-- Text Input --}}
    <column class="w-full px-4 pt-3">
        <outlined-text-input
            value="{{ $postText }}"
            placeholder="What's on your mind?"
            :multiline="true"
            @change="updateText"
        />
    </column>

    <spacer />

    {{-- Add to your post --}}
    <divider class="w-full" />
    <column class="w-full px-4 py-2">
        <row class="w-full items-center py-3 gap-3">
            <icon name="photo" :size="22" color="#45BD62" />
            <text class="text-[15] text-theme-on-surface">Photo/video</text>
        </row>
        <divider class="w-full" />
        <row class="w-full items-center py-3 gap-3">
            <icon name="person" :size="22" color="#1877F2" />
            <text class="text-[15] text-theme-on-surface">Tag people</text>
        </row>
        <divider class="w-full" />
        <row class="w-full items-center py-3 gap-3">
            <icon name="videocam" :size="22" color="#F3425F" />
            <text class="text-[15] text-theme-on-surface">Live video</text>
        </row>
        <divider class="w-full" />
        <row class="w-full items-center py-3 gap-3">
            <icon name="location" :size="22" color="#F5533D" />
            <text class="text-[15] text-theme-on-surface">Check in</text>
        </row>
    </column>

</column>
