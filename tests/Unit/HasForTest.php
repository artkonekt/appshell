<?php

declare(strict_types=1);

/**
 * Contains the HasForTest class.
 *
 * @copyright   Copyright (c) 2024 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-10-29
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Http\Requests\CreateAddressForm;
use Konekt\AppShell\Models\Invitation;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Tests\TestCase;
use Konekt\Customer\Models\Customer;

class HasForTest extends TestCase
{
    /** @test */
    public function it_can_be_extended()
    {
        $invitation = Invitation::create(['email' => 'random@email.com']);
        $form = new CreateAddressForm(['for' => 'random2000', 'forId' => $invitation->id]);

        $this->assertNull($form->getFor());
        CreateAddressForm::addHasForDefinition('random2000', Invitation::class);

        $retrieved = $form->getFor();
        $this->assertInstanceOf(Invitation::class, $retrieved);
    }

    /** @test */
    public function it_can_be_overridden()
    {
        $user = User::create(['email' => 'random@email.com', 'name' => 'Terence Hill', 'password' => '123456']);
        $customer = Customer::create(['name' => 'Customer']);
        $form = new CreateAddressForm(['for' => 'customer', 'forId' => $customer->id]);

        $this->assertInstanceOf(Customer::class, $form->getFor());
        $this->assertEquals($customer->id, $form->getFor()->id);

        CreateAddressForm::overrideHasForDefinition('customer', User::class);
        $form = new CreateAddressForm(['for' => 'customer', 'forId' => $user->id]);

        $retrieved = $form->getFor();
        $this->assertInstanceOf(User::class, $retrieved);
        $this->assertEquals($user->id, $retrieved->id);
    }
}
