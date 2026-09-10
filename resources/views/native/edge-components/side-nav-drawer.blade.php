<native:side-nav-header title="My App" subtitle="user@example.com" icon="person" />

<native:side-nav-item id="home" label="Home" icon="home" url="/edge-components/side-nav" :active="true" />

<native:side-nav-group heading="Account" :expanded="false">
    <native:side-nav-item id="profile" label="Profile" icon="person" url="/edge-components/side-nav" />
    <native:side-nav-item id="settings" label="Settings" icon="settings" url="/edge-components/side-nav" />
</native:side-nav-group>

<native:divider />

<native:side-nav-item id="help" label="Help" icon="help" url="https://nativephp.com/docs" open-in-browser="true" />
