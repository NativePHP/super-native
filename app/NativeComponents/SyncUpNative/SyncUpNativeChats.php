<?php

namespace App\NativeComponents\SyncUpNative;

use App\NativeComponents\Concerns\HasSyncUpData;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\Layouts\Builders\NavAction;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class SyncUpNativeChats extends NativeComponent
{
    use HasSyncUpData;

    public string $activeFilter = 'All';

    public string $search = '';

    public bool $showNewMessage = false;

    public function navTitle(): string
    {
        return 'SyncUp';
    }

    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()
            ->action(NavAction::make('more')->icon('ellipsis')->press('openMenu'));
    }

    public function setFilter(string $name): void
    {
        $this->activeFilter = $name;
    }

    public function updateSearch(string $value): void
    {
        $this->search = $value;
    }

    public function openChat(int $id): void
    {
        $this->navigate("/syncup-native/chat/{$id}")
            ->transition(Transition::SlideFromRight);
    }

    public function newMessage(): void
    {
        $this->showNewMessage = true;
    }

    public function closeNewMessage(): void
    {
        $this->showNewMessage = false;
    }

    public function startChatWith(int $userId): void
    {
        $this->showNewMessage = false;
        $this->navigate("/syncup-native/chat/{$userId}")
            ->transition(Transition::SlideFromRight);
    }

    public function addSuggestion(int $id): void { /* stub */ }
    public function openSearch(): void           { /* stub */ }
    public function openMenu(): void             { /* stub */ }

    public function render(): Element
    {
        $users = self::suUsers();
        $conversations = self::suConversations();

        $rows = [];
        foreach ($conversations as $c) {
            if ($c['isGroup']) {
                $rows[] = $c + [
                    'displayName' => $c['name'],
                    'avatarUrl' => null,
                ];
            } else {
                $u = self::suUser($c['userId']);
                $rows[] = $c + [
                    'displayName' => $u['name'],
                    'avatarUrl' => $u['avatarUrl'],
                    'status' => $u['status'],
                ];
            }
        }

        $friends = array_values(array_filter($users, fn ($u) => $u['id'] !== 0));

        return $this->view('syncup.chats', [
            'rows' => $rows,
            'filters' => self::suFilters(),
            'suggestions' => self::suSuggestions(),
            'friends' => $friends,
        ]);
    }
}
