<?php

namespace App\NativeComponents;

use Illuminate\Support\Facades\Http;
use Native\Mobile\Edge\Element;
// Imports below are referenced only by the commented-out
// custom-Element example further down — keep them around so
// uncommenting Just Works without an "unresolved class" error.
use Native\Mobile\Edge\Elements\Column;
use Native\Mobile\Edge\Elements\Image;
use Native\Mobile\Edge\Elements\Row;
use Native\Mobile\Edge\Elements\Text;
use Native\Mobile\Edge\NativeComponent;

class NativeTabsHome extends NativeComponent
{
    public int $taps = 0;

    public function navTitle(): string
    {
        return 'Home';
    }


    public function searchItems(): ?array
    {
        return [
            ['title' => 'Ada Lovelace', 'subtitle' => 'Analytical Engine programmer', 'url' => '/'],
            ['title' => 'Brian Kernighan', 'subtitle' => 'Co-author of C', 'url' => '/'],
            ['title' => 'Charlie Munger', 'subtitle' => 'Investor', 'url' => '/'],
            ['title' => 'Dana Scott', 'subtitle' => 'Domain theory', 'url' => '/'],
            ['title' => 'Edsger Dijkstra', 'subtitle' => 'Algorithms', 'url' => '/'],
            ['title' => 'Fei-Fei Li', 'subtitle' => 'Computer vision', 'url' => '/'],
            ['title' => 'Grace Hopper', 'subtitle' => 'COBOL pioneer', 'url' => '/'],
            ['title' => 'Hedy Lamarr', 'subtitle' => 'Frequency hopping', 'url' => '/'],
            ['title' => 'Ivan Sutherland', 'subtitle' => 'Sketchpad / 3D graphics', 'url' => '/'],
            ['title' => 'James Gosling', 'subtitle' => 'Java', 'url' => '/'],
            ['title' => 'Katherine Johnson', 'subtitle' => 'NASA mathematician', 'url' => '/'],
            ['title' => 'Linus Torvalds', 'subtitle' => 'Linux & Git', 'url' => '/'],
        ];
    }


//    public function onSearchQuery(string $query): array
//    {
//        $needle = trim($query);
//        if ($needle === '') {
//            return [];
//        }
//
//        $posts = Http::timeout(5)
//            ->get('https://jsonplaceholder.typicode.com/posts', ['q' => $needle])
//            ->json() ?? [];
//
//        return collect($posts)
//            ->take(20)
//            ->map(fn($p) => Row::make()
//                ->class('items-start gap-3 px-4 py-3')
//                ->onPress("openPost({$p['id']})")
//                ->addChild(
//                // Tinted "P" avatar — could be Image::make($u->avatar_url) for real users.
//                    Column::make()
//                        ->class('w-10 h-10 rounded-full bg-purple-100 items-center justify-center')
//                        ->addChild(Text::make(str($p['title'])->limit(1, '')->upper())->class('text-purple-700 font-semibold'))
//                )
//                ->addChild(
//                    Column::make()
//                        ->class('flex-1 gap-1')
//                        ->addChild(
//                            Text::make($p['title'] ?? '(no title)')
//                                ->class('font-semibold')
//                        )
//                        ->addChild(
//                            Text::make(str(($p['body'] ?? ''))->limit(120)->value())
//                                ->class('text-sm text-gray-500')
//                        )
//                )
//                ->addChild(
//                    Text::make("#{$p['id']}")
//                        ->class('text-xs text-gray-400 px-2 py-1 rounded bg-gray-100')
//                )
//            )
//            ->values()
//            ->toArray();
//    }


//     public function onSearchQuery(string $query): array
//     {
//         $needle = trim($query);
//         if ($needle === '') {
//             return [];
//         }
//
//         $posts = Http::timeout(5)
//             ->get('https://jsonplaceholder.typicode.com/posts', ['q' => $needle])
//             ->json() ?? [];
//
//         return collect($posts)
//             ->take(20)
//             ->map(fn ($p) => view('search-post-row', ['post' => $p]))
//             ->values()
//             ->toArray();
//     }



//    public function onSearchQuery(string $query): array
//    {
//        $needle = trim($query);
//        if ($needle === '') {
//            return [];
//        }
//
//        try {
//            $posts = Http::timeout(5)
//                ->get('https://jsonplaceholder.typicode.com/posts', ['q' => $needle])
//                ->json() ?? [];
//        } catch (\Throwable) {
//            return [];
//        }
//
//        return collect($posts)
//            ->take(20)
//            ->map(fn ($p) => [
//                'title' => $p['title'] ?? '(no title)',
//                'subtitle' => str(($p['body'] ?? ''))->limit(90)->value(),
//                'leading' => 'article',
//                'url' => '/',
//            ])
//            ->values()
//            ->toArray();
//    }

    public function tap(): void
    {
        $this->taps++;
    }

    public function render(): \Illuminate\View\View
    {
        return view('native-tabs-home');
    }
}
