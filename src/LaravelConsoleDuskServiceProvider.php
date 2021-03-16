<?php

declare(strict_types=1);

namespace RamPall\LaravelConsoleDusk;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Console\ChromeDriverCommand;
use RamPall\LaravelConsoleDusk\Contracts\ManagerContract;

class LaravelConsoleDuskServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laravel-console-dusk.php' => config_path('laravel-console-dusk.php'),
            ], 'config');

            $manager = resolve(ManagerContract::class);

            Browser::$baseUrl = config('app.url');
            Browser::$storeScreenshotsAt = $this->getPath('laravel-console-dusk/screenshots');
            Browser::$storeConsoleLogAt = $this->getPath('laravel-console-dusk/log');

            Command::macro('browse', function ($callback) use ($manager) {
                $manager->browse($this, $callback);
            });
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-console-dusk.php', 'laravel-console-dusk');

        $this->app->bind(ManagerContract::class, function ($app) {
            return new Manager();
        });

        $this->commands([
            ChromeDriverCommand::class,
        ]);
    }

    public function provides(): array
    {
        return [ManagerContract::class];
    }

    protected function getPath(string $path): string
    {
        return tap($path, function ($path) {
            if (! File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
        });
    }
}
