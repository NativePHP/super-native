<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasFacebookData;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class FacebookPost extends NativeComponent
{
    use HasFacebookData;

    /** @var array */
    public array $post = [];

    /** @var array<int, array> */
    public array $comments = [];

    public bool $isLiked = false;

    public function mount(): void
    {
        $id = (int) $this->param('id');
        $posts = self::fbPosts();
        $users = self::fbUsers();

        $post = $posts[$id] ?? $posts[0];
        $post['user'] = $users[$post['userId']];
        $this->post = $post;

        $comments = self::fbComments();
        foreach ($comments as &$comment) {
            $comment['user'] = $users[$comment['userId']];
        }
        $this->comments = $comments;
    }

    public function viewProfile(int $userId): void
    {
        $this->navigate($this->route('facebook.profile', $userId))
            ->transition(Transition::SlideFromRight);
    }

    public function toggleLike(): void
    {
        $this->isLiked = ! $this->isLiked;
    }

    public function render(): \Illuminate\View\View
    {
        return view('facebook-post', [
            'reactionsFormatted' => self::formatFbCount(
                $this->post['reactions'] + ($this->isLiked ? 1 : 0)
            ),
        ]);
    }
}
