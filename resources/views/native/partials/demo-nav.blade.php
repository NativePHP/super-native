<top-bar title="{{ $title ?? 'NativePHP Demos' }}" />

<side-nav>
    <side-nav-header
        title="NativePHP"
        subtitle="Native UI Demos"
        showCloseButton="true"
        pinned="true"
    />

    <side-nav-item id="explore" icon="search" url="/" label="Airbnb" />
    <side-nav-item id="twitter" icon="chat_bubble" url="/twitter" label="Twitter / X" />
    <side-nav-item id="facebook" icon="people" url="/facebook" label="Facebook" />
    <side-nav-item id="instagram" icon="camera_alt" url="/instagram" label="Instagram" />
    <side-nav-item id="spotify" icon="music_note" url="/spotify" label="Spotify" />
    <side-nav-item id="youtube" icon="play_circle" url="/youtube" label="YouTube" />

    <divider />

    <side-nav-item id="benchmark" icon="speed" :url="route('benchmark')" label="Benchmark" />
{{--    <side-nav-item id="demo" icon="build" :url="route('demo')" label="Demo" />--}}
{{--    <side-nav-item id="skia" icon="palette" :url="route('skia')" label="Skia Canvas" />--}}

</side-nav>
