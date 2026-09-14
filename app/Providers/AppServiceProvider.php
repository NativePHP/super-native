<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

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
        $this->configureDumper();
    }

    /**
     * Expand `dd()` output instead of collapsing it.
     *
     * Symfony's HtmlDumper defaults to `maxDepth => 1`, which for an
     * element tree means one click per node to see anything. Element
     * trees are deep and uniform, so start every level open.
     */
    protected function configureDumper(): void
    {
        if ($this->app->isProduction()) {
            return;
        }

        VarDumper::setHandler(function (mixed $var): void {
            $dumper = in_array(PHP_SAPI, ['cli', 'phpdbg'], true)
                ? new CliDumper
                : tap(new HtmlDumper)->setDisplayOptions(['maxDepth' => 99]);

            $dumper->dump((new VarCloner)->cloneVar($var));
        });
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
