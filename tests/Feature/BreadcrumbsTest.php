<?php

declare(strict_types=1);

/**
 * Contains the BreadcrumbsTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-31
 *
 */

namespace Konekt\AppShell\Tests\Feature;

use Konekt\AppShell\Tests\TestCase;

class BreadcrumbsTest extends TestCase
{
    /** @test */
    public function the_customer_index_contains_breadcrumbs()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.customer.index'));

        $response->assertSee('<nav aria-label="breadcrumb">', false);
        $response->assertSee('class="breadcrumb-item active">Customers', false);
    }
}
