<?php
/**
 * Contains the AvailableSettings Test class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
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
    public function single_setting_can_be_registered_by_passing_a_setting_object()
    {
        $available = new AvailableSettings();

        $this->assertCount(0, $available->all());

        $available->register(new MailchimpApiKey());
        $this->assertCount(1, $available->all());
    }

    /**
     * @test
     */
    public function single_setting_can_be_registered_by_passing_a_setting_class_name()
    {
        $available = new AvailableSettings();

        $this->assertCount(0, $available->all());

        $available->register(MailchimpApiKey::class);
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

    /**
     * @test
     */
    public function constructor_accepts_array_of_class_names_and_registers_them()
    {
        $available = new AvailableSettings([
            MailchimpApiKey::class,
            UIColorScheme::class
        ]);

        $this->assertCount(2, $available->all());
        $this->assertInstanceOf(MailchimpApiKey::class, $available->getByKey(MailchimpApiKey::KEY));
        $this->assertInstanceOf(UIColorScheme::class, $available->getByKey('ui.color_scheme'));
    }

    /**
     * @test
     */
    public function constructor_accepts_array_of_setting_objects_and_registers_them()
    {
        $available = new AvailableSettings([
            new MailchimpApiKey(),
            new UIColorScheme()
        ]);

        $this->assertCount(2, $available->all());
        $this->assertInstanceOf(MailchimpApiKey::class, $available->getByKey(MailchimpApiKey::KEY));
        $this->assertInstanceOf(UIColorScheme::class, $available->getByKey('ui.color_scheme'));
    }

    /**
     * @test
     */
    public function constructor_accepts_mixed_array_of_setting_objects_and_class_names_and_registers_them()
    {
        $available = new AvailableSettings([
            MailchimpApiKey::class,
            new UIColorScheme()
        ]);

        $this->assertCount(2, $available->all());
        $this->assertInstanceOf(MailchimpApiKey::class, $available->getByKey(MailchimpApiKey::KEY));
        $this->assertInstanceOf(UIColorScheme::class, $available->getByKey('ui.color_scheme'));
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_you_try_to_register_an_invalid_scalar_type()
    {
        $this->expectException(\InvalidArgumentException::class);

        $available = new AvailableSettings();

        $available->register(2);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_you_try_to_register_a_non_class_string()
    {
        $this->expectException(\InvalidArgumentException::class);

        $available = new AvailableSettings();

        $available->register('I do not exist');
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_you_try_to_register_a_non_setting_class()
    {
        $this->expectException(\InvalidArgumentException::class);

        $available = new AvailableSettings();

        $available->register(self::class);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_you_try_to_register_a_non_setting_object()
    {
        $this->expectException(\InvalidArgumentException::class);

        $available = new AvailableSettings();

        $available->register($this);
    }
}
