<scroll-view class="w-full bg-theme-background">
    <column class="w-full p-5 gap-5">

        {{-- Variants --}}
        <text class="text-lg font-semibold text-theme-on-background">Variants</text>
        <row class="w-full gap-2 flex-wrap items-center">
            <button variant="primary" @tap="increment">Primary</button>
            <button variant="secondary" @tap="increment">Secondary</button>
            <button variant="destructive" @tap="decrement">Destructive</button>
            <button variant="ghost" @tap="increment">Ghost</button>
        </row>

        {{-- Sizes --}}
        <text class="text-lg font-semibold text-theme-on-background">Sizes</text>
        <row class="w-full gap-2 items-center flex-wrap">
            <button variant="primary" size="sm" @tap="increment">Small</button>
            <button variant="primary" size="md" @tap="increment">Medium</button>
            <button variant="primary" size="lg" @tap="increment">Large</button>
        </row>

        {{-- With icons --}}
        <text class="text-lg font-semibold text-theme-on-background">With icons</text>
        <row class="w-full gap-2 items-center flex-wrap">
            <button variant="primary" icon="add" @tap="increment">Add item</button>
            <button variant="secondary" icon-trailing="arrow.right" @tap="increment">Next</button>
            <button variant="destructive" icon="delete" @tap="decrement">Delete</button>
        </row>

        {{-- States --}}
        <text class="text-lg font-semibold text-theme-on-background">States</text>
        <row class="w-full gap-2 items-center flex-wrap">
            <button variant="primary" @tap="increment">Enabled</button>
            <button variant="primary" disabled @tap="increment">Disabled</button>
            <button variant="primary" loading @tap="increment">Loading</button>
        </row>

        <divider class="my-2"/>

        {{-- Pressable escape hatch — bright accent pills stay vivid in both modes --}}
        <text class="text-lg font-semibold text-theme-on-background">Pressable (custom)</text>
        <row class="w-full gap-2 flex-wrap">
            <pressable @tap="increment" class="bg-pink-500 rounded-full px-6 py-2 items-center justify-center">
                <text class="text-white font-semibold">Pink Pill</text>
            </pressable>
            <pressable @tap="increment" class="bg-teal-500 rounded-full px-6 py-2 items-center justify-center">
                <text class="text-white font-semibold">Teal Pill</text>
            </pressable>
            <pressable @tap="increment"
                              class="border-2 border-theme-primary rounded-lg px-5 py-2 items-center justify-center">
                <text class="text-theme-primary font-semibold">Outlined</text>
            </pressable>
        </row>

        <row class="w-full gap-3 items-center">
            <pressable @tap="increment" a11y-label="Increment"
                              class="w-[48] h-[48] rounded-full bg-theme-primary items-center justify-center">
                <icon name="add" :size="24" color="#FFFFFF"/>
            </pressable>
            <pressable @tap="decrement" a11y-label="Decrement"
                              class="w-[48] h-[48] rounded-full bg-theme-destructive items-center justify-center">
                <icon name="minus.circle.fill" :size="24" color="#FFFFFF"/>
            </pressable>
            <pressable @tap="increment" a11y-label="Confirm"
                              class="w-[48] h-[48] rounded-full bg-theme-accent items-center justify-center">
                <icon name="check" :size="24" color="#FFFFFF"/>
            </pressable>
            <pressable @tap="increment" a11y-label="Star"
                              class="w-[48] h-[48] rounded-full bg-theme-secondary items-center justify-center">
                <icon name="star" :size="24" color="#FFFFFF"/>
            </pressable>
            <pressable @tap="increment" a11y-label="Favorite"
                              class="w-[48] h-[48] rounded-full bg-amber-500 items-center justify-center">
                <icon name="favorite" :size="24" color="#FFFFFF"/>
            </pressable>
        </row>

        <divider class="my-2"/>

        {{-- Counter --}}
        <text class="text-lg font-semibold text-theme-on-background">Interactive Counter</text>
        <row class="w-full gap-4 items-center justify-center">
            <button variant="destructive" size="lg" icon="minus.circle.fill" a11y-label="Decrement"
                           @tap="decrement"/>
            <column class="w-[80] h-[80] rounded-2xl bg-theme-primary items-center justify-center">
                <text class="text-theme-on-primary font-extrabold text-3xl">{{ $count }}</text>
            </column>
            <button variant="primary" size="lg" icon="add" a11y-label="Increment" @tap="increment"/>
        </row>

    </column>
</scroll-view>
