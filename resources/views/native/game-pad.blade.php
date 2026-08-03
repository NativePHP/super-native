@php
    use App\Icons\Android;
    use App\Icons\Ios;

    $facingIos = match ($facing) {
        'up' => Ios::ChevronUp,
        'down' => Ios::ChevronDown,
        'left' => Ios::ChevronLeft,
        default => Ios::ChevronRight,
    };
    $facingAndroid = match ($facing) {
        'up' => Android::KeyboardArrowUp,
        'down' => Android::KeyboardArrowDown,
        'left' => Android::KeyboardArrowLeft,
        default => Android::KeyboardArrowRight,
    };

    // Wall edges sit flush inside the 320pt arena: 160 - (8pt bar / 2).
    $wallOffset = 156;
    $wallClass = fn (string $side) => $flashingWall === $side ? 'bg-theme-destructive' : 'bg-theme-outline-variant';
@endphp

<column class="w-full h-full items-center px-6 py-4 gap-4 bg-theme-background">
    <text class="text-sm text-theme-on-surface-variant text-center">
        Hold the d-pad to move · hold FIRE to shoot · hold SHIELD to guard
    </text>

    {{-- Arena — everything inside is positioned via translate offsets from center. --}}
    <stack class="w-80 h-80 rounded-2xl bg-theme-surface items-center justify-center">
        {{-- Walls — the edge a shot connects with flashes red for a few ticks. --}}
        <stack class="w-full h-2 rounded-full {{ $wallClass('up') }}" :translate-y="-$wallOffset"/>
        <stack class="w-full h-2 rounded-full {{ $wallClass('down') }}" :translate-y="$wallOffset"/>
        <stack class="w-2 h-full rounded-full {{ $wallClass('left') }}" :translate-x="-$wallOffset"/>
        <stack class="w-2 h-full rounded-full {{ $wallClass('right') }}" :translate-x="$wallOffset"/>

        {{-- Shots --}}
        @foreach ($shots as $shot)
            <stack :native:key="'shot-'.$shot['id']"
                   class="w-3 h-3 rounded-full bg-theme-accent"
                   :translate-x="$shot['x']" :translate-y="$shot['y']"
                   :animate-duration="50" animate-easing="linear"/>
        @endforeach

        {{-- Character — turns green with a shield icon while SHIELD is held. --}}
        <stack class="w-11 h-11 rounded-xl items-center justify-center shadow-md {{ $shieldRaised ? 'bg-theme-success' : 'bg-theme-primary' }}"
               :translate-x="$x" :translate-y="$y"
               :animate-duration="50" animate-easing="linear">
            @if ($shieldRaised)
                <native:icon :size="24" a11y-label="Shielded"
                             class="text-theme-on-success"
                             :ios="Ios::ShieldFill" :android="Android::Shield"/>
            @else
                <native:icon :size="24" a11y-label="Facing {{ $facing }}"
                             class="text-theme-on-primary"
                             :ios="$facingIos" :android="$facingAndroid"/>
            @endif
        </stack>
    </stack>

    <row class="w-full items-center justify-between px-2">
        {{-- D-pad — @tapDown starts moving, @tapUp stops. Held button lights up. --}}
        <column class="items-center gap-1">
            <pressable @tapDown="startMove('up')" @tapUp="stopMove" press-scale="0.92"
                       class="w-14 h-14 rounded-xl items-center justify-center {{ $moving === 'up' ? 'bg-theme-primary' : 'bg-theme-surface-variant' }}">
                <native:icon :size="28" a11y-label="Move up"
                             class="{{ $moving === 'up' ? 'text-theme-on-primary' : 'text-theme-on-surface-variant' }}"
                             :ios="Ios::ChevronUp" :android="Android::KeyboardArrowUp"/>
            </pressable>
            <row class="gap-1 items-center">
                <pressable @tapDown="startMove('left')" @tapUp="stopMove" press-scale="0.92"
                           class="w-14 h-14 rounded-xl items-center justify-center {{ $moving === 'left' ? 'bg-theme-primary' : 'bg-theme-surface-variant' }}">
                    <native:icon :size="28" a11y-label="Move left"
                                 class="{{ $moving === 'left' ? 'text-theme-on-primary' : 'text-theme-on-surface-variant' }}"
                                 :ios="Ios::ChevronLeft" :android="Android::KeyboardArrowLeft"/>
                </pressable>
                <stack class="w-14 h-14 rounded-xl bg-theme-surface items-center justify-center">
                    <stack class="w-3 h-3 rounded-full bg-theme-outline"/>
                </stack>
                <pressable @tapDown="startMove('right')" @tapUp="stopMove" press-scale="0.92"
                           class="w-14 h-14 rounded-xl items-center justify-center {{ $moving === 'right' ? 'bg-theme-primary' : 'bg-theme-surface-variant' }}">
                    <native:icon :size="28" a11y-label="Move right"
                                 class="{{ $moving === 'right' ? 'text-theme-on-primary' : 'text-theme-on-surface-variant' }}"
                                 :ios="Ios::ChevronRight" :android="Android::KeyboardArrowRight"/>
                </pressable>
            </row>
            <pressable @tapDown="startMove('down')" @tapUp="stopMove" press-scale="0.92"
                       class="w-14 h-14 rounded-xl items-center justify-center {{ $moving === 'down' ? 'bg-theme-primary' : 'bg-theme-surface-variant' }}">
                <native:icon :size="28" a11y-label="Move down"
                             class="{{ $moving === 'down' ? 'text-theme-on-primary' : 'text-theme-on-surface-variant' }}"
                             :ios="Ios::ChevronDown" :android="Android::KeyboardArrowDown"/>
            </pressable>
        </column>

        {{-- Action buttons — icons recolor only while held. --}}
        <column class="items-center gap-3">
            <column class="items-center gap-1">
                <pressable @tapDown="raiseShield" @tapUp="lowerShield" press-scale="0.92"
                           class="w-16 h-16 rounded-full items-center justify-center {{ $shieldRaised ? 'bg-theme-success' : 'bg-theme-surface-variant' }}">
                    <native:icon :size="30" a11y-label="Shield"
                                 class="{{ $shieldRaised ? 'text-theme-on-success' : 'text-theme-on-surface-variant' }}"
                                 :ios="Ios::ShieldFill" :android="Android::Shield"/>
                </pressable>
                <text class="text-xs font-semibold text-theme-on-surface-variant">SHIELD</text>
            </column>
            <column class="items-center gap-1">
                <pressable @tapDown="startFire" @tapUp="stopFire" press-scale="0.92"
                           class="w-16 h-16 rounded-full items-center justify-center {{ $firing ? 'bg-theme-destructive' : 'bg-theme-surface-variant' }}">
                    <native:icon :size="30" a11y-label="Fire"
                                 class="{{ $firing ? 'text-theme-on-destructive' : 'text-theme-on-surface-variant' }}"
                                 :ios="Ios::FlameFill" :android="Android::LocalFireDepartment"/>
                </pressable>
                <text class="text-xs font-semibold text-theme-on-surface-variant">FIRE</text>
            </column>
        </column>
    </row>

    <text class="text-sm text-theme-on-surface-variant">Wall hits: {{ $wallHits }}</text>
</column>
