<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasFacebookData;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class FacebookFeed extends NativeComponent
{
    use HasFacebookData;

    /** @var array<int, bool> */
    public array $likedPosts = [];

    public function navTitle(): string
    {
        return 'Facebook';
    }

    public function viewPost(int $index): void
    {
        $this->navigate($this->route('facebook.post', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function viewProfile(int $userId): void
    {
        $this->navigate($this->route('facebook.profile', $userId))
            ->transition(Transition::SlideFromRight);
    }

    public function createPost(): void
    {
        $this->navigate($this->route('facebook.create'))
            ->transition(Transition::SlideFromBottom);
    }

    public function toggleLike(int $index): void
    {
        if (isset($this->likedPosts[$index])) {
            unset($this->likedPosts[$index]);
        } else {
            $this->likedPosts[$index] = true;
        }
    }

    public function render(): Element
    {
        $users = self::fbUsers();
        $posts = self::fbPosts();
        $stories = array_filter($users, fn (array $u): bool => $u['hasStory']);

        foreach ($posts as $i => &$post) {
            $post['user'] = $users[$post['userId']];
            $post['reactionsFormatted'] = self::formatFbCount(
                $post['reactions'] + (isset($this->likedPosts[$i]) ? 1 : 0)
            );
            $post['isLiked'] = isset($this->likedPosts[$i]);
        }

        return $this->view('facebook-feed', [
            'posts' => $posts,
            'stories' => array_values($stories),
        ]);
    }
}
