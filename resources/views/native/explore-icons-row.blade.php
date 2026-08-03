{{-- One virtual-list row: 3 uniform square icon cells. Rendered once per
     window index with ['index']; $iconCatalog is shared by ExploreIcons.
     The final row pads with empty cells so grid columns stay aligned. --}}
@php($cases = array_slice($iconCatalog['cases'], $index * 3, 3))
<row :key="'icons-'.$index" class="w-full gap-2 pb-3">
    @foreach ($cases as $case)
        <pressable @tap="showIcon('{{ $case->name }}')"
                   a11y-label="{{ \Illuminate\Support\Str::headline($case->name) }}"
                   class="flex-1 h-[84] items-center justify-center bg-theme-surface-variant rounded-lg">
            <icon :ios="$iconCatalog['ios'] ? $case : null"
                  :android="$iconCatalog['ios'] ? null : $case"
                  :size="36" class="text-theme-on-surface"/>
        </pressable>
    @endforeach
    @for ($pad = count($cases); $pad < 3; $pad++)
        <column class="flex-1"/>
    @endfor
</row>
