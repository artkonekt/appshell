<?php

declare(strict_types=1);

/**
 * Contains the UserTest class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-03-12
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Illuminate\Support\Str;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Tests\TestCase;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerType;
use Konekt\User\Models\UserType;

class UserTest extends TestCase
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
}
