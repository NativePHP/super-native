<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasListingData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;

class ListingDetail extends NativeComponent
{
    use HasListingData;

    /** @var array */
    public array $listing = [];

    /** @var array<int, array> */
    public array $listingReviews = [];

    public int $listingId = 0;

    public bool $isWishlisted = false;

    public bool $showFullDescription = false;

    public int $currentImage = 0;

    public function mount(): void
    {
        nativephp_call('UI.SetBackground', json_encode(['color' => '#FFFFFF']));

        $this->listingId = (int) $this->param('id');
        $listings = self::listings();
        $allReviews = self::reviews();

        $this->listing = $listings[$this->listingId] ?? $listings[0];
        $this->listingReviews = $allReviews[$this->listingId] ?? $allReviews[0] ?? [];
    }

    public function toggleWishlist(): void
    {
        $this->isWishlisted = ! $this->isWishlisted;
    }

    public function toggleDescription(): void
    {
        $this->showFullDescription = ! $this->showFullDescription;
    }

    public function nextImage(): void
    {
        $count = count($this->listing['images']);
        $this->currentImage = ($this->currentImage + 1) % $count;
    }

    public function prevImage(): void
    {
        $count = count($this->listing['images']);
        $this->currentImage = ($this->currentImage - 1 + $count) % $count;
    }

    public function reserve(): void
    {
        Dialog::alert('Reservation Requested', 'Your reservation for ' . $this->listing['title'] . ' has been submitted!');
    }

    public function render(): \Illuminate\View\View
    {
        $bathroomsFormatted = $this->listing['bathrooms'] == floor($this->listing['bathrooms'])
            ? (int) $this->listing['bathrooms']
            : $this->listing['bathrooms'];

        return view('listing-detail', [
            'bathroomsFormatted' => $bathroomsFormatted,
            'currentImageUrl' => $this->listing['images'][$this->currentImage] ?? $this->listing['imageUrl'],
            'imageCount' => count($this->listing['images']),
        ]);
    }
}
