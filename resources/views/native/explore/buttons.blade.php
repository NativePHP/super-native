<native:scroll-view class="w-full bg-theme-surface">
    <native:column class="w-full p-5 gap-5">

        {{-- Variants --}}
        <native:text class="text-lg font-semibold">Variants</native:text>
        <native:row class="w-full gap-2 flex-wrap items-center">
            <native:button variant="primary"     @press="increment">Primary</native:button>
            <native:button variant="secondary"   @press="increment">Secondary</native:button>
            <native:button variant="destructive" @press="decrement">Destructive</native:button>
            <native:button variant="ghost"       @press="increment">Ghost</native:button>
        </native:row>

        {{-- Sizes --}}
        <native:text class="text-lg font-semibold">Sizes</native:text>
        <native:row class="w-full gap-2 items-center flex-wrap">
            <native:button variant="primary" size="sm" @press="increment">Small</native:button>
            <native:button variant="primary" size="md" @press="increment">Medium</native:button>
            <native:button variant="primary" size="lg" @press="increment">Large</native:button>
        </native:row>

        {{-- With icons --}}
        <native:text class="text-lg font-semibold">With icons</native:text>
        <native:row class="w-full gap-2 items-center flex-wrap">
            <native:button variant="primary"     icon="add"                          @press="increment">Add item</native:button>
            <native:button variant="secondary"   icon-trailing="arrow.right"         @press="increment">Next</native:button>
            <native:button variant="destructive" icon="delete"                       @press="decrement">Delete</native:button>
        </native:row>

        {{-- States --}}
        <native:text class="text-lg font-semibold">States</native:text>
        <native:row class="w-full gap-2 items-center flex-wrap">
            <native:button variant="primary"           @press="increment">Enabled</native:button>
            <native:button variant="primary" disabled  @press="increment">Disabled</native:button>
            <native:button variant="primary" loading   @press="increment">Loading</native:button>
        </native:row>

        <native:divider class="my-2" />

        {{-- Pressable escape hatch --}}
        <native:text class="text-lg font-semibold">Pressable (custom)</native:text>
        <native:row class="w-full gap-2 flex-wrap">
            <native:pressable @press="increment" class="bg-pink-500 rounded-full px-6 py-2 items-center justify-center">
                <native:text class="text-white font-semibold">Pink Pill</native:text>
            </native:pressable>
            <native:pressable @press="increment" class="bg-teal-500 rounded-full px-6 py-2 items-center justify-center">
                <native:text class="text-white font-semibold">Teal Pill</native:text>
            </native:pressable>
            <native:pressable @press="increment" class="border-2 border-blue-500 rounded-lg px-5 py-2 items-center justify-center">
                <native:text class="text-blue-500 font-semibold">Outlined</native:text>
            </native:pressable>
        </native:row>

        <native:row class="w-full gap-3 items-center">
            <native:pressable @press="increment" class="w-[48] h-[48] rounded-full bg-blue-500 items-center justify-center">
                <native:icon name="add" :size="24" color="#FFFFFF"/>
            </native:pressable>
            <native:pressable @press="decrement" class="w-[48] h-[48] rounded-full bg-red-500 items-center justify-center">
                <native:icon name="minus.circle.fill" :size="24" color="#FFFFFF"/>
            </native:pressable>
            <native:pressable @press="increment" class="w-[48] h-[48] rounded-full bg-green-500 items-center justify-center">
                <native:icon name="check" :size="24" color="#FFFFFF"/>
            </native:pressable>
            <native:pressable @press="increment" class="w-[48] h-[48] rounded-full bg-purple-500 items-center justify-center">
                <native:icon name="star" :size="24" color="#FFFFFF"/>
            </native:pressable>
            <native:pressable @press="increment" class="w-[48] h-[48] rounded-full bg-amber-500 items-center justify-center">
                <native:icon name="favorite" :size="24" color="#FFFFFF"/>
            </native:pressable>
        </native:row>

        <native:divider class="my-2" />

        {{-- Counter --}}
        <native:text class="text-lg font-semibold">Interactive Counter</native:text>
        <native:row class="w-full gap-4 items-center justify-center">
            <native:button variant="destructive" size="lg" icon="minus.circle.fill" a11y-label="Decrement" @press="decrement"/>
            <native:column class="w-[80] h-[80] rounded-2xl bg-indigo-600 items-center justify-center">
                <native:text class="text-white font-extrabold text-3xl">{{ $count }}</native:text>
            </native:column>
            <native:button variant="primary" size="lg" icon="add" a11y-label="Increment" @press="increment"/>
        </native:row>

    </native:column>
</native:scroll-view>
