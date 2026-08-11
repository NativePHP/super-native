{{-- The pattern from the issue, at full size. The scroll-view fills the
     screen; its single `fill` child is now at least viewport-tall, so
     justify-center has slack to distribute and the card sits in the middle.
     Focus a field: the keyboard shrinks the viewport and the content scrolls
     rather than being clipped. --}}
<scroll-view class="w-full h-full bg-blue-200">
    <column fill class="w-full items-center justify-center p-6 gap-4">

        <column class="w-full max-w-[360px] bg-white rounded-2xl p-6 gap-4">
            <column class="gap-1">
                <text class="text-2xl font-bold">Welcome back</text>
                <text class="text-sm opacity-60">Sign in to continue.</text>
            </column>

            <outlined-text-input native:model="email" label="Email" keyboard="email" />
            <outlined-text-input native:model="password" label="Password" secure />

            <button class="w-full">Sign in</button>
        </column>

        <text class="text-sm opacity-60">
            Centred vertically, and still scrollable with the keyboard up.
        </text>

    </column>
</scroll-view>
