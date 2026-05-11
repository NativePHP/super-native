<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasSyncUpData;
use Native\Mobile\Edge\NativeComponent;

class SyncUpProfile extends NativeComponent
{
    use HasSyncUpData;

    public string $name = 'Elena Rodriguez';

    public string $bio = 'Product Designer & Tech Enthusiast. Always syncing up with the latest trends in UI/UX and collaborative technology. ✨';

    public bool $saved = false;

    public function navTitle(): string
    {
        return 'SyncUp';
    }

    public function updateName(string $value): void
    {
        $this->name = $value;
        $this->saved = false;
    }

    public function updateBio(string $value): void
    {
        $this->bio = $value;
        $this->saved = false;
    }

    public function editPhoto(): void  { /* stub */ }
    public function copyLink(): void   { /* stub */ }
    public function shareLink(): void  { /* stub */ }

    public function saveProfile(): void
    {
        $this->saved = true;
    }

    public function signOut(): void
    {
        $this->navigate('/syncup/login');
    }

    public function render(): \Illuminate\View\View
    {
        return view('syncup.profile');
    }
}
