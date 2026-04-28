{{-- Shared bottom tab bar — set $active to one of: home, browse, profile --}}
<native:bottom-nav>
    <native:bottom-nav-item id="home"    icon="home"          url="/"        label="Home"    :active="($active ?? '') === 'home'" />
    <native:bottom-nav-item id="browse"  icon="grid_view"     url="/browse"  label="Browse"  :active="($active ?? '') === 'browse'" />
    <native:bottom-nav-item id="profile" icon="person"        url="/profile" label="Profile" :active="($active ?? '') === 'profile'" />
</native:bottom-nav>
