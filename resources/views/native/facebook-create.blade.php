<column class="w-full h-full bg-white safe-area">

    {{-- Top Bar --}}
    <row class="w-full px-4 py-3 items-center justify-between">
        <row class="items-center gap-3">
            <column @press="back" a11y-label="Close" class="w-[32] h-[32] items-center justify-center">
                <icon name="close" :size="24" color="#050505" />
            </column>
            <text class="text-[18] font-bold text-[#050505]">Create Post</text>
        </row>
        <button
            label="Post"
            @press="submitPost"
            color="#1877F2"
            labelColor="#FFFFFF"
            :fontSize="14"
        />
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
        <column>
            <text class="text-[15] font-bold text-[#050505]">You</text>
            <row class="items-center gap-1 bg-[#E4E6EB] rounded px-2 py-0.5">
                <icon name="public" :size="12" color="#65676B" />
                <text class="text-[11] text-[#65676B]">Public</text>
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

    {{-- Bottom Actions --}}
    <divider class="w-full" />
    <column class="w-full px-4 py-3 gap-3">
        <text class="text-[14] font-semibold text-[#050505]">Add to your post</text>
        <row class="w-full justify-between">
            <row class="items-center gap-2">
                <icon name="photo_library" :size="24" color="#45BD62" />
            </row>
            <row class="items-center gap-2">
                <icon name="person_add" :size="24" color="#1877F2" />
            </row>
            <row class="items-center gap-2">
                <icon name="mood" :size="24" color="#F7B928" />
            </row>
            <row class="items-center gap-2">
                <icon name="location_on" :size="24" color="#F3425F" />
            </row>
            <row class="items-center gap-2">
                <icon name="more_horiz" :size="24" color="#65676B" />
            </row>
        </row>
    </column>

</column>
