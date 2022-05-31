<?php

declare(strict_types=1);

/**
 * Contains the UseMixTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-03
 *
 */

namespace Konekt\AppShell\Tests\Feature;

use Konekt\AppShell\Tests\TestCase;

class UseMixTest extends TestCase
{
    /** @test */
    public function it_uses_the_mix_asset_helper_if_configured_so()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.account.display'));
        $response->assertStatus(500);
        $response->assertSeeText('Mix manifest');
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);
        $app['config']->set('konekt.app_shell.ui.use_mix', true);
    }
}
