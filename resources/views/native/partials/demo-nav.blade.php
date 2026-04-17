<native:top-bar title="{{ $title ?? 'NativePHP Demos' }}" />

<native:side-nav>
    <native:side-nav-header
        title="NativePHP"
        subtitle="Native UI Demos"
        showCloseButton="true"
        pinned="true"
    />

    <native:side-nav-item id="explore" icon="search" url="/" label="Airbnb" />
    <native:side-nav-item id="twitter" icon="chat_bubble" url="/twitter" label="Twitter / X" />
    <native:side-nav-item id="ikea" icon="weekend" url="/ikea" label="IKEA" />
    <native:side-nav-item id="facebook" icon="people" url="/facebook" label="Facebook" />
    <native:side-nav-item id="instagram" icon="camera_alt" url="/instagram" label="Instagram" />
    <native:side-nav-item id="spotify" icon="music_note" url="/spotify" label="Spotify" />
    <native:side-nav-item id="youtube" icon="play_circle" url="/youtube" label="YouTube" />

    <native:divider />

    <native:side-nav-item id="benchmark" icon="speed" :url="route('benchmark')" label="Benchmark" />
{{--    <native:side-nav-item id="demo" icon="build" :url="route('demo')" label="Demo" />--}}
{{--    <native:side-nav-item id="skia" icon="palette" :url="route('skia')" label="Skia Canvas" />--}}

</native:side-nav>
