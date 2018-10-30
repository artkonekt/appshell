<?php

namespace Konekt\AppShell\Tests\Feature;

use Konekt\AppShell\Tests\TestCase;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerType;

class CustomerTest extends TestCase
{
    /** @var Customer */
    private $customer;

    public function setUp()
    {
        parent::setUp();

        $this->customer = Customer::create([
            'type'            => CustomerType::ORGANIZATION,
            'firstname'       => 'Test',
            'lastname'        => 'Elek',
            'company_name'    => 'Acme co.',
            'tax_nr'          => '12345',
            'registration_nr' => '54321'
        ]);
    }

    /** @test */
    public function guests_can_not_access_the_customers_resource()
    {
        $response = $this->get(route('appshell.customer.index'));

        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    /** @test */
    public function it_can_create_a_customer()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.customer.create'));

        $response->assertSee('Create new customer');
        $response->assertSee('Create customer');
        $response->assertSee('First name');
        $response->assertSee('Last name');
    }

    /** @test */
    public function it_can_store_a_customer()
    {
        $this->actingAs($this->adminUser)->post(route('appshell.customer.store'), [
            'type'            => CustomerType::ORGANIZATION,
            'firstname'       => 'Bat',
            'lastname'        => 'Man ',
            'company_name'    => 'Acmeeee co.',
            'tax_nr'          => '4444',
            'registration_nr' => '5555'
        ]);

        $customer = Customer::all()->last();

        $this->assertEquals(CustomerType::ORGANIZATION, $customer->type->value());
        $this->assertEquals('Bat', $customer->firstname);
        $this->assertEquals('Man', $customer->lastname);
        $this->assertEquals('Acmeeee co.', $customer->company_name);
        $this->assertEquals('4444', $customer->tax_nr);
        $this->assertEquals('5555', $customer->registration_nr);
    }

    /** @test */
    public function it_can_list_customers()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.customer.index'));

        $response->assertSee($this->customer->getName());
    }

    /** @test */
    public function it_can_edit_a_customer()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.customer.edit', $this->customer));

        $response->assertSee("Editing " . $this->customer->getName());
    }

    /** @test */
    public function it_can_update_a_customer()
    {
        $this->actingAs($this->adminUser)->put(route('appshell.customer.update', $this->customer), [
            'company_name' => 'Modified customer',
            'type'         => CustomerType::ORGANIZATION
        ]);

        $this->assertEquals('Modified customer', $this->customer->fresh()->getName());
    }

    /** @test */
    public function it_can_delete_a_customer()
    {
        $this->actingAs($this->adminUser)->delete(route('appshell.customer.destroy', $this->customer));

        $this->assertEmpty(Customer::all());
    }
}
