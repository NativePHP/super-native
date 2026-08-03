<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\Elements\Column;
use Native\Mobile\Edge\Elements\Pressable;
use Native\Mobile\Edge\Elements\Text;
use Native\Mobile\Edge\NativeComponent;

/**
 * Minimal CHILD component used by EdgeChildTest to verify child-owned
 * callback dispatch. Auto-discovered as <native:edge-child-test-card>.
 * The @tap lives INSIDE this child, so its callback registers in the
 * child's own registry rather than the mounting screen's.
 */
class EdgeChildTestCard extends NativeComponent
{
    /** Prop assigned from the mounting tag. */
    public string $label = 'Child';

    /** Child-local state; bumps within the request's dispatch → render cycle. */
    public int $taps = 0;

    public function childTapped(): void
    {
        $this->taps++;

        // Bubbles to the parent's @child-tapped tag binding (screen state
        // is snapshotted, so this survives across renders).
        $this->emit('child-tapped', $this->taps);
    }

    public function render(): Element
    {
        return Column::make(
            Text::make("{$this->label}: child taps {$this->taps}")->fontSize(15),
            Pressable::make(
                Text::make('Tap child')->fontSize(16)->fontWeight(7),
            )->onTap('childTapped')->padding(8),
        )->gap(8)->padding(12);
    }
}
