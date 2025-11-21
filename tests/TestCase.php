<?php

namespace MarghoobSuleman\APIWizard\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use MarghoobSuleman\APIWizard\APIWizardServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * The latest response from the application.
     * This property is required for Orchestra Testbench v9 compatibility.
     *
     * @var \Illuminate\Testing\TestResponse|null
     */
    public static $latestResponse;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            APIWizardServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
