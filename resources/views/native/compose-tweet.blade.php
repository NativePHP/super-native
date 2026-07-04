<column class="w-full h-full bg-theme-surface safe-area">

    {{-- Top Bar --}}
    <row class="w-full px-4 py-3 items-center justify-between">
        <column @press="back" a11y-label="Close" class="w-[32] h-[32] items-center justify-center">
            <icon name="close" :size="24" color="#0F1419" />
        </column>
        <button
            label="Post"
            @press="postTweet"
            color="#1D9BF0"
            labelColor="#FFFFFF"
            :fontSize="15"
        />
    </row>

    <divider class="w-full" />

    {{-- Compose Area --}}
    <row class="w-full px-4 pt-4 gap-3">
        <image
            src="https://i.pravatar.cc/150?u=currentuser"
            alt="Your profile"
            class="w-[40] h-[40] rounded-full"
            :fit="2"
        />
        <column class="flex-1">
            <outlined-text-input
                value="{{ $tweetText }}"
                placeholder="What is happening?!"
                :multiline="true"
                @change="updateText"
            />
        </column>
    </row>

</column>
