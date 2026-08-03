<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasInstagramData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class InstagramProfile extends NativeComponent
{
    use HasInstagramData;

    public array $user = [];

    /** @var array<int, array> */
    public array $userPosts = [];

    public bool $isFollowing = false;

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $users = self::igUsers();
        $this->user = $users[$id] ?? $users[0];

        $allPosts = self::igPosts();
        $this->userPosts = array_values(
            array_filter($allPosts, fn (array $p): bool => $p['userId'] === $id)
        );
    }

    public function toggleFollow(): void
    {
        $this->isFollowing = ! $this->isFollowing;
    }

    public function viewPost(int $postId): void
    {
        $this->navigate($this->route('instagram.post', $postId))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): View
    {
        $allPosts = self::igPosts();

        $postsWithIndex = [];
        foreach ($this->userPosts as $post) {
            $originalIndex = array_search($post, $allPosts);
            $post['originalIndex'] = $originalIndex;
            $postsWithIndex[] = $post;
        }

        return view('instagram-profile', [
            'postsWithIndex' => $postsWithIndex,
            'postsFormatted' => self::formatIgCount($this->user['postCount']),
            'followersFormatted' => self::formatIgCount($this->user['followers'] + ($this->isFollowing ? 1 : 0)),
            'followingFormatted' => self::formatIgCount($this->user['following']),
            'highlights' => self::igStoryHighlights(),
        ]);
    }
}
