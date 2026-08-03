<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasFacebookData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class FacebookFeed extends NativeComponent
{
    use HasFacebookData;

    /** @var array<int, bool> Keyed by post id, stable across refresh rotation. */
    public array $likedPosts = [];

    public int $refreshCount = 0;

    /** Post id whose "more actions" sheet is open, or null. */
    public ?int $menuPostId = null;

    public function navTitle(): string
    {
        return 'Facebook';
    }

    public function refresh(): void
    {
        $this->refreshCount++;
    }

    public function viewPost(int $id): void
    {
        $this->navigate($this->route('facebook.post', $id))
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

    public function toggleLike(int $id): void
    {
        if (isset($this->likedPosts[$id])) {
            unset($this->likedPosts[$id]);
        } else {
            $this->likedPosts[$id] = true;
        }
    }

    public function openPostMenu(int $id): void
    {
        $this->menuPostId = $id;
    }

    public function closePostMenu(): void
    {
        $this->menuPostId = null;
    }

    public function render(): View
    {
        $users = self::fbUsers();
        $posts = self::fbPosts();

        $stories = [];
        foreach ($users as $userId => $user) {
            if ($user['hasStory']) {
                $user['id'] = $userId;
                $stories[] = $user;
            }
        }

        foreach ($posts as $id => &$post) {
            $post['id'] = $id;
            $post['user'] = $users[$post['userId']];
            $post['reactionsFormatted'] = self::formatFbCount(
                $post['reactions'] + (isset($this->likedPosts[$id]) ? 1 : 0)
            );
            $post['isLiked'] = isset($this->likedPosts[$id]);
        }
        unset($post);

        if ($this->refreshCount > 0 && count($posts) > 1) {
            $offset = $this->refreshCount % count($posts);
            $posts = array_merge(array_slice($posts, $offset), array_slice($posts, 0, $offset));
        }

        return view('facebook-feed', [
            'posts' => $posts,
            'stories' => $stories,
        ]);
    }
}
