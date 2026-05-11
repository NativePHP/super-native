<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasIHerbData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class IHerbStore extends NativeComponent
{
    use HasIHerbData;

    public string $selectedBestSellerCategory = 'Supplements';

    public function selectBestSellerCategory(string $category): void
    {
        $this->selectedBestSellerCategory = $category;
    }

    public function viewProduct(int $index): void
    {
        $this->navigate($this->route('iherb.product', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function viewCategory(int $index): void
    {
        $this->navigate($this->route('iherb.category', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function viewCart(): void
    {
        $this->navigate($this->route('iherb.cart'))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): \Illuminate\View\View
    {
        $products = self::iherbProducts();
        $categories = self::iherbCategories();

        $trending = array_slice($products, 0, 6);
        foreach ($trending as $i => &$product) {
            $product['originalIndex'] = $i;
            $product['reviewFormatted'] = self::formatReviewCount($product['reviewCount']);
            $product['priceFormatted'] = self::formatPrice($product['price']);
            $product['originalPriceFormatted'] = $product['originalPrice'] ? self::formatPrice($product['originalPrice']) : null;
        }

        $bestSellers = [];
        foreach ($products as $i => $product) {
            if ($product['category'] === $this->selectedBestSellerCategory) {
                $product['originalIndex'] = $i;
                $product['reviewFormatted'] = self::formatReviewCount($product['reviewCount']);
                $product['priceFormatted'] = self::formatPrice($product['price']);
                $product['originalPriceFormatted'] = $product['originalPrice'] ? self::formatPrice($product['originalPrice']) : null;
                $bestSellers[] = $product;
            }
        }

        return view('iherb-store', [
            'categories' => $categories,
            'healthTopics' => self::healthTopics(),
            'trending' => $trending,
            'bestSellers' => $bestSellers,
        ]);
    }
}
