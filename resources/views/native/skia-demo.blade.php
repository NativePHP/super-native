<scroll-view class="bg-[#060911]">
    <column class="w-full px-4 pt-3 pb-10 gap-4">
        <row class="items-center justify-between">
            <text class="text-xs font-semibold text-[#99a8bb]">SKIA STUDIO / {{ $commercial ? 'COMMERCIAL DEMOS' : ($showcase ? 'COLLECTION 001' : 'THE LAB') }}</text>
            <text class="text-xs text-[#99a8bb]">{{ sprintf('%02d / %02d', ($commercial ? $product : ($showcase ? $exhibit : $chapter)) + 1, $commercial ? count($products) : ($showcase ? count($exhibits) : count($chapters))) }}</text>
        </row>
        <row class="gap-2">
            <button label="Film demos" :variant="$commercial ? 'filled' : 'tonal'" @press="openCommercial" class="flex-1 w-full" />
            <button label="Showcase" :variant="$showcase ? 'filled' : 'tonal'" @press="openShowcase" class="flex-1 w-full" />
            <button label="Lab" :variant="! $commercial && ! $showcase ? 'filled' : 'tonal'" @press="openLab" class="flex-1 w-full" />
        </row>
        @if($commercial)
            <column class="gap-2">
                <text class="text-3xl font-bold text-[#f4f5fa]">{{ $current['title'] }}</text>
                <text class="text-sm text-[#c3ccda]">{{ $current['description'] }}</text>
            </column>
            <skia-canvas native:key="skia-commercial-{{ $product }}-{{ $replay }}" :scene="$scene" fit="contain" :animated="true" canvas-id="skia-studio" :class="$product === 0 ? 'w-full h-[400] rounded-2xl' : 'w-full h-72 rounded-2xl'" :a11y-label="$current['title'].' native animation'" />
            <row class="gap-2">
                <button label="Previous" variant="tonal" @press="previousCommercial" class="flex-1 w-full" />
                <button label="Replay" @press="replayCommercial" class="flex-1 w-full" />
                <button label="Next" variant="tonal" @press="nextCommercial" class="flex-1 w-full" />
            </row>
            <text class="text-sm font-semibold text-[#c3ccda]">All 18 commercial examples</text>
            @foreach(array_chunk($products, 3, true) as $group)
                <row class="gap-2">
                    @foreach($group as $index => $item)
                        <button :label="$item['label']" :variant="$product === $index ? 'filled' : 'tonal'" @press="selectCommercial({{ $index }})" class="flex-1 w-full" />
                    @endforeach
                </row>
            @endforeach
        @elseif($showcase)
            <skia-canvas native:key="skia-studio-canvas" :scene="$scene" fit="contain" :animated="$playing" canvas-id="skia-studio" class="w-full h-[440] rounded-2xl" :a11y-label="$current['title'].' animated artwork'" />
            <row class="gap-2">
                @foreach($exhibits as $index => $item)
                    <button :label="$item['label']" :variant="$exhibit === $index ? 'filled' : 'tonal'" @press="selectExhibit({{ $index }})" class="flex-1 w-full" />
                @endforeach
            </row>
            <text class="text-sm text-[#c3ccda]">{{ $current['description'] }}</text>
            <row class="gap-2">
                <button :label="$playing ? 'Pause' : 'Play'" variant="outlined" @press="toggleMotion" class="flex-1 w-full" />
                <button label="Recolor" variant="outlined" @press="changePalette" class="flex-1 w-full" />
                <button label="Next" variant="outlined" @press="nextExhibit" class="flex-1 w-full" />
            </row>
            <column class="gap-2">
                <row class="justify-between">
                    <text class="text-xs text-[#99a8bb]">{{ ['Light field', 'Distortion', 'Orbital speed', 'Traffic speed'][$exhibit] }}</text>
                    <text class="text-xs text-[#99a8bb]">{{ round($intensity) }}%</text>
                </row>
                <slider native:model.live="intensity" :min="0" :max="100" class="w-full" a11y-label="Artwork intensity" />
            </column>
            <text class="text-xs text-[#73849b]">{{ $current['technique'] }}</text>
            <button :label="'Open the '.count($chapters).'-part feature lab'" variant="tonal" @press="openLab" class="w-full" />
        @else
            <column class="gap-2">
                <text class="text-3xl font-bold text-[#f4f5fa]">{{ $current['title'] }}</text>
                <text class="text-sm text-[#99a8bb]">{{ $current['description'] }}</text>
            </column>
            <skia-canvas native:key="skia-studio-canvas" :scene="$scene" :fit="$fit" :animated="$playing && in_array($chapter, [9, 13, 15, 18, 19, 25, 30])" :interactive="in_array($chapter, [10, 16, 20, 24, 26, 27, 28, 29, 30])" canvas-id="skia-studio" class="w-full h-80 rounded-3xl" a11y-label="Skia drawing preview" />
            <row class="gap-3">
                <button label="Previous" variant="tonal" @press="previousChapter" class="flex-1 w-full" />
                <button label="Next chapter" @press="nextChapter" class="flex-1 w-full" />
            </row>
            @if(in_array($chapter, [4, 8, 11, 13, 23]))
                <column class="gap-2">
                    <text class="text-sm font-semibold text-[#f4f5fa]">{{ $chapter === 11 ? 'Shape density' : ($chapter === 13 ? 'Playback speed' : 'Intensity') }} · {{ round($intensity) }}%</text>
                    <slider native:model.live="intensity" :min="0" :max="100" class="w-full" a11y-label="Drawing intensity" />
                </column>
            @endif
            <row class="gap-2">
                <button label="Palette" variant="outlined" @press="changePalette" class="flex-1 w-full" />
                <button :label="ucfirst($fit)" variant="outlined" @press="changeFit" class="flex-1 w-full" />
                @if(in_array($chapter, [9, 13, 15, 18, 19, 25, 30]))
                    <button :label="$playing ? 'Pause' : 'Play'" variant="outlined" @press="toggleMotion" class="flex-1 w-full" />
                @endif
            </row>
            @if($chapter === 26)
                <row class="gap-2">
                    <button label="Replace shape" @press="updateShape" class="flex-1 w-full" />
                    <button label="Spring" @press="springShape" class="flex-1 w-full" />
                </row>
            @elseif($chapter === 27)
                <row class="gap-2">
                    <button label="Rotate 15°" @press="rotatePoster" class="flex-1 w-full" />
                    <button label="Reset poster" @press="resetPoster" class="flex-1 w-full" />
                </row>
            @elseif($chapter === 28)
                <row class="gap-2">
                    <button label="Earlier" @press="moveChart(-1)" class="flex-1 w-full" />
                    <button label="Later" @press="moveChart(1)" class="flex-1 w-full" />
                </row>
            @elseif($chapter === 29)
                <row class="gap-2">
                    <button label="Ink color" @press="changeInk" class="flex-1 w-full" />
                    <button label="Undo" @press="undoInk" class="flex-1 w-full" />
                    <button label="Clear" @press="clearInk" class="flex-1 w-full" />
                </row>
            @endif
            @if($chapter === 17 || $chapter >= 26)
                <row class="gap-2">
                    @foreach(['png', 'jpeg', 'webp', 'pdf'] as $format)
                        <button :label="strtoupper($format)" @press="exportFrame('{{ $format }}')" class="flex-1 w-full" />
                    @endforeach
                </row>
            @endif
            @if($exportPath !== '')
                <button label="Share last export" variant="tonal" @press="shareExport" class="w-full" />
            @endif
            @if($chapter >= 16)
                <text class="text-sm text-[#83e2be]">{{ $status }}</text>
            @endif
            @foreach(array_chunk($chapters, 3, true) as $group)
                <row class="gap-2">
                    @foreach($group as $index => $item)
                        <button :label="$item['label']" :variant="$chapter === $index ? 'filled' : 'tonal'" @press="selectChapter({{ $index }})" class="flex-1 w-full" />
                    @endforeach
                </row>
            @endforeach
            <button label="Back to the showcase" variant="tonal" @press="openShowcase" class="w-full" />
        @endif
        @if((! $commercial && ! $showcase && $chapter === 10) || str_starts_with($status, 'Renderer:'))
            <text class="text-sm text-[#ffb5ce]">{{ $status }}</text>
        @endif
    </column>
</scroll-view>
