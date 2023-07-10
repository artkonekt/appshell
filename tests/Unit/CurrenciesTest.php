<?php

declare(strict_types=1);

/**
 * Contains the CurrenciesTest class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-07-10
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Illuminate\Support\Arr;
use Konekt\AppShell\Helpers\Currencies;
use PHPUnit\Framework\TestCase;

class CurrenciesTest extends TestCase
{
    /** @test */
    public function choices_returns_all_the_currencies_in_key_value_pairs()
    {
        $result = Currencies::choices();

        $this->assertIsArray($result);
        $this->assertTrue(Arr::isAssoc($result));
        $this->assertCount(170, $result);
    }

    /** @test */
    public function codes_returns_the_currency_codes_only()
    {
        $result = Currencies::codes();
        $this->assertTrue(Arr::isList($result));
        $this->assertCount(170, $result);
        $this->assertContains('USD', $result);
    }

    /** @test */
    public function it_returns_the_name_of_a_currency_by_code()
    {
        $this->assertEquals('United States Dollar', Currencies::nameOf('USD'));
    }

    /** @test */
    public function nameof_method_returns_null_for_nonexisting_currencies()
    {
        $this->assertNull(Currencies::nameOf('---'));
    }

    /** @test */
    public function the_exists_method_tells_whether_currency_by_code_exists()
    {
        $this->assertTrue(Currencies::exists('USD'));
        $this->assertFalse(Currencies::exists('---'));
    }

    /** @test */
    public function the_list_of_currencies_can_be_filtered_to_an_exact_list()
    {
        Currencies::limitTo('USD', 'EUR', 'SEK');

        $this->assertEquals(['USD', 'EUR', 'SEK'], Currencies::codes());
    }

    /** @test */
    public function currencies_can_be_excluded()
    {
        Currencies::revertToFullList();
        Currencies::exclude('USD', 'EUR');

        $this->assertNotContains('USD', Currencies::codes());
        $this->assertNotContains('EUR', Currencies::codes());
        $this->assertCount(168, Currencies::codes());
    }

    /** @test */
    public function currencies_can_be_moved_to_the_top()
    {
        Currencies::revertToFullList();
        Currencies::moveToTop('HUF', 'RON', 'EUR');

        $this->assertEquals('HUF', Currencies::codes()[0]);
        $this->assertEquals('RON', Currencies::codes()[1]);
        $this->assertEquals('EUR', Currencies::codes()[2]);
    }
}
