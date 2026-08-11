{{-- The persistent "map": mounted ONCE beneath the screen by the layout's
     background layer. The corner badges are absolute stack children with
     authored ZERO insets — the merged signed-zero anchoring fix is what
     puts them in the right corners (before it, bottom-0 / right-0 fell
     back to top-left). --}}
<native:stack class="w-full h-full bg-indigo-950">

    <native:column class="absolute top-16 left-8 w-40 h-40 rounded-full bg-violet-700/40" />
    <native:column class="absolute top-64 right-0 w-56 h-56 rounded-full bg-cyan-600/30" />
    <native:column class="absolute bottom-24 left-0 w-48 h-48 rounded-full bg-fuchsia-700/30" />

    <native:column class="absolute top-0 left-0 rounded-br-lg bg-emerald-500 px-2 py-1">
        <native:text class="text-xs text-white">top-0 left-0</native:text>
    </native:column>

    <native:column class="absolute top-0 right-0 rounded-bl-lg bg-amber-500 px-2 py-1">
        <native:text class="text-xs text-black">top-0 right-0</native:text>
    </native:column>

    <native:column class="absolute bottom-0 left-0 rounded-tr-lg bg-rose-500 px-2 py-1">
        <native:text class="text-xs text-white">bottom-0 left-0</native:text>
    </native:column>

    <native:column class="absolute bottom-0 right-0 rounded-tl-lg bg-sky-400 px-2 py-1">
        <native:text class="text-xs text-black">bottom-0 right-0</native:text>
    </native:column>

</native:stack>
