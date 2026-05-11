<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasIHerbData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class IHerbCategory extends NativeComponent
{
    use HasIHerbData;

    /** @var array{name: string, icon: string, productCount: int} */
    public array $category = [];

    /** @var array<int, array> */
    public array $categoryProducts = [];

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $categories = self::iherbCategories();
        $this->category = $categories[$id] ?? $categories[0];

        $allProducts = self::iherbProducts();
        $this->categoryProducts = array_values(
            array_filter($allProducts, fn (array $p): bool => $p['category'] === $this->category['name'])
        );
    }

    public function viewProduct(int $index): void
    {
        $this->navigate($this->route('iherb.product', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): \Illuminate\View\View
    {
        $allProducts = self::iherbProducts();
        $productsWithMeta = [];

        foreach ($this->categoryProducts as $product) {
            $originalIndex = array_search($product, $allProducts);
            $product['originalIndex'] = $originalIndex;
            $product['reviewFormatted'] = self::formatReviewCount($product['reviewCount']);
            $product['priceFormatted'] = self::formatPrice($product['price']);
            $product['originalPriceFormatted'] = $product['originalPrice'] ? self::formatPrice($product['originalPrice']) : null;
            $productsWithMeta[] = $product;
        }

        return view('iherb-category', [
            'productsWithMeta' => $productsWithMeta,
            'subcategories' => self::subcategories(),
        ]);
    }
}
