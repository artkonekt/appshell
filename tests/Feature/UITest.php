<?php
/**
 * Contains the UITest class.
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

class UITest extends TestCase
{
    /** @test */
    public function the_default_url_can_be_accessed()
    {
        $url = config('konekt.app_shell.ui.url');

        $this->assertNotEmpty($url);
        $response = $this->actingAs($this->adminUser)->get(url($url));
        $response->assertStatus(200);
    }

    /** @test */
    public function default_assets_are_rendered_in_the_layout()
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
}
