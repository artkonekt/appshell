<?php
/**
 * Contains the UIWithMissingAssetsConfigurationTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-10-30
 *
 */

namespace Konekt\AppShell\Tests\Feature;

use Konekt\AppShell\Assets\DefaultAppShellAssets;
use Konekt\AppShell\Tests\TestCase;

class UIWithMissingAssetsConfigurationTest extends TestCase
{
    /** @test */
    public function default_assets_are_rendered_in_the_layout_without_asset_configuration()
    {
        $url = config('konekt.app_shell.ui.url');

        $this->assertNotEmpty($url);
        $response = $this->actingAs($this->adminUser)->get(url($url));
        $response->assertStatus(200);

        foreach (DefaultAppShellAssets::JS as $key => $value) {
            if (is_numeric($key)) {
                $response->assertSee(asset($value));
            } else {
                $response->assertSee(asset($key));
            }
        }

        foreach (DefaultAppShellAssets::CSS as $key => $value) {
            if (is_numeric($key)) {
                $response->assertSee(asset($value));
            } else {
                $response->assertSee(asset($key));
            }
        }
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('konekt.app_shell.ui', [
            'name'   => 'AppShell',
            'url'    => '/admin/customer',
        ]);
    }
}
