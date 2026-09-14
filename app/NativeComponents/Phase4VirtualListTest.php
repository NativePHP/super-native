<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Concerns\HasVirtualListWindow;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\Elements\Column;
use Native\Mobile\Edge\Elements\Pressable;
use Native\Mobile\Edge\Elements\Row;
use Native\Mobile\Edge\Elements\Spacer;
use Native\Mobile\Edge\Elements\Text;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\UI\Elements\NativeVirtualList;

/**
 * Phase 4 — list virtualization verification screen.
 *
 * Uses the canonical native-ui plugin's `NativeVirtualList` element with
 * the `HasVirtualListWindow` trait. PHP only materializes the rows
 * inside `[virtualWindowFrom..virtualWindowTo]`; the rest of the 10k
 * logical rows are rendered as placeholder spacers by the native
 * LazyColumn / List. Native fires `on_window_change(from, to)` (via
 * `setVirtualWindow`) as the visible range moves; the next render
 * emits the new slice.
 *
 * The single observable signal that proves Phase 4 is the BENCH_C
 * `nodes=` field — it stays ~chrome + window-size regardless of
 * TOTAL_ITEMS or scroll position.
 */
class Phase4VirtualListTest extends NativeComponent
{
    use HasVirtualListWindow;

    /** Logical list size — far bigger than what we materialize. */
    private const TOTAL_ITEMS = 10000;

    public function navTitle(): string
    {
        return 'Phase 4 — Virtual List';
    }

    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()
            ->displayMode('large')
            ->subtitle('Windowed materialization');
    }

    public function backToLauncher(): void
    {
        $this->back();
    }

    public function render(): Element
    {
        // The trait's defaults are [0..79] — clamp to our real total.
        $from = max(0, $this->virtualWindowFrom);
        $to = min(self::TOTAL_ITEMS - 1, $this->virtualWindowTo);

        // Materialize only the rows inside [from..to]. For 10k logical
        // items with a window of ~80, that's ~80 Element constructions
        // per render — vs. 10000 for a naive list.
        $rows = [];
        for ($i = $from; $i <= $to; $i++) {
            $rows[] = Row::make(
                Text::make("row #{$i}")->fontSize(13)->color('#CBD5E1'),
                Spacer::make()->flexGrow(1),
                Text::make(sprintf('%.2f ms', $i * 0.001))
                    ->fontSize(12)->color('#64748B'),
            )
                ->key("row-{$i}")
                ->fillWidth()->padding(8, 12)->bg('#1E293B')->borderRadius(6);
        }

        $list = NativeVirtualList::make(...$rows)
            ->fillWidth()
            ->flexGrow(1);

        // The element's window/count/handler attrs are set via the
        // applyAttributes hook the Blade precompiler also uses — this is
        // the canonical API; there's no fluent setter on the plugin
        // element.
        $list->applyAttributes([
            'count' => self::TOTAL_ITEMS,
            'window_from' => $from,
            'window_to' => $to,
            'estimated_row_height' => 48,
            'overscan' => 40,
            'on_window_change' => 'setVirtualWindow',
        ]);

        $header = Column::make()->fillWidth()->padding(16)->gap(12);

        $header->addChild(
            Pressable::make(
                Row::make(
                    Text::make('<')->fontSize(20)->fontWeight(7)->color('#94A3B8'),
                    Spacer::make()->width(8),
                    Text::make('Back')->fontSize(15)->color('#94A3B8'),
                )->gap(0)
            )->onPress('backToLauncher')->padding(4, 0, 4, 0)
        );

        $header->addChild(
            Text::make('Phase 4 verification')
                ->fontSize(22)->fontWeight(7)->color('#F1F5F9')
        );
        $header->addChild(
            Text::make(sprintf(
                '%d logical items, current window = [%d..%d]. Scroll the list — '.
                'native fires on_window_change when the visible range drifts past '.
                'the materialized slice, and the next render emits the new slice.',
                self::TOTAL_ITEMS,
                $from,
                $to,
            ))->fontSize(13)->color('#94A3B8')
        );

        $root = Column::make()->fill()->safeArea()->bg('#0F172A');
        $root->addChild($header);
        $root->addChild($list);

        return $root;
    }
}
