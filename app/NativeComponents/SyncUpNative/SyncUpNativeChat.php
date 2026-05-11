<?php

namespace App\NativeComponents\SyncUpNative;

use App\Icons\MaterialOutlined;
use App\NativeComponents\Concerns\HasSyncUpData;
use Illuminate\View\View;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\Elements\Divider;
use Native\Mobile\Edge\Layouts\Builders\NavAction;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Dialog;
use App\Icons\Material;
use App\Icons\SF;
use Nativephp\NativeUi\Elements\Button;

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

    /** Hide the bottom tab bar on the chat detail — pushed-detail pattern. */
    protected bool $hidesTabBar = true;

    public function mount(): void
    {
        $id = (int) $this->param('id', 1);
        $this->messages = self::suMessages($id);
        $this->seeded = true;
    }

    public function navTitle(): string
    {
        return "Simon Says";
    }

    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()
            ->action(
                NavAction::make('video')
                    ->icon(sf: SF::Camera, material: MaterialOutlined::Camera)
                    ->press('startVideo')
            )
            ->action(
                NavAction::make('call')
                    ->icon(sf: SF::Phone, material: MaterialOutlined::Phone)
                    ->press('startCall')
            )
            ->action(
                NavAction::make('more')
                    ->icon(sf: SF::Ellipsis, material: Material::MoreVert)
                    ->items([
                        NavAction::make('mark_read')
                            ->icon(sf: SF::CheckmarkCircle, material: Material::CheckCircle)
                            ->label('Mark all read')
                            ->press('markAllRead'),
                        NavAction::make('mute')
                            ->icon(sf: SF::BellSlash, material: Material::NotificationsOff)
                            ->label('Mute notifications')
                            ->press('mute'),
                        NavAction::make('archive')
                            ->icon(sf: SF::Archivebox, material: Material::Archive)
                            ->label('Archive')
                            ->press('archive'),
                        NavAction::divider(),
                        NavAction::make('delete')
                            ->icon(sf: SF::Trash, material: Material::Delete)
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

    public function markAllRead()
    {
        Dialog::toast('Mark all read');
    }

    public function render(): View
    {
        return view('syncup-native.chat', [
            'friend' => $this->friend(),
        ]);
    }
}
