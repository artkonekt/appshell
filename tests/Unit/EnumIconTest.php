<?php

declare(strict_types=1);

/**
 * Contains the EnumIconTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShellTheme;
use Konekt\AppShell\Widgets\EnumIcon;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerType;

class EnumIconTest extends TestCase
{
    /** @test */
    public function it_can_render_if_the_model_is_the_enum_itself()
    {
        $icon = EnumIcon::create(new AppShellTheme(), ['value' => '$model']);
        $output = trim($icon->render(CustomerType::INDIVIDUAL()));

        $this->assertStringContainsString('<i ', $output);
        $this->assertStringContainsString('zmdi-account-circle', $output);
    }

    /** @test */
    public function it_can_render_if_the_model_is_an_enum_field_of_the_model()
    {
        $icon = EnumIcon::create(new AppShellTheme(), ['value' => '$model.type']);
        $customer = new Customer(['type' => CustomerType::ORGANIZATION]);
        $output = trim($icon->render($customer));

        $this->assertStringContainsString('<i ', $output);
        $this->assertStringContainsString('zmdi-city', $output);
    }
}
