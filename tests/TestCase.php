<?php
/**
 * Contains the base TestCase class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 *
 * @since       2018-02-27
 */

namespace Konekt\AppShell\Tests;

use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Collective\Html\HtmlServiceProvider;
use Cviebrock\EloquentSluggable\ServiceProvider as SluggableServiceProviderAlias;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsServiceProvider;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Support\Facades\Route;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Providers\ModuleServiceProvider as AppShellModule;
use Konekt\AppShell\Tests\Dummies\MemoryOnlyGearsBackend;
use Konekt\Concord\ConcordServiceProvider;
use Konekt\Gears\Providers\GearsServiceProvider;
use Konekt\LaravelMigrationCompatibility\LaravelMigrationCompatibilityProvider;
use Konekt\Menu\Facades\Menu;
use Konekt\Menu\MenuServiceProvider;
use Konekt\User\Models\UserType;
use Laracasts\Flash\FlashServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /** @var User */
    protected $adminUser;

    /** @var User */
    protected $normalUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
        $this->artisan('migrate');

        $this->adminUser = User::create([
            'name'     => 'AppShell Admin',
            'email'    => 'test@gmail.com',
            'type'     => UserType::ADMIN,
            'password' => bcrypt('test'),
        ]);

        $this->adminUser->assignRole('admin');

        $this->normalUser = User::create([
            'name'     => 'AppShell Client',
            'email'    => 'test_client@gmail.com',
            'type'     => UserType::CLIENT,
            'password' => bcrypt('test'),
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ConcordServiceProvider::class,
            GearsServiceProvider::class,
            LaravelMigrationCompatibilityProvider::class,
            BreadcrumbsServiceProvider::class,
            MenuServiceProvider::class,
            FlashServiceProvider::class,
            SluggableServiceProviderAlias::class,
            HtmlServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Breadcrumbs' => Breadcrumbs::class,
            'Menu' => Menu::class,
            'Form' => FormFacade::class,
            'Html' => HtmlFacade::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $this->predefinedRoutes();

        $app['config']->set('gears.driver', MemoryOnlyGearsBackend::class);

        $engine = env('TEST_DB_ENGINE', 'sqlite');

        $app['config']->set('database.default', $engine);
        $app['config']->set('database.connections.' . $engine, [
            'driver'   => $engine,
            'database' => 'sqlite' == $engine ? ':memory:' : 'appshell_test',
            'prefix'   => '',
            'host'     => '127.0.0.1',
            'username' => env('TEST_DB_USERNAME', 'pgsql' === $engine ? 'postgres' : 'root'),
            'password' => env('TEST_DB_PASSWORD', ''),
        ]);

        if ('pgsql' === $engine) {
            $app['config']->set("database.connections.{$engine}.charset", 'utf8');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('concord.modules', [
            AppShellModule::class,
        ]);

        $app['config']->set('auth.providers.users.model', User::class);
    }

    private function predefinedRoutes()
    {
        Route::get('/home', function () {
        })->name('home');
        Route::get('/login', function () {
        })->name('login');
        Route::get('/logout', function () {
        })->name('logout');
    }
}
