@include('native.partials.edge-component-note', ['caption' => 'Edge Component showcase — this screen exists to show off the bottom nav below.'])

<native:bottom-nav>
    <native:bottom-nav-item id="home" icon="home" label="Home" url="/edge-components/bottom-nav-search-item" :active="true" />
    <native:bottom-nav-item
        id="search"
        icon="search"
        label="Search"
        search="true"
        search-placeholder="Search"
    />
    <native:bottom-nav-item id="profile" icon="person" label="Profile" url="/edge-components/bottom-nav-search-item" />
</native:bottom-nav>
