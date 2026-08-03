<scroll-view class="w-full h-full bg-theme-background ">
    <column class="w-full gap-0">

        {{-- Hero Image with Navigation --}}
        <stack class="w-full h-[300] ">
            <image
                src="{{ $currentImageUrl }}"
                class="w-full h-[300] "
                :fit="2"
            />
            {{-- Top Bar Overlay --}}
            <row class="w-full px-4 pt-[52] items-center justify-between">
                <column @tap="back" class="w-[34] h-[34] rounded-full bg-white items-center justify-center shadow">
                    <icon name="arrow_back" :size="18" color="#222222" />
                </column>
                <row class="items-center gap-2">
                    <column class="w-[34] h-[34] rounded-full bg-white items-center justify-center shadow">
                        <icon name="ios_share" :size="18" color="#222222" />
                    </column>
                    <column @tap="toggleWishlist" class="w-[34] h-[34] rounded-full bg-white items-center justify-center shadow">
                        <icon
                            name="{{ $isWishlisted ? 'favorite' : 'favorite_border' }}"
                            :size="18"
                            color="{{ $isWishlisted ? '#FF385C' : '#222222' }}"
                        />
                    </column>
                </row>
            </row>
            {{-- Image Arrows --}}
            @if ($imageCount > 1)
                <row class="w-full h-[300] px-3 items-center justify-between">
                    <column @tap="prevImage" class="w-[28] h-[28] rounded-full bg-white items-center justify-center shadow">
                        <icon name="chevron_left" :size="18" color="#222222" />
                    </column>
                    <column @tap="nextImage" class="w-[28] h-[28] rounded-full bg-white items-center justify-center shadow">
                        <icon name="chevron_right" :size="18" color="#222222" />
                    </column>
                </row>
            @endif
            {{-- Image Dots --}}
            <column class="w-full h-[300] justify-end items-center pb-3">
                <row class="items-center gap-1">
                    @for ($d = 0; $d < $imageCount; $d++)
                        <column class="w-[6] h-[6] rounded-full {{ $d === $currentImage ? 'bg-white' : 'bg-[#FFFFFF88]' }}" />
                    @endfor
                </row>
            </column>
        </stack>

        {{-- Title --}}
        <column class="w-full px-5 pt-5 gap-1">
            <text class="text-[24] font-bold text-theme-on-background">{{ $listing['title'] }}</text>
        </column>

        {{-- Rating + Reviews Row --}}
        <row class="w-full px-5 pt-2 items-center gap-1">
            <icon name="star" :size="14" color="#222222" />
            <text class="text-[14] font-semibold text-theme-on-background">{{ $listing['rating'] }}</text>
            <text class="text-[14] text-theme-on-background"> · </text>
            <text class="text-[14] font-semibold text-theme-on-background">{{ $listing['reviewCount'] }} reviews</text>
            <text class="text-[14] text-theme-on-background"> · </text>
            <text class="text-[14] font-semibold text-theme-on-background">{{ $listing['location'] }}</text>
        </row>

        <divider class="w-full mx-5 mt-5 mb-0" color="#EBEBEB" />

        {{-- Property Type + Host --}}
        <row class="w-full px-5 py-5 items-center justify-between">
            <column class="w-[260] gap-1">
                <text class="text-[20] font-semibold text-theme-on-background">{{ $listing['type'] }} hosted by {{ $listing['host'] }}</text>
                <row class="items-center gap-0">
                    <text class="text-[14] text-theme-on-surface-variant">{{ $listing['guests'] }} guests · {{ $listing['bedrooms'] }} {{ $listing['bedrooms'] === 1 ? 'bedroom' : 'bedrooms' }} · {{ $listing['beds'] }} {{ $listing['beds'] === 1 ? 'bed' : 'beds' }} · {{ $bathroomsFormatted }} {{ $listing['bathrooms'] == 1 ? 'bath' : 'baths' }}</text>
                </row>
            </column>
            <stack class="w-[56] h-[56]">
                <image
                    src="{{ $listing['hostAvatarUrl'] }}"
                    class="w-[56] h-[56] rounded-full"
                    :fit="2"
                />
                @if ($listing['hostIsSuperhost'])
                    <column class="w-[56] h-[56] items-end justify-end">
                        <column class="w-[20] h-[20] rounded-full bg-theme-secondary items-center justify-center">
                            <icon name="verified" :size="14" color="#FFFFFF" />
                        </column>
                    </column>
                @endif
            </stack>
        </row>

        <divider class="w-full mx-5" color="#EBEBEB" />

        {{-- Highlights --}}
        <column class="w-full px-5 py-5 gap-5">
            @foreach ($listing['highlights'] as $highlight)
                <row class="w-full items-start gap-4">
                    <icon name="{{ $highlight['icon'] }}" :size="26" color="#222222" />
                    <column class="w-[280] gap-1">
                        <text class="text-[14] font-semibold text-theme-on-background">{{ $highlight['title'] }}</text>
                        @if ($highlight['subtitle'] !== '')
                            <text class="text-[13] text-theme-on-surface-variant">{{ $highlight['subtitle'] }}</text>
                        @endif
                    </column>
                </row>
            @endforeach
        </column>

        <divider class="w-full mx-5" color="#EBEBEB" />

        {{-- Description --}}
        <column class="w-full px-5 py-5 gap-3">
            <text class="text-[14] text-theme-on-background" :maxLines="$showFullDescription ? 50 : 4">{{ $listing['description'] }}</text>
            <column @tap="toggleDescription">
                <row class="items-center gap-1">
                    <text class="text-[14] font-semibold text-theme-on-background">{{ $showFullDescription ? 'Show less' : 'Show more' }}</text>
                    <icon name="{{ $showFullDescription ? 'expand_less' : 'chevron_right' }}" :size="16" color="#222222" />
                </row>
            </column>
        </column>

        <divider class="w-full mx-5" color="#EBEBEB" />

        {{-- Amenities --}}
        <column class="w-full px-5 py-5 gap-4">
            <text class="text-[20] font-semibold text-theme-on-background">What this place offers</text>
            @foreach (array_slice($listing['amenities'], 0, 6) as $amenity)
                <row class="w-full items-center gap-4 py-1">
                    <icon name="{{ $amenity['icon'] }}" :size="24" color="#222222" />
                    <text class="text-[15] text-theme-on-background">{{ $amenity['label'] }}</text>
                </row>
            @endforeach
            @if (count($listing['amenities']) > 6)
                <column class="w-full py-3 rounded-lg items-center border border-theme-outline">
                    <text class="text-[14] font-semibold text-theme-on-background">Show all {{ count($listing['amenities']) }} amenities</text>
                </column>
            @endif
        </column>

        <divider class="w-full mx-5" color="#EBEBEB" />

        {{-- Reviews Section --}}
        <column class="w-full px-5 pt-5 pb-2 gap-2">
            <row class="items-center gap-2">
                <icon name="star" :size="18" color="#222222" />
                <text class="text-[20] font-semibold text-theme-on-background">{{ $listing['rating'] }} · {{ $listing['reviewCount'] }} reviews</text>
            </row>
        </column>

        <scroll-view horizontal>
            <row class="gap-3 px-5 pt-2 pb-5">
                @foreach ($listingReviews as $review)
                    <column class="w-[280] p-4 rounded-xl gap-3 border border-theme-outline">
                        <text class="text-[14] text-theme-on-background" :maxLines="4">{{ $review['text'] }}</text>
                        <spacer />
                        <row class="items-center gap-3">
                            <image
                                src="{{ $review['avatarUrl'] }}"
                                class="w-[40] h-[40] rounded-full"
                                :fit="2"
                            />
                            <column>
                                <text class="text-[14] font-semibold text-theme-on-background">{{ $review['username'] }}</text>
                                <text class="text-[12] text-theme-on-surface-variant">{{ $review['date'] }}</text>
                            </column>
                        </row>
                    </column>
                @endforeach
            </row>
        </scroll-view>

        <divider class="w-full mx-5" color="#EBEBEB" />

        {{-- Where You'll Be --}}
        <column class="w-full px-5 py-5 gap-3">
            <text class="text-[20] font-semibold text-theme-on-background">Where you'll be</text>
            <column class="w-full h-[180] bg-theme-surface-variant rounded-xl items-center justify-center">
                <icon name="map" :size="48" color="#B0B0B0" />
                <text class="text-[13] text-theme-on-surface-variant pt-2">{{ $listing['location'] }}</text>
            </column>
        </column>

        <divider class="w-full mx-5" color="#EBEBEB" />

        {{-- Host Section --}}
        <column class="w-full px-5 py-5 gap-4">
            <row class="items-center gap-4">
                <stack class="w-[56] h-[56]">
                    <image
                        src="{{ $listing['hostAvatarUrl'] }}"
                        class="w-[56] h-[56] rounded-full"
                        :fit="2"
                    />
                    @if ($listing['hostIsSuperhost'])
                        <column class="w-[56] h-[56] items-end justify-end">
                            <column class="w-[20] h-[20] rounded-full bg-theme-secondary items-center justify-center">
                                <icon name="verified" :size="14" color="#FFFFFF" />
                            </column>
                        </column>
                    @endif
                </stack>
                <column>
                    <text class="text-[18] font-semibold text-theme-on-background">Hosted by {{ $listing['host'] }}</text>
                    <text class="text-[13] text-theme-on-surface-variant">{{ $listing['hostYears'] }} years hosting</text>
                </column>
            </row>
            @if ($listing['hostIsSuperhost'])
                <row class="items-center gap-2">
                    <icon name="verified_user" :size="18" color="#222222" />
                    <text class="text-[14] text-theme-on-background">Superhost</text>
                </row>
            @endif
        </column>

        <spacer class="h-[20]" />

        {{-- Reserve Bar --}}
        <divider class="w-full" color="#EBEBEB" />
        <row class="w-full bg-theme-background px-5 pt-3 pb-6 items-center justify-between">
            <column class="gap-0">
                <row class="items-center gap-1">
                    <text class="text-[17] font-bold text-theme-on-background">${{ $listing['price'] }}</text>
                    <text class="text-[15] text-theme-on-background">night</text>
                </row>
                <text class="text-[12] text-theme-on-background">{{ $listing['dates'] }}</text>
            </column>
            <column @tap="reserve" class="bg-theme-primary rounded-lg px-6 py-3">
                <text class="text-[16] font-bold text-theme-on-primary">Reserve</text>
            </column>
        </row>

    </column>
</scroll-view>
