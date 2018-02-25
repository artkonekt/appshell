<?php
/**
 * Contains the AvailableSettings Test class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-25
 *
 */


namespace Konekt\AppShell\Tests\Unit;


use Konekt\AppShell\Models\SettingScope;
use Konekt\AppShell\Settings\AvailableSettings;
use Konekt\AppShell\Tests\Unit\Settings\MailchimpApiKey;
use Konekt\AppShell\Tests\Unit\Settings\UIColorScheme;
use Orchestra\Testbench\TestCase;

class AvailableSettingsTest extends TestCase
{
    /**
     * @test
     */
    public function single_setting_can_be_registered()
    {
        $available = new AvailableSettings();

        $this->assertCount(0, $available->all());

        $available->register(new MailchimpApiKey());
        $this->assertCount(1, $available->all());
    }

    /**
     * @test
     */
    public function items_can_be_retrieved_by_scope()
    {
        $available = new AvailableSettings();

        $available->register(new MailchimpApiKey());

        $this->assertCount(1, $available->byScope(SettingScope::APPLICATION()));
        $this->assertCount(0, $available->byScope(SettingScope::USER()));

        $available->register(new UIColorScheme());
        $this->assertCount(1, $available->byScope(SettingScope::USER()));
    }
}
