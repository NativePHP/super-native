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
