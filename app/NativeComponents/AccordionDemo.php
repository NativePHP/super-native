<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Showcase for `<accordion>` (mobile-ui PR #20) — a disclosure group built
 * from three cooperating tags: `<accordion>` wraps an `<accordion-header>`
 * (always visible, tappable) and an `<accordion-content>` (revealed when
 * expanded). iOS renders a SwiftUI `DisclosureGroup`; Android draws a
 * clickable header row plus a rotating chevron over `AnimatedVisibility`.
 *
 * The three sections exercise the component's whole surface:
 *
 *  1. FAQ — `@change` reporting open/closed back to PHP, so the server
 *     always knows what's on screen (see [$open] and the live tally).
 *  2. Server-driven — the same rows driven the other way, from PHP, via
 *     the `expanded` prop. "Only one at a time" is the classic accordion
 *     behaviour, which the component does NOT do on its own; it falls out
 *     of keeping the state here and letting [openOnly] close the siblings.
 *  3. Rich content — arbitrary children (image, rows, buttons) inside
 *     `<accordion-content>`, to show it is not a text-only container.
 */
class AccordionDemo extends NativeComponent
{
    /**
     * Open/closed state per FAQ row, mirrored from the native side by
     * [setOpen]. Section 1 reads this only to *display* the truth; it
     * deliberately does not feed it back into `expanded`, so the native
     * component stays in charge of its own animation.
     *
     * @var array<string, bool>
     */
    public array $open = [
        'shipping' => false,
        'returns' => true,
        'warranty' => false,
    ];

    /**
     * Which row Section 2 has open, driven entirely from PHP through the
     * `expanded` prop. Empty string means "all closed".
     */
    public string $exclusive = 'specs';

    /** Whether Section 2's rows are all forced open. */
    public bool $allExpanded = false;

    /** Count of change events received, to prove the callback is live. */
    public int $changeCount = 0;

    /**
     * @var array<int, array{id: string, question: string, answer: string}>
     */
    public array $faqs = [
        [
            'id' => 'shipping',
            'question' => 'How long does shipping take?',
            'answer' => 'Standard delivery lands in 3-5 working days. Express is next working day if you order before 3pm. Tracking goes out the moment the parcel leaves the warehouse.',
        ],
        [
            'id' => 'returns',
            'question' => 'What is the returns policy?',
            'answer' => 'Send anything back within 30 days for a full refund, opened or not. Return postage is on us — the label is in the box.',
        ],
        [
            'id' => 'warranty',
            'question' => 'Is there a warranty?',
            'answer' => 'Two years, covering manufacturing defects. Accidental damage is not included, but out-of-warranty repairs are charged at cost.',
        ],
    ];

    /**
     * @var array<int, array{id: string, title: string, icon: string, lines: array<int, string>}>
     */
    public array $sections = [
        [
            'id' => 'specs',
            'title' => 'Specifications',
            'icon' => 'list.bullet',
            'lines' => ['Weight — 1.24 kg', 'Height — 18.4 cm', 'Material — anodised aluminium'],
        ],
        [
            'id' => 'care',
            'title' => 'Care instructions',
            'icon' => 'sparkles',
            'lines' => ['Wipe with a damp cloth', 'Do not submerge', 'Avoid abrasive cleaners'],
        ],
        [
            'id' => 'delivery',
            'title' => 'Delivery & assembly',
            'icon' => 'shippingbox.fill',
            'lines' => ['Flat-packed in one carton', 'Two-person assembly, ~20 minutes', 'Tools included'],
        ],
    ];

    public function navTitle(): string
    {
        return 'Accordion';
    }

    /**
     * `@change` handler for Section 1. The literal id comes from the Blade
     * expression, the bool is appended by the native TOGGLE_CHANGE event.
     */
    public function setOpen(string $id, bool $isOpen): void
    {
        $this->open[$id] = $isOpen;
        $this->changeCount++;
    }

    /**
     * Section 2 — classic one-at-a-time accordion. Tapping the row that is
     * already open closes it, so the group can end up fully collapsed.
     *
     * Trust [$isOpen] from the event rather than inferring the new state by
     * comparing against [$exclusive]: after [expandAll] every row is open
     * while `$exclusive` is empty, so the comparison would read a *close* as
     * an *open* and leave the row badged open after the user shut it.
     */
    public function openOnly(string $id, bool $isOpen): void
    {
        $this->exclusive = $isOpen ? $id : '';
        $this->allExpanded = false;
    }

    public function expandAll(): void
    {
        $this->allExpanded = true;
        $this->exclusive = '';
    }

    public function collapseAll(): void
    {
        $this->allExpanded = false;
        $this->exclusive = '';
    }

    /** How many FAQ rows are currently open, for the live tally chip. */
    public function openCount(): int
    {
        return count(array_filter($this->open));
    }

    public function render(): View
    {
        return view('native.accordion-demo');
    }
}
