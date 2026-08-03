{{-- Page wrapper: scroll-view with theme.background + safe-area. --}}
<scroll-view class="flex-1 w-full bg-theme-background">
    <column class="flex-1 p-5 gap-5 safe-area">

        {{-- ============================================= --}}
        {{-- HEADER --}}
        {{-- ============================================= --}}
        <column class="gap-1">
            <text class="text-4xl text-red-500 font-extrabold ">Hello World</text>
            <text class="text-sm text-gray-400 ">Every core primitive, styled to the nines
            </text>
        </column>

        <divider/>

        {{-- ============================================= --}}
        {{-- LIST (Pull-to-Refresh + Infinite Scroll) --}}
        {{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700">List</text>--}}
{{--        <text class="text-sm text-gray-400">{{ count($items) }} items · Refreshed {{ $refreshCount }}x · Pull down or scroll to bottom</text>--}}

{{--        <list @refresh="refreshList" @endReached="loadMore" separator class="h-[500] w-full bg-gray-50 rounded-lg">--}}
{{--            @foreach ($items as $item)--}}
{{--                <row @swipeDelete="removeItem({{ $item['id'] }})" class="px-4 py-3 gap-3 items-center bg-white ">--}}
{{--                    <column class="w-[40] h-[40] rounded-full bg-blue-500 items-center justify-center">--}}
{{--                        <text class="text-white font-bold text-base">{{ substr($item['name'], 0, 1) }}</text>--}}
{{--                    </column>--}}
{{--                    <column class="flex-1 gap-0.5">--}}
{{--                        <text class="text-sm font-semibold text-gray-900 ">{{ $item['name'] }}</text>--}}
{{--                        <text class="text-sm text-gray-600 ">{{ $item['description'] }}</text>--}}
{{--                        <text class="text-sm text-gray-400">{{ $item['email'] }} · {{ $item['city'] }}</text>--}}
{{--                    </column>--}}
{{--                </row>--}}
{{--            @endforeach--}}
{{--        </list>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- MODAL --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 dark:text-gray-300">Overlays</text>--}}

{{--        <row class="gap-3">--}}
{{--            <button @tap="openModal" class="bg-indigo-500 rounded-lg px-5 py-3 flex-1 text-center">--}}
{{--                Full-Screen Modal--}}
{{--            </button>--}}
{{--            <button @tap="openSheet" class="bg-teal-500 rounded-lg px-5 py-3 flex-1">--}}
{{--                Bottom Sheet--}}
{{--            </button>--}}
{{--        </row>--}}

{{--        <modal :visible="$showModal" @dismiss="closeModal">--}}
{{--            <column class="flex-1 p-6 gap-4 bg-white ">--}}
{{--                <text class="text-2xl font-bold ">Full-Screen Modal</text>--}}
{{--                <text class="text-gray-600 ">This is a full-screen modal overlay. Tap the X or press back to dismiss.</text>--}}
{{--                <divider/>--}}
{{--                <text class="text-sm text-[]]0">You can put any content here — forms, lists, images, anything.</text>--}}
{{--                <button @tap="closeModal" class="bg-red-500 rounded-lg px-5 py-3 mt-4">--}}
{{--                    Close Modal--}}
{{--                </button>--}}
{{--            </column>--}}
{{--        </modal>--}}

{{--        <bottom-sheet :visible="$showSheet" @dismiss="closeSheet" detents="medium">--}}
{{--            <column class="px-5 pt-2 pb-8 gap-3">--}}
{{--                <text class="text-lg font-bold dark:text-white">Bottom Sheet</text>--}}
{{--                <text class="text-sm text-gray-400">Drag down or tap outside to dismiss.</text>--}}
{{--                <divider/>--}}
{{--                --}}{{-- List rows composed from primitives (icon + column(headline + supporting)) --}}
{{--                @foreach ([--}}
{{--                    ['icon' => 'star',     'headline' => 'Option 1', 'supporting' => 'First option'],--}}
{{--                    ['icon' => 'favorite', 'headline' => 'Option 2', 'supporting' => 'Second option'],--}}
{{--                    ['icon' => 'settings', 'headline' => 'Option 3', 'supporting' => 'Third option'],--}}
{{--                ] as $row)--}}
{{--                    <row class="items-center gap-3 py-2">--}}
{{--                        <icon :name="$row['icon']" :size="24" color="#475569"/>--}}
{{--                        <column class="flex-1 gap-0">--}}
{{--                            <text class="text-base font-medium">{{ $row['headline'] }}</text>--}}
{{--                            <text class="text-sm text-gray-500">{{ $row['supporting'] }}</text>--}}
{{--                        </column>--}}
{{--                    </row>--}}
{{--                @endforeach--}}
{{--                <button variant="primary" @tap="closeSheet">Done</button>--}}
{{--            </column>--}}
{{--        </bottom-sheet>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- TYPOGRAPHY --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Typography</text>--}}
{{--        <column class="w-full gap-2">--}}
{{--            <text class="text-xs text-gray-600 ">text-xs (12pt) — The quick brown fox</text>--}}
{{--            <text class="text-sm text-gray-600 ">text-sm (14pt) — The quick brown fox</text>--}}
{{--            <text class="text-gray-600 ">(16pt) — The quick brown fox</text>--}}
{{--            <text class="text-lg text-gray-600 ">text-lg (18pt) — The quick brown fox</text>--}}
{{--            <text class="text-xl text-gray-600 ">text-xl (20pt) — The quick brown fox</text>--}}
{{--            <text class="text-2xl font-bold text-gray-600 ">text-2xl bold</text>--}}
{{--            <text class="text-3xl font-extrabold text-gray-600 ">text-3xl extrabold</text>--}}
{{--        </column>--}}

{{--        <column class="w-full gap-1 mt-2">--}}
{{--            <text class="font-thin text-gray-600 dark:text-purple-600">font-thin</text>--}}
{{--            <text class="font-light text-gray-600 dark:text-purple-600">font-light</text>--}}
{{--            <text class="font-normal text-gray-600 dark:text-purple-600">font-normal</text>--}}
{{--            <text class="font-medium text-gray-600 dark:text-purple-600">font-medium</text>--}}
{{--            <text class="font-semibold text-gray-600 dark:text-purple-600">font-semibold</text>--}}
{{--            <text class="font-bold text-gray-600 dark:text-purple-600">font-bold</text>--}}
{{--            <text class="font-extrabold text-gray-600 dark:text-purple-600">font-extrabold</text>--}}
{{--        </column>--}}

{{--        <column class="w-full gap-1 mt-2">--}}
{{--            <text class="text-left w-full ">text-left aligned</text>--}}
{{--            <text class="text-center w-full ">text-center aligned</text>--}}
{{--            <text class="text-right w-full ">text-right aligned</text>--}}
{{--        </column>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- ALL TAILWIND COLORS --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">All Tailwind Colors</text>--}}

{{--        --}}{{-- Slate --}}
{{--        <text class="text-sm text-gray-500 ">Slate</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-slate-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-slate-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-slate-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-slate-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-slate-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-slate-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-slate-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-slate-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-slate-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Gray --}}
{{--        <text class="text-sm text-gray-500 ">Gray</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-gray-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-gray-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-gray-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-gray-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-gray-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-gray-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-gray-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-gray-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-gray-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Zinc --}}
{{--        <text class="text-sm text-gray-500 ">Zinc</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-zinc-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-zinc-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-zinc-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-zinc-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-zinc-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-zinc-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-zinc-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-zinc-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-zinc-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Neutral --}}
{{--        <text class="text-sm text-gray-500 ">Neutral</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-neutral-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-neutral-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-neutral-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-neutral-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-neutral-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-neutral-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-neutral-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-neutral-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-neutral-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Stone --}}
{{--        <text class="text-sm text-gray-500 ">Stone</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-stone-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-stone-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-stone-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-stone-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-stone-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-stone-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-stone-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-stone-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-stone-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Red --}}
{{--        <text class="text-sm text-gray-500 ">Red</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-red-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-red-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-red-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-red-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-red-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-red-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-red-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-red-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-red-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Orange --}}
{{--        <text class="text-sm text-gray-500 ">Orange</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-orange-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-orange-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-orange-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-orange-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-orange-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-orange-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-orange-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-orange-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-orange-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Amber --}}
{{--        <text class="text-sm text-gray-500 ">Amber</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-amber-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-amber-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-amber-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-amber-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-amber-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-amber-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-amber-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-amber-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-amber-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Yellow --}}
{{--        <text class="text-sm text-gray-500 ">Yellow</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-yellow-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-yellow-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-yellow-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-yellow-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-yellow-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-yellow-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-yellow-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-yellow-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-yellow-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Lime --}}
{{--        <text class="text-sm text-gray-500 ">Lime</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-lime-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-lime-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-lime-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-lime-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-lime-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-lime-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-lime-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-lime-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-lime-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Green --}}
{{--        <text class="text-sm text-gray-500 ">Green</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-green-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-green-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-green-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-green-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-green-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-green-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-green-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-green-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-green-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Emerald --}}
{{--        <text class="text-sm text-gray-500 ">Emerald</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-emerald-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-emerald-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-emerald-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-emerald-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-emerald-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-emerald-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-emerald-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-emerald-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-emerald-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Teal --}}
{{--        <text class="text-sm text-gray-500 ">Teal</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-teal-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-teal-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-teal-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-teal-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-teal-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-teal-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-teal-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-teal-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-teal-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Cyan --}}
{{--        <text class="text-sm text-gray-500 ">Cyan</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-cyan-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-cyan-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-cyan-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-cyan-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-cyan-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-cyan-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-cyan-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-cyan-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-cyan-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Sky --}}
{{--        <text class="text-sm text-gray-500 ">Sky</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-sky-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-sky-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-sky-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-sky-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-sky-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-sky-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-sky-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-sky-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-sky-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Blue --}}
{{--        <text class="text-sm text-gray-500 ">Blue</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-blue-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-blue-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-blue-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-blue-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-blue-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-blue-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-blue-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-blue-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-blue-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Indigo --}}
{{--        <text class="text-sm text-gray-500 ">Indigo</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-indigo-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-indigo-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-indigo-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-indigo-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-indigo-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-indigo-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-indigo-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-indigo-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-indigo-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Violet --}}
{{--        <text class="text-sm text-gray-500 ">Violet</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-violet-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-violet-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-violet-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-violet-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-violet-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-violet-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-violet-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-violet-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-violet-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Purple --}}
{{--        <text class="text-sm text-gray-500 ">Purple</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-purple-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-purple-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-purple-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-purple-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-purple-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-purple-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-purple-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-purple-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-purple-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Fuchsia --}}
{{--        <text class="text-sm text-gray-500 ">Fuchsia</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-fuchsia-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-fuchsia-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-fuchsia-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-fuchsia-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-fuchsia-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-fuchsia-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-fuchsia-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-fuchsia-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-fuchsia-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Pink --}}
{{--        <text class="text-sm text-gray-500 ">Pink</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-pink-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-pink-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-pink-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-pink-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-pink-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-pink-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-pink-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-pink-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-pink-900"/>--}}
{{--        </row>--}}

{{--        --}}{{-- Rose --}}
{{--        <text class="text-sm text-gray-500 ">Rose</text>--}}
{{--        <row class="w-full gap-1">--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-rose-100"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-rose-200"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-rose-300"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-rose-400"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-rose-500"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-rose-600"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-rose-700"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-rose-800"/>--}}
{{--            <column class="flex-1 h-[32] rounded-sm bg-rose-900"/>--}}
{{--        </row>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- BUTTONS — new semantic API --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Buttons</text>--}}

{{--        --}}{{-- Variants (primary / secondary / destructive / ghost) --}}
{{--        <text class="text-sm text-gray-500">Variants</text>--}}
{{--        <row class="w-full gap-2 flex-wrap items-center">--}}
{{--            <button class="text-xs" variant="primary" @tap="increment">Primary</button>--}}
{{--            <button class="text-xs" variant="secondary" @tap="increment">Secondary</button>--}}
{{--            <button class="text-xs" variant="destructive" @tap="decrement">Destructive</button>--}}
{{--            <button class="text-xs" variant="ghost" @tap="increment">Ghost</button>--}}
{{--        </row>--}}

{{--        --}}{{-- Sizes --}}
{{--        <text class="text-sm text-gray-500">Sizes</text>--}}
{{--        <row class="w-full gap-2 items-center flex-wrap">--}}
{{--            <button variant="primary" size="sm" @tap="increment">Small</button>--}}
{{--            <button variant="primary" size="md" @tap="increment">Medium</button>--}}
{{--            <button variant="primary" size="lg" @tap="increment">Large</button>--}}
{{--        </row>--}}

{{--        --}}{{-- Icons (leading + trailing) --}}
{{--        --}}{{-- Prefer short generic names ("add", "edit", "delete", "settings") —--}}
{{--             they're in IconHelper's manual map on iOS and Material's canonical--}}
{{--             names on Android. For icons without a map entry, use dotted SF--}}
{{--             Symbol paths ("arrow.right", "minus.circle.fill") which iOS passes--}}
{{--             through directly. --}}
{{--        <text class="text-sm text-gray-500">With icons</text>--}}
{{--        <row class="w-full gap-2 items-center flex-wrap">--}}
{{--            <button variant="primary" icon="add" @tap="increment">Add item</button>--}}
{{--            <button variant="secondary" icon-trailing="arrow.right" @tap="increment">Next</button>--}}
{{--            <button variant="destructive" icon="delete" @tap="decrement">Delete</button>--}}
{{--        </row>--}}

{{--        --}}{{-- Icon-only (needs a11y-label) --}}
{{--        <text class="text-sm text-gray-500">Icon-only</text>--}}
{{--        <row class="w-full gap-2 items-center">--}}
{{--            <button variant="primary" icon="add" a11y-label="Add" @tap="increment"/>--}}
{{--            <button variant="secondary" icon="edit" a11y-label="Edit" @tap="increment"/>--}}
{{--            <button variant="destructive" icon="delete" a11y-label="Delete" @tap="decrement"/>--}}
{{--            <button variant="ghost" icon="settings" a11y-label="Settings" @tap="increment"/>--}}
{{--        </row>--}}

{{--        --}}{{-- States --}}
{{--        <text class="text-sm text-gray-500">States</text>--}}
{{--        <row class="w-full gap-2 items-center flex-wrap">--}}
{{--            <button variant="primary" @tap="increment">Enabled</button>--}}
{{--            <button variant="primary" disabled @tap="increment">Disabled</button>--}}
{{--            <button variant="primary" loading @tap="increment">Loading</button>--}}
{{--        </row>--}}

{{--        --}}{{-- Custom look — escape hatch via <pressable> --}}
{{--        --}}{{-- Use this when Model 3 constraints on <button> are too strict. --}}
{{--        <text class="text-sm text-gray-500">Custom look (via pressable)</text>--}}
{{--        <scroll-view :horizontal="true" class="w-full h-[44]">--}}
{{--            <row class="gap-2 h-[44]">--}}
{{--                <pressable @tap="increment" class="bg-pink-500 rounded-full px-6 py-2 items-center justify-center">--}}
{{--                    <text class="text-white font-semibold">Pink Pill</text>--}}
{{--                </pressable>--}}
{{--                <pressable @tap="increment" class="bg-teal-500 rounded-full px-6 py-2 items-center justify-center">--}}
{{--                    <text class="text-white font-semibold">Teal Pill</text>--}}
{{--                </pressable>--}}
{{--                <pressable @tap="increment" class="bg-rose-500 rounded-full px-6 py-2 items-center justify-center">--}}
{{--                    <text class="text-white font-semibold">Rose Pill</text>--}}
{{--                </pressable>--}}
{{--                <pressable @tap="increment" class="border-2 border-blue-500 rounded-lg px-5 py-2 items-center justify-center">--}}
{{--                    <text class="text-blue-500 font-semibold">Outlined blue</text>--}}
{{--                </pressable>--}}
{{--                <pressable @tap="increment" class="border-2 border-red-500 rounded-lg px-5 py-2 items-center justify-center">--}}
{{--                    <text class="text-red-500 font-semibold">Outlined red</text>--}}
{{--                </pressable>--}}
{{--            </row>--}}
{{--        </scroll-view>--}}

{{--        --}}{{-- Icon circles — still via pressable (custom shape + color) --}}
{{--        <row class="w-full gap-3 items-center">--}}
{{--            <pressable @tap="increment"--}}
{{--                              class="w-[48] h-[48] rounded-full bg-blue-500 items-center justify-center">--}}
{{--                <icon name="add" :size="24" color="#FFFFFF"/>--}}
{{--            </pressable>--}}
{{--            <pressable @tap="decrement"--}}
{{--                              class="w-[48] h-[48] rounded-full bg-red-500 items-center justify-center">--}}
{{--                <icon name="minus.circle.fill" :size="24" color="#FFFFFF"/>--}}
{{--            </pressable>--}}
{{--            <pressable @tap="increment"--}}
{{--                              class="w-[48] h-[48] rounded-full bg-green-500 items-center justify-center">--}}
{{--                <icon name="check" :size="24" color="#FFFFFF"/>--}}
{{--            </pressable>--}}
{{--            <pressable @tap="increment"--}}
{{--                              class="w-[48] h-[48] rounded-full bg-purple-500 items-center justify-center">--}}
{{--                <icon name="star" :size="24" color="#FFFFFF"/>--}}
{{--            </pressable>--}}
{{--            <pressable @tap="increment"--}}
{{--                              class="w-[48] h-[48] rounded-full bg-amber-500 items-center justify-center">--}}
{{--                <icon name="favorite" :size="24" color="#FFFFFF"/>--}}
{{--            </pressable>--}}
{{--        </row>--}}

{{--        <divider/>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- THEME & SURFACES --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold">Theme & Surfaces</text>--}}
{{--        <text class="text-sm text-gray-500">All colors below come from the active theme. Toggle system dark mode to see them flip.</text>--}}

{{--        --}}{{-- Color token swatches. `bg-theme-<token>` + `text-theme-on-<token>`--}}
{{--             resolve against `config/native-ui.php`. Tokens are LIGHT-mode hex--}}
{{--             values at parse time; full dark-mode component theming is handled--}}
{{--             at the layout wrapper (see <x-layouts.app>) plus theme-aware classes. --}}
{{--        <row class="w-full gap-2 flex-wrap">--}}
{{--            <column class="flex-1 h-[72] rounded-lg p-3 bg-theme-primary justify-center items-center min-w-[120]">--}}
{{--                <text class="font-semibold text-theme-on-primary">Primary</text>--}}
{{--                <text class="text-xs text-theme-on-primary">on-primary</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[72] rounded-lg p-3 bg-theme-secondary justify-center items-center min-w-[120]">--}}
{{--                <text class="font-semibold text-theme-on-secondary">Secondary</text>--}}
{{--                <text class="text-xs text-theme-on-secondary">on-secondary</text>--}}
{{--            </column>--}}
{{--        </row>--}}
{{--        <row class="w-full gap-2 flex-wrap">--}}
{{--            <column class="flex-1 h-[72] rounded-lg p-3 bg-theme-destructive justify-center items-center min-w-[120]">--}}
{{--                <text class="font-semibold text-theme-on-destructive">Destructive</text>--}}
{{--                <text class="text-xs text-theme-on-destructive">on-destructive</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[72] rounded-lg p-3 bg-theme-accent justify-center items-center min-w-[120]">--}}
{{--                <text class="font-semibold text-theme-on-accent">Accent</text>--}}
{{--                <text class="text-xs text-theme-on-accent">on-accent</text>--}}
{{--            </column>--}}
{{--        </row>--}}

{{--        --}}{{-- Surface-on-background: demonstrates visual hierarchy. The outer--}}
{{--             scroll-view is painting theme.background; this column uses--}}
{{--             theme.surface. On most themes surface is subtly lighter than--}}
{{--             background — notice how the surface visibly "floats" on the page. --}}
{{--        <column class="bg-theme-surface rounded-lg p-4 gap-2">--}}
{{--            <text class="font-semibold text-theme-on-surface">Surface card</text>--}}
{{--            <text class="text-sm text-theme-on-surface">--}}
{{--                This column uses `bg-theme-surface` and its text uses `text-theme-on-surface`.--}}
{{--                Cards, sheets, and list rows use these tokens so they pop off the background.--}}
{{--            </text>--}}
{{--        </column>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- INTERACTIVE COUNTER --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Interactive Counter</text>--}}
{{--        <row class="w-full gap-4 items-center justify-center">--}}
{{--            <button variant="destructive" size="lg" icon="minus.circle.fill" a11y-label="Decrement" @tap="decrement"/>--}}
{{--            <column class="w-[80] h-[80] rounded-2xl bg-indigo-600 items-center justify-center shadow-lg">--}}
{{--                <text class="text-white font-extrabold text-3xl">{{ $count }}</text>--}}
{{--            </column>--}}
{{--            <button variant="primary" size="lg" icon="add" a11y-label="Increment" @tap="increment"/>--}}
{{--        </row>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- NATIVE EVENT LISTENER --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Native Events</text>--}}
{{--        <button variant="primary" size="lg" @tap="showAlert">Show Alert</button>--}}
{{--        @if($lastButton)--}}
{{--            <text class="text-gray-600 ">You pressed: {{ $lastButton }}</text>--}}
{{--        @endif--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- BORDER RADIUS — horizontal scroll --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Border Radius</text>--}}
{{--        <scroll-view :horizontal="true" class="w-full h-[80]">--}}
{{--            <row class="gap-3 items-center h-[64]">--}}
{{--                <column class="w-[56] h-[56] bg-sky-500 rounded-none items-center justify-center">--}}
{{--                    <text class="text-white text-sm">none</text>--}}
{{--                </column>--}}
{{--                <column class="w-[56] h-[56] bg-sky-500 rounded-sm items-center justify-center">--}}
{{--                    <text class="text-white text-sm">sm</text>--}}
{{--                </column>--}}
{{--                <column class="w-[56] h-[56] bg-sky-500 rounded-md items-center justify-center">--}}
{{--                    <text class="text-white text-sm">md</text>--}}
{{--                </column>--}}
{{--                <column class="w-[56] h-[56] bg-sky-500 rounded-lg items-center justify-center">--}}
{{--                    <text class="text-white text-sm">lg</text>--}}
{{--                </column>--}}
{{--                <column class="w-[56] h-[56] bg-sky-500 rounded-xl items-center justify-center">--}}
{{--                    <text class="text-white text-sm">xl</text>--}}
{{--                </column>--}}
{{--                <column class="w-[56] h-[56] bg-sky-500 rounded-2xl items-center justify-center">--}}
{{--                    <text class="text-white text-sm">2xl</text>--}}
{{--                </column>--}}
{{--                <column class="w-[56] h-[56] bg-sky-500 rounded-3xl items-center justify-center">--}}
{{--                    <text class="text-white text-sm">3xl</text>--}}
{{--                </column>--}}
{{--                <column class="w-[56] h-[56] bg-sky-500 rounded-full items-center justify-center">--}}
{{--                    <text class="text-white text-sm">full</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </scroll-view>--}}

{{--        <button @navigate.fade="'/doom'" class="w-full bg-red-800 rounded-lg px-5 py-3 text-white font-semibold">--}}
{{--            Play--}}
{{--        </button>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- SHADOWS / ELEVATION --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Shadows & Elevation</text>--}}
{{--        <scroll-view :horizontal="true" class="w-full h-[76]">--}}
{{--            <row class="gap-3 items-center h-[76] px-2">--}}
{{--                <column class="w-[70] h-[60] bg-white rounded-lg shadow-none items-center justify-center">--}}
{{--                    <text class="text-sm text-gray-500 ">none</text>--}}
{{--                </column>--}}
{{--                <column class="w-[70] h-[60] bg-white rounded-lg shadow-sm items-center justify-center">--}}
{{--                    <text class="text-sm text-gray-500 ">sm</text>--}}
{{--                </column>--}}
{{--                <column class="w-[70] h-[60] bg-white rounded-lg shadow-md items-center justify-center">--}}
{{--                    <text class="text-sm text-gray-500 ">md</text>--}}
{{--                </column>--}}
{{--                <column class="w-[70] h-[60] bg-white rounded-lg shadow-lg items-center justify-center">--}}
{{--                    <text class="text-sm text-gray-500 ">lg</text>--}}
{{--                </column>--}}
{{--                <column class="w-[70] h-[60] bg-white rounded-lg shadow-xl items-center justify-center">--}}
{{--                    <text class="text-sm text-gray-500 ">xl</text>--}}
{{--                </column>--}}
{{--                <column class="w-[70] h-[60] bg-white rounded-lg shadow-2xl items-center justify-center">--}}
{{--                    <text class="text-sm text-gray-500 ">2xl</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </scroll-view>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- BORDERS --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Borders</text>--}}
{{--        <row class="w-full gap-3 items-center">--}}
{{--            <column class="flex-1 h-[50] border border-gray-300 rounded-lg items-center justify-center">--}}
{{--                <text class="text-sm text-gray-500 ">1px</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[50] border-2 border-blue-500 rounded-lg items-center justify-center">--}}
{{--                <text class="text-sm text-blue-500">2px blue</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[50] border-4 border-red-500 rounded-lg items-center justify-center">--}}
{{--                <text class="text-sm text-red-500">4px red</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[50] border-4 border-green-500 rounded-full items-center justify-center">--}}
{{--                <text class="text-sm text-green-500">pill</text>--}}
{{--            </column>--}}
{{--        </row>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- OPACITY --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Opacity</text>--}}
{{--        <row class="w-full gap-2 items-center">--}}
{{--            <column class="flex-1 h-[40] bg-blue-500 rounded-md opacity-100 items-center justify-center">--}}
{{--                <text class="text-white text-sm">100</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[40] bg-blue-500 rounded-md opacity-75 items-center justify-center">--}}
{{--                <text class="text-white text-sm">75</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[40] bg-blue-500 rounded-md opacity-50 items-center justify-center">--}}
{{--                <text class="text-white text-sm">50</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[40] bg-blue-500 rounded-md opacity-25 items-center justify-center">--}}
{{--                <text class="text-white text-sm">25</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[40] bg-blue-500 rounded-md opacity-10 items-center justify-center">--}}
{{--                <text class="text-sm ">10</text>--}}
{{--            </column>--}}
{{--        </row>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- ICONS — only mapped SF Symbol names --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Icons</text>--}}
{{--        <text class="text-sm text-gray-400 ">All mapped icon names</text>--}}

{{--        --}}{{-- Row 1: Navigation --}}
{{--        <scroll-view :horizontal="true" class="w-full h-[48]">--}}
{{--            <row class="gap-4 items-center h-[48]">--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="home" :size="24" color="#333333"/>--}}
{{--                    <text class="text-sm text-gray-400 ">home</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="search" :size="24" color="#007AFF"/>--}}
{{--                    <text class="text-sm text-gray-400 ">search</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="settings" :size="24" color="#8E8E93"/>--}}
{{--                    <text class="text-sm text-gray-400 ">settings</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="dashboard" :size="24" color="#5856D6"/>--}}
{{--                    <text class="text-sm text-gray-400 ">dashboard</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="menu" :size="24" color="#333333"/>--}}
{{--                    <text class="text-sm text-gray-400 ">menu</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="person" :size="24" color="#FF2D55"/>--}}
{{--                    <text class="text-sm text-gray-400 ">person</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="profile" :size="24" color="#007AFF"/>--}}
{{--                    <text class="text-sm text-gray-400 ">profile</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </scroll-view>--}}

{{--        --}}{{-- Row 2: Content --}}
{{--        <scroll-view :horizontal="true" class="w-full h-[48]">--}}
{{--            <row class="gap-4 items-center h-[48]">--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="favorite" :size="24" color="#FF3B30"/>--}}
{{--                    <text class="text-sm text-gray-400 ">favorite</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="star" :size="24" color="#FF9500"/>--}}
{{--                    <text class="text-sm text-gray-400 ">star</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="bookmark" :size="24" color="#5856D6"/>--}}
{{--                    <text class="text-sm text-gray-400 ">bookmark</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="photo" :size="24" color="#34C759"/>--}}
{{--                    <text class="text-sm text-gray-400 ">photo</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="camera" :size="24" color="#FF9500"/>--}}
{{--                    <text class="text-sm text-gray-400 ">camera</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="video" :size="24" color="#FF3B30"/>--}}
{{--                    <text class="text-sm text-gray-400 ">video</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="folder" :size="24" color="#007AFF"/>--}}
{{--                    <text class="text-sm text-gray-400 ">folder</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </scroll-view>--}}

{{--        --}}{{-- Row 3: Communication --}}
{{--        <scroll-view :horizontal="true" class="w-full h-[48]">--}}
{{--            <row class="gap-4 items-center h-[48]">--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="mail" :size="24" color="#007AFF"/>--}}
{{--                    <text class="text-sm text-gray-400 ">mail</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="notifications" :size="24" color="#5856D6"/>--}}
{{--                    <text class="text-sm text-gray-400 ">notifications</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="message" :size="24" color="#34C759"/>--}}
{{--                    <text class="text-sm text-gray-400 ">message</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="chat" :size="24" color="#FF9500"/>--}}
{{--                    <text class="text-sm text-gray-400 ">chat</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="phone" :size="24" color="#34C759"/>--}}
{{--                    <text class="text-sm text-gray-400 ">phone</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="share" :size="24" color="#007AFF"/>--}}
{{--                    <text class="text-sm text-gray-400 ">share</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </scroll-view>--}}

{{--        --}}{{-- Row 4: Actions & Status --}}
{{--        <scroll-view :horizontal="true" class="w-full h-[48]">--}}
{{--            <row class="gap-4 items-center h-[48]">--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="add" :size="24" color="#34C759"/>--}}
{{--                    <text class="text-sm text-gray-400 ">add</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="edit" :size="24" color="#007AFF"/>--}}
{{--                    <text class="text-sm text-gray-400 ">edit</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="delete" :size="24" color="#FF3B30"/>--}}
{{--                    <text class="text-sm text-gray-400 ">delete</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="check" :size="24" color="#34C759"/>--}}
{{--                    <text class="text-sm text-gray-400 ">check</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="close" :size="24" color="#FF3B30"/>--}}
{{--                    <text class="text-sm text-gray-400 ">close</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="warning" :size="24" color="#FF9500"/>--}}
{{--                    <text class="text-sm text-gray-400 ">warning</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="info" :size="24" color="#007AFF"/>--}}
{{--                    <text class="text-sm text-gray-400 ">info</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </scroll-view>--}}

{{--        --}}{{-- Row 5: Device & Misc --}}
{{--        <scroll-view :horizontal="true" class="w-full h-[48]">--}}
{{--            <row class="gap-4 items-center h-[48]">--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="lock" :size="24" color="#8E8E93"/>--}}
{{--                    <text class="text-sm text-gray-400 ">lock</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="unlock" :size="24" color="#34C759"/>--}}
{{--                    <text class="text-sm text-gray-400 ">unlock</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="location" :size="24" color="#FF3B30"/>--}}
{{--                    <text class="text-sm text-gray-400 ">location</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="globe" :size="24" color="#007AFF"/>--}}
{{--                    <text class="text-sm text-gray-400 ">globe</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="bolt" :size="24" color="#FF9500"/>--}}
{{--                    <text class="text-sm text-gray-400 ">bolt</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="clock" :size="24" color="#5856D6"/>--}}
{{--                    <text class="text-sm text-gray-400 ">clock</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="calendar" :size="24" color="#FF3B30"/>--}}
{{--                    <text class="text-sm text-gray-400 ">calendar</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="qrcode" :size="24" color="#333333"/>--}}
{{--                    <text class="text-sm text-gray-400 ">qrcode</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </scroll-view>--}}

{{--        --}}{{-- Row 6: Commerce & SF Symbols direct --}}
{{--        <scroll-view :horizontal="true" class="w-full h-[48]">--}}
{{--            <row class="gap-4 items-center h-[48]">--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="cart" :size="24" color="#34C759"/>--}}
{{--                    <text class="text-sm text-gray-400 ">cart</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="orders" :size="24" color="#FF9500"/>--}}
{{--                    <text class="text-sm text-gray-400 ">orders</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="download" :size="24" color="#007AFF"/>--}}
{{--                    <text class="text-sm text-gray-400 ">download</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="upload" :size="24" color="#5856D6"/>--}}
{{--                    <text class="text-sm text-gray-400 ">upload</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="refresh" :size="24" color="#007AFF"/>--}}
{{--                    <text class="text-sm text-gray-400 ">refresh</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="filter" :size="24" color="#8E8E93"/>--}}
{{--                    <text class="text-sm text-gray-400 ">filter</text>--}}
{{--                </column>--}}
{{--                <column class="items-center gap-1">--}}
{{--                    <icon name="list" :size="24" color="#333333"/>--}}
{{--                    <text class="text-sm text-gray-400 ">list</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </scroll-view>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- TEXT INPUT --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Text Input — Outlined</text>--}}
{{--        <outlined-text-input class="w-full" label="Name" placeholder="Jane Doe"/>--}}
{{--        <outlined-text-input class="w-full" label="Email" placeholder="you@example.com" keyboard="email" leading-icon="email"/>--}}
{{--        <outlined-text-input class="w-full" label="Password" placeholder="••••••••" secure leading-icon="lock"/>--}}
{{--        <outlined-text-input class="w-full" label="With icons" placeholder="Search..." leading-icon="search" trailing-icon="close"/>--}}
{{--        <outlined-text-input class="w-full" label="Supporting" placeholder="Username" supporting="3–20 characters"/>--}}
{{--        <outlined-text-input class="w-full" label="Error state" value="not-an-email" error supporting="Enter a valid email"/>--}}
{{--        <outlined-text-input class="w-full" label="Disabled" value="Can't edit" disabled/>--}}
{{--        <outlined-text-input class="w-full" label="Bio" placeholder="Tell us about yourself..." multiline :max-lines="4"/>--}}

{{--        <text class="text-lg font-semibold text-gray-700  mt-4">Text Input — Filled</text>--}}
{{--        <filled-text-input class="w-full" label="Search" placeholder="Search anything..." leading-icon="search"/>--}}
{{--        <filled-text-input class="w-full" label="Price" prefix="$" suffix=".00" keyboard="decimal"/>--}}
{{--        <filled-text-input class="w-full" label="Phone" placeholder="+1 (555) 000-0000" keyboard="phone" leading-icon="phone"/>--}}
{{--        <filled-text-input class="w-full" label="Loading" loading/>--}}
{{--        <filled-text-input class="w-full" label="Small size" size="sm" placeholder="Compact"/>--}}
{{--        <filled-text-input class="w-full" label="Large size" size="lg" placeholder="Prominent"/>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- SLIDER — PHP ↔ Native round-trip benchmark    --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Slider</text>--}}

{{--        --}}{{-- LIVE: every drag tick pushes through PHP, re-renders Text below. --}}
{{--        <column class="gap-1">--}}
{{--            <text class="text-sm text-gray-600 ">Live (every drag tick)</text>--}}
{{--            <slider native:model.live="slideValue" :min="0" :max="100" class="w-full"/>--}}
{{--            <text class="text-base font-mono text-gray-900 ">Value: {{ number_format($slideValue, 1) }}</text>--}}
{{--            <text class="text-base font-mono text-gray-900 ">Value: {{ number_format($slideValue, 1) * 2 }}</text>--}}
{{--        </column>--}}

{{--        --}}{{-- DEBOUNCE: coalesce rapid drags, fire ~150ms after last change. --}}
{{--        <column class="gap-1">--}}
{{--            <text class="text-sm text-gray-600 ">Debounced (150ms)</text>--}}
{{--            <slider native:model.debounce.150ms="slideDebounced" :min="0" :max="100" class="w-full"/>--}}
{{--            <text class="text-base font-mono text-gray-900 ">Value: {{ number_format($slideDebounced, 1) }}</text>--}}
{{--        </column>--}}

{{--        --}}{{-- BLUR: only fires on drag release. --}}
{{--        <column class="gap-1">--}}
{{--            <text class="text-sm text-gray-600 ">On release (blur)</text>--}}
{{--            <slider native:model.blur="slideBlur" :min="0" :max="100" class="w-full"/>--}}
{{--            <text class="text-base font-mono text-gray-900 ">Value: {{ number_format($slideBlur, 1) }}</text>--}}
{{--        </column>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- TOGGLE --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Toggle</text>--}}
{{--        <toggle native:model="showModal" label="Show modal" class="w-full"/>--}}
{{--        <toggle native:model="showSheet" label="Show sheet" class="w-full"/>--}}
{{--        <toggle :value="true" label="Disabled (always on)" disabled class="w-full"/>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- CHECKBOX — composed from pressable + icon + text --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Checkbox (composed)</text>--}}

{{--        @php--}}
{{--            $checkboxRows = [--}}
{{--                ['field' => 'subscribed',    'label' => 'Subscribe to newsletter'],--}}
{{--                ['field' => 'termsAccepted', 'label' => 'I accept the terms and conditions'],--}}
{{--            ];--}}
{{--        @endphp--}}
{{--        @foreach ($checkboxRows as $row)--}}
{{--            <pressable @tap="toggleField('{{ $row['field'] }}')">--}}
{{--                <row class="items-center gap-2">--}}
{{--                    <icon--}}
{{--                        :name="$this->{$row['field']} ? 'check_box' : 'check_box_outline'"--}}
{{--                        :size="22"--}}
{{--                        :color="$this->{$row['field']} ? '#0F766E' : '#475569'"/>--}}
{{--                    <text>{{ $row['label'] }}</text>--}}
{{--                </row>--}}
{{--            </pressable>--}}
{{--        @endforeach--}}

{{--        --}}{{-- Disabled (non-interactive, no @press) --}}
{{--        <row class="items-center gap-2 opacity-50">--}}
{{--            <icon name="check_box" :size="22" color="#CBD5E1"/>--}}
{{--            <text>Disabled (checked)</text>--}}
{{--        </row>--}}

{{--        <text class="text-sm text-gray-500 ">--}}
{{--            subscribed: {{ $subscribed ? 'yes' : 'no' }} · terms: {{ $termsAccepted ? 'yes' : 'no' }}--}}
{{--        </text>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- SELECT --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Select</text>--}}
{{--        <select--}}
{{--            native:model="favoriteLanguage"--}}
{{--            label="Favorite language"--}}
{{--            placeholder="Pick one..."--}}
{{--            :options="['PHP', 'Swift', 'Kotlin', 'TypeScript', 'Rust', 'Go']"--}}
{{--            class="w-full"--}}
{{--        />--}}
{{--        <text class="text-sm text-gray-500 ">Selected: {{ $favoriteLanguage }}</text>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- RADIO GROUP — composed from pressable + icon + text --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Radio Group (composed)</text>--}}
{{--        <column class="gap-2 w-full">--}}
{{--            <text class="text-sm text-gray-500">Pricing plan</text>--}}

{{--            @foreach ([--}}
{{--                ['value' => 'free', 'label' => 'Free — $0/mo'],--}}
{{--                ['value' => 'pro',  'label' => 'Pro — $19/mo'],--}}
{{--                ['value' => 'team', 'label' => 'Team — $49/mo'],--}}
{{--            ] as $row)--}}
{{--                @php $checked = $pricingPlan === $row['value']; @endphp--}}
{{--                <pressable @tap="selectPricingPlan('{{ $row['value'] }}')">--}}
{{--                    <row class="items-center gap-2">--}}
{{--                        <icon--}}
{{--                            :name="$checked ? 'radio_button_checked' : 'radio_button_unchecked'"--}}
{{--                            :size="22"--}}
{{--                            :color="$checked ? '#0F766E' : '#475569'"/>--}}
{{--                        <text>{{ $row['label'] }}</text>--}}
{{--                    </row>--}}
{{--                </pressable>--}}
{{--            @endforeach--}}

{{--            --}}{{-- Disabled (non-interactive) --}}
{{--            <row class="items-center gap-2 opacity-50">--}}
{{--                <icon name="radio_button_unchecked" :size="22" color="#CBD5E1"/>--}}
{{--                <text>Enterprise — custom</text>--}}
{{--            </row>--}}
{{--        </column>--}}
{{--        <text class="text-sm text-gray-500 ">Chosen: {{ $pricingPlan }}</text>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- CARD VARIANTS — composed from column + classes --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Card — variants (composed)</text>--}}

{{--        <column class="w-full p-4 gap-1 bg-slate-100 rounded-xl">--}}
{{--            <text class="font-semibold ">Filled</text>--}}
{{--            <text class="text-sm text-gray-600 ">surface-variant background, no stroke. Medium emphasis — the default.</text>--}}
{{--        </column>--}}

{{--        <column class="w-full p-4 gap-1 bg-white rounded-xl border border-slate-300">--}}
{{--            <text class="font-semibold ">Outlined</text>--}}
{{--            <text class="text-sm text-gray-600 ">surface background + outline stroke. Lower emphasis, crisp edges.</text>--}}
{{--        </column>--}}

{{--        <column class="w-full p-4 gap-1 bg-white rounded-xl shadow">--}}
{{--            <text class="font-semibold ">Elevated</text>--}}
{{--            <text class="text-sm text-gray-600 ">surface + soft shadow. Highest emphasis — floats off the background.</text>--}}
{{--        </column>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- CHIP — composed from pressable + row + icon + text --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Chip (composed)</text>--}}

{{--        <text class="text-sm text-gray-600 ">Tap to toggle:</text>--}}
{{--        <row class="gap-2 flex-wrap">--}}
{{--            @foreach ([--}}
{{--                ['field' => 'subscribed',    'label' => 'Subscribed',     'icon' => 'favorite'],--}}
{{--                ['field' => 'termsAccepted', 'label' => 'Terms accepted', 'icon' => 'check'],--}}
{{--            ] as $row)--}}
{{--                @php $sel = $this->{$row['field']}; @endphp--}}
{{--                <pressable @tap="toggleField('{{ $row['field'] }}')">--}}
{{--                    <row class="items-center gap-1 px-3 py-2 rounded-full {{ $sel ? 'bg-teal-600' : 'bg-slate-100' }} border {{ $sel ? 'border-teal-600' : 'border-slate-300' }}">--}}
{{--                        <icon :name="$row['icon']" :size="14" :color="$sel ? '#FFFFFF' : '#475569'"/>--}}
{{--                        <text class="text-sm font-medium {{ $sel ? 'text-white' : 'text-slate-900' }}">{{ $row['label'] }}</text>--}}
{{--                    </row>--}}
{{--                </pressable>--}}
{{--            @endforeach--}}
{{--        </row>--}}

{{--        <text class="text-sm text-gray-600  mt-2">Static selection state (non-interactive):</text>--}}
{{--        <row class="gap-2 flex-wrap">--}}
{{--            @foreach ([--}}
{{--                ['label' => 'Swift',  'selected' => true,  'icon' => 'code'],--}}
{{--                ['label' => 'Kotlin', 'selected' => false, 'icon' => 'code'],--}}
{{--                ['label' => 'PHP',    'selected' => true,  'icon' => 'code'],--}}
{{--                ['label' => 'Rust',   'selected' => false, 'icon' => null],--}}
{{--            ] as $row)--}}
{{--                <row class="items-center gap-1 px-3 py-2 rounded-full {{ $row['selected'] ? 'bg-teal-600' : 'bg-slate-100' }} border {{ $row['selected'] ? 'border-teal-600' : 'border-slate-300' }}">--}}
{{--                    @if ($row['icon'])--}}
{{--                        <icon :name="$row['icon']" :size="14" :color="$row['selected'] ? '#FFFFFF' : '#475569'"/>--}}
{{--                    @endif--}}
{{--                    <text class="text-sm font-medium {{ $row['selected'] ? 'text-white' : 'text-slate-900' }}">{{ $row['label'] }}</text>--}}
{{--                </row>--}}
{{--            @endforeach--}}
{{--            <row class="items-center gap-1 px-3 py-2 rounded-full bg-teal-600 border border-teal-600 opacity-50">--}}
{{--                <text class="text-sm font-medium text-white">Disabled</text>--}}
{{--            </row>--}}
{{--        </row>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- BADGE — composed from row + text with bg + rounded --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Badge (composed)</text>--}}
{{--        <row class="items-center gap-3 flex-wrap">--}}
{{--            <text class="text-gray-700 ">Notifications</text>--}}
{{--            <row class="bg-red-600 rounded-full px-2 py-0.5 items-center">--}}
{{--                <text class="text-xs font-bold text-white">3</text>--}}
{{--            </row>--}}

{{--            <text class="text-gray-700  ml-4">Inbox</text>--}}
{{--            <row class="bg-red-600 rounded-full px-2 py-0.5 items-center">--}}
{{--                <text class="text-xs font-bold text-white">99+</text>--}}
{{--            </row>--}}

{{--            <text class="text-gray-700  ml-4">New</text>--}}
{{--            <row class="bg-teal-600 rounded-full px-2 py-0.5 items-center">--}}
{{--                <text class="text-xs font-bold text-white">NEW</text>--}}
{{--            </row>--}}

{{--            <text class="text-gray-700  ml-4">Pro</text>--}}
{{--            <row class="bg-orange-400 rounded-full px-2 py-0.5 items-center">--}}
{{--                <text class="text-xs font-bold text-white">PRO</text>--}}
{{--            </row>--}}
{{--        </row>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- PROGRESS BAR                                  --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Progress Bar</text>--}}
{{--        <column class="gap-3 w-full">--}}
{{--            <column class="gap-1">--}}
{{--                <text class="text-sm text-gray-600 ">Bound to slider value (live):</text>--}}
{{--                <progress-bar :value="$slideValue / 100" class="w-full"/>--}}
{{--            </column>--}}
{{--            <column class="gap-1">--}}
{{--                <text class="text-sm text-gray-600 ">Indeterminate:</text>--}}
{{--                <progress-bar indeterminate class="w-full"/>--}}
{{--            </column>--}}
{{--            <column class="gap-1">--}}
{{--                <text class="text-sm text-gray-600 ">Custom color override:</text>--}}
{{--                <progress-bar :value="0.7" color="#4232a8" class="w-full"/>--}}
{{--            </column>--}}
{{--        </column>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- TAB ROW — composed from scroll-view + pressable rows --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Tab Row (composed)</text>--}}
{{--        <column class="w-full gap-0">--}}
{{--            <scroll-view :horizontal="true">--}}
{{--                <row class="gap-0">--}}
{{--                    @foreach ([--}}
{{--                        ['label' => 'Overview', 'icon' => 'home'],--}}
{{--                        ['label' => 'Activity', 'icon' => 'list'],--}}
{{--                        ['label' => 'Settings', 'icon' => 'settings'],--}}
{{--                        ['label' => 'About',    'icon' => 'info'],--}}
{{--                    ] as $i => $tab)--}}
{{--                        @php $isActive = $activeTab === $i; @endphp--}}
{{--                        <pressable @tap="selectTab({{ $i }})">--}}
{{--                            <column class="items-center px-4 pt-3 gap-1">--}}
{{--                                <row class="items-center gap-1">--}}
{{--                                    <icon :name="$tab['icon']" :size="18" :color="$isActive ? '#0F766E' : '#475569'"/>--}}
{{--                                    <text class="text-sm font-medium {{ $isActive ? 'text-teal-600' : 'text-slate-500' }}">{{ $tab['label'] }}</text>--}}
{{--                                </row>--}}
{{--                                <column class="w-full h-[2] {{ $isActive ? 'bg-teal-600' : '' }}"/>--}}
{{--                            </column>--}}
{{--                        </pressable>--}}
{{--                    @endforeach--}}
{{--                </row>--}}
{{--            </scroll-view>--}}
{{--            <column class="w-full h-[1] bg-slate-200"/>--}}
{{--        </column>--}}
{{--        <text class="text-sm text-gray-500 ">Active tab index: {{ $activeTab }}</text>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- BUTTON GROUP — composed from row + pressable segments --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Button Group (composed)</text>--}}
{{--        <row class="w-full rounded-xl border border-slate-300">--}}
{{--            @php $planOptions = ['Monthly', 'Yearly', 'Lifetime']; @endphp--}}
{{--            @foreach ($planOptions as $i => $opt)--}}
{{--                @php--}}
{{--                    $selected = $planTier === $i;--}}
{{--                    $isFirst  = $i === 0;--}}
{{--                    $isLast   = $i === count($planOptions) - 1;--}}
{{--                @endphp--}}
{{--                <pressable @tap="selectPlanTier({{ $i }})" class="flex-1">--}}
{{--                    <column class="items-center justify-center py-3 px-4 {{ $selected ? 'bg-teal-600' : 'bg-white' }} {{ $isFirst ? 'rounded-l-xl' : '' }} {{ $isLast ? 'rounded-r-xl' : '' }}">--}}
{{--                        <text class="text-sm font-medium {{ $selected ? 'text-white' : 'text-slate-900' }}">{{ $opt }}</text>--}}
{{--                    </column>--}}
{{--                </pressable>--}}
{{--                @if (! $isLast)--}}
{{--                    <column class="w-[1] bg-slate-300"/>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        </row>--}}
{{--        <text class="text-sm text-gray-500 ">Plan tier index: {{ $planTier }}</text>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- IMAGE --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Image</text>--}}
{{--        <image--}}
{{--            src="https://picsum.photos/seed/nativephp/800/400"--}}
{{--            class="w-full h-[200] rounded-xl"--}}
{{--            :fit="2"--}}
{{--        />--}}
{{--        <scroll-view :horizontal="true">--}}
{{--            <row class="gap-3">--}}
{{--                <image--}}
{{--                    src="https://picsum.photos/seed/left/400/400"--}}
{{--                    class="w-[400] h-[400] rounded-lg"--}}
{{--                    :fit="2"--}}
{{--                />--}}
{{--                <image--}}
{{--                    src="https://picsum.photos/seed/right/400/400"--}}
{{--                    class="w-[400] h-[400] rounded-lg"--}}
{{--                    :fit="2"--}}
{{--                />--}}

{{--            </row>--}}
{{--        </scroll-view>--}}


{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- FLEX LAYOUT --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Flex Layout</text>--}}

{{--        <text class="text-sm text-gray-400 ">justify-start</text>--}}
{{--        <row class="w-full gap-2 justify-start">--}}
{{--            <column class="w-[40] h-[40] bg-indigo-500 rounded-md"/>--}}
{{--            <column class="w-[40] h-[40] bg-indigo-400 rounded-md"/>--}}
{{--            <column class="w-[40] h-[40] bg-indigo-300 rounded-md"/>--}}
{{--        </row>--}}

{{--        <text class="text-sm text-gray-400 ">justify-center</text>--}}
{{--        <row class="w-full gap-2 justify-center">--}}
{{--            <column class="w-[40] h-[40] bg-violet-500 rounded-md"/>--}}
{{--            <column class="w-[40] h-[40] bg-violet-400 rounded-md"/>--}}
{{--            <column class="w-[40] h-[40] bg-violet-300 rounded-md"/>--}}
{{--        </row>--}}

{{--        <text class="text-sm text-gray-400 ">justify-end</text>--}}
{{--        <row class="w-full gap-2 justify-end">--}}
{{--            <column class="w-[40] h-[40] bg-fuchsia-500 rounded-md"/>--}}
{{--            <column class="w-[40] h-[40] bg-fuchsia-400 rounded-md"/>--}}
{{--            <column class="w-[40] h-[40] bg-fuchsia-300 rounded-md"/>--}}
{{--        </row>--}}

{{--        <text class="text-sm text-gray-400 ">justify-between</text>--}}
{{--        <row class="w-full justify-between">--}}
{{--            <column class="w-[40] h-[40] bg-pink-500 rounded-md"/>--}}
{{--            <column class="w-[40] h-[40] bg-pink-400 rounded-md"/>--}}
{{--            <column class="w-[40] h-[40] bg-pink-300 rounded-md"/>--}}
{{--        </row>--}}

{{--        <text class="text-sm text-gray-400 ">justify-evenly</text>--}}
{{--        <row class="w-full justify-evenly">--}}
{{--            <column class="w-[40] h-[40] bg-rose-500 rounded-md"/>--}}
{{--            <column class="w-[40] h-[40] bg-rose-400 rounded-md"/>--}}
{{--            <column class="w-[40] h-[40] bg-rose-300 rounded-md"/>--}}
{{--        </row>--}}

{{--        <text class="text-sm text-gray-400  mt-2">flex-1 distribution</text>--}}
{{--        <row class="w-full gap-2">--}}
{{--            <column class="flex-1 h-[40] bg-cyan-500 rounded-md items-center justify-center">--}}
{{--                <text class="text-white text-sm">1</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[40] bg-cyan-400 rounded-md items-center justify-center">--}}
{{--                <text class="text-white text-sm">1</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 h-[40] bg-cyan-300 rounded-md items-center justify-center">--}}
{{--                <text class="text-white text-sm">1</text>--}}
{{--            </column>--}}
{{--        </row>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- STACK (LAYERED) --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Stack (Layered)</text>--}}

{{--        --}}{{-- Notification badge on avatar --}}
{{--        <stack class="w-[64] h-[64]">--}}
{{--            <column class="w-[64] h-[64] rounded-full bg-indigo-500 items-center justify-center">--}}
{{--                <text class="text-white font-bold text-xl">SR</text>--}}
{{--            </column>--}}
{{--            <row class="w-full items-start justify-end">--}}
{{--                <column--}}
{{--                    class="w-[22] h-[22] rounded-full bg-red-500 border-2 border-white items-center justify-center">--}}
{{--                    <text class="text-white text-sm font-bold">3</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </stack>--}}

{{--        --}}{{-- Overlay on image --}}
{{--        <stack class="w-full h-[180]">--}}
{{--            <image--}}
{{--                src="https://picsum.photos/seed/overlay/800/400"--}}
{{--                class="w-full h-[180] rounded-xl"--}}
{{--                :fit="2"--}}
{{--            />--}}
{{--            <column class="w-full h-[180] rounded-xl justify-end p-4">--}}
{{--                <column class="bg-black opacity-60 rounded-lg p-3">--}}
{{--                    <text class="text-white font-bold text-lg">Overlaid Text</text>--}}
{{--                    <text class="text-white text-sm opacity-80">Stacked on top of an image</text>--}}
{{--                </column>--}}
{{--            </column>--}}
{{--        </stack>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- CANVAS & SHAPES --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Canvas & Shapes</text>--}}
{{--        <canvas class="w-full h-[200] bg-gray-50 rounded-xl">--}}
{{--            --}}{{-- Rectangles --}}
{{--            <rect class="left-[10] top-[10] w-[100] h-[50] bg-blue-500 rounded-lg"/>--}}
{{--            <rect class="left-[120] top-[10] w-[80] h-[50] bg-green-500 rounded-md"/>--}}
{{--            <rect class="left-[210] top-[10] w-[60] h-[50] bg-amber-500 rounded-sm"/>--}}
{{--            <rect class="left-[280] top-[10] w-[60] h-[50] bg-red-500"/>--}}

{{--            --}}{{-- Circles --}}
{{--            <circle class="left-[10] top-[80] w-[60] h-[60] bg-purple-500"/>--}}
{{--            <circle class="left-[50] top-[100] w-[40] h-[40] bg-pink-400 opacity-75"/>--}}
{{--            <circle class="left-[120] top-[80] w-[60] h-[60] bg-teal-500"/>--}}
{{--            <circle class="left-[200] top-[90] w-[50] h-[50] bg-orange-500"/>--}}
{{--            <circle class="left-[270] top-[80] w-[60] h-[60] bg-indigo-400"/>--}}

{{--            --}}{{-- Lines --}}
{{--            <line from="10,160" to="340,160" class="border-gray-300 border-2"/>--}}
{{--            <line from="10,170" to="340,170" class="border-blue-400 border-2"/>--}}
{{--            <line from="10,180" to="340,180" class="border-red-400 border-2"/>--}}
{{--            <line from="10,190" to="340,190" class="border-green-400 border-2"/>--}}
{{--        </canvas>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- CARD-STYLE LAYOUTS --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Card Layouts</text>--}}

{{--        --}}{{-- Profile card --}}
{{--        <column class="w-full bg-white rounded-2xl shadow-lg p-5 gap-4 border border-gray-100">--}}
{{--            <row class="w-full gap-4 items-center">--}}
{{--                <column class="w-[56] h-[56] rounded-full bg-indigo-500 items-center justify-center">--}}
{{--                    <text class="text-white font-bold text-xl">JD</text>--}}
{{--                </column>--}}
{{--                <column class="flex-1 gap-0">--}}
{{--                    <text class="font-bold text-lg ">Jane Doe</text>--}}
{{--                    <text class="text-sm text-gray-400 ">Senior Developer</text>--}}
{{--                </column>--}}
{{--                <icon name="more" :size="24" color="#999999"/>--}}
{{--            </row>--}}
{{--            <text class="text-gray-600  text-sm">Building beautiful native apps with PHP. Loves--}}
{{--                clean architecture, Tailwind, and strong coffee.--}}
{{--            </text>--}}
{{--            <row class="w-full gap-3 mt-6">--}}
{{--                <pressable @tap="increment" class="flex-1 bg-indigo-500 rounded-lg py-2 items-center">--}}
{{--                    <text class="text-white font-semibold">Follow</text>--}}
{{--                </pressable>--}}
{{--                <pressable @tap="increment"--}}
{{--                                  class="flex-1 border-2 border-indigo-500 rounded-lg py-2 items-center">--}}
{{--                    <text class="text-indigo-500 font-semibold">Message</text>--}}
{{--                </pressable>--}}
{{--            </row>--}}
{{--        </column>--}}

{{--        --}}{{-- Stats card --}}
{{--        <row class="w-full gap-3">--}}
{{--            <column class="flex-1 bg-blue-100 rounded-xl p-4 gap-1 items-center">--}}
{{--                <icon name="chart.bar.fill" :size="24" color="#3B82F6"/>--}}
{{--                <text class="text-2xl font-bold text-blue-600">2.4k</text>--}}
{{--                <text class="text-sm text-blue-400">Followers</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 bg-green-100 rounded-xl p-4 gap-1 items-center">--}}
{{--                <icon name="star" :size="24" color="#22C55E"/>--}}
{{--                <text class="text-2xl font-bold text-green-600">182</text>--}}
{{--                <text class="text-sm text-green-400">Stars</text>--}}
{{--            </column>--}}
{{--            <column class="flex-1 bg-purple-100 rounded-xl p-4 gap-1 items-center">--}}
{{--                <icon name="chevron.left/chevron.right" :size="24" color="#A855F7"/>--}}
{{--                <text class="text-2xl font-bold text-purple-600">47</text>--}}
{{--                <text class="text-sm text-purple-400">Repos</text>--}}
{{--            </column>--}}
{{--        </row>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- LIST ITEMS --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">List Items</text>--}}
{{--        <column class="w-full bg-white rounded-xl shadow-sm border border-gray-100">--}}
{{--            --}}{{-- Item 1 --}}
{{--            <pressable @tap="increment" class="w-full">--}}
{{--                <row class="w-full px-4 py-3 gap-3 items-center">--}}
{{--                    <column class="w-[40] h-[40] rounded-full bg-blue-100 items-center justify-center">--}}
{{--                        <icon name="mail" :size="20" color="#3B82F6"/>--}}
{{--                    </column>--}}
{{--                    <column class="flex-1 gap-0">--}}
{{--                        <text class="font-semibold ">Messages</text>--}}
{{--                        <text class="text-sm text-gray-400 ">3 unread messages</text>--}}
{{--                    </column>--}}
{{--                    <column class="w-[24] h-[24] rounded-full bg-red-500 items-center justify-center">--}}
{{--                        <text class="text-white text-sm font-bold">3</text>--}}
{{--                    </column>--}}
{{--                    <icon name="forward" :size="20" color="#CCCCCC"/>--}}
{{--                </row>--}}
{{--            </pressable>--}}
{{--            <divider/>--}}
{{--            --}}{{-- Item 2 --}}
{{--            <pressable @tap="increment" class="w-full">--}}
{{--                <row class="w-full px-4 py-3 gap-3 items-center">--}}
{{--                    <column class="w-[40] h-[40] rounded-full bg-green-100 items-center justify-center">--}}
{{--                        <icon name="notifications" :size="20" color="#22C55E"/>--}}
{{--                    </column>--}}
{{--                    <column class="flex-1 gap-0">--}}
{{--                        <text class="font-semibold ">Notifications</text>--}}
{{--                        <text class="text-sm text-gray-400 ">Push & email alerts</text>--}}
{{--                    </column>--}}
{{--                    <icon name="forward" :size="20" color="#CCCCCC"/>--}}
{{--                </row>--}}
{{--            </pressable>--}}
{{--            <divider/>--}}
{{--            --}}{{-- Item 3 --}}
{{--            <pressable @tap="increment" class="w-full">--}}
{{--                <row class="w-full px-4 py-3 gap-3 items-center">--}}
{{--                    <column class="w-[40] h-[40] rounded-full bg-purple-100 items-center justify-center">--}}
{{--                        <icon name="lock" :size="20" color="#A855F7"/>--}}
{{--                    </column>--}}
{{--                    <column class="flex-1 gap-0">--}}
{{--                        <text class="font-semibold ">Privacy</text>--}}
{{--                        <text class="text-sm text-gray-400 ">Manage your data</text>--}}
{{--                    </column>--}}
{{--                    <icon name="forward" :size="20" color="#CCCCCC"/>--}}
{{--                </row>--}}
{{--            </pressable>--}}
{{--            <divider/>--}}
{{--            --}}{{-- Item 4 --}}
{{--            <pressable @tap="increment" class="w-full">--}}
{{--                <row class="w-full px-4 py-3 gap-3 items-center">--}}
{{--                    <column class="w-[40] h-[40] rounded-full bg-amber-100 items-center justify-center">--}}
{{--                        <icon name="settings" :size="20" color="#F59E0B"/>--}}
{{--                    </column>--}}
{{--                    <column class="flex-1 gap-0">--}}
{{--                        <text class="font-semibold ">Settings</text>--}}
{{--                        <text class="text-sm text-gray-400 ">App preferences</text>--}}
{{--                    </column>--}}
{{--                    <icon name="forward" :size="20" color="#CCCCCC"/>--}}
{{--                </row>--}}
{{--            </pressable>--}}
{{--        </column>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- ACTIVITY INDICATOR --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Activity Indicator</text>--}}
{{--        <row class="w-full items-center gap-4">--}}
{{--            <activity-indicator/>--}}
{{--            <text class="text-gray-500 ">Default</text>--}}
{{--        </row>--}}
{{--        <row class="w-full items-center gap-4">--}}
{{--            <activity-indicator :size="1"/>--}}
{{--            <text class="text-gray-500 ">Large</text>--}}
{{--        </row>--}}
{{--        <row class="w-full items-center gap-4">--}}
{{--            <activity-indicator :size="2"/>--}}
{{--            <text class="text-gray-500 ">Small</text>--}}
{{--        </row>--}}
{{--        <row class="w-full items-center gap-6 mt-2">--}}
{{--            <activity-indicator color="#3B82F6"/>--}}
{{--            <activity-indicator color="#EF4444"/>--}}
{{--            <activity-indicator color="#22C55E"/>--}}
{{--            <activity-indicator color="#A855F7"/>--}}
{{--            <activity-indicator color="#F97316"/>--}}
{{--            <text class="text-gray-500  text-sm">Custom colors</text>--}}
{{--        </row>--}}

{{--        <divider/>--}}

{{--        --}}{{-- ============================================= --}}
{{--        --}}{{-- CREATIVE COMPOSITIONS --}}
{{--        --}}{{-- ============================================= --}}
{{--        <text class="text-lg font-semibold text-gray-700 ">Creative Compositions</text>--}}

{{--        --}}{{-- Faux gradient banner --}}
{{--        <stack class="w-full h-[140]">--}}
{{--            <row class="w-full h-[140]">--}}
{{--                <column class="flex-1 h-[140] bg-indigo-600"/>--}}
{{--                <column class="flex-1 h-[140] bg-purple-600"/>--}}
{{--                <column class="flex-1 h-[140] bg-pink-600"/>--}}
{{--            </row>--}}
{{--            <column class="w-full h-[140] items-center justify-center">--}}
{{--                <text class="text-white font-extrabold text-2xl">NativePHP</text>--}}
{{--                <text class="text-white opacity-75 text-sm">Build native. Write PHP.</text>--}}
{{--            </column>--}}
{{--        </stack>--}}

{{--        --}}{{-- Tag cloud --}}
{{--        <scroll-view :horizontal="true">--}}
{{--            <row class="w-full gap-2 flex-wrap mt-2">--}}
{{--                <column class="bg-blue-100 rounded-full px-3 py-1">--}}
{{--                    <text class="text-blue-700 text-sm font-semibold">Laravel</text>--}}
{{--                </column>--}}
{{--                <column class="bg-green-100 rounded-full px-3 py-1">--}}
{{--                    <text class="text-green-700 text-sm font-semibold">PHP</text>--}}
{{--                </column>--}}
{{--                <column class="bg-purple-100 rounded-full px-3 py-1">--}}
{{--                    <text class="text-purple-700 text-sm font-semibold">Swift</text>--}}
{{--                </column>--}}
{{--                <column class="bg-amber-100 rounded-full px-3 py-1">--}}
{{--                    <text class="text-amber-700 text-sm font-semibold">Kotlin</text>--}}
{{--                </column>--}}
{{--                <column class="bg-red-100 rounded-full px-3 py-1">--}}
{{--                    <text class="text-red-700 text-sm font-semibold">Yoga</text>--}}
{{--                </column>--}}
{{--                <column class="bg-teal-100 rounded-full px-3 py-1">--}}
{{--                    <text class="text-teal-700 text-sm font-semibold">Tailwind</text>--}}
{{--                </column>--}}
{{--                <column class="bg-pink-100 rounded-full px-3 py-1">--}}
{{--                    <text class="text-pink-700 text-sm font-semibold">UIKit</text>--}}
{{--                </column>--}}
{{--                <column class="bg-indigo-100 rounded-full px-3 py-1">--}}
{{--                    <text class="text-indigo-700 text-sm font-semibold">Compose</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </scroll-view>--}}

{{--        --}}{{-- Chat bubble mockup --}}
{{--        <column class="w-full gap-3 mt-3">--}}
{{--            <row class="w-full justify-end">--}}
{{--                <column class="w-3/4 bg-blue-500 rounded-2xl p-3 text-right">--}}
{{--                    <text class="text-white text-sm">Hey, have you tried NativePHP yet?</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--            <row class="w-full justify-start">--}}
{{--                <column class="w-3/4 bg-gray-200 dark:bg-gray-800 rounded-2xl p-3">--}}
{{--                    <text class="text-gray-800 dark:text-white text-sm text-left">--}}
{{--                        Yes! Native iOS and Android apps in PHP. The Yoga layout is pixel-perfect.--}}
{{--                    </text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--            <row class="w-full justify-end">--}}
{{--                <column class="w-1/2 bg-blue-500 rounded-2xl p-3 text-right">--}}
{{--                    <text class="text-white text-sm">Tailwind classes just work!</text>--}}
{{--                </column>--}}
{{--            </row>--}}
{{--        </column>--}}

{{--        --}}{{-- Bottom padding --}}
{{--        <spacer class="h-[20]"/>--}}

    </column>
</scroll-view>
{{--</column>--}}

{{-- Bottom Navigation --}}
{{--<row class="w-full h-[90] bg-white border-t border-gray-200 items-start justify-evenly pt-2">--}}
{{--    <pressable @tap="increment" class="flex-1 items-center gap-1">--}}
{{--        <icon name="home" :size="22" color="#007AFF" />--}}
{{--        <text class="text-sm text-blue-500 font-medium">Home</text>--}}
{{--    </pressable>--}}
{{--    <pressable @tap="increment" class="flex-1 items-center gap-1">--}}
{{--        <icon name="search" :size="22" color="#8E8E93" />--}}
{{--        <text class="text-sm text-gray-400 ">Search</text>--}}
{{--    </pressable>--}}
{{--    <pressable @tap="increment" class="flex-1 items-center gap-1">--}}
{{--        <icon name="favorite" :size="22" color="#8E8E93" />--}}
{{--        <text class="text-sm text-gray-400 ">Favorites</text>--}}
{{--    </pressable>--}}
{{--    <pressable @tap="increment" class="flex-1 items-center gap-1">--}}
{{--        <icon name="person" :size="22" color="#8E8E93" />--}}
{{--        <text class="text-sm text-gray-400 ">Profile</text>--}}
{{--    </pressable>--}}
{{--</row>--}}
{{--</column>--}}
