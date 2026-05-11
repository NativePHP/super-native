<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasIkeaData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;

class IkeaCart extends NativeComponent
{
    use HasIkeaData;

    /** @var array<int, int> */
    public array $cartItems = [0 => 1, 1 => 1, 5 => 2];

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
        Dialog::alert('Order Placed!', 'Your order has been submitted. You will receive a confirmation email shortly.');
    }

    public function render(): \Illuminate\View\View
    {
        $allProducts = self::ikeaProducts();
        $items = [];
        $subtotal = 0.0;

        foreach ($this->cartItems as $productIndex => $qty) {
            if (isset($allProducts[$productIndex])) {
                $product = $allProducts[$productIndex];
                $lineTotal = $product['price'] * $qty;
                $subtotal += $lineTotal;
                $items[] = [
                    'productIndex' => $productIndex,
                    'seriesName' => $product['seriesName'],
                    'name' => $product['name'],
                    'imageUrl' => $product['imageUrl'],
                    'price' => $product['price'],
                    'priceFormatted' => self::formatIkeaPrice($product['price']),
                    'color' => $product['color'],
                    'qty' => $qty,
                    'lineTotalFormatted' => self::formatIkeaPrice($lineTotal),
                ];
            }
        }

        $deliveryFee = $subtotal >= 500 ? 0.0 : 49.00;

        return view('ikea-cart', [
            'items' => $items,
            'subtotalFormatted' => self::formatIkeaPrice($subtotal),
            'deliveryFeeFormatted' => $deliveryFee > 0 ? self::formatIkeaPrice($deliveryFee) : 'FREE',
            'totalFormatted' => self::formatIkeaPrice($subtotal + $deliveryFee),
            'freeDelivery' => $deliveryFee === 0.0,
            'itemCount' => array_sum($this->cartItems),
        ]);
    }
}
