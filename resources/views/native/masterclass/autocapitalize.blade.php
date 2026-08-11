<scroll-view class="w-full h-full bg-theme-background">
    <column class="w-full p-4 gap-8">

        <column class="gap-1">
            <text class="text-2xl font-bold">#304 · Autocapitalization</text>
            <text class="text-sm opacity-60">
                Tap each field and type a letter. Watch the FIRST character, and watch
                the shift key on the keyboard.
            </text>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             1. The repro from the issue. keyboardType sets the key layout
                only — SwiftUI's TextField still defaulted to .sentences,
                which is why the email keyboard appeared AND the first
                letter capitalized.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">1. keyboard="email" — the repro</text>
            <text class="text-sm opacity-60">
                Expected: email keyboard, and the first letter stays lower case.
                Autocorrect is off too — it used to try to "correct" the local part.
            </text>
            <outlined-text-input native:model="email" label="Email" keyboard="email" />
            <text class="text-sm opacity-60">Value: {{ $email === '' ? '(empty)' : $email }}</text>
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             2. url — same derivation, a second case-sensitive keyboard.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">2. keyboard="url"</text>
            <text class="text-sm opacity-60">
                Also case-sensitive, also derives to no capitalization.
            </text>
            <outlined-text-input native:model="url" label="Website" keyboard="url" />
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             3. Explicit override — the second thing the issue asked for
                ("there does not appear to be a separate attribute").
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">3. Explicit autocapitalize</text>
            <text class="text-sm opacity-60">
                For what a keyboard type can't imply. "words" capitalizes each word —
                a name field. "characters" shouts everything — a reference code.
            </text>
            <outlined-text-input native:model="name" label="Full name" autocapitalize="words" />
            <outlined-text-input native:model="code" label="Booking reference" autocapitalize="characters" />
        </column>

        {{-- ─────────────────────────────────────────────────────────────
             4. The override beating a derived value, and the one place the
                platforms deliberately still differ.
        ───────────────────────────────────────────────────────────────── --}}
        <column class="gap-2">
            <text class="text-lg font-bold">4. Override beats the keyboard type</text>
            <text class="text-sm opacity-60">
                An email keyboard that DOES capitalize sentences. Nonsense in practice,
                but it proves the explicit value wins over the derived one.
            </text>
            <outlined-text-input
                native:model="forced"
                label="Email, forced to sentences"
                keyboard="email"
                autocapitalize="sentences"
            />
        </column>

        <column class="gap-2">
            <text class="text-lg font-bold">5. Plain text, nothing specified ⚠️</text>
            <text class="text-sm opacity-60">
                THE ONE SECTION EXPECTED TO DIFFER. iOS capitalizes sentences (its own
                long-standing default, unchanged here); Android does not (Compose's
                default, also unchanged).
            </text>
            <text class="text-sm opacity-60">
                Unifying it would mean silently capitalizing every unclassified text
                field in every existing Android app, so it is left as a separate call.
                Set autocapitalize="sentences" explicitly if you want it on both.
            </text>
            <outlined-text-input native:model="plain" label="Plain text field" />
        </column>

        <column class="h-8"></column>
    </column>
</scroll-view>
