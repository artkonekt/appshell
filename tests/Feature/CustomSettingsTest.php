<?php
/**
 * Contains the CustomSettingsTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-24
 *
 */

namespace Konekt\AppShell\Tests\Feature;

use Konekt\AppShell\Tests\Dummies\AppServiceProvider;
use Konekt\AppShell\Tests\TestCase;

class CustomSettingsTest extends TestCase
{
    /** @test */
    public function the_custom_setting_is_visible()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.settings.index'));

        $response->assertStatus(200);
        $response->assertSee('Laika the Astronaut');
    }

    protected function getPackageProviders($app)
    {
        $providers = parent::getPackageProviders($app);
        $providers[] = AppServiceProvider::class;

        return $providers;
    }
}
