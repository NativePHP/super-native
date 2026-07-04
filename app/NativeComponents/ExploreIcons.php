<?php

namespace App\NativeComponents;

use App\Icons\Android;
use App\Icons\Ios;
use Illuminate\Support\Str;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\Elements\Column;
use Native\Mobile\Edge\Elements\Icon;
use Native\Mobile\Edge\Elements\Pressable;
use Native\Mobile\Edge\Elements\Row;
use Native\Mobile\Edge\Elements\Text;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Traits\HasVirtualListWindow;
use Native\Mobile\Platform;
use Nativephp\NativeUi\Elements\BottomSheet;
use Nativephp\NativeUi\Elements\NativeVirtualList;

/**
 * Catalog browser for the current platform's icon set — SF Symbols on
 * iOS (~7,800), Material on Android (~2,100).
 *
 * Icon-only grid (uniform square cells); tap a cell for a bottom sheet
 * with the enum reference and the raw symbol name. Search via the nav
 * bar narrows by case name.
 *
 * The catalogs are far too large to publish as one wire tree, so the
 * grid is a `virtual_list` of icon rows: native renders `count` logical
 * slots and fires `on_window_change(from, to)` as the visible range
 * moves; PHP only materializes the ~80 rows inside the window. Payload
 * stays ~constant no matter how big the catalog gets.
 */
class ExploreIcons extends NativeComponent
{
    use HasVirtualListWindow;

    private const PER_ROW = 3;

    private const CELL_SIZE = 84;

    /** Fixed row height (CELL_SIZE + row bottom padding) — placeholders match exactly. */
    private const ESTIMATED_ROW_HEIGHT = 96;

    public string $query = '';

    /** Case name of the icon shown in the detail sheet (null = closed). */
    public ?string $selectedName = null;

    public function navTitle(): string
    {
        return 'Icons';
    }

    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()
            ->searchBar('Search icons...', 'findIcon');
    }

    public function findIcon(string $query): void
    {
        $this->query = trim($query);

        // A narrower result set may not reach the old window — snap back
        // to the top so the first matches are what's on screen.
        $this->setVirtualWindow(0, 79);
    }

    public function showIcon(string $caseName): void
    {
        $this->selectedName = $caseName;
    }

    public function closeIconSheet(): void
    {
        $this->selectedName = null;
    }

    /**
     * @return array{heading: string, ios: bool, enum: class-string, cases: array<int, \UnitEnum>}
     */
    private function catalog(): array
    {
        $ios = ! Platform::isAndroid();
        $enum = $ios ? Ios::class : Android::class;
        $cases = $enum::cases();

        if ($this->query !== '') {
            $needle = strtolower($this->query);
            $cases = array_values(array_filter(
                $cases,
                fn ($case) => str_contains(strtolower($case->name), $needle)
            ));
        }

        return [
            'heading' => $ios ? 'SF Symbols' : 'Material (filled)',
            'ios' => $ios,
            'enum' => $enum,
            'cases' => $cases,
        ];
    }

    public function render(): Element
    {
        $catalog = $this->catalog();
        $cases = $catalog['cases'];
        $total = count($cases);
        $rowCount = (int) ceil($total / self::PER_ROW);

        $root = Column::make()->fill()->class('bg-theme-background');

        $root->addChild(
            Text::make("{$catalog['heading']} — {$total} icons")
                ->class('text-lg font-semibold text-theme-on-background px-5 pt-5')
        );

        if ($total === 0) {
            $root->addChild(
                Text::make("No icons match \"{$this->query}\"")
                    ->class('text-sm text-theme-on-surface-variant px-5 pt-3')
            );

            return $this->wrapWithChrome($root);
        }

        $from = max(0, min($this->virtualWindowFrom, $rowCount - 1));
        $to = min($rowCount - 1, max($from, $this->virtualWindowTo));

        $rows = [];
        for ($i = $from; $i <= $to; $i++) {
            $rows[] = $this->iconRow($cases, $i, $catalog['ios']);
        }

        $list = NativeVirtualList::make(...$rows)
            ->fillWidth()
            ->flexGrow(1)
            ->class('px-5 py-3');
        $list->applyAttributes([
            'count' => $rowCount,
            'window_from' => $from,
            'window_to' => $to,
            'estimated_row_height' => self::ESTIMATED_ROW_HEIGHT,
            'overscan' => 40,
            'on_window_change' => 'setVirtualWindow',
        ]);

        $root->addChild($list);
        $root->addChild($this->detailSheet($catalog));

        // Element-returning render() skips the automatic fromView() chrome
        // wrap — apply it explicitly so the StackLayout TopBar (back
        // chevron, title, search bar) and safe area come back.
        return $this->wrapWithChrome($root);
    }

    /**
     * One logical list row: PER_ROW uniform square icon cells. The final
     * row pads with empty cells so the grid columns stay aligned.
     *
     * @param  array<int, \UnitEnum>  $cases
     */
    private function iconRow(array $cases, int $rowIndex, bool $ios): Element
    {
        $row = Row::make()->fillWidth()->gap(8)->padding(0, 0, 12, 0)->key("icons-{$rowIndex}");
        $slice = array_slice($cases, $rowIndex * self::PER_ROW, self::PER_ROW);

        foreach ($slice as $case) {
            $icon = $ios
                ? Icon::make(ios: $case)->size(36)->class('text-slate-800 dark:text-white')
                : Icon::make(android: $case)->size(36)->class('text-slate-800 dark:text-white');

            $row->addChild(
                Pressable::make($icon)
                    ->onPress("showIcon('{$case->name}')")
                    ->a11yLabel(Str::headline($case->name))
                    ->flexGrow(1)->flexBasis(0)->height(self::CELL_SIZE)
                    ->center()->class('bg-theme-surface-variant rounded-lg')
            );
        }

        for ($pad = count($slice); $pad < self::PER_ROW; $pad++) {
            $row->addChild(Column::make()->flexGrow(1)->flexBasis(0));
        }

        return $row;
    }

    /**
     * Bottom sheet with the tapped icon's enum reference and raw symbol
     * name — always in the tree, visibility driven by [$selectedName].
     *
     * @param  array{heading: string, ios: bool, enum: class-string, cases: array<int, \UnitEnum>}  $catalog
     */
    private function detailSheet(array $catalog): Element
    {
        $case = $this->selectedCase($catalog['enum']);

        $sheet = BottomSheet::make()
            ->visible($case !== null)
            ->detents('small')
            ->onDismiss('closeIconSheet');

        if ($case === null) {
            return $sheet;
        }

        $preview = $catalog['ios']
            ? Icon::make(ios: $case)->size(112)->class('text-slate-800 dark:text-white')
            : Icon::make(android: $case)->size(112)->class('text-slate-800 dark:text-white');

        $enumShort = class_basename($catalog['enum']);

        $sheet->addChild(
            Column::make(
                $preview,
                Text::make("{$enumShort}::{$case->name}")
                    ->class('text-base font-semibold text-theme-on-surface text-center'),
                Text::make($case->value)
                    ->class('text-sm text-theme-on-surface-variant text-center'),
            )->fillWidth()->gap(10)->padding(24)->center()
        );

        return $sheet;
    }

    private function selectedCase(string $enum): ?\UnitEnum
    {
        if ($this->selectedName === null) {
            return null;
        }

        foreach ($enum::cases() as $case) {
            if ($case->name === $this->selectedName) {
                return $case;
            }
        }

        return null;
    }
}
