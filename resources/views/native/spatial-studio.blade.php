<scroll-view class="bg-[#f7f8fc]">
    <column class="w-full px-4 pt-3 pb-10 gap-4">
        <row class="items-center justify-between">
            <text class="text-sm font-bold text-[#5940b8]">SKIA / SPATIAL LAB</text>
            <text class="text-sm font-semibold text-[#47526b]">{{ sprintf('%02d / %02d', $demo + 1, count($demos)) }}</text>
        </row>
        <text class="text-3xl font-bold text-[#172039]">{{ $current['title'] }}</text>
        <skia-canvas native:key="spatial-{{ $demo }}-{{ $revision }}" :scene="$scene" :animated="$playing" :interactive="true" canvas-id="spatial-studio" fit="contain" class="w-full h-[380] rounded-2xl" :a11y-label="$current['title']" />
        <row class="gap-2">
            <button label="Previous" variant="tonal" @press="previousDemo" class="flex-1 w-full" />
            <button :label="$playing ? 'Pause' : 'Play'" @press="toggleMotion" class="flex-1 w-full" />
            <button label="Next" variant="tonal" @press="nextDemo" class="flex-1 w-full" />
        </row>
        <text class="text-base text-[#303c57]">{{ $current['description'] }}</text>
        <text class="text-sm text-[#40355d]">The scrubber runs entirely on the native rendering thread. Drag to hold a pose; reset to resume the demo.</text>
        <row class="gap-2">
            <button label="Back 10%" variant="tonal" @press="adjustPose(-0.1)" class="flex-1 w-full" />
            <button label="Reset" variant="tonal" @press="resetDemo" class="flex-1 w-full" />
            <button label="Ahead 10%" variant="tonal" @press="adjustPose(0.1)" class="flex-1 w-full" />
        </row>
        @if($demo === 9)
            <button label="Clear signature" @press="clearInk" class="w-full" />
        @endif
        <text class="text-base font-semibold text-[#172039]">{{ $current['api'] }}</text>
        @if($status !== '')
            <text class="text-base font-semibold text-[#5940b8]">{{ $status }}</text>
        @endif
        <text class="text-xl font-bold text-[#172039]">Explore all {{ count($demos) }} examples</text>
        @foreach(array_chunk($demos, 3, true) as $group)
            <row class="gap-2">
                @foreach($group as $index => $item)
                    <button :label="$item['label']" :variant="$demo === $index ? 'filled' : 'tonal'" @press="selectDemo({{ $index }})" class="flex-1 w-full" />
                @endforeach
            </row>
        @endforeach
        <row class="gap-2">
            <button label="Save PNG" variant="tonal" @press="exportFrame('png')" class="flex-1 w-full" />
            <button label="Save PDF" variant="tonal" @press="exportFrame('pdf')" class="flex-1 w-full" />
        </row>
        @if($exportPath !== '')
            <button label="Share export" @press="shareExport" class="w-full" />
        @endif
        <text class="text-sm text-[#47526b]">Spatial surfaces rendered with Skia. Depth uses painter ordering; intersecting solid models need a full 3D renderer. PDF exports flatten spatial artwork.</text>
    </column>
</scroll-view>
