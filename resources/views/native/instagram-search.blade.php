<scroll-view class="w-full h-full bg-white safe-area">
    <column class="w-full gap-0 ">

        {{-- Search Bar --}}
        <column class="w-full px-4 pt-3 pb-2">
            <row class="w-full bg-[#EFEFEF] rounded-lg px-3 py-2 items-center gap-2">
                <icon name="search" :size="20" color="#8E8E8E" />
                <text class="text-[15] text-[#8E8E8E]">Search</text>
            </row>
        </column>

        {{-- Category Chips --}}
        <scroll-view horizontal>
            <row class="gap-2 px-4 pb-3">
                @foreach (['IGTV', 'Travel', 'Architecture', 'Food', 'Art', 'Nature', 'Fitness', 'Style'] as $tag)
                    <chip label="{{ $tag }}" />
                @endforeach
            </row>
        </scroll-view>

        {{-- Explore Grid --}}
        <column class="w-full gap-1">
            @foreach (array_chunk($posts, 3) as $rowIndex => $row)
                @if ($rowIndex % 2 === 0)
                    {{-- Standard 3-column row --}}
                    <row class="w-full gap-1 justify-start">
                        @foreach ($row as $index => $post)
                            <column @press="viewPost({{ array_search($post, $posts) }})">
                                <image
                                    src="{{ $post['imageUrl'] }}"
                                    alt="{{ \Illuminate\Support\Str::limit($post['caption'], 60) }}"
                                    class="w-[125] h-[125]"
                                    :fit="2"
                                />
                            </column>
                        @endforeach
                    </row>
                @else
                    {{-- Featured layout: 1 large + 2 stacked --}}
                    <row class="w-full gap-1 justify-start">
                        @if (isset($row[0]))
                            <column @press="viewPost({{ array_search($row[0], $posts) }})">
                                <image
                                    src="{{ $row[0]['imageUrl'] }}"
                                    alt="{{ \Illuminate\Support\Str::limit($row[0]['caption'], 60) }}"
                                    class="w-[250] h-[251]"
                                    :fit="2"
                                />
                            </column>
                        @endif
                        <column class="gap-1">
                            @if (isset($row[1]))
                                <column @press="viewPost({{ array_search($row[1], $posts) }})">
                                    <image
                                        src="{{ $row[1]['imageUrl'] }}"
                                        alt="{{ \Illuminate\Support\Str::limit($row[1]['caption'], 60) }}"
                                        class="w-[125] h-[125]"
                                        :fit="2"
                                    />
                                </column>
                            @endif
                            @if (isset($row[2]))
                                <column @press="viewPost({{ array_search($row[2], $posts) }})">
                                    <image
                                        src="{{ $row[2]['imageUrl'] }}"
                                        alt="{{ \Illuminate\Support\Str::limit($row[2]['caption'], 60) }}"
                                        class="w-[125] h-[125]"
                                        :fit="2"
                                    />
                                </column>
                            @endif
                        </column>
                    </row>
                @endif
            @endforeach
        </column>

        <spacer class="h-[20]" />

    </column>
</scroll-view>
