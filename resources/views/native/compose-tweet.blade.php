<native:column class="w-full h-full bg-white safe-area">

    {{-- Top Bar --}}
    <native:row class="w-full px-4 py-3 items-center justify-between">
        <native:column @press="back" class="w-[32] h-[32] items-center justify-center">
            <native:icon name="close" :size="24" color="#0F1419" />
        </native:column>
        <native:button
            label="Post"
            @press="postTweet"
            color="#1D9BF0"
            labelColor="#FFFFFF"
            :fontSize="15"
        />
    </native:row>

    <native:divider class="w-full" />

    {{-- Compose Area --}}
    <native:row class="w-full px-4 pt-4 gap-3">
        <native:image
            src="https://i.pravatar.cc/150?u=currentuser"
            class="w-[40] h-[40] rounded-full"
            :fit="2"
        />
        <native:column class="w-[300]">
            <native:outlined-text-input
                value="{{ $tweetText }}"
                placeholder="What is happening?!"
                :multiline="true"
                @change="updateText"
            />
        </native:column>
    </native:row>

</native:column>
