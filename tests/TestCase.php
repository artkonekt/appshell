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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Providers\ModuleServiceProvider as AppShellModule;
use Konekt\Concord\ConcordServiceProvider;
use Konekt\Gears\Providers\GearsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected $adminUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
        $this->artisan('migrate');

        $this->adminUser = User::create([
            'name'     => 'AppShell',
            'email'    => 'test@gmail.com',
            'password' => bcrypt('test'),
        ]);

        $this->adminUser->assignRole('admin');
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
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        Auth::routes();
        Route::get('/home', function () {
        })->name('home');
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
}
