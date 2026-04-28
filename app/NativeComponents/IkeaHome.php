<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasIkeaData;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class IkeaHome extends NativeComponent
{
    use HasIkeaData;

    public string $selectedCategory = 'Living Room';

    public function navTitle(): string
    {
        return 'IKEA';
    }

    public function selectCategory(string $category): void
    {
        $this->selectedCategory = $category;
    }

    public function viewProduct(int $index): void
    {
        $this->navigate($this->route('ikea.product', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function viewCart(): void
    {
        $this->navigate($this->route('ikea.cart'))
            ->transition(Transition::SlideFromRight);
    }

    public function viewSearch(): void
    {
        $this->navigate($this->route('ikea.search'))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): Element
    {
        $products = self::ikeaProducts();
        $categories = self::ikeaCategories();

        $newArrivals = [];
        $categoryProducts = [];

        foreach ($products as $i => $product) {
            $product['originalIndex'] = $i;
            $product['priceFormatted'] = self::formatIkeaPrice($product['price']);
            $product['originalPriceFormatted'] = $product['originalPrice'] ? self::formatIkeaPrice($product['originalPrice']) : null;
            $product['reviewFormatted'] = self::formatIkeaReviewCount($product['reviewCount']);

            if ($product['isNew'] || $product['badge'] === 'Top seller') {
                $newArrivals[] = $product;
            }

            if ($product['category'] === $this->selectedCategory) {
                $categoryProducts[] = $product;
            }
        }

        $popular = array_slice($products, 0, 6);
        foreach ($popular as $i => &$p) {
            $p['originalIndex'] = $i;
            $p['priceFormatted'] = self::formatIkeaPrice($p['price']);
            $p['originalPriceFormatted'] = $p['originalPrice'] ? self::formatIkeaPrice($p['originalPrice']) : null;
            $p['reviewFormatted'] = self::formatIkeaReviewCount($p['reviewCount']);
        }

        return $this->view('ikea-home', [
            'categories' => $categories,
            'popular' => $popular,
            'newArrivals' => $newArrivals,
            'categoryProducts' => $categoryProducts,
            'roomIdeas' => self::ikeaRoomIdeas(),
        ]);
    }
}
