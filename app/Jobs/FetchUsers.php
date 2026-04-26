<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;

class FetchUsers implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct($page)
    {
        try {
            $response = json_decode(
                file_get_contents('https://jsonplaceholder.typicode.com/posts?'.http_build_query([
                        '_page' => $page,
                        '_limit' => 10,
                    ])),
                true
            );

            $users =  collect($response ?? [])->map(fn ($post, $index) => [
                'id' => $post['id'],
                'name' => 'User '.$index + 1,
                'description' => Str::limit($post['title'], 60),
                'email' => 'user'.$post['userId'].'@example.com',
                'city' => 'Post #'.$post['id'],
            ])->all();

            Livewire::dispatch('users-fetched', users: $users, page: $this->page);
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
