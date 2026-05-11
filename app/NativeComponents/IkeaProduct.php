<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasIkeaData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;

class IkeaProduct extends NativeComponent
{
    use HasIkeaData;

    /** @var array */
    public array $product = [];

    public int $quantity = 1;

    public bool $isFavorited = false;

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $products = self::ikeaProducts();
        $this->product = $products[$id] ?? $products[0];
    }

    public function incrementQty(): void
    {
        if ($this->quantity < 10) {
            $this->quantity++;
        }
    }

    public function decrementQty(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function toggleFavorite(): void
    {
        $this->isFavorited = ! $this->isFavorited;
    }

    public function addToCart(): void
    {
        Dialog::alert('Added to bag', $this->quantity . 'x ' . $this->product['seriesName'] . ' ' . $this->product['name'] . ' added to your shopping bag.');
    }

    public function render(): \Illuminate\View\View
    {
        return view('ikea-product', [
            'priceFormatted' => self::formatIkeaPrice($this->product['price']),
            'originalPriceFormatted' => $this->product['originalPrice'] ? self::formatIkeaPrice($this->product['originalPrice']) : null,
            'reviewFormatted' => self::formatIkeaReviewCount($this->product['reviewCount']),
            'totalFormatted' => self::formatIkeaPrice($this->product['price'] * $this->quantity),
        ]);
    }
}