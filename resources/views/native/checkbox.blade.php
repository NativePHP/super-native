@ios
<native:pressable @press="toggleChecked">
    <native:row class="items-center gap-2">
        <native:icon :name="$isChecked ? 'check_box' : 'check_box_outline'" :size="22"
                     :color="$isChecked ? '#14B8A6' : '#475569'"/>
        @if($label)
            <native:text>{{ $label }}</native:text>
        @endif
    </native:row>
</native:pressable>
@else
    <native:checkbox />
@endios
