<?php

namespace App\NativeComponents;

use App\Icons\Android;
use App\Icons\Ios;
use Illuminate\View\View;
use Native\Mobile\Edge\Concerns\HasVirtualListWindow;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Platform;

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

    /** Cells per row — keep in sync with the slice in explore-icons-row.blade.php. */
    private const PER_ROW = 3;

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
            ->displayMode('inline')
            ->font('Audiowide-Regular')
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

    public function render(): View
    {
        $catalog = $this->catalog();
        $total = count($catalog['cases']);
        $rowCount = (int) ceil($total / self::PER_ROW);

        $from = max(0, min($this->virtualWindowFrom, max(0, $rowCount - 1)));
        $to = min(max(0, $rowCount - 1), max($from, $this->virtualWindowTo));

        // The virtual list's `item` view renders once per window index with
        // only ['index'] in scope — share the filtered catalog so row views
        // can slice it (see explore-icons-row.blade.php).
        view()->share('iconCatalog', $catalog);

        return view('native.explore-icons', [
            'catalog' => $catalog,
            'total' => $total,
            'rowCount' => $rowCount,
            'from' => $from,
            'to' => $to,
            'query' => $this->query,
            'selectedCase' => $this->selectedCase($catalog['enum']),
            'enumShort' => class_basename($catalog['enum']),
        ]);
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
