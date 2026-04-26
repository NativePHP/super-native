<native:column class="w-full h-full bg-gray-50 safe-area">

    {{-- Top Bar --}}
    <native:column class="w-full bg-[#003399]">
        <native:row class="w-full px-4 py-3 items-center gap-3">
            <native:column @press="back" class="w-[32] h-[32] rounded-full bg-white/20 items-center justify-center">
                <native:icon name="arrow_back" :size="20" color="#FFFFFF" />
            </native:column>
            <native:text class="text-[18] font-bold text-white">Search</native:text>
        </native:row>
    </native:column>

    {{-- Search Input --}}
    <native:column class="w-full bg-white px-4 py-3">
        <native:outlined-text-input
            value="{{ $searchQuery }}"
            placeholder="What are you looking for?"
            @change="updateSearch"
            :variant="0"
            class="w-full"
        />
    </native:column>

    {{-- Room Filter Chips --}}
    <native:scroll-view horizontal class="bg-white">
        <native:row class="gap-2 px-4 pb-3">
            @foreach ($categories as $cat)
                <native:chip
                    label="{{ $cat['name'] }}"
                    icon="{{ $cat['icon'] }}"
                    :selected="$selectedRoom === $cat['name']"
                    @change="selectRoom('{{ $cat['name'] }}')"
                />
            @endforeach
        </native:row>
    </native:scroll-view>

    <native:divider class="w-full" />

    {{-- Result Count --}}
    <native:column class="w-full px-4 py-2 bg-gray-50">
        <native:text class="text-[13] text-[#484848]">{{ $resultCount }} {{ $resultCount === 1 ? 'result' : 'results' }}</native:text>
    </native:column>

    {{-- Product Results --}}
    <native:scroll-view class="w-full h-full">
        <native:column class="w-full px-4 pt-2 pb-4 gap-3">
            @foreach ($results as $product)
                <native:column @press="viewProduct({{ $product['originalIndex'] }})" class="w-full bg-white rounded-lg">
                    <native:row class="w-full gap-3 p-3">
                        {{-- Product Image --}}
                        <native:column class="w-[100] h-[100] bg-[#F5F5F5] rounded-lg items-center justify-center">
                            <native:image
                                src="{{ $product['imageUrl'] }}"
                                class="w-[90] h-[90] rounded-lg"
                                :fit="2"
                            />
                        </native:column>

                        {{-- Product Info --}}
                        <native:column class="w-[230] gap-1">
                            @if ($product['badge'])
                                <native:text class="text-[10] font-bold text-[#CC0000]">{{ $product['badge'] }}</native:text>
                            @endif
                            <native:text class="text-[14] font-bold text-[#111111]">{{ $product['seriesName'] }}</native:text>
                            <native:text class="text-[12] text-[#484848]" :maxLines="1">{{ $product['name'] }}</native:text>
                            <native:text class="text-[11] text-[#484848]">{{ $product['color'] }}</native:text>
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
                        </native:column>
                    </native:row>
                </native:column>
            @endforeach
        </native:column>

        @if (count($results) === 0)
            <native:column class="w-full items-center py-8">
                <native:icon name="search_off" :size="48" color="#CCCCCC" />
                <native:spacer class="h-[8]" />
                <native:text class="text-[15] text-[#999999]">No products found</native:text>
                <native:text class="text-[12] text-[#999999]">Try a different search or room filter</native:text>
            </native:column>
        @endif
    </native:scroll-view>

</native:column>
