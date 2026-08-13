{{--
    The permanent desktop sidebar.

    Included from inside a screen's `@desktop` block, so on a phone this file is
    never even rendered — the `@include` is a runtime call inside the `if`, not a
    compile-time splice. That is the whole point of the block: one screen, and the
    nav simply is not part of the tree the phone builds.

    Nothing here positions itself. `side_nav` renders on macOS as a fixed-width
    column (220pt when the tree sets no width), so it sits BESIDE the content for
    exactly one reason: the screen that includes it has a `<row>` root. Put the
    same include under a `<column>` and it stacks above the content instead.

    `custom` is what keeps it there, and it is not decoration. A screen extending
    mobile's NativeComponent runs `wrapWithChrome()`, which HOISTS a top-level
    `side_nav` out of the content tree and re-attaches it at the chrome root for a
    drawer host to pull out — correct on a phone, where a side nav is a drawer.
    On a Mac there is no drawer host, so a hoisted nav is drawn at the root and
    lands UNDER the content instead of beside it. `custom` means "this screen
    positions its own nav", and the hoist skips it. Core-based screens
    (`SupaNative\Core\Edge\NativeComponent`, i.e. the desktop-only ones) have no
    hoisting at all and ignore the flag, so one partial suits both.

    `pt-8` because these windows draw content to the top edge, so without it the
    pinned header would sit under the traffic lights.

    One caveat, checked rather than assumed: a Blade directive inside a
    `<native:*>` ATTRIBUTE value is inert. The precompiler turns the value into a
    PHP string literal before Blade looks for directives, and Blade only compiles
    directives in inline HTML — so the `@desktop` lands in the string as text
    instead of breaking the file. Use a `{{ }}` expression there, as the subtitle
    does. Directives in element *bodies* are fine, which is all this needs.

    @param string|null $active  Which item to mark current — 'launcher',
                                'dashboard', 'counter', 'batch1', 'typography'
                                or 'buttons'. Omit for none.
--}}
<side-nav custom class="h-full pt-8 bg-slate-900" dark="true" label-visibility="labeled">
    <side-nav-header
        title="{{ config('app.name') }}"
        subtitle="{{ SupaNative\Core\Platform::current() }} — desktop only"
        icon="dashboard"
        pinned="true" />

    <side-nav-item icon="square.grid.3x3" label="Launcher" url="/" :active="($active ?? '') === 'launcher'" />
    <side-nav-item icon="dashboard" label="Dashboard" url="/desktop" :active="($active ?? '') === 'dashboard'" />
    <side-nav-item icon="plus.forwardslash.minus" label="Counter" url="/counter" :active="($active ?? '') === 'counter'" />
    <side-nav-item icon="rectangle.3.group" label="Renderer batch 1" url="/renderer-batch1" :active="($active ?? '') === 'batch1'" />

    <divider />

    <side-nav-group heading="Explore" icon="folder" expanded="true">
        <side-nav-item icon="textformat" label="Typography" url="/explore/typography" :active="($active ?? '') === 'typography'" />
        <side-nav-item icon="capsule" label="Buttons" url="/explore/buttons" :active="($active ?? '') === 'buttons'" />
    </side-nav-group>
</side-nav>
