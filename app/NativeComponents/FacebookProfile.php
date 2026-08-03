<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasFacebookData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class FacebookProfile extends NativeComponent
{
    use HasFacebookData;

    public array $user = [];

    /** @var array<int, array> */
    public array $userPosts = [];

    public int $selectedTab = 0;

    public bool $friendRequested = false;

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

    public function toggleFriendRequest(): void
    {
        $this->friendRequested = ! $this->friendRequested;
    }

    public function viewPost(int $postId): void
    {
        $this->navigate($this->route('facebook.post', $postId))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): View
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

        $photos = array_values(array_filter(array_map(
            fn (array $post): ?string => $post['imageUrl'],
            $allPosts
        )));

        return view('facebook-profile', [
            'postsWithMeta' => $postsWithMeta,
            'friendsFormatted' => self::formatFbCount($this->user['friendCount']),
            'photos' => $photos,
        ]);
    }
}
