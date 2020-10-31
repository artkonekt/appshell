<?php

declare(strict_types=1);

/**
 * Contains the BreadcrumbsDisableTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-31
 *
 */

namespace Konekt\AppShell\Tests\Feature;

use Konekt\AppShell\Providers\ModuleServiceProvider as AppShellModule;
use Konekt\AppShell\Tests\TestCase;

class BreadcrumbsDisableTest extends TestCase
{
    /** @test */
    public function the_customer_index_shows_empty_breadcrumbs_if_breadcrumbs_are_disabled_in_config()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.customer.index'));

        $response->assertDontSee('class="breadcrumb-item active">Customers', false);
        $response->assertSee('class="breadcrumb-item active">&nbsp;', false);
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('concord.modules', [
            AppShellModule::class => [
                'breadcrumbs' => false
            ],
        ]);
    }
}
