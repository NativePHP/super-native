<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use SupaNative\Core\Edge\ElementRegistry;
use SupaNative\Core\Edge\Elements\TextInput;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        // `text_input` is the one wire type in the desktop renderer's first
        // batch that nothing installed here claims: core leaves it to a UI
        // plugin, and nativephp/mobile-ui registers the three Material
        // variants (outlined / bare / filled) rather than the plain one. So
        // the app points the bare type at core's own element class, which is
        // what the renderer was written against.
        ElementRegistry::register('text_input', TextInput::class);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}
