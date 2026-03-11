<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NativeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * The NativePHP plugins to enable.
     *
     * Only plugins listed here will be compiled into your native builds.
     * This is a security measure to prevent transitive dependencies from
     * automatically registering plugins without your explicit consent.
     *
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    public function plugins(): array
    {
        return [
//            \Nativephp\ComposeUi\ComposeUIServiceProvider::class,
            \Native\Mobile\Providers\DialogServiceProvider::class,
            \Native\Mobile\Providers\DeviceServiceProvider::class,
//            \Native\Mobile\Providers\BackgroundTasksServiceProvider::class,
//            \Native\Mobile\Providers\TimerServiceProvider::class,
//            \Native\Mobile\Providers\DebugLogServiceProvider::class,
//            \NativePhp\SkiaCanvas\SkiaCanvasServiceProvider::class,
        ];
    }
}
