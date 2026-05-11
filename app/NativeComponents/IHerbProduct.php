<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasIHerbData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;

class IHerbProduct extends NativeComponent
{
    use HasIHerbData;

    /** @var array */
    public array $product = [];

    public int $quantity = 1;

    public bool $isWishlisted = false;

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $products = self::iherbProducts();
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

    public function toggleWishlist(): void
    {
        $this->isWishlisted = ! $this->isWishlisted;
    }

    public function addToCart(): void
    {
        Dialog::alert('Added to Cart', $this->quantity . 'x ' . $this->product['name'] . ' added to your cart.');
    }

    public function render(): \Illuminate\View\View
    {
        return view('iherb-product', [
            'priceFormatted' => self::formatPrice($this->product['price']),
            'originalPriceFormatted' => $this->product['originalPrice'] ? self::formatPrice($this->product['originalPrice']) : null,
            'reviewFormatted' => self::formatReviewCount($this->product['reviewCount']),
            'totalFormatted' => self::formatPrice($this->product['price'] * $this->quantity),
        ]);
    }
}
