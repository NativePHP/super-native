<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\HasInstagramData;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class InstagramSearch extends NativeComponent
{
    use HasInstagramData;

    public function viewPost(int $index): void
    {
        $this->navigate($this->route('instagram.post', $index))
            ->transition(Transition::SlideFromRight);
    }

    public function render(): View
    {
        $posts = self::igPosts();

        foreach ($posts as $id => &$post) {
            $post['id'] = $id;
        }
        unset($post);

        return view('instagram-search', [
            'posts' => $posts,
        ]);
    }
}
