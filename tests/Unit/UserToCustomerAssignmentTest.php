<?php

declare(strict_types=1);

/**
 * Contains the UserToCustomerAssignmentTest class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-03-12
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Tests\TestCase;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerType;
use Konekt\User\Models\UserType;

class UserToCustomerAssignmentTest extends TestCase
{
    /** @test */
    public function a_user_can_have_a_customer()
    {
        $customer = Customer::create([
            'type' => CustomerType::INDIVIDUAL,
            'firstname' => 'Joe',
            'lastname' => 'Pesci',
        ]);
        $user = User::create([
            'email' => 'user@example.co',
            'type' => UserType::CLIENT,
            'name' => 'User',
            'customer_id' => $customer->id,
            'password' => Str::uuid(),
        ]);

        $this->assertInstanceOf(Customer::class, $user->customer);
    }

    /** @test */
    public function a_users_customer_is_optional()
    {
        $user = User::create([
            'email' => 'user@example.co',
            'type' => UserType::CLIENT,
            'name' => 'User',
            'password' => Str::uuid(),
        ]);

        $this->assertNull($user->customer_id);
        $this->assertNull($user->customer);
    }

    /** @test */
    public function it_can_be_obtained_if_a_user_is_associated_with_a_customer()
    {
        $customer = Customer::create([
            'type' => CustomerType::INDIVIDUAL,
            'firstname' => 'Suie',
            'lastname' => 'Paparude',
        ]);
        $user = User::create([
            'email' => 'user@example.co',
            'type' => UserType::CLIENT,
            'name' => 'Ninja',
            'customer_id' => $customer->id,
            'password' => Str::uuid(),
        ]);

        $this->assertTrue($user->isAssociatedWithACustomer());
        $this->assertFalse($user->isNotAssociatedWithACustomer());
    }
    /** @test */
    public function it_can_be_obtained_if_a_user_is_not_associated_with_a_customer()
    {
        $user = User::create([
            'email' => 'user@example.co',
            'type' => UserType::CLIENT,
            'name' => 'Customerless I am',
            'password' => Str::uuid(),
        ]);

        $this->assertTrue($user->isNotAssociatedWithACustomer());
        $this->assertFalse($user->isAssociatedWithACustomer());
    }

    /** @test */
    public function the_customers_visible_method_returns_an_empty_collection_if_the_user_can_not_list_customers_and_is_not_associated_with_a_customer()
    {
        $user = User::create([
            'email' => 'chinese@man.cn',
            'type' => UserType::CLIENT,
            'name' => 'Chinese Man',
            'password' => Str::uuid(),
        ]);

        $this->assertFalse($user->can('list customers'));
        $this->assertInstanceOf(Collection::class, $user->customersVisible());
        $this->assertTrue($user->customersVisible()->isEmpty());
    }

    /** @test */
    public function the_customers_visible_method_returns_the_users_associated_customer_in_a_collection_if_the_user_can_not_list_customers_and_is_associated_with_a_customer()
    {
        $customer = Customer::create([
            'type' => CustomerType::ORGANIZATION,
            'company_name' => 'Stash Inc.'
        ]);
        $user = User::create([
            'email' => 'patrick@stashinc.com',
            'type' => UserType::CLIENT,
            'name' => 'Patrick Parker',
            'password' => Str::uuid(),
            'customer_id' => $customer->id,
        ]);

        $list = $user->customersVisible();
        $this->assertFalse($user->can('list customers'));
        $this->assertInstanceOf(Collection::class, $list);
        $this->assertCount(1, $list);
        $this->assertEquals($customer->id, $list->first()->id);
        $this->assertEquals('Stash Inc.', $list->first()->company_name);
    }

    /** @test */
    public function the_customers_visible_method_returns_all_the_customers_if_user_can_list_customers()
    {
        foreach ([1,2,3,4] as $i) {
            Customer::create([
                'type' => CustomerType::ORGANIZATION,
                'company_name' => 'Company #' . (string)$i
            ]);
        }

        $user = User::create([
            'email' => 'capable@user.is',
            'type' => UserType::CLIENT,
            'name' => 'Capable User',
            'password' => Str::uuid()
        ]);

        $user->givePermissionTo('list customers');

        $list = $user->customersVisible();
        $this->assertTrue($user->can('list customers'));
        $this->assertInstanceOf(Collection::class, $list);
        $this->assertCount(4, $list);
    }
}
