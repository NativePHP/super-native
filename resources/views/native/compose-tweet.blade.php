@php use App\Icons\Android; use App\Icons\Ios; @endphp
@php
    $hasText = trim($tweetText) !== '';
    $remaining = 280 - mb_strlen($tweetText);
@endphp

<column class="w-full h-full bg-theme-surface safe-area">

    {{-- Top Bar --}}
    <row class="w-full px-4 py-3 items-center justify-between">
        <pressable @navigate.back a11y-label="Close" class="w-[32] h-[32] items-center justify-center">
            <icon :ios="Ios::Xmark" :android="Android::Close" :size="24" class="text-theme-on-surface" />
        </pressable>
        <pressable @tap="postTweet" a11y-label="Post" class="px-5 py-2 rounded-full {{ $hasText ? 'bg-[#1D9BF0]' : 'bg-[#1D9BF0]/50' }}">
            <text class="text-[15] font-bold text-white">Post</text>
        </pressable>
    </row>

    {{-- Compose Area --}}
    <row class="w-full px-4 pt-4 gap-3">
        <image
            src="https://i.pravatar.cc/150?u=currentuser"
            alt="Your profile"
            class="w-[40] h-[40] rounded-full"
            :fit="2"
        />
        <column class="flex-1 gap-3">
            {{-- Audience pill --}}
            <row class="w-full">
                <row class="items-center gap-1 px-3 py-1 rounded-full border border-theme-outline">
                    <icon :ios="Ios::Globe" :android="Android::Public" :size="13" color="#1D9BF0" />
                    <text class="text-[13] font-semibold text-[#1D9BF0]">Everyone</text>
                </row>
                <spacer />
            </row>

            <outlined-text-input
                value="{{ $tweetText }}"
                placeholder="What is happening?!"
                :multiline="true"
                @change="updateText"
            />
        </column>
    </row>

    <spacer />

    {{-- Reply scope --}}
    <row class="w-full px-4 py-2 items-center gap-2">
        <icon :ios="Ios::Globe" :android="Android::Public" :size="15" color="#1D9BF0" />
        <text class="text-[13] font-semibold text-[#1D9BF0]">Everyone can reply</text>
    </row>

    <divider class="w-full" />

    {{-- Bottom toolbar --}}
    <row class="w-full px-4 py-3 items-center justify-between">
        <row class="items-center gap-6">
            <icon :ios="Ios::PhotoOnRectangle" :android="Android::PhotoLibrary" :size="20" color="#1D9BF0" />
            <icon :ios="Ios::Camera" :android="Android::CameraAlt" :size="20" color="#1D9BF0" />
            <icon :ios="Ios::ListBullet" :android="Android::List" :size="20" color="#1D9BF0" />
            <icon :ios="Ios::MappinAndEllipse" :android="Android::LocationOn" :size="20" color="#1D9BF0" />
            <icon :ios="Ios::FaceSmiling" :android="Android::Mood" :size="20" color="#1D9BF0" />
        </row>
        <text class="text-[13] {{ $remaining < 20 ? 'text-[#F91880]' : 'text-[#536471] dark:text-[#71767B]' }}">{{ $remaining }}</text>
    </row>

</column>
