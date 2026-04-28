

<native:scroll-view class="w-full h-full bg-gray-50">
    <native:column class="w-full gap-0 ">

        {{-- Top Bar --}}
        <native:column class="w-full bg-[#003399] px-4 pt-3 pb-3">
            <native:row class="w-full items-center justify-between">
                <native:text class="text-[22] font-bold text-[#FFCC00]">IKEA</native:text>
                <native:row class="items-center gap-3">
                    <native:column @press="viewSearch" class="w-[36] h-[36] rounded-full bg-white/20 items-center justify-center">
                        <native:icon name="search" :size="20" color="#FFFFFF" />
                    </native:column>
                    <native:column @press="viewCart" class="w-[36] h-[36] rounded-full bg-white/20 items-center justify-center">
                        <native:icon name="cart" :size="20" color="#FFFFFF" />
                    </native:column>
                </native:row>
            </native:row>
        </native:column>

        {{-- Hero Banner --}}
        <native:column class="w-full bg-[#003399] px-5 pb-5">
            <native:text class="text-[24] font-bold text-white">Create your dream home</native:text>
            <native:spacer class="h-[4]" />
            <native:text class="text-[14] text-white">Affordable solutions for every room</native:text>
            <native:spacer class="h-[12]" />
            <native:button label="Explore rooms" color="#FFCC00" labelColor="#003399" :fontSize="13" />
        </native:column>

        {{-- Shop by Room --}}
        <native:column class="w-full bg-white px-4 pt-4 pb-2">
            <native:text class="text-[18] font-bold text-[#111111]">Shop by room</native:text>
        </native:column>
        <native:scroll-view horizontal class="bg-white">
            <native:row class="gap-4 px-4 pb-4">
                @foreach ($categories as $catIndex => $cat)
                    <native:column @press="selectCategory('{{ $cat['name'] }}')" class="items-center gap-2 w-[72]">
                        <native:column class="w-[56] h-[56] rounded-full bg-[#F5F5F5] items-center justify-center">
                            <native:icon name="{{ $cat['icon'] }}" :size="26" color="#003399" />
                        </native:column>
                        <native:text class="text-[11] text-[#111111]">{{ $cat['name'] }}</native:text>
                    </native:column>
                @endforeach
            </native:row>
        </native:scroll-view>

        {{-- Room Ideas --}}
        <native:scroll-view horizontal class="bg-white">
            <native:row class="gap-2 px-4 pb-3">
                @foreach ($roomIdeas as $idea)
                    <native:chip label="{{ $idea }}" />
                @endforeach
            </native:row>
        </native:scroll-view>

        <native:divider class="w-full" />

        {{-- Popular Products --}}
        <native:column class="w-full bg-white px-4 pt-4 pb-2">
            <native:text class="text-[18] font-bold text-[#111111]">Popular right now</native:text>
        </native:column>
        <native:scroll-view horizontal class="bg-white">
            <native:row class="gap-3 px-4 pb-4">
                @foreach ($popular as $product)
                    <native:column @press="viewProduct({{ $product['originalIndex'] }})" class="w-[160] gap-2">
                        <native:column class="w-[160] h-[160] bg-[#F5F5F5] rounded-lg items-center justify-center">
                            <native:image
                                src="{{ $product['imageUrl'] }}"
                                class="w-[140] h-[140] rounded-lg"
                                :fit="2"
                            />
                        </native:column>
                        <native:text class="text-[12] font-bold text-[#111111]">{{ $product['seriesName'] }}</native:text>
                        <native:text class="text-[11] text-[#484848]" :maxLines="1">{{ $product['name'] }}</native:text>
                        <native:row class="items-center gap-2">
                            <native:text class="text-[14] font-bold text-[#111111]">{{ $product['priceFormatted'] }}</native:text>
                            @if ($product['originalPriceFormatted'])
                                <native:text class="text-[12] text-[#999999] line-through">{{ $product['originalPriceFormatted'] }}</native:text>
                            @endif
                        </native:row>
                        <native:row class="items-center gap-1">
                            <native:icon name="star" :size="12" color="#111111" />
                            <native:text class="text-[11] text-[#484848]">{{ $product['rating'] }} ({{ $product['reviewFormatted'] }})</native:text>
                        </native:row>
                    </native:column>
                @endforeach
            </native:row>
        </native:scroll-view>

        <native:divider class="w-full" />

        {{-- Category Filter --}}
        <native:column class="w-full bg-white px-4 pt-4 pb-2">
            <native:text class="text-[18] font-bold text-[#111111]">{{ $selectedCategory }}</native:text>
        </native:column>
        <native:scroll-view horizontal class="bg-white">
            <native:row class="gap-2 px-4 pb-3">
                @foreach ($categories as $cat)
                    <native:chip
                        label="{{ $cat['name'] }}"
                        :selected="$selectedCategory === $cat['name']"
                        @change="selectCategory('{{ $cat['name'] }}')"
                    />
                @endforeach
            </native:row>
        </native:scroll-view>

        {{-- Category Products --}}
        <native:column class="w-full bg-white px-4 pb-4 gap-3">
            @foreach ($categoryProducts as $product)
                <native:column @press="viewProduct({{ $product['originalIndex'] }})" class="w-full">
                    <native:row class="w-full gap-3">
                        <native:column class="w-[110] h-[110] bg-[#F5F5F5] rounded-lg items-center justify-center">
                            <native:image
                                src="{{ $product['imageUrl'] }}"
                                class="w-[100] h-[100] rounded-lg"
                                :fit="2"
                            />
                        </native:column>
                        <native:column class="w-[230] gap-1">
                            @if ($product['badge'])
                                <native:text class="text-[10] font-bold text-[#CC0000]">{{ $product['badge'] }}</native:text>
                            @endif
                            <native:text class="text-[14] font-bold text-[#111111]">{{ $product['seriesName'] }}</native:text>
                            <native:text class="text-[12] text-[#484848]" :maxLines="1">{{ $product['name'] }}</native:text>
                            <native:row class="items-center gap-2">
                                <native:text class="text-[16] font-bold text-[#111111]">{{ $product['priceFormatted'] }}</native:text>
                                @if ($product['originalPriceFormatted'])
                                    <native:text class="text-[12] text-[#999999] line-through">{{ $product['originalPriceFormatted'] }}</native:text>
                                @endif
                            </native:row>
                            <native:row class="items-center gap-1">
                                <native:icon name="star" :size="12" color="#111111" />
                                <native:text class="text-[11] text-[#484848]">{{ $product['rating'] }} ({{ $product['reviewFormatted'] }})</native:text>
                            </native:row>
                            <native:text class="text-[11] text-[#484848]">{{ $product['color'] }}</native:text>
                        </native:column>
                    </native:row>
                    <native:divider class="w-full mt-3" />
                </native:column>
            @endforeach
        </native:column>

        @if (count($categoryProducts) === 0)
            <native:column class="w-full bg-white items-center py-8">
                <native:icon name="search" :size="48" color="#CCCCCC" />
                <native:spacer class="h-[8]" />
                <native:text class="text-[15] text-[#999999]">No products in this category</native:text>
            </native:column>
        @endif

        {{-- Delivery Banner --}}
        <native:column class="w-full bg-[#003399] px-4 py-4 items-center gap-2">
            <native:row class="items-center gap-2">
                <native:icon name="local_shipping" :size="20" color="#FFCC00" />
                <native:text class="text-[14] font-semibold text-white">Free delivery on orders over $500</native:text>
            </native:row>
            <native:text class="text-[12] text-white">Click and collect available at all stores</native:text>
        </native:column>

        <native:spacer class="h-[20]" />

    </native:column>
</native:scroll-view>
