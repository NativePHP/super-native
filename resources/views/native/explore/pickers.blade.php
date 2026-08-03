<scroll-view class="w-full">
    <column class="w-full p-5 gap-6">

        <text class="text-2xl font-semibold text-theme-on-background">Modes</text>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Date</text>
            <date-picker class="w-full" label="Starts" native:model="date"
                         placeholder="Pick a date" a11y-label="Start date"
                         a11y-hint="Opens a calendar"/>
            <text class="text-[16] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2">{{ $date ?: '(empty)' }}</text>
        </column>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Time — 24h on the wire</text>
            <date-picker class="w-full" mode="time" label="Opens at" native:model="time"
                         placeholder="Pick a time" a11y-label="Opening time"/>
            <text class="text-[16] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2">{{ $time ?: '(empty)' }}</text>
        </column>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Datetime</text>
            <date-picker class="w-full" mode="datetime" label="Appointment" native:model="datetime"
                         placeholder="Pick date &amp; time" a11y-label="Appointment"/>
            <text class="text-[16] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2">{{ $datetime ?: '(empty)' }}</text>
        </column>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Empty — placeholder path</text>
            <date-picker class="w-full" label="Deadline" native:model="empty"
                         placeholder="No date chosen" a11y-label="Deadline"/>
            <text class="text-[16] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2">{{ $empty ?: '(empty)' }}</text>
        </column>

        <divider class="my-2"/>

        <text class="text-2xl font-semibold text-theme-on-background">Bounds</text>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">July 2026 only</text>
            <date-picker class="w-full" label="In July" native:model="bounded"
                         min="2026-07-01" max="2026-07-31"
                         a11y-label="Date within July 2026"/>
            <text class="text-[16] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2">{{ $bounded ?: '(empty)' }}</text>
        </column>

        <divider class="my-2"/>

        <text class="text-2xl font-semibold text-theme-on-background">Internationalization</text>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Europe/Berlin · de-DE · 24h</text>
            <date-picker class="w-full" mode="datetime" label="Termin" native:model="berlin"
                         timezone="Europe/Berlin" locale="de-DE" hour-format="24"
                         title="Termin wählen" confirm-label="Übernehmen" cancel-label="Abbrechen"
                         a11y-label="Termin"/>
            <text class="text-[16] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2">{{ $berlin ?: '(empty)' }}</text>
            <text class="text-[14] text-theme-on-surface-variant text-center">Display is German; the wire value stays wall-clock ISO.</text>
        </column>

        <divider class="my-2"/>

        <text class="text-2xl font-semibold text-theme-on-background">Picker styles</text>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Inline — graphical / embedded</text>
            <date-picker class="w-full" picker-style="inline" label="Inline" native:model="inlineDate"
                         a11y-label="Inline date"/>
            <text class="text-[16] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2">{{ $inlineDate ?: '(empty)' }}</text>
        </column>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Wheel — drum on iOS, embedded on Android</text>
            <date-picker class="w-full" mode="time" picker-style="wheel" label="Wheel" native:model="wheelTime"
                         a11y-label="Wheel time"/>
            <text class="text-[16] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-2">{{ $wheelTime ?: '(empty)' }}</text>
        </column>

        <divider class="my-2"/>

        <text class="text-2xl font-semibold text-theme-on-background">State</text>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Disabled</text>
            <date-picker class="w-full" label="Locked" native:model="disabled" disabled
                         a11y-label="Locked date"/>
        </column>

        <divider class="my-2"/>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">@change only (no native:model)</text>
            <date-picker class="w-full" mode="datetime" label="Event handler"
                         value="2026-07-25T08:00" placeholder="Pick to fire @change"
                         a11y-label="Event handler demo" @change="noteChange"/>
        </column>

        <column class="gap-1">
            <text class="text-xl text-theme-on-surface-variant">Last @change payload</text>
            <text class="text-[18] text-theme-on-surface font-bold bg-theme-surface-variant rounded-full text-center p-3">{{ $lastEvent }}</text>
        </column>

    </column>
</scroll-view>
