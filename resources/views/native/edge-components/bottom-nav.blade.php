@include('native.partials.edge-component-note', ['caption' => 'Edge Component showcase — this screen exists to show off the bottom nav below.'])

<native:bottom-nav>
    <native:bottom-nav-item id="home" icon="home" label="Home" url="/edge-components/bottom-nav" :active="true" />
    <native:bottom-nav-item id="friends" icon="person" label="Friends" url="/edge-components/bottom-nav" :news="true" />
    <native:bottom-nav-item id="profile" icon="person" label="Profile" url="/edge-components/bottom-nav" badge="3" />
</native:bottom-nav>
