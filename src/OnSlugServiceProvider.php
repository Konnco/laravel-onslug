<?php

namespace Konnco\OnSlug;

use Illuminate\Support\ServiceProvider;
use Konnco\OnSlug\Commands\OnSlugCommand;

class OnSlugServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-onslug.php' => config_path('laravel-onslug.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/laravel-onslug'),
            ], 'views');

            $migrationFileName = 'create_laravel_onslug_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                OnSlugCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-onslug');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-onslug.php', 'laravel-onslug');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
