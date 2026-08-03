@ios
<pressable @tap="toggleChecked">
    <row class="items-center gap-2">
        <icon :name="$isChecked ? 'check_box' : 'check_box_outline'" :size="22"
                     :color="$isChecked ? '#14B8A6' : '#475569'"/>
        @if($label)
            <text>{{ $label }}</text>
        @endif
    </row>
</pressable>
@else
    <checkbox />
@endios
