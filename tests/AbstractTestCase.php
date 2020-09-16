<?php

namespace LaravelAdminExt\Select2\Test;

use Encore\Admin\AdminServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Facade;
use LaravelAdminExt\Select2\Select2ServiceProvider;
use TestCase as BaseTestCase;

abstract class AbstractTestCase extends BaseTestCase
{
    /**
     * @var \Illuminate\Foundation\Application|null
     */
    protected $app;

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

    public function setUp(): void
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
        $this->app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $this->app['config']->set('filesystems', require __DIR__ . '/../vendor/encore/laravel-admin/tests/config/filesystems.php');

        $adminConfig = require __DIR__ . '/config/admin.php';
        $this->app['config']->set('admin', $adminConfig);

        foreach (Arr::dot(Arr::get($adminConfig, 'auth'), 'auth.') as $key => $value) {
            $this->app['config']->set($key, $value);
        }

        $this->artisan('vendor:publish', ['--provider' => AdminServiceProvider::class,]);

        $this->artisan('admin:install');

        $this->migrateTestTables();

        if (file_exists($routes = admin_path('routes.php'))) {
            require $routes;
        }

        require __DIR__ . '/routes.php';

        require __DIR__ . '/../vendor/encore/laravel-admin/tests/seeds/factory.php';
    }

    public function tearDown(): void
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
