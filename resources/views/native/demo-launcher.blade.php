<list :separator="true" class="w-full h-full safe-area-top bg-theme-background max-w-4xl mx-auto">
    @foreach($groups as $group)
        <list-section :native:key="$group['title']" :header="$group['title']">
            @foreach($group['demos'] as $demo)
                <list-item
                    :native:key="$demo['id']"
                    @navigate($demo['url'])
                    {{-- Platform pair, not a single string: an SF Symbol name
                         renders blank on Android and a Material name renders
                         blank on iOS. --}}
                    :leadingIconIos="$demo['ios']"
                    :leadingIconAndroid="$demo['android']"
                    :leadingIconBgColor="$demo['color']"
                    :headline="$demo['title']"
                    :supporting="$demo['subtitle']"
                    />
            @endforeach
        </list-section>
    @endforeach
</list>
