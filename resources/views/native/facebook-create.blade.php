<native:column class="w-full h-full bg-white safe-area">

    {{-- Top Bar --}}
    <native:row class="w-full px-4 py-3 items-center justify-between">
        <native:row class="items-center gap-3">
            <native:column @press="back" class="w-[32] h-[32] items-center justify-center">
                <native:icon name="close" :size="24" color="#050505" />
            </native:column>
            <native:text class="text-[18] font-bold text-[#050505]">Create Post</native:text>
        </native:row>
        <native:button
            label="Post"
            @press="submitPost"
            color="#1877F2"
            labelColor="#FFFFFF"
            :fontSize="14"
        />
    </native:row>

    <native:divider class="w-full" />

    {{-- Author Info --}}
    <native:row class="w-full px-4 pt-4 items-center gap-3">
        <native:image
            src="https://i.pravatar.cc/150?u=fbcurrent"
            class="w-[44] h-[44] rounded-full"
            :fit="2"
        />
        <native:column>
            <native:text class="text-[15] font-bold text-[#050505]">You</native:text>
            <native:row class="items-center gap-1 bg-[#E4E6EB] rounded px-2 py-0.5">
                <native:icon name="public" :size="12" color="#65676B" />
                <native:text class="text-[11] text-[#65676B]">Public</native:text>
            </native:row>
        </native:column>
    </native:row>

    {{-- Text Input --}}
    <native:column class="w-full px-4 pt-3">
        <native:outlined-text-input
            value="{{ $postText }}"
            placeholder="What's on your mind?"
            :multiline="true"
            @change="updateText"
        />
    </native:column>

    <native:spacer />

    {{-- Bottom Actions --}}
    <native:divider class="w-full" />
    <native:column class="w-full px-4 py-3 gap-3">
        <native:text class="text-[14] font-semibold text-[#050505]">Add to your post</native:text>
        <native:row class="w-full justify-between">
            <native:row class="items-center gap-2">
                <native:icon name="photo_library" :size="24" color="#45BD62" />
            </native:row>
            <native:row class="items-center gap-2">
                <native:icon name="person_add" :size="24" color="#1877F2" />
            </native:row>
            <native:row class="items-center gap-2">
                <native:icon name="mood" :size="24" color="#F7B928" />
            </native:row>
            <native:row class="items-center gap-2">
                <native:icon name="location_on" :size="24" color="#F3425F" />
            </native:row>
            <native:row class="items-center gap-2">
                <native:icon name="more_horiz" :size="24" color="#65676B" />
            </native:row>
        </native:row>
    </native:column>

</native:column>
