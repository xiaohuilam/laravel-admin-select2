<?php

namespace LaravelAdminExt\Select2\Test;

use Illuminate\Foundation\Application;
use TestCase as BaseTestCase;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\AdminServiceProvider;
use LaravelAdminExt\Select2\Select2ServiceProvider;

require __DIR__ . '/../vendor/encore/laravel-admin/tests/TestCase.php';

abstract class AbstractTestCase extends BaseTestCase
{
    /**
     * Boots the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /**
         * @var \Illuminate\Foundation\Application $app
         */
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        $app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Admin', \Encore\Admin\Facades\Admin::class);
        });

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $app->register(AdminServiceProvider::class);
        $app->register(Select2ServiceProvider::class);

        return $app;
    }

    public function setUp()
    {
        if (!$this->app) {
            $this->refreshApplication();
        }

        $this->setUpTraits();

        foreach ($this->afterApplicationCreatedCallbacks as $callback) {
            call_user_func($callback);
        }

        Facade::clearResolvedInstances();

        Model::setEventDispatcher($this->app['events']);

        $this->setUpHasRun = true;

        $this->app['config']->set('app.env', 'testing');
        $this->app['config']->set('app.debug', true);
        $this->app['config']->set('database.default', 'sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');
        $this->app['config']->set('database.connections.sqlite.prefix', 'test');
        $this->app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $this->app['config']->set('filesystems', require __DIR__ . '/../vendor/encore/laravel-admin/tests/config/filesystems.php');

        $this->artisan('vendor:publish', ['--provider' => AdminServiceProvider::class,]);

        $this->artisan('admin:install');

        $this->migrateTestTables();

        if (file_exists($routes = admin_path('routes.php'))) {
            require $routes;
        }

        require __DIR__ . '/routes.php';

        require __DIR__ . '/../vendor/encore/laravel-admin/tests/seeds/factory.php';
    }

    public function tearDown()
    {
        (new \CreateTestTables())->down();
        (new \CreateAdminTables())->down();
        (new \CreateTestTables())->down();

        if ($this->app) {
            foreach ($this->beforeApplicationDestroyedCallbacks as $callback) {
                call_user_func($callback);
            }

            $this->app->flush();

            $this->app = null;
        }

        $this->setUpHasRun = false;

        if (property_exists($this, 'serverVariables')) {
            $this->serverVariables = [];
        }

        $this->afterApplicationCreatedCallbacks = [];
        $this->beforeApplicationDestroyedCallbacks = [];
    }

    /**
     * run package database migrations.
     *
     * @return void
     */
    public function migrateTestTables()
    {
        parent::migrateTestTables();
        $fileSystem = new Filesystem();
        $fileSystem->requireOnce(__DIR__ . '/migrations/2019_04_10_093148_create_test_tablexs.php');
        (new \CreateTestTablexs())->up();
    }
}
