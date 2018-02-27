<?php
/**
 * Contains the SettingsBackendTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-27
 *
 */


namespace Konekt\AppShell\Tests\Unit;


use Konekt\AppShell\Contracts\SettingsBackend;
use Konekt\AppShell\Settings\Backends\Database as DatabaseBackend;
use Konekt\AppShell\Tests\Unit\Settings\MailchimpApiKey;
use Konekt\AppShell\Tests\Unit\Settings\UIColorScheme;

class SettingsBackendTest extends TestCase
{
    /**
     * @test
     * @dataProvider backendProvider
     */
    public function individual_values_can_be_saved_and_returned(SettingsBackend $backend)
    {
        $uiColorScheme = new UIColorScheme();

        $this->assertNull($backend->get($uiColorScheme));
        $backend->set($uiColorScheme, 'blue');

        $this->assertEquals('blue', $backend->get($uiColorScheme));
    }

    /**
     * @test
     * @dataProvider backendProvider
     */
    public function individual_values_can_be_get_and_set_by_string_keys(SettingsBackend $backend)
    {
        $uiColorScheme = new UIColorScheme();

        $this->assertNull($backend->get($uiColorScheme->key()));

        $backend->set($uiColorScheme->key(), 'green');
        $this->assertEquals('green', $backend->get($uiColorScheme->key()));
    }

    /**
     * @test
     * @dataProvider backendProvider
     */
    public function string_and_object_getters_setters_can_be_freely_combined(
        SettingsBackend $backend
    ) {
        $mailchimp = new MailchimpApiKey();

        $backend->set(MailchimpApiKey::KEY, 'abcedfgh');
        $this->assertEquals('abcedfgh', $backend->get($mailchimp));

        $backend->set($mailchimp, 'asdqwe1234');
        $this->assertEquals('asdqwe1234', $backend->get(MailchimpApiKey::KEY));
    }

    /**
     * @test
     * @dataProvider backendProvider
     */
    public function all_settings_can_be_retrieved(SettingsBackend $backend)
    {
        $uiColorScheme = new UIColorScheme();

        $backend->set(MailchimpApiKey::KEY, 'gugugu');
        $backend->set($uiColorScheme, 'red');

        $all = $backend->all();

        $this->assertCount(2, $all);

        $this->assertTrue($all->has(MailchimpApiKey::KEY));
        $this->assertEquals('gugugu', $all->get(MailchimpApiKey::KEY)->value);

        $this->assertTrue($all->has($uiColorScheme->key()));
        $this->assertEquals('red', $all->get($uiColorScheme->key())->value);
    }

    /**
     * @test
     * @dataProvider backendProvider
     */
    public function settings_can_be_saved_for_distinct_users(SettingsBackend $backend)
    {
        $backend->set(MailchimpApiKey::KEY, '1234', 25);
        $backend->set(MailchimpApiKey::KEY, '5678', 27);

        $this->assertEquals('1234', $backend->get(MailchimpApiKey::KEY, 25));
        $this->assertEquals('5678', $backend->get(MailchimpApiKey::KEY, 27));

        $all = $backend->all();

        $this->assertCount(2, $all);

        $this->assertFalse($all->has(MailchimpApiKey::KEY));
        $this->assertTrue($all->has(MailchimpApiKey::KEY . '@' . 25));
        $this->assertTrue($all->has(MailchimpApiKey::KEY . '@' . 27));
    }

    public function backendProvider()
    {
        return [
            [new DatabaseBackend()]
        ];
    }
}
