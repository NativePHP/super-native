{{--<native:column class="w-full h-full bg-white dark:bg-zinc-800">--}}
<native:scroll-view class="flex-1 w-full bg-white ">
    <native:column class="flex-1 p-5 gap-5 safe-area">

        {{-- ============================================= --}}
        {{-- HEADER --}}
        {{-- ============================================= --}}
        <native:column class="gap-1">
            <native:text class="text-4xl text-red-500 font-extrabold ">Hello World</native:text>
            <native:text class="text-sm text-gray-400 ">Every core primitive, styled to the nines
            </native:text>
        </native:column>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- LIST (Pull-to-Refresh + Infinite Scroll) --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700">List</native:text>
        <native:text class="text-xs text-gray-400">{{ count($items) }} items · Refreshed {{ $refreshCount }}x · Pull down or scroll to bottom</native:text>

        <native:list @refresh="refreshList" @endReached="loadMore" separator class="h-[500] w-full bg-gray-50 rounded-lg">
            @foreach ($items as $item)
                <native:row @swipeDelete="removeItem({{ $item['id'] }})" class="px-4 py-3 gap-3 items-center bg-white ">
                    <native:column class="w-[40] h-[40] rounded-full bg-blue-500 items-center justify-center">
                        <native:text class="text-white font-bold text-base">{{ substr($item['name'], 0, 1) }}</native:text>
                    </native:column>
                    <native:column class="flex-1 gap-0.5">
                        <native:text class="text-sm font-semibold text-gray-900 ">{{ $item['name'] }}</native:text>
                        <native:text class="text-xs text-gray-600 ">{{ $item['description'] }}</native:text>
                        <native:text class="text-xs text-gray-400">{{ $item['email'] }} · {{ $item['city'] }}</native:text>
                    </native:column>
                </native:row>
            @endforeach
        </native:list>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- MODAL --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 dark:text-gray-300">Overlays</native:text>

        <native:row class="gap-3">
            <native:button @press="openModal" class="bg-indigo-500 rounded-lg px-5 py-3 flex-1 text-center">
                Full-Screen Modal
            </native:button>
            <native:button @press="openSheet" class="bg-teal-500 rounded-lg px-5 py-3 flex-1">
                Bottom Sheet
            </native:button>
        </native:row>

        <native:modal :visible="$showModal" @dismiss="closeModal">
            <native:column class="flex-1 p-6 gap-4 bg-white ">
                <native:text class="text-2xl font-bold ">Full-Screen Modal</native:text>
                <native:text class="text-base text-gray-600 ">This is a full-screen modal overlay. Tap the X or press back to dismiss.</native:text>
                <native:divider/>
                <native:text class="text-sm text-[]]0">You can put any content here — forms, lists, images, anything.</native:text>
                <native:button @press="closeModal" class="bg-red-500 rounded-lg px-5 py-3 mt-4">
                    Close Modal
                </native:button>
            </native:column>
        </native:modal>

        <native:bottom-sheet :visible="$showSheet" @dismiss="closeSheet" detents="medium">
            <native:column class="px-5 pt-2 pb-8 gap-3">
                <native:text class="text-lg font-bold dark:text-white">Bottom Sheet</native:text>
                <native:text class="text-sm text-gray-400">Drag down or tap outside to dismiss.</native:text>
                <native:divider/>
                <native:list-item headline="Option 1" leading-icon="star" supporting="First option"/>
                <native:list-item headline="Option 2" leading-icon="favorite" supporting="Second option"/>
                <native:list-item headline="Option 3" leading-icon="settings" supporting="Third option"/>
                <native:button @press="closeSheet" class="bg-blue-500 rounded-xl px-5 py-3.5 mt-2">
                    Done
                </native:button>
            </native:column>
        </native:bottom-sheet>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- TYPOGRAPHY --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Typography</native:text>
        <native:column class="w-full gap-2">
            <native:text class="text-xs text-gray-500 ">text-xs (12pt) — The quick brown fox</native:text>
            <native:text class="text-sm text-gray-600 ">text-sm (14pt) — The quick brown fox</native:text>
            <native:text class="text-base text-gray-700 ">text-base (16pt) — The quick brown fox</native:text>
            <native:text class="text-lg text-gray-800 ">text-lg (18pt) — The quick brown fox</native:text>
            <native:text class="text-xl text-gray-900 ">text-xl (20pt) — The quick brown fox</native:text>
            <native:text class="text-2xl font-bold text-black ">text-2xl bold</native:text>
            <native:text class="text-3xl font-extrabold text-black ">text-3xl extrabold</native:text>
        </native:column>

        <native:column class="w-full gap-1 mt-2">
            <native:text class="font-thin text-base ">font-thin</native:text>
            <native:text class="font-light text-base ">font-light</native:text>
            <native:text class="font-normal text-base ">font-normal</native:text>
            <native:text class="font-medium text-base ">font-medium</native:text>
            <native:text class="font-semibold text-base ">font-semibold</native:text>
            <native:text class="font-bold text-base ">font-bold</native:text>
            <native:text class="font-extrabold text-base ">font-extrabold</native:text>
        </native:column>

        <native:column class="w-full gap-1 mt-2">
            <native:text class="text-base text-left w-full ">text-left aligned</native:text>
            <native:text class="text-base text-center w-full ">text-center aligned</native:text>
            <native:text class="text-base text-right w-full ">text-right aligned</native:text>
        </native:column>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- ALL TAILWIND COLORS --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">All Tailwind Colors</native:text>

        {{-- Slate --}}
        <native:text class="text-xs text-gray-500 ">Slate</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-slate-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-slate-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-slate-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-slate-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-slate-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-slate-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-slate-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-slate-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-slate-900"/>
        </native:row>

        {{-- Gray --}}
        <native:text class="text-xs text-gray-500 ">Gray</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-gray-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-gray-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-gray-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-gray-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-gray-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-gray-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-gray-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-gray-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-gray-900"/>
        </native:row>

        {{-- Zinc --}}
        <native:text class="text-xs text-gray-500 ">Zinc</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-zinc-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-zinc-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-zinc-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-zinc-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-zinc-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-zinc-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-zinc-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-zinc-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-zinc-900"/>
        </native:row>

        {{-- Neutral --}}
        <native:text class="text-xs text-gray-500 ">Neutral</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-neutral-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-neutral-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-neutral-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-neutral-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-neutral-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-neutral-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-neutral-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-neutral-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-neutral-900"/>
        </native:row>

        {{-- Stone --}}
        <native:text class="text-xs text-gray-500 ">Stone</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-stone-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-stone-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-stone-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-stone-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-stone-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-stone-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-stone-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-stone-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-stone-900"/>
        </native:row>

        {{-- Red --}}
        <native:text class="text-xs text-gray-500 ">Red</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-red-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-red-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-red-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-red-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-red-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-red-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-red-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-red-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-red-900"/>
        </native:row>

        {{-- Orange --}}
        <native:text class="text-xs text-gray-500 ">Orange</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-orange-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-orange-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-orange-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-orange-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-orange-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-orange-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-orange-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-orange-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-orange-900"/>
        </native:row>

        {{-- Amber --}}
        <native:text class="text-xs text-gray-500 ">Amber</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-amber-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-amber-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-amber-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-amber-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-amber-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-amber-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-amber-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-amber-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-amber-900"/>
        </native:row>

        {{-- Yellow --}}
        <native:text class="text-xs text-gray-500 ">Yellow</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-yellow-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-yellow-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-yellow-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-yellow-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-yellow-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-yellow-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-yellow-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-yellow-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-yellow-900"/>
        </native:row>

        {{-- Lime --}}
        <native:text class="text-xs text-gray-500 ">Lime</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-lime-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-lime-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-lime-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-lime-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-lime-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-lime-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-lime-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-lime-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-lime-900"/>
        </native:row>

        {{-- Green --}}
        <native:text class="text-xs text-gray-500 ">Green</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-green-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-green-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-green-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-green-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-green-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-green-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-green-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-green-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-green-900"/>
        </native:row>

        {{-- Emerald --}}
        <native:text class="text-xs text-gray-500 ">Emerald</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-emerald-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-emerald-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-emerald-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-emerald-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-emerald-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-emerald-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-emerald-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-emerald-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-emerald-900"/>
        </native:row>

        {{-- Teal --}}
        <native:text class="text-xs text-gray-500 ">Teal</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-teal-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-teal-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-teal-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-teal-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-teal-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-teal-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-teal-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-teal-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-teal-900"/>
        </native:row>

        {{-- Cyan --}}
        <native:text class="text-xs text-gray-500 ">Cyan</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-cyan-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-cyan-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-cyan-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-cyan-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-cyan-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-cyan-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-cyan-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-cyan-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-cyan-900"/>
        </native:row>

        {{-- Sky --}}
        <native:text class="text-xs text-gray-500 ">Sky</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-sky-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-sky-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-sky-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-sky-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-sky-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-sky-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-sky-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-sky-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-sky-900"/>
        </native:row>

        {{-- Blue --}}
        <native:text class="text-xs text-gray-500 ">Blue</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-blue-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-blue-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-blue-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-blue-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-blue-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-blue-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-blue-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-blue-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-blue-900"/>
        </native:row>

        {{-- Indigo --}}
        <native:text class="text-xs text-gray-500 ">Indigo</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-indigo-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-indigo-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-indigo-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-indigo-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-indigo-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-indigo-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-indigo-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-indigo-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-indigo-900"/>
        </native:row>

        {{-- Violet --}}
        <native:text class="text-xs text-gray-500 ">Violet</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-violet-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-violet-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-violet-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-violet-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-violet-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-violet-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-violet-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-violet-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-violet-900"/>
        </native:row>

        {{-- Purple --}}
        <native:text class="text-xs text-gray-500 ">Purple</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-purple-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-purple-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-purple-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-purple-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-purple-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-purple-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-purple-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-purple-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-purple-900"/>
        </native:row>

        {{-- Fuchsia --}}
        <native:text class="text-xs text-gray-500 ">Fuchsia</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-fuchsia-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-fuchsia-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-fuchsia-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-fuchsia-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-fuchsia-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-fuchsia-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-fuchsia-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-fuchsia-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-fuchsia-900"/>
        </native:row>

        {{-- Pink --}}
        <native:text class="text-xs text-gray-500 ">Pink</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-pink-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-pink-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-pink-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-pink-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-pink-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-pink-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-pink-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-pink-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-pink-900"/>
        </native:row>

        {{-- Rose --}}
        <native:text class="text-xs text-gray-500 ">Rose</native:text>
        <native:row class="w-full gap-1">
            <native:column class="flex-1 h-[32] rounded-sm bg-rose-100"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-rose-200"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-rose-300"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-rose-400"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-rose-500"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-rose-600"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-rose-700"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-rose-800"/>
            <native:column class="flex-1 h-[32] rounded-sm bg-rose-900"/>
        </native:row>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- BUTTONS --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Buttons</native:text>

        {{-- Solid buttons — horizontal scroll --}}
        <native:scroll-view :horizontal="true" class="w-full h-[52]">
            <native:row class="gap-2 h-[52]">
                <native:button @press="increment" class="bg-blue-500 rounded-lg px-5 py-3 text-white font-semibold">
                    Primary
                </native:button>
                <native:button @press="decrement" class="bg-red-500 rounded-lg px-5 py-3 text-white font-semibold">
                    Danger
                </native:button>
                <native:button @press="increment" class="bg-green-500 rounded-lg px-5 py-3 text-white font-semibold">
                    Success
                </native:button>
                <native:button @press="increment" class="bg-amber-500 rounded-lg px-5 py-3 text-white font-semibold">
                    Warning
                </native:button>
                <native:button @press="increment" class="bg-purple-500 rounded-lg px-5 py-3 text-white font-semibold">
                    Purple
                </native:button>
                <native:button @press="increment" class="bg-pink-500 rounded-lg px-5 py-3 text-white font-semibold">
                    Pink
                </native:button>
            </native:row>
        </native:scroll-view>

        {{-- Pill buttons — horizontal scroll --}}
        <native:scroll-view :horizontal="true" class="w-full h-[44]">
            <native:row class="gap-2 h-[44]">
                <native:button @press="increment" class="bg-indigo-500 rounded-full px-6 py-2 text-white">
                    Pill Button
                </native:button>
                <native:button @press="increment" class="bg-pink-500 rounded-full px-6 py-2 text-white">
                    Pink Pill
                </native:button>
                <native:button @press="increment" class="bg-teal-500 rounded-full px-6 py-2 text-white">
                    Teal Pill
                </native:button>
                <native:button @press="increment" class="bg-rose-500 rounded-full px-6 py-2 text-white">
                    Rose Pill
                </native:button>
                <native:button @press="increment" class="bg-cyan-500 rounded-full px-6 py-2 text-white">
                    Cyan Pill
                </native:button>
            </native:row>
        </native:scroll-view>

        {{-- Outlined / ghost style buttons --}}
        <native:row class="w-full gap-2 flex-wrap">
            <native:pressable @press="increment" class="border-2 border-blue-500 rounded-lg px-5 py-2">
                <native:text class="text-blue-500 font-semibold">Outlined</native:text>
            </native:pressable>
            <native:pressable @press="increment" class="border-2 border-red-500 rounded-lg px-5 py-2">
                <native:text class="text-red-500 font-semibold">Outlined</native:text>
            </native:pressable>
            <native:pressable @press="increment" class="rounded-lg px-5 py-2">
                <native:text class="text-blue-500 font-semibold">Ghost</native:text>
            </native:pressable>
        </native:row>

        {{-- Icon buttons --}}
        <native:row class="w-full gap-3 items-center">
            <native:pressable @press="increment"
                              class="w-[48] h-[48] rounded-full bg-blue-500 items-center justify-center">
                <native:icon name="add" :size="24" color="#FFFFFF"/>
            </native:pressable>
            <native:pressable @press="decrement"
                              class="w-[48] h-[48] rounded-full bg-red-500 items-center justify-center">
                <native:icon name="minus.circle.fill" :size="24" color="#FFFFFF"/>
            </native:pressable>
            <native:pressable @press="increment"
                              class="w-[48] h-[48] rounded-full bg-green-500 items-center justify-center">
                <native:icon name="check" :size="24" color="#FFFFFF"/>
            </native:pressable>
            <native:pressable @press="increment"
                              class="w-[48] h-[48] rounded-full bg-purple-500 items-center justify-center">
                <native:icon name="star" :size="24" color="#FFFFFF"/>
            </native:pressable>
            <native:pressable @press="increment"
                              class="w-[48] h-[48] rounded-full bg-amber-500 items-center justify-center">
                <native:icon name="favorite" :size="24" color="#FFFFFF"/>
            </native:pressable>
        </native:row>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- INTERACTIVE COUNTER --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Interactive Counter</native:text>
        <native:row class="w-full gap-4 items-center justify-center">
            <native:button @press="decrement" class="bg-red-500 rounded-full px-6 py-3 text-white font-bold text-xl">
                −
            </native:button>
            <native:column class="w-[80] h-[80] rounded-2xl bg-indigo-600 items-center justify-center shadow-lg">
                <native:text class="text-white font-extrabold text-3xl">{{ $count }}</native:text>
            </native:column>
            <native:button @press="increment" class="bg-green-500 rounded-full px-6 py-3 text-white font-bold text-xl">
                +
            </native:button>
        </native:row>

        {{-- ============================================= --}}
        {{-- NATIVE EVENT LISTENER --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Native Events</native:text>
        <native:button @press="showAlert" class="bg-indigo-500 rounded-lg px-5 py-3 text-white font-semibold w-full">
            Show Alert
        </native:button>
        @if($lastButton)
            <native:text class="text-base text-gray-600 ">You pressed: {{ $lastButton }}</native:text>
        @endif

        <native:divider/>

        {{-- ============================================= --}}
        {{-- BORDER RADIUS — horizontal scroll --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Border Radius</native:text>
        <native:scroll-view :horizontal="true" class="w-full h-[80]">
            <native:row class="gap-3 items-center h-[64]">
                <native:column class="w-[56] h-[56] bg-sky-500 rounded-none items-center justify-center">
                    <native:text class="text-white text-xs">none</native:text>
                </native:column>
                <native:column class="w-[56] h-[56] bg-sky-500 rounded-sm items-center justify-center">
                    <native:text class="text-white text-xs">sm</native:text>
                </native:column>
                <native:column class="w-[56] h-[56] bg-sky-500 rounded-md items-center justify-center">
                    <native:text class="text-white text-xs">md</native:text>
                </native:column>
                <native:column class="w-[56] h-[56] bg-sky-500 rounded-lg items-center justify-center">
                    <native:text class="text-white text-xs">lg</native:text>
                </native:column>
                <native:column class="w-[56] h-[56] bg-sky-500 rounded-xl items-center justify-center">
                    <native:text class="text-white text-xs">xl</native:text>
                </native:column>
                <native:column class="w-[56] h-[56] bg-sky-500 rounded-2xl items-center justify-center">
                    <native:text class="text-white text-xs">2xl</native:text>
                </native:column>
                <native:column class="w-[56] h-[56] bg-sky-500 rounded-3xl items-center justify-center">
                    <native:text class="text-white text-xs">3xl</native:text>
                </native:column>
                <native:column class="w-[56] h-[56] bg-sky-500 rounded-full items-center justify-center">
                    <native:text class="text-white text-xs">full</native:text>
                </native:column>
            </native:row>
        </native:scroll-view>

        <native:button @navigate.fade="'/doom'" class="w-full bg-red-800 rounded-lg px-5 py-3 text-white font-semibold">
            Play
        </native:button>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- SHADOWS / ELEVATION --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Shadows & Elevation</native:text>
        <native:scroll-view :horizontal="true" class="w-full h-[76]">
            <native:row class="gap-3 items-center h-[76] px-2">
                <native:column class="w-[70] h-[60] bg-white rounded-lg shadow-none items-center justify-center">
                    <native:text class="text-xs text-gray-500 ">none</native:text>
                </native:column>
                <native:column class="w-[70] h-[60] bg-white rounded-lg shadow-sm items-center justify-center">
                    <native:text class="text-xs text-gray-500 ">sm</native:text>
                </native:column>
                <native:column class="w-[70] h-[60] bg-white rounded-lg shadow-md items-center justify-center">
                    <native:text class="text-xs text-gray-500 ">md</native:text>
                </native:column>
                <native:column class="w-[70] h-[60] bg-white rounded-lg shadow-lg items-center justify-center">
                    <native:text class="text-xs text-gray-500 ">lg</native:text>
                </native:column>
                <native:column class="w-[70] h-[60] bg-white rounded-lg shadow-xl items-center justify-center">
                    <native:text class="text-xs text-gray-500 ">xl</native:text>
                </native:column>
                <native:column class="w-[70] h-[60] bg-white rounded-lg shadow-2xl items-center justify-center">
                    <native:text class="text-xs text-gray-500 ">2xl</native:text>
                </native:column>
            </native:row>
        </native:scroll-view>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- BORDERS --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Borders</native:text>
        <native:row class="w-full gap-3 items-center">
            <native:column class="flex-1 h-[50] border border-gray-300 rounded-lg items-center justify-center">
                <native:text class="text-xs text-gray-500 ">1px</native:text>
            </native:column>
            <native:column class="flex-1 h-[50] border-2 border-blue-500 rounded-lg items-center justify-center">
                <native:text class="text-xs text-blue-500">2px blue</native:text>
            </native:column>
            <native:column class="flex-1 h-[50] border-4 border-red-500 rounded-lg items-center justify-center">
                <native:text class="text-xs text-red-500">4px red</native:text>
            </native:column>
            <native:column class="flex-1 h-[50] border-4 border-green-500 rounded-full items-center justify-center">
                <native:text class="text-xs text-green-500">pill</native:text>
            </native:column>
        </native:row>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- OPACITY --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Opacity</native:text>
        <native:row class="w-full gap-2 items-center">
            <native:column class="flex-1 h-[40] bg-blue-500 rounded-md opacity-100 items-center justify-center">
                <native:text class="text-white text-xs">100</native:text>
            </native:column>
            <native:column class="flex-1 h-[40] bg-blue-500 rounded-md opacity-75 items-center justify-center">
                <native:text class="text-white text-xs">75</native:text>
            </native:column>
            <native:column class="flex-1 h-[40] bg-blue-500 rounded-md opacity-50 items-center justify-center">
                <native:text class="text-white text-xs">50</native:text>
            </native:column>
            <native:column class="flex-1 h-[40] bg-blue-500 rounded-md opacity-25 items-center justify-center">
                <native:text class="text-white text-xs">25</native:text>
            </native:column>
            <native:column class="flex-1 h-[40] bg-blue-500 rounded-md opacity-10 items-center justify-center">
                <native:text class="text-xs ">10</native:text>
            </native:column>
        </native:row>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- ICONS — only mapped SF Symbol names --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Icons</native:text>
        <native:text class="text-xs text-gray-400 ">All mapped icon names</native:text>

        {{-- Row 1: Navigation --}}
        <native:scroll-view :horizontal="true" class="w-full h-[48]">
            <native:row class="gap-4 items-center h-[48]">
                <native:column class="items-center gap-1">
                    <native:icon name="home" :size="24" color="#333333"/>
                    <native:text class="text-xs text-gray-400 ">home</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="search" :size="24" color="#007AFF"/>
                    <native:text class="text-xs text-gray-400 ">search</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="settings" :size="24" color="#8E8E93"/>
                    <native:text class="text-xs text-gray-400 ">settings</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="dashboard" :size="24" color="#5856D6"/>
                    <native:text class="text-xs text-gray-400 ">dashboard</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="menu" :size="24" color="#333333"/>
                    <native:text class="text-xs text-gray-400 ">menu</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="person" :size="24" color="#FF2D55"/>
                    <native:text class="text-xs text-gray-400 ">person</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="profile" :size="24" color="#007AFF"/>
                    <native:text class="text-xs text-gray-400 ">profile</native:text>
                </native:column>
            </native:row>
        </native:scroll-view>

        {{-- Row 2: Content --}}
        <native:scroll-view :horizontal="true" class="w-full h-[48]">
            <native:row class="gap-4 items-center h-[48]">
                <native:column class="items-center gap-1">
                    <native:icon name="favorite" :size="24" color="#FF3B30"/>
                    <native:text class="text-xs text-gray-400 ">favorite</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="star" :size="24" color="#FF9500"/>
                    <native:text class="text-xs text-gray-400 ">star</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="bookmark" :size="24" color="#5856D6"/>
                    <native:text class="text-xs text-gray-400 ">bookmark</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="photo" :size="24" color="#34C759"/>
                    <native:text class="text-xs text-gray-400 ">photo</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="camera" :size="24" color="#FF9500"/>
                    <native:text class="text-xs text-gray-400 ">camera</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="video" :size="24" color="#FF3B30"/>
                    <native:text class="text-xs text-gray-400 ">video</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="folder" :size="24" color="#007AFF"/>
                    <native:text class="text-xs text-gray-400 ">folder</native:text>
                </native:column>
            </native:row>
        </native:scroll-view>

        {{-- Row 3: Communication --}}
        <native:scroll-view :horizontal="true" class="w-full h-[48]">
            <native:row class="gap-4 items-center h-[48]">
                <native:column class="items-center gap-1">
                    <native:icon name="mail" :size="24" color="#007AFF"/>
                    <native:text class="text-xs text-gray-400 ">mail</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="notifications" :size="24" color="#5856D6"/>
                    <native:text class="text-xs text-gray-400 ">notifications</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="message" :size="24" color="#34C759"/>
                    <native:text class="text-xs text-gray-400 ">message</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="chat" :size="24" color="#FF9500"/>
                    <native:text class="text-xs text-gray-400 ">chat</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="phone" :size="24" color="#34C759"/>
                    <native:text class="text-xs text-gray-400 ">phone</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="share" :size="24" color="#007AFF"/>
                    <native:text class="text-xs text-gray-400 ">share</native:text>
                </native:column>
            </native:row>
        </native:scroll-view>

        {{-- Row 4: Actions & Status --}}
        <native:scroll-view :horizontal="true" class="w-full h-[48]">
            <native:row class="gap-4 items-center h-[48]">
                <native:column class="items-center gap-1">
                    <native:icon name="add" :size="24" color="#34C759"/>
                    <native:text class="text-xs text-gray-400 ">add</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="edit" :size="24" color="#007AFF"/>
                    <native:text class="text-xs text-gray-400 ">edit</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="delete" :size="24" color="#FF3B30"/>
                    <native:text class="text-xs text-gray-400 ">delete</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="check" :size="24" color="#34C759"/>
                    <native:text class="text-xs text-gray-400 ">check</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="close" :size="24" color="#FF3B30"/>
                    <native:text class="text-xs text-gray-400 ">close</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="warning" :size="24" color="#FF9500"/>
                    <native:text class="text-xs text-gray-400 ">warning</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="info" :size="24" color="#007AFF"/>
                    <native:text class="text-xs text-gray-400 ">info</native:text>
                </native:column>
            </native:row>
        </native:scroll-view>

        {{-- Row 5: Device & Misc --}}
        <native:scroll-view :horizontal="true" class="w-full h-[48]">
            <native:row class="gap-4 items-center h-[48]">
                <native:column class="items-center gap-1">
                    <native:icon name="lock" :size="24" color="#8E8E93"/>
                    <native:text class="text-xs text-gray-400 ">lock</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="unlock" :size="24" color="#34C759"/>
                    <native:text class="text-xs text-gray-400 ">unlock</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="location" :size="24" color="#FF3B30"/>
                    <native:text class="text-xs text-gray-400 ">location</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="globe" :size="24" color="#007AFF"/>
                    <native:text class="text-xs text-gray-400 ">globe</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="bolt" :size="24" color="#FF9500"/>
                    <native:text class="text-xs text-gray-400 ">bolt</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="clock" :size="24" color="#5856D6"/>
                    <native:text class="text-xs text-gray-400 ">clock</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="calendar" :size="24" color="#FF3B30"/>
                    <native:text class="text-xs text-gray-400 ">calendar</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="qrcode" :size="24" color="#333333"/>
                    <native:text class="text-xs text-gray-400 ">qrcode</native:text>
                </native:column>
            </native:row>
        </native:scroll-view>

        {{-- Row 6: Commerce & SF Symbols direct --}}
        <native:scroll-view :horizontal="true" class="w-full h-[48]">
            <native:row class="gap-4 items-center h-[48]">
                <native:column class="items-center gap-1">
                    <native:icon name="cart" :size="24" color="#34C759"/>
                    <native:text class="text-xs text-gray-400 ">cart</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="orders" :size="24" color="#FF9500"/>
                    <native:text class="text-xs text-gray-400 ">orders</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="download" :size="24" color="#007AFF"/>
                    <native:text class="text-xs text-gray-400 ">download</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="upload" :size="24" color="#5856D6"/>
                    <native:text class="text-xs text-gray-400 ">upload</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="refresh" :size="24" color="#007AFF"/>
                    <native:text class="text-xs text-gray-400 ">refresh</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="filter" :size="24" color="#8E8E93"/>
                    <native:text class="text-xs text-gray-400 ">filter</native:text>
                </native:column>
                <native:column class="items-center gap-1">
                    <native:icon name="list" :size="24" color="#333333"/>
                    <native:text class="text-xs text-gray-400 ">list</native:text>
                </native:column>
            </native:row>
        </native:scroll-view>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- TEXT INPUT --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Text Input</native:text>
        <native:outlined-text-input placeholder="Default keyboard" class="w-full"/>
        <native:outlined-text-input placeholder="Password field" class="w-full" :secure="true"/>

        <native:text class="text-sm font-semibold text-gray-500  mt-2">Keyboard Types</native:text>
        <native:outlined-text-input placeholder="Email (kb=2)" class="w-full" keyboard="2"/>
        <native:outlined-text-input placeholder="Phone (kb=3)" class="w-full" keyboard="3"/>
        <native:outlined-text-input placeholder="Number (kb=1)" class="w-full" keyboard="1"/>
        <native:outlined-text-input placeholder="Decimal (kb=5)" class="w-full" keyboard="5"/>
        <native:outlined-text-input placeholder="URL (kb=4)" class="w-full" keyboard="4"/>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- TOGGLE --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Toggle</native:text>
        <native:toggle class="" :value="false" label="Enable notifications"/>
        <native:toggle :value="true" label="Dark mode (on)"/>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- IMAGE --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Image</native:text>
        <native:image
            src="https://picsum.photos/seed/nativephp/800/400"
            class="w-full h-[200] rounded-xl"
            :fit="2"
        />
        <native:scroll-view :horizontal="true">
            <native:row class="gap-3">
                <native:image
                    src="https://picsum.photos/seed/left/400/400"
                    class="w-[400] h-[400] rounded-lg"
                    :fit="2"
                />
                <native:image
                    src="https://picsum.photos/seed/right/400/400"
                    class="w-[400] h-[400] rounded-lg"
                    :fit="2"
                />

            </native:row>
        </native:scroll-view>


        <native:divider/>

        {{-- ============================================= --}}
        {{-- FLEX LAYOUT --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Flex Layout</native:text>

        <native:text class="text-sm text-gray-400 ">justify-start</native:text>
        <native:row class="w-full gap-2 justify-start">
            <native:column class="w-[40] h-[40] bg-indigo-500 rounded-md"/>
            <native:column class="w-[40] h-[40] bg-indigo-400 rounded-md"/>
            <native:column class="w-[40] h-[40] bg-indigo-300 rounded-md"/>
        </native:row>

        <native:text class="text-sm text-gray-400 ">justify-center</native:text>
        <native:row class="w-full gap-2 justify-center">
            <native:column class="w-[40] h-[40] bg-violet-500 rounded-md"/>
            <native:column class="w-[40] h-[40] bg-violet-400 rounded-md"/>
            <native:column class="w-[40] h-[40] bg-violet-300 rounded-md"/>
        </native:row>

        <native:text class="text-sm text-gray-400 ">justify-end</native:text>
        <native:row class="w-full gap-2 justify-end">
            <native:column class="w-[40] h-[40] bg-fuchsia-500 rounded-md"/>
            <native:column class="w-[40] h-[40] bg-fuchsia-400 rounded-md"/>
            <native:column class="w-[40] h-[40] bg-fuchsia-300 rounded-md"/>
        </native:row>

        <native:text class="text-sm text-gray-400 ">justify-between</native:text>
        <native:row class="w-full justify-between">
            <native:column class="w-[40] h-[40] bg-pink-500 rounded-md"/>
            <native:column class="w-[40] h-[40] bg-pink-400 rounded-md"/>
            <native:column class="w-[40] h-[40] bg-pink-300 rounded-md"/>
        </native:row>

        <native:text class="text-sm text-gray-400 ">justify-evenly</native:text>
        <native:row class="w-full justify-evenly">
            <native:column class="w-[40] h-[40] bg-rose-500 rounded-md"/>
            <native:column class="w-[40] h-[40] bg-rose-400 rounded-md"/>
            <native:column class="w-[40] h-[40] bg-rose-300 rounded-md"/>
        </native:row>

        <native:text class="text-sm text-gray-400  mt-2">flex-1 distribution</native:text>
        <native:row class="w-full gap-2">
            <native:column class="flex-1 h-[40] bg-cyan-500 rounded-md items-center justify-center">
                <native:text class="text-white text-xs">1</native:text>
            </native:column>
            <native:column class="flex-1 h-[40] bg-cyan-400 rounded-md items-center justify-center">
                <native:text class="text-white text-xs">1</native:text>
            </native:column>
            <native:column class="flex-1 h-[40] bg-cyan-300 rounded-md items-center justify-center">
                <native:text class="text-white text-xs">1</native:text>
            </native:column>
        </native:row>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- STACK (LAYERED) --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Stack (Layered)</native:text>

        {{-- Notification badge on avatar --}}
        <native:stack class="w-[64] h-[64]">
            <native:column class="w-[64] h-[64] rounded-full bg-indigo-500 items-center justify-center">
                <native:text class="text-white font-bold text-xl">SR</native:text>
            </native:column>
            <native:row class="w-full items-start justify-end">
                <native:column
                    class="w-[22] h-[22] rounded-full bg-red-500 border-2 border-white items-center justify-center">
                    <native:text class="text-white text-xs font-bold">3</native:text>
                </native:column>
            </native:row>
        </native:stack>

        {{-- Overlay on image --}}
        <native:stack class="w-full h-[180]">
            <native:image
                src="https://picsum.photos/seed/overlay/800/400"
                class="w-full h-[180] rounded-xl"
                :fit="2"
            />
            <native:column class="w-full h-[180] rounded-xl justify-end p-4">
                <native:column class="bg-black opacity-60 rounded-lg p-3">
                    <native:text class="text-white font-bold text-lg">Overlaid Text</native:text>
                    <native:text class="text-white text-sm opacity-80">Stacked on top of an image</native:text>
                </native:column>
            </native:column>
        </native:stack>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- CANVAS & SHAPES --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Canvas & Shapes</native:text>
        <native:canvas class="w-full h-[200] bg-gray-50 rounded-xl">
            {{-- Rectangles --}}
            <native:rect class="left-[10] top-[10] w-[100] h-[50] bg-blue-500 rounded-lg"/>
            <native:rect class="left-[120] top-[10] w-[80] h-[50] bg-green-500 rounded-md"/>
            <native:rect class="left-[210] top-[10] w-[60] h-[50] bg-amber-500 rounded-sm"/>
            <native:rect class="left-[280] top-[10] w-[60] h-[50] bg-red-500"/>

            {{-- Circles --}}
            <native:circle class="left-[10] top-[80] w-[60] h-[60] bg-purple-500"/>
            <native:circle class="left-[50] top-[100] w-[40] h-[40] bg-pink-400 opacity-75"/>
            <native:circle class="left-[120] top-[80] w-[60] h-[60] bg-teal-500"/>
            <native:circle class="left-[200] top-[90] w-[50] h-[50] bg-orange-500"/>
            <native:circle class="left-[270] top-[80] w-[60] h-[60] bg-indigo-400"/>

            {{-- Lines --}}
            <native:line from="10,160" to="340,160" class="border-gray-300 border-2"/>
            <native:line from="10,170" to="340,170" class="border-blue-400 border-2"/>
            <native:line from="10,180" to="340,180" class="border-red-400 border-2"/>
            <native:line from="10,190" to="340,190" class="border-green-400 border-2"/>
        </native:canvas>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- CARD-STYLE LAYOUTS --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Card Layouts</native:text>

        {{-- Profile card --}}
        <native:column class="w-full bg-white rounded-2xl shadow-lg p-5 gap-4 border border-gray-100">
            <native:row class="w-full gap-4 items-center">
                <native:column class="w-[56] h-[56] rounded-full bg-indigo-500 items-center justify-center">
                    <native:text class="text-white font-bold text-xl">JD</native:text>
                </native:column>
                <native:column class="flex-1 gap-0">
                    <native:text class="font-bold text-lg ">Jane Doe</native:text>
                    <native:text class="text-sm text-gray-400 ">Senior Developer</native:text>
                </native:column>
                <native:icon name="more" :size="24" color="#999999"/>
            </native:row>
            <native:text class="text-gray-600  text-sm">Building beautiful native apps with PHP. Loves
                clean architecture, Tailwind, and strong coffee.
            </native:text>
            <native:row class="w-full gap-3">
                <native:pressable @press="increment" class="flex-1 bg-indigo-500 rounded-lg py-2 items-center">
                    <native:text class="text-white font-semibold">Follow</native:text>
                </native:pressable>
                <native:pressable @press="increment"
                                  class="flex-1 border-2 border-indigo-500 rounded-lg py-2 items-center">
                    <native:text class="text-indigo-500 font-semibold">Message</native:text>
                </native:pressable>
            </native:row>
        </native:column>

        {{-- Stats card --}}
        <native:row class="w-full gap-3">
            <native:column class="flex-1 bg-blue-100 rounded-xl p-4 gap-1 items-center">
                <native:icon name="chart.bar.fill" :size="24" color="#3B82F6"/>
                <native:text class="text-2xl font-bold text-blue-600">2.4k</native:text>
                <native:text class="text-xs text-blue-400">Followers</native:text>
            </native:column>
            <native:column class="flex-1 bg-green-100 rounded-xl p-4 gap-1 items-center">
                <native:icon name="star" :size="24" color="#22C55E"/>
                <native:text class="text-2xl font-bold text-green-600">182</native:text>
                <native:text class="text-xs text-green-400">Stars</native:text>
            </native:column>
            <native:column class="flex-1 bg-purple-100 rounded-xl p-4 gap-1 items-center">
                <native:icon name="chevron.left/chevron.right" :size="24" color="#A855F7"/>
                <native:text class="text-2xl font-bold text-purple-600">47</native:text>
                <native:text class="text-xs text-purple-400">Repos</native:text>
            </native:column>
        </native:row>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- LIST ITEMS --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">List Items</native:text>
        <native:column class="w-full bg-white rounded-xl shadow-sm border border-gray-100">
            {{-- Item 1 --}}
            <native:pressable @press="increment" class="w-full">
                <native:row class="w-full px-4 py-3 gap-3 items-center">
                    <native:column class="w-[40] h-[40] rounded-full bg-blue-100 items-center justify-center">
                        <native:icon name="mail" :size="20" color="#3B82F6"/>
                    </native:column>
                    <native:column class="flex-1 gap-0">
                        <native:text class="font-semibold ">Messages</native:text>
                        <native:text class="text-xs text-gray-400 ">3 unread messages</native:text>
                    </native:column>
                    <native:column class="w-[24] h-[24] rounded-full bg-red-500 items-center justify-center">
                        <native:text class="text-white text-xs font-bold">3</native:text>
                    </native:column>
                    <native:icon name="forward" :size="20" color="#CCCCCC"/>
                </native:row>
            </native:pressable>
            <native:divider/>
            {{-- Item 2 --}}
            <native:pressable @press="increment" class="w-full">
                <native:row class="w-full px-4 py-3 gap-3 items-center">
                    <native:column class="w-[40] h-[40] rounded-full bg-green-100 items-center justify-center">
                        <native:icon name="notifications" :size="20" color="#22C55E"/>
                    </native:column>
                    <native:column class="flex-1 gap-0">
                        <native:text class="font-semibold ">Notifications</native:text>
                        <native:text class="text-xs text-gray-400 ">Push & email alerts</native:text>
                    </native:column>
                    <native:icon name="forward" :size="20" color="#CCCCCC"/>
                </native:row>
            </native:pressable>
            <native:divider/>
            {{-- Item 3 --}}
            <native:pressable @press="increment" class="w-full">
                <native:row class="w-full px-4 py-3 gap-3 items-center">
                    <native:column class="w-[40] h-[40] rounded-full bg-purple-100 items-center justify-center">
                        <native:icon name="lock" :size="20" color="#A855F7"/>
                    </native:column>
                    <native:column class="flex-1 gap-0">
                        <native:text class="font-semibold ">Privacy</native:text>
                        <native:text class="text-xs text-gray-400 ">Manage your data</native:text>
                    </native:column>
                    <native:icon name="forward" :size="20" color="#CCCCCC"/>
                </native:row>
            </native:pressable>
            <native:divider/>
            {{-- Item 4 --}}
            <native:pressable @press="increment" class="w-full">
                <native:row class="w-full px-4 py-3 gap-3 items-center">
                    <native:column class="w-[40] h-[40] rounded-full bg-amber-100 items-center justify-center">
                        <native:icon name="settings" :size="20" color="#F59E0B"/>
                    </native:column>
                    <native:column class="flex-1 gap-0">
                        <native:text class="font-semibold ">Settings</native:text>
                        <native:text class="text-xs text-gray-400 ">App preferences</native:text>
                    </native:column>
                    <native:icon name="forward" :size="20" color="#CCCCCC"/>
                </native:row>
            </native:pressable>
        </native:column>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- ACTIVITY INDICATOR --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Activity Indicator</native:text>
        <native:row class="w-full items-center gap-4">
            <native:activity-indicator/>
            <native:text class="text-gray-500 ">Default</native:text>
        </native:row>
        <native:row class="w-full items-center gap-4">
            <native:activity-indicator :size="1"/>
            <native:text class="text-gray-500 ">Large</native:text>
        </native:row>
        <native:row class="w-full items-center gap-4">
            <native:activity-indicator :size="2"/>
            <native:text class="text-gray-500 ">Small</native:text>
        </native:row>
        <native:row class="w-full items-center gap-6 mt-2">
            <native:activity-indicator color="#3B82F6"/>
            <native:activity-indicator color="#EF4444"/>
            <native:activity-indicator color="#22C55E"/>
            <native:activity-indicator color="#A855F7"/>
            <native:activity-indicator color="#F97316"/>
            <native:text class="text-gray-500  text-sm">Custom colors</native:text>
        </native:row>

        <native:divider/>

        {{-- ============================================= --}}
        {{-- CREATIVE COMPOSITIONS --}}
        {{-- ============================================= --}}
        <native:text class="text-lg font-semibold text-gray-700 ">Creative Compositions</native:text>

        {{-- Faux gradient banner --}}
        <native:stack class="w-full h-[140]">
            <native:row class="w-full h-[140]">
                <native:column class="flex-1 h-[140] bg-indigo-600"/>
                <native:column class="flex-1 h-[140] bg-purple-600"/>
                <native:column class="flex-1 h-[140] bg-pink-600"/>
            </native:row>
            <native:column class="w-full h-[140] items-center justify-center">
                <native:text class="text-white font-extrabold text-2xl">NativePHP</native:text>
                <native:text class="text-white opacity-75 text-sm">Build native. Write PHP.</native:text>
            </native:column>
        </native:stack>

        {{-- Tag cloud --}}
        <native:scroll-view :horizontal="true">
            <native:row class="w-full gap-2 flex-wrap mt-2">
                <native:column class="bg-blue-100 rounded-full px-3 py-1">
                    <native:text class="text-blue-700 text-xs font-semibold">Laravel</native:text>
                </native:column>
                <native:column class="bg-green-100 rounded-full px-3 py-1">
                    <native:text class="text-green-700 text-xs font-semibold">PHP</native:text>
                </native:column>
                <native:column class="bg-purple-100 rounded-full px-3 py-1">
                    <native:text class="text-purple-700 text-xs font-semibold">Swift</native:text>
                </native:column>
                <native:column class="bg-amber-100 rounded-full px-3 py-1">
                    <native:text class="text-amber-700 text-xs font-semibold">Kotlin</native:text>
                </native:column>
                <native:column class="bg-red-100 rounded-full px-3 py-1">
                    <native:text class="text-red-700 text-xs font-semibold">Yoga</native:text>
                </native:column>
                <native:column class="bg-teal-100 rounded-full px-3 py-1">
                    <native:text class="text-teal-700 text-xs font-semibold">Tailwind</native:text>
                </native:column>
                <native:column class="bg-pink-100 rounded-full px-3 py-1">
                    <native:text class="text-pink-700 text-xs font-semibold">UIKit</native:text>
                </native:column>
                <native:column class="bg-indigo-100 rounded-full px-3 py-1">
                    <native:text class="text-indigo-700 text-xs font-semibold">Compose</native:text>
                </native:column>
            </native:row>
        </native:scroll-view>

        {{-- Chat bubble mockup --}}
        <native:column class="w-full gap-3 mt-3">
            <native:row class="w-full justify-end">
                <native:column class="w-3/4 bg-blue-500 rounded-2xl p-3">
                    <native:text class="text-white text-sm">Hey, have you tried NativePHP yet?</native:text>
                </native:column>
            </native:row>
            <native:row class="w-full justify-start">
                <native:column class="w-3/4 bg-gray-200 dark:bg-gray-800 rounded-2xl p-3">
                    <native:text class="text-gray-800  text-sm">Yes! Native iOS and Android apps in
                        PHP. The Yoga layout is pixel-perfect.
                    </native:text>
                </native:column>
            </native:row>
            <native:row class="w-full justify-end">
                <native:column class="w-1/2 bg-blue-500 rounded-2xl p-3">
                    <native:text class="text-white text-sm">Tailwind classes just work!</native:text>
                </native:column>
            </native:row>
        </native:column>

        {{-- Bottom padding --}}
        <native:spacer class="h-[20]"/>

    </native:column>
</native:scroll-view>
{{--</native:column>--}}

{{-- Bottom Navigation --}}
{{--<native:row class="w-full h-[90] bg-white border-t border-gray-200 items-start justify-evenly pt-2">--}}
{{--    <native:pressable @press="increment" class="flex-1 items-center gap-1">--}}
{{--        <native:icon name="home" :size="22" color="#007AFF" />--}}
{{--        <native:text class="text-xs text-blue-500 font-medium">Home</native:text>--}}
{{--    </native:pressable>--}}
{{--    <native:pressable @press="increment" class="flex-1 items-center gap-1">--}}
{{--        <native:icon name="search" :size="22" color="#8E8E93" />--}}
{{--        <native:text class="text-xs text-gray-400 ">Search</native:text>--}}
{{--    </native:pressable>--}}
{{--    <native:pressable @press="increment" class="flex-1 items-center gap-1">--}}
{{--        <native:icon name="favorite" :size="22" color="#8E8E93" />--}}
{{--        <native:text class="text-xs text-gray-400 ">Favorites</native:text>--}}
{{--    </native:pressable>--}}
{{--    <native:pressable @press="increment" class="flex-1 items-center gap-1">--}}
{{--        <native:icon name="person" :size="22" color="#8E8E93" />--}}
{{--        <native:text class="text-xs text-gray-400 ">Profile</native:text>--}}
{{--    </native:pressable>--}}
{{--</native:row>--}}
{{--</native:column>--}}
