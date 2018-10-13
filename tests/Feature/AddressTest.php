<?php

namespace Konekt\AppShell\Tests\Feature;

use Konekt\Address\Models\AddressType;
use Konekt\AppShell\Models\Address;
use Konekt\AppShell\Tests\TestCase;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerType;

class AddressTest extends TestCase
{
    /** @var Customer */
    private $customer;

    /** @var Address */
    private $address;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'Konekt\Address\Seeds\Countries'])->run();

        $this->customer = Customer::create([
            'type'            => CustomerType::ORGANIZATION,
            'firstname'       => 'Greatest',
            'lastname'        => 'Test',
            'company_name'    => 'Pear',
            'tax_nr'          => '1111',
            'registration_nr' => '2222'
        ]);

        $this->address = $this->customer->addresses()->create([
            'type'        => AddressType::CONTRACT,
            'name'        => 'Contract address',
            'country_id'  => 'BE',
            'province_id' => 'BR',
            'city'        => 'Bruxelles',
            'postalcode'  => '1047',
            'address'     => 'Paul Henri Spaak Building, Wiertzstraat 60'
        ]);
    }

    /** @test */
    public function guests_can_not_access_the_address_resource()
    {
        $response = $this->get(route('appshell.address.index'));

        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    /** @test */
    public function create_address_page_can_be_loaded()
    {
        $response = $this->actingAs($this->adminUser)
                         ->get(
                             route('appshell.address.create')
                             . '?for=customer&forId=' . $this->customer->id
                         );

        $response->assertStatus(200);
        $response->assertSee('Create new address');
        $response->assertSee($this->customer->getName());
        $response->assertSee('Create address');
        $response->assertSee('Country');
    }

    /** @test */
    public function new_address_can_be_saved()
    {
        $response = $this->actingAs($this->adminUser)
                         //->followingRedirects()
                         ->post(route('appshell.address.store'), [
            'type'        => AddressType::BILLING,
            //'name'        => 'Billing address',
            'country_id'  => 'HU',
            'province_id' => 'BP',
            'city'        => 'Budapest',
            'postalcode'  => '1111',
            'address'     => 'Vaci utca 21',
            'for'         => 'customer',
            'forId'       => $this->customer->id
        ]);

        // @todo test if UI redirects to proper place without errors
        // @todo test the unlucky path as well (validation errors)
        // @todo check what's with provinces not in db

        //$response->assertStatus(200);
        $response->assertRedirect('asd');
        dd($response->getContent());

        $response->assertDontSeeText('error');

        $address = $this->customer->addresses->last();

        $this->assertEquals(AddressType::BILLING, $address->type->value());
        $this->assertEquals('Billing address', $address->name);
        $this->assertEquals('HU', $address->country_id);
        $this->assertEquals('BP', $address->province_id);
        $this->assertEquals('Budapest', $address->city);
        $this->assertEquals('1111', $address->postalcode);
        $this->assertEquals('Vaci utca 21', $address->address);
    }

    /** @test */
    public function it_can_list_address()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.customer.show',
            $this->customer));

        $response->assertSee($this->address->name);
        $response->assertSee($this->address->address);
    }


    /** @test */
    public function it_can_edit_customer()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.customer.edit',
            $this->customer));

        $response->assertSee("Editing " . $this->customer->getName());
    }
}
