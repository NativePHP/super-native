<native:top-bar title="Dashboard" subtitle="Welcome back" back="true">
    <native:top-bar-action
        id="search"
        label="Search"
        icon="search"
        @tap="openSearch"
    />
    <native:top-bar-action
        id="settings"
        icon="settings"
        label="Settings"
        url="https://yourapp.com/my-account"
    />
</native:top-bar>

@include('native.partials.edge-component-note', ['caption' => 'Edge Component showcase — this screen exists to show off the top bar above.'])
