<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasInstagramData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class InstagramProfile extends NativeComponent
{
    use HasInstagramData;

    /** @var array */
    public array $user = [];

    /** @var array<int, array> */
    public array $userPosts = [];

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

    public function viewPost(int $postId): void
    {
        $this->navigate($this->route('instagram.post', $postId))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): \Illuminate\View\View
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
            'followersFormatted' => self::formatIgCount($this->user['followers']),
            'followingFormatted' => self::formatIgCount($this->user['following']),
            'highlights' => self::igStoryHighlights(),
        ]);
    }
}
