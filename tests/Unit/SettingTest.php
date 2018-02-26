<?php
/**
 * Contains the SettingTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-25
 *
 */


namespace Konekt\AppShell\Tests\Unit;


use Konekt\AppShell\Contracts\Setting;
use Konekt\AppShell\Contracts\SettingScope;
use Konekt\AppShell\Tests\Unit\Settings\MailchimpApiKey;
use Orchestra\Testbench\TestCase;

class SettingTest extends TestCase
{

    /**
     * @test
     */
    public function setting_can_be_instantiated()
    {
        $mailchimpApiKey = new MailchimpApiKey();

        $this->assertInstanceOf(Setting::class, $mailchimpApiKey);
    }

    /**
     * @test
     */
    public function it_has_a_scope()
    {
        $mailchimpApiKey = new MailchimpApiKey();

        $this->assertInstanceOf(SettingScope::class, $mailchimpApiKey->scope());
    }

}
