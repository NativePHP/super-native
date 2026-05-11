<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasSyncUpData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class SyncUpFriends extends NativeComponent
{
    use HasSyncUpData;

    public function navTitle(): string
    {
        return 'SyncUp';
    }

    // The layout provides the `search` action; no per-screen overrides
    // needed on this screen. (Override `navigationOptions()` if/when one is.)

    public function scanQr(): void       { /* stub */ }
    public function findById(): void     { /* stub */ }
    public function shareInvite(): void  { /* stub */ }
    public function copyInvite(): void   { /* stub */ }
    public function openSearch(): void   { /* stub */ }

    public function messageFriend(int $id): void
    {
        $this->navigate("/syncup/chat/{$id}")
            ->transition(Transition::SlideFromRight);
    }

    public function addSuggestion(int $id): void
    {
        // Stub.
    }

    public function render(): \Illuminate\View\View
    {
        $users = self::suUsers();

        // Take 3 friends for the list (skip "You" at id=0); the remaining are
        // suggestions (overlap with suSuggestions for the demo). The mockup
        // shows 3 visible friends and 2+ suggestions.
        $friends = array_slice(array_filter($users, fn ($u) => $u['id'] !== 0), 0, 3);
        $onlineCount = count(array_filter($users, fn ($u) => $u['status'] === 'online'));

        return view('syncup.friends', [
            'friends' => array_values($friends),
            'onlineCount' => $onlineCount,
            'suggestions' => self::suSuggestions(),
        ]);
    }
}
