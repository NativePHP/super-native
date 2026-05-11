<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasIkeaData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class IkeaSearch extends NativeComponent
{
    use HasIkeaData;

    public string $searchQuery = '';

    public string $selectedRoom = '';

    public function updateSearch(string $value): void
    {
        $this->searchQuery = $value;
    }

    public function selectRoom(string $room): void
    {
        $this->selectedRoom = $this->selectedRoom === $room ? '' : $room;
    }

    public function viewProduct(int $index): void
    {
        $this->navigate($this->route('ikea.product', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): \Illuminate\View\View
    {
        $allProducts = self::ikeaProducts();
        $categories = self::ikeaCategories();

        $results = [];
        foreach ($allProducts as $i => $product) {
            $matchesSearch = $this->searchQuery === '' ||
                str_contains(strtolower($product['name']), strtolower($this->searchQuery)) ||
                str_contains(strtolower($product['seriesName']), strtolower($this->searchQuery)) ||
                str_contains(strtolower($product['category']), strtolower($this->searchQuery));

            $matchesRoom = $this->selectedRoom === '' || $product['category'] === $this->selectedRoom;

            if ($matchesSearch && $matchesRoom) {
                $product['originalIndex'] = $i;
                $product['priceFormatted'] = self::formatIkeaPrice($product['price']);
                $product['originalPriceFormatted'] = $product['originalPrice'] ? self::formatIkeaPrice($product['originalPrice']) : null;
                $product['reviewFormatted'] = self::formatIkeaReviewCount($product['reviewCount']);
                $results[] = $product;
            }
        }

        return view('ikea-search', [
            'categories' => $categories,
            'results' => $results,
            'resultCount' => count($results),
        ]);
    }
}
