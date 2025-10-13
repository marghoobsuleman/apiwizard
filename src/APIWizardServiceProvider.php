<?php

namespace MarghoobSuleman\APIWizard;

use Illuminate\Support\ServiceProvider;
use MarghoobSuleman\APIWizard\Console\Commands\GenerateAPICommand;
use MarghoobSuleman\APIWizard\Console\Commands\ModelWizardCommand;

class APIWizardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge package configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/apiwizard.php', 'apiwizard'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateAPICommand::class,
                ModelWizardCommand::class,
            ]);

            // Publish configuration
            $this->publishes([
                __DIR__.'/../config/apiwizard.php' => config_path('apiwizard.php'),
            ], 'apiwizard-config');

            // Publish stubs
            $this->publishes([
                __DIR__.'/../stubs' => base_path('stubs/apiwizard'),
            ], 'apiwizard-stubs');
        }
    }
}
