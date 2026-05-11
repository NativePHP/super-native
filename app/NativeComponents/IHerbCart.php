<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasIHerbData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;

class IHerbCart extends NativeComponent
{
    use HasIHerbData;

    /** @var array<int, int> */
    public array $cartItems = [0 => 1, 2 => 2, 4 => 1];

    public function incrementItem(int $productIndex): void
    {
        if (isset($this->cartItems[$productIndex]) && $this->cartItems[$productIndex] < 10) {
            $this->cartItems[$productIndex]++;
        }
    }

    public function decrementItem(int $productIndex): void
    {
        if (isset($this->cartItems[$productIndex])) {
            if ($this->cartItems[$productIndex] <= 1) {
                unset($this->cartItems[$productIndex]);
            } else {
                $this->cartItems[$productIndex]--;
            }
        }
    }

    public function removeItem(int $productIndex): void
    {
        unset($this->cartItems[$productIndex]);
    }

    public function checkout(): void
    {
        Dialog::alert('Order Placed!', 'Your order has been submitted. Free shipping on orders over $30!');
    }

    public function render(): \Illuminate\View\View
    {
        $allProducts = self::iherbProducts();
        $items = [];
        $subtotal = 0.0;

        foreach ($this->cartItems as $productIndex => $qty) {
            if (isset($allProducts[$productIndex])) {
                $product = $allProducts[$productIndex];
                $lineTotal = $product['price'] * $qty;
                $subtotal += $lineTotal;
                $items[] = [
                    'productIndex' => $productIndex,
                    'name' => $product['name'],
                    'brand' => $product['brand'],
                    'imageUrl' => $product['imageUrl'],
                    'price' => $product['price'],
                    'priceFormatted' => self::formatPrice($product['price']),
                    'qty' => $qty,
                    'lineTotalFormatted' => self::formatPrice($lineTotal),
                ];
            }
        }

        $freeShipping = $subtotal >= 30;

        return view('iherb-cart', [
            'items' => $items,
            'subtotalFormatted' => self::formatPrice($subtotal),
            'freeShipping' => $freeShipping,
            'itemCount' => array_sum($this->cartItems),
        ]);
    }
}
