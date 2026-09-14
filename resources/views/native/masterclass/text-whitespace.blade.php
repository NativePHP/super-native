<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-8">

        <column class="gap-1">
            <text class="text-2xl font-bold">#336 · Text whitespace</text>
            <text class="text-sm opacity-60">
                The same three-line message through slot and attribute. Both
                paths must agree, on iOS and Android alike.
            </text>
        </column>

        {{-- 1 + 2. Default collapses on BOTH paths now — the browser default. --}}
        <column class="gap-2">
            <text class="text-lg font-bold">1. Slot, default</text>
            <text class="text-sm opacity-60">One run-on line, like a browser.</text>
            <column class="w-full rounded-2xl bg-gray-200 px-4 py-3">
                <text>{{ $message }}</text>
            </column>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">2. :text attribute, default</text>
            <text class="text-sm opacity-60">Now collapses too — slot and attribute agree. Used to be verbatim.</text>
            <column class="w-full rounded-2xl bg-gray-200 px-4 py-3">
                <text :text="$message" />
            </column>
        </column>

        {{-- 3 + 4. The opt-out keeps breaks on BOTH paths. --}}
        <column class="gap-2">
            <text class="text-lg font-bold">3. Slot, whitespace-pre-line</text>
            <text class="text-sm opacity-60">Blank line and line break preserved.</text>
            <column class="w-full rounded-2xl bg-green-200 px-4 py-3">
                <text class="whitespace-pre-line">{{ $message }}</text>
            </column>
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">4. :text attribute, whitespace-pre-line</text>
            <text class="text-sm opacity-60">Same class, same result on the attribute path.</text>
            <column class="w-full rounded-2xl bg-green-200 px-4 py-3">
                <text class="whitespace-pre-line" :text="$message" />
            </column>
        </column>

        {{-- 5. Author-wrapped template text flows under the default, breaks under pre-line. --}}
        <column class="gap-2">
            <text class="text-lg font-bold">5. Wrapped template text</text>
            <text class="text-sm opacity-60">Top: default, flows as one sentence. Bottom: pre-line, breaks where the template does.</text>
            <column class="w-full rounded-2xl bg-gray-200 px-4 py-3">
                <text>
                    A long sentence that I wrapped
                    over two lines in my editor.
                </text>
            </column>
            <column class="w-full rounded-2xl bg-green-200 px-4 py-3">
                <text class="whitespace-pre-line">
                    A long sentence that I wrapped
                    over two lines in my editor.
                </text>
            </column>
        </column>

        {{-- 6. pre-wrap keeps indentation bytes too. --}}
        <column class="gap-2">
            <text class="text-lg font-bold">6. whitespace-pre-wrap</text>
            <text class="text-sm opacity-60">Indentation kept. Default would flatten it to one line.</text>
            <column class="w-full rounded-2xl bg-gray-900 px-4 py-3">
                <text class="whitespace-pre-wrap font-mono text-sm text-green-300">{{ $code }}</text>
            </column>
        </column>

        {{-- 7. A nested run inherits the closest classed ancestor. --}}
        <column class="gap-2">
            <text class="text-lg font-bold">7. Nested run inherits</text>
            <text class="text-sm opacity-60">The bold run has no class of its own; it keeps its break because the parent is pre-line.</text>
            <column class="w-full rounded-2xl bg-green-200 px-4 py-3">
                <text class="whitespace-pre-line">Plain run, line one
line two, then <text class="font-bold">a bold run
on its own line</text> and a tail.</text>
            </column>
        </column>

    </column>
</scroll-view>
