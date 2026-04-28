<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasInstagramData;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class InstagramFeed extends NativeComponent
{
    use HasInstagramData;

    /** @var array<int, bool> */
    public array $likedPosts = [];

    public function navTitle(): string
    {
        return 'Instagram';
    }

    /** @var array<int, bool> */
    public array $savedPosts = [];

    public function viewPost(int $index): void
    {
        $this->navigate($this->route('instagram.post', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function viewProfile(int $userId): void
    {
        $this->navigate($this->route('instagram.profile', $userId))
            ->transition(Transition::SlideFromRight);
    }

    public function toggleLike(int $index): void
    {
        if (isset($this->likedPosts[$index])) {
            unset($this->likedPosts[$index]);
        } else {
            $this->likedPosts[$index] = true;
        }
    }

    public function toggleSave(int $index): void
    {
        if (isset($this->savedPosts[$index])) {
            unset($this->savedPosts[$index]);
        } else {
            $this->savedPosts[$index] = true;
        }
    }

    public function render(): Element
    {
        $users = self::igUsers();
        $posts = self::igPosts();
        $stories = array_values(array_filter($users, fn (array $u): bool => $u['hasStory']));

        foreach ($posts as $i => &$post) {
            $post['user'] = $users[$post['userId']];
            $post['isLiked'] = isset($this->likedPosts[$i]);
            $post['isSaved'] = isset($this->savedPosts[$i]);
            $post['likesFormatted'] = self::formatIgCount(
                $post['likes'] + ($post['isLiked'] ? 1 : 0)
            );
        }

        return $this->view('instagram-feed', [
            'posts' => $posts,
            'stories' => $stories,
        ]);
    }
}
