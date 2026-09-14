<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Native\Mobile\Facades\Dialog;

/**
 * The "slow login API call" used by /async-loading, in both flavours:
 *
 *  - [perform()] runs the request inline, on whichever runtime calls it.
 *  - [handle()]  runs the same request on the background queue worker and
 *                parks the result in the cache for the UI to pick up.
 *
 * The result MUST travel back through shared state (cache/database). The
 * queue worker is a separate PHP runtime with its own container, so a
 * Laravel event dispatched in [handle()] fires listeners on the worker and
 * is invisible to the NativeComponent driving the screen.
 */
class DemoApiLogin implements ShouldQueue
{
    use Queueable;

    /**
     * @param  string  $resultKey  Cache key the UI polls for this request's result.
     */
    public function __construct(
        public string $resultKey,
        public string $email,
    ) {}

    public function handle(): void
    {
        $result = static::perform($this->email);

        // The one channel that actually crosses runtimes. Needs a shared
        // store — `database` (this app) or `file`. An `array` cache lives
        // in the worker's memory and the UI would poll forever.
        Cache::put($this->resultKey, $result, now()->addMinutes(5));

        // Proof the job ran and can even reach the device from the worker
        // runtime — while the component still has no idea it finished.
        Dialog::toast('Queue worker finished the login request');
    }

    /**
     * The actual request. Returns a plain array so it survives the cache
     * round-trip unchanged.
     *
     * @return array{ok: bool, message: string, ms: int}
     */
    public static function perform(string $email): array
    {
        $started = microtime(true);

        try {
            $response = Http::timeout(12)->get('https://jsonplaceholder.typicode.com/users/1');

            // Stand-in for a slow auth endpoint — jsonplaceholder answers in
            // ~200ms, too quick to see a spinner at all. Drop this line when
            // you point perform() at your own /login.
            usleep(1_200_000);

            if ($response->failed()) {
                return static::result(false, 'HTTP '.$response->status(), $started);
            }

            return static::result(true, 'Signed in as '.($response->json('name') ?: $email), $started);
        } catch (\Throwable $e) {
            return static::result(false, class_basename($e).': '.Str::limit($e->getMessage(), 70), $started);
        }
    }

    /** @return array{ok: bool, message: string, ms: int} */
    protected static function result(bool $ok, string $message, float $started): array
    {
        return [
            'ok' => $ok,
            'message' => $message,
            'ms' => (int) round((microtime(true) - $started) * 1000),
        ];
    }
}
