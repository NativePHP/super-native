<?php

namespace App\NativeComponents\SyncUpNative;

use App\NativeComponents\Concerns\HasSyncUpData;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\Layouts\Builders\NavAction;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;

class SyncUpNativeChat extends NativeComponent
{
    use HasSyncUpData;

    /** @var array<int, array{id:int, fromMe:bool, text:string, time:string, imageUrl?:string, status?:string}> */
    public array $messages = [];

    public string $draft = '';

    public bool $seeded = false;

    public bool $showMoreActions = false;

    public bool $showClearConfirm = false;

    public bool $isMuted = false;

    public function mount(): void
    {
        $id = (int) $this->param('id', 1);
        $this->messages = self::suMessages($id);
        $this->seeded = true;
    }

    public function navTitle(): string
    {
        return $this->friend()['name'];
    }

    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()
            ->action(NavAction::make('video')->icon('video.fill')->press('startVideo'))
            ->action(NavAction::make('call')->icon('phone.fill')->press('startCall'))
            ->action(
                NavAction::make('more')
                    ->icon('ellipsis')
                    ->items([
                        NavAction::make('mark_read')
                            ->icon('checkmark.circle')
                            ->label('Mark all read')
                            ->press('markAllRead'),
                        NavAction::make('mute')
                            ->icon('bell.slash')
                            ->label('Mute notifications')
                            ->press('mute'),
                        NavAction::make('archive')
                            ->icon('archivebox')
                            ->label('Archive')
                            ->press('archive'),
                        NavAction::make('delete')
                            ->icon('trash')
                            ->label('Delete')
                            ->destructive()
                            ->press('deleteIt'),
                    ])
            );
    }

    public function setDraft(string $value): void
    {
        $this->draft = $value;
    }

    public function send(): void
    {
        $text = trim($this->draft);
        if ($text === '') {
            return;
        }

        $this->messages[] = [
            'id' => count($this->messages) + 1,
            'fromMe' => true,
            'text' => $text,
            'time' => date('g:i A'),
            'status' => 'sent',
        ];
        $this->draft = '';
    }

    public function attachFile(): void  { /* stub */ }
    public function attachPhoto(): void { /* stub */ }
    public function openEmoji(): void   { /* stub */ }
    public function openMore(): void    { /* stub */ }
    public function startCall(): void   {
        Dialog::toast('Starting Call');
    }
    public function startVideo(): void  {
        Dialog::toast('Starting Video');
    }

    public function openMenu(): void
    {
        $this->showMoreActions = true;
    }

    public function closeMoreActions(): void
    {
        $this->showMoreActions = false;
    }

    public function toggleMute(): void
    {
        $this->isMuted = ! $this->isMuted;
        $this->showMoreActions = false;
    }

    public function askClearHistory(): void
    {
        $this->showMoreActions = false;
        $this->showClearConfirm = true;
    }

    public function confirmClearHistory(): void
    {
        $this->messages = [];
        $this->showClearConfirm = false;
    }

    public function cancelClearHistory(): void
    {
        $this->showClearConfirm = false;
    }

    private function friend(): array
    {
        $id = (int) $this->param('id', 1);
        $conv = self::suConversation($id);
        if ($conv && ! $conv['isGroup']) {
            return self::suUser($conv['userId']);
        }
        return self::suUser(5);
    }

    public function render(): Element
    {
        return $this->view('syncup-native.chat', [
            'friend' => $this->friend(),
        ]);
    }
}
