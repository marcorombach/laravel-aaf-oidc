<?php

namespace Marcorombach\LaravelAafRadius\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Marcorombach\LaravelAafOIDC\LaravelAafOIDCServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Marcorombach\\LaravelAafOIDC\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelAafOIDCServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-aaf-radius_table.php.stub';
        $migration->up();
        */
    }
}
