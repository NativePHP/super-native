<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

/**
 * Showcase for `<native:bottom-sheet>` and `<native:modal>` — every detent
 * variant + dismissible vs blocking modal, all driven by simple booleans
 * on this component. The user taps a button to open one, then either taps
 * inside it to perform an action or swipes / taps the backdrop to dismiss.
 */
class ExploreSheets extends NativeComponent
{
    /** Bottom-sheet visibility flags (one per variant). */
    public bool $showSmallSheet = false;

    public bool $showMediumSheet = false;

    public bool $showCustomSheet = false;

    public bool $showActionSheet = false;

    /** Modal visibility flags. */
    public bool $showDismissibleModal = false;

    public bool $showBlockingModal = false;

    /** Echo the last action so you can see the press handler fired. */
    public string $lastAction = '';

    public function navTitle(): string
    {
        return 'Sheets & Modals';
    }

    // ── Bottom-sheet open handlers ──

    public function openSmallSheet(): void     { $this->showSmallSheet = true; }
    public function openMediumSheet(): void    { $this->showMediumSheet = true; }
    public function openCustomSheet(): void    { $this->showCustomSheet = true; }
    public function openActionSheet(): void    { $this->showActionSheet = true; }

    // ── Bottom-sheet dismiss handlers ──

    public function closeSmallSheet(): void    { $this->showSmallSheet = false; }
    public function closeMediumSheet(): void   { $this->showMediumSheet = false; }
    public function closeCustomSheet(): void   { $this->showCustomSheet = false; }
    public function closeActionSheet(): void   { $this->showActionSheet = false; }

    // ── Modal handlers ──

    public function openDismissibleModal(): void  { $this->showDismissibleModal = true; }
    public function closeDismissibleModal(): void { $this->showDismissibleModal = false; }

    public function openBlockingModal(): void     { $this->showBlockingModal = true; }
    public function confirmBlockingModal(): void
    {
        $this->lastAction = 'Confirmed blocking modal';
        $this->showBlockingModal = false;
    }

    public function cancelBlockingModal(): void
    {
        $this->lastAction = 'Cancelled blocking modal';
        $this->showBlockingModal = false;
    }

    // ── Action-sheet items ──

    public function actionEdit(): void
    {
        $this->lastAction = 'Edit pressed';
        $this->showActionSheet = false;
    }

    public function actionShare(): void
    {
        $this->lastAction = 'Share pressed';
        $this->showActionSheet = false;
    }

    public function actionDelete(): void
    {
        $this->lastAction = 'Delete pressed';
        $this->showActionSheet = false;
    }

    public function render(): \Illuminate\View\View
    {
        return view('explore.sheets');
    }
}
