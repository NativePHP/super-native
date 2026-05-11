<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasFacebookData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class FacebookProfile extends NativeComponent
{
    use HasFacebookData;

    /** @var array */
    public array $user = [];

    /** @var array<int, array> */
    public array $userPosts = [];

    public int $selectedTab = 0;

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $users = self::fbUsers();
        $this->user = $users[$id] ?? $users[0];

        $allPosts = self::fbPosts();
        $this->userPosts = array_values(
            array_filter($allPosts, fn (array $p): bool => $p['userId'] === $id)
        );
    }

    public function selectTab(int $index): void
    {
        $this->selectedTab = $index;
    }

    public function viewPost(int $postId): void
    {
        $this->navigate($this->route('facebook.post', $postId))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): \Illuminate\View\View
    {
        $users = self::fbUsers();
        $allPosts = self::fbPosts();

        $postsWithMeta = [];
        foreach ($this->userPosts as $post) {
            $originalIndex = array_search($post, $allPosts);
            $post['user'] = $users[$post['userId']];
            $post['originalIndex'] = $originalIndex;
            $post['reactionsFormatted'] = self::formatFbCount($post['reactions']);
            $postsWithMeta[] = $post;
        }

        return view('facebook-profile', [
            'postsWithMeta' => $postsWithMeta,
            'friendsFormatted' => self::formatFbCount($this->user['friendCount']),
        ]);
    }
}
