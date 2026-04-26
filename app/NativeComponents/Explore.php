<?php

namespace App\NativeComponents;

use Illuminate\Support\Str;
use Native\Mobile\Attributes\OnNative;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Events\Alert\ButtonPressed;
use Native\Mobile\Facades\Dialog;

class Explore extends NativeComponent
{
    public int $count = 0;

    public string $lastButton = '';

    public array $items = [];

    public int $page = 1;

    public int $refreshCount = 0;

    public bool $showModal = false;

    public bool $showSheet = false;

    // Slider demo — native:model.live binds this straight across the bridge.
    public float $slideValue = 0.0;

    public float $slideDebounced = 50.0;

    public float $slideBlur = 25.0;

    // Checkbox demo
    public bool $subscribed = true;

    public bool $termsAccepted = false;

    // Select demo
    public string $favoriteLanguage = 'PHP';

    // Radio demo
    public string $pricingPlan = 'pro';

    // Tab row demo
    public int $activeTab = 0;

    // Button-group demo
    public int $planTier = 1;

    public function mount(): void
    {
        nativephp_call('UI.SetBackground', json_encode(['color' => '#FFFFFF']));
        $this->items = $this->fetchUsers($this->page);
    }

    public function showAlert()
    {
        Dialog::alert('Hello', 'Pick an option', ['Cancel', 'OK']);
    }

    #[OnNative(ButtonPressed::class)]
    public function handleAlert(int $index, string $label, ?string $id = null): void
    {
        $this->lastButton = $label;
    }

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function refreshList()
    {
        $this->refreshCount++;
        $this->page = 1;
        $this->items = $this->fetchUsers($this->page);
    }

    public function loadMore()
    {
        $this->page++;
        $newItems = $this->fetchUsers($this->page);
        $this->items = array_merge($this->items, $newItems);
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function openSheet()
    {
        $this->showSheet = true;
    }

    public function closeSheet()
    {
        $this->showSheet = false;
    }

    public function removeItem(int $id)
    {
        $this->items = array_values(array_filter($this->items, fn ($i) => $i['id'] !== $id));
    }

    // ── Primitive-composed component helpers ──────────────────────────────

    /** Flip any bool property by name — used by checkbox + chip primitive demos. */
    public function toggleField(string $field): void
    {
        if (property_exists($this, $field) && is_bool($this->{$field})) {
            $this->{$field} = ! $this->{$field};
        }
    }

    public function selectPricingPlan(string $value): void
    {
        $this->pricingPlan = $value;
    }

    public function selectTab(int $index): void
    {
        $this->activeTab = $index;
    }

    public function selectPlanTier(int $index): void
    {
        $this->planTier = $index;
    }

    private function fetchUsers(int $page): array
    {
        try {
            $response = json_decode(
                file_get_contents('https://jsonplaceholder.typicode.com/posts?'.http_build_query([
                    '_page' => $page,
                    '_limit' => 10,
                ])),
                true
            );

            return collect($response ?? [])->map(fn ($post, $index) => [
                'id' => $post['id'],
                'name' => 'User '.$index + 1,
                'description' => Str::limit($post['title'], 60),
                'email' => 'user'.$post['userId'].'@example.com',
                'city' => 'Post #'.$post['id'],
            ])->all();
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function render(): Element
    {
        return $this->view('explore');
    }
}
