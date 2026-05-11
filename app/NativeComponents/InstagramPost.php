<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasInstagramData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class InstagramPost extends NativeComponent
{
    use HasInstagramData;

    /** @var array */
    public array $post = [];

    /** @var array<int, array> */
    public array $comments = [];

    public bool $isLiked = false;

    public bool $isSaved = false;

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $posts = self::igPosts();
        $users = self::igUsers();

        $post = $posts[$id] ?? $posts[0];
        $post['user'] = $users[$post['userId']];
        $this->post = $post;

        $comments = self::igComments();
        foreach ($comments as &$comment) {
            $comment['user'] = $users[$comment['userId']];
        }
        $this->comments = $comments;
    }

    public function viewProfile(int $userId): void
    {
        $this->navigate($this->route('instagram.profile', $userId))
            ->transition(Transition::SlideFromRight);
    }

    public function toggleLike(): void
    {
        $this->isLiked = ! $this->isLiked;
    }

    public function toggleSave(): void
    {
        $this->isSaved = ! $this->isSaved;
    }

    public function render(): \Illuminate\View\View
    {
        return view('instagram-post', [
            'likesFormatted' => self::formatIgCount(
                $this->post['likes'] + ($this->isLiked ? 1 : 0)
            ),
        ]);
    }
}
