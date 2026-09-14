@php use App\Icons\Android; use App\Icons\Ios; @endphp
@ios
<pressable @tap="toggleChecked">
    <row class="items-center gap-2">
        <icon :ios="$isChecked ? Ios::CheckmarkSquareFill : Ios::Square" :android="$isChecked ? Android::CheckBox : Android::CheckBoxOutlineBlank" :size="22"
                     :color="$isChecked ? '#14B8A6' : '#475569'"/>
        @if($label)
            <text>{{ $label }}</text>
        @endif
    </row>
</pressable>
@else
    <checkbox />
@endios
