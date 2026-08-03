<scroll-view class="w-full h-full bg-theme-surface safe-area">
    <column class="w-full gap-0">

        {{-- Search Bar --}}
        <column class="w-full px-4 pt-3 pb-2">
            <row class="w-full bg-theme-surface-variant rounded-xl px-3 py-2 items-center gap-2">
                <icon name="search" :size="20" class="text-theme-on-surface-variant" />
                <text class="text-[15] text-theme-on-surface-variant">Search</text>
            </row>
        </column>

        {{-- Category Chips --}}
        <scroll-view horizontal>
            <row class="gap-2 px-4 pb-3">
                @foreach (['Trending', 'Reels', 'Travel', 'Architecture', 'Food', 'Art', 'Nature', 'Fitness', 'Style'] as $tag)
                    <chip label="{{ $tag }}" />
                @endforeach
            </row>
        </scroll-view>

        {{-- Explore Grid --}}
        <column class="w-full gap-[2]">
            @foreach (array_chunk($posts, 3) as $rowIndex => $row)
                @if ($rowIndex % 2 === 0)
                    {{-- Standard 3-column row --}}
                    <row class="w-full gap-[2]">
                        @foreach ($row as $post)
                            <pressable @tap="viewPost({{ $post['id'] }})" class="flex-1" a11y-label="View post">
                                <image
                                    src="{{ $post['imageUrl'] }}"
                                    alt="{{ \Illuminate\Support\Str::limit($post['caption'], 60) }}"
                                    class="w-full h-[125]"
                                    :fit="2"
                                />
                            </pressable>
                        @endforeach
                        @for ($i = count($row); $i < 3; $i++)
                            <column class="flex-1" />
                        @endfor
                    </row>
                @else
                    {{-- Featured layout: 1 large + 2 stacked --}}
                    <row class="w-full gap-[2]">
                        @if (isset($row[0]))
                            <pressable @tap="viewPost({{ $row[0]['id'] }})" class="w-2/3" a11y-label="View post">
                                <stack class="w-full h-[252]">
                                    <image
                                        src="{{ $row[0]['imageUrl'] }}"
                                        alt="{{ \Illuminate\Support\Str::limit($row[0]['caption'], 60) }}"
                                        class="w-full h-[252]"
                                        :fit="2"
                                    />
                                    <column class="absolute top-2 right-2">
                                        <icon name="play_arrow" :size="22" color="#FFFFFF" />
                                    </column>
                                </stack>
                            </pressable>
                        @endif
                        <column class="flex-1 gap-[2]">
                            @foreach ([1, 2] as $slot)
                                @if (isset($row[$slot]))
                                    <pressable @tap="viewPost({{ $row[$slot]['id'] }})" class="w-full" a11y-label="View post">
                                        <image
                                            src="{{ $row[$slot]['imageUrl'] }}"
                                            alt="{{ \Illuminate\Support\Str::limit($row[$slot]['caption'], 60) }}"
                                            class="w-full h-[125]"
                                            :fit="2"
                                        />
                                    </pressable>
                                @endif
                            @endforeach
                        </column>
                    </row>
                @endif
            @endforeach
        </column>

        <spacer class="h-[20]" />

    </column>
</scroll-view>
