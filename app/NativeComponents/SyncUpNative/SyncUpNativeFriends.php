<?php

namespace App\NativeComponents\SyncUpNative;

use App\NativeComponents\Concerns\HasSyncUpData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class SyncUpNativeFriends extends NativeComponent
{
    use HasSyncUpData;

    public function navTitle(): string
    {
        return 'SyncUp';
    }

    public function scanQr(): void       { /* stub */ }
    public function findById(): void     { /* stub */ }
    public function shareInvite(): void  { /* stub */ }
    public function copyInvite(): void   { /* stub */ }
    public function openSearch(): void   { /* stub */ }

    public function messageFriend(int $id): void
    {
        $this->navigate("/syncup-native/chat/{$id}")
            ->transition(Transition::SlideFromRight);
    }

    public function addSuggestion(int $id): void { /* stub */ }

    public function render(): \Illuminate\View\View
    {
        $users = self::suUsers();

        $friends = array_slice(array_filter($users, fn ($u) => $u['id'] !== 0), 0, 3);
        $onlineCount = count(array_filter($users, fn ($u) => $u['status'] === 'online'));

        return view('syncup.friends', [
            'friends' => array_values($friends),
            'onlineCount' => $onlineCount,
            'suggestions' => self::suSuggestions(),
        ]);
    }
}
