<?php

namespace App\NativeComponents;

use App\Icons\AndroidOutlined;
use App\Icons\Ios;
use Native\Mobile\Edge\Layouts\Builders\NavAction;
use Native\Mobile\Edge\Layouts\Builders\NavBarOptions;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

/**
 * Native-chrome demo screen. Routed under `NativeStackLayout` (which
 * sets `usesNativeChrome() = true`), so the top bar is rendered via
 * SwiftUI's `NavigationStack` instead of the custom HStack `TopBar`
 * element. On iOS 26+ the bar should pick up Liquid Glass material.
 */
class NativeChromeDemo extends NativeComponent
{
    public int $shareCount = 0;

    public string $lastAction = '';

    public function navTitle(): string
    {
        return 'Native Chrome';
    }

    /**
     * Contributes a subtitle, share icon, and ellipsis action to the
     * layout's NavBar. Verifies that `navigationOptions()` round-trips
     * through the `wrapWithNativeChrome` path correctly: subtitle ends
     * up as a `principal` toolbar item, actions as `topBarTrailing`.
     */
    public function navigationOptions(): ?NavBarOptions
    {
        return NavBarOptions::make()
            ->subtitle('NavigationStack toolbar')
            // A plain icon — fires its press handler directly.
            ->action(NavAction::make('share')->icon('share')->a11yLabel('Share')->press('shareIt'))
            // A pull-down menu — tap to reveal sub-items. Each sub-item
            // is itself a NavAction with its own icon / label / press
            // handler, plus an optional `destructive()` flag for red
            // styling on iOS.
            ->action(
                NavAction::make('more')
                    ->icon('ellipsis')
                    ->a11yLabel('More options')
                    ->items([
                        NavAction::make('mark_read')
                            ->icon('checkmark.circle')
                            ->label('Mark all read')
                            ->press('markAllRead'),
                        NavAction::make('mute')
                            ->icon(ios: Ios::BellSlash, android: AndroidOutlined::VolumeMute)
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

    public function shareIt(): void
    {
        $this->shareCount++;
        $this->lastAction = 'Share tapped';
    }

    public function markAllRead(): void { $this->lastAction = 'Mark all read'; }
    public function mute(): void        { $this->lastAction = 'Mute notifications'; }
    public function archive(): void     { $this->lastAction = 'Archive'; }
    public function deleteIt(): void    { $this->lastAction = 'Delete (destructive)'; }

    /** Push the detail screen — exercises the multi-level NavigationStack. */
    public function pushDetail(): void
    {
        $this->navigate('/native-chrome/detail')
            ->transition(Transition::SlideFromRight);
    }

    public function render(): \Illuminate\View\View
    {
        return view('native-chrome-demo');
    }
}
