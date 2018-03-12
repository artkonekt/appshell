<?php
/**
 * Contains the SettingsManagerTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-27
 *
 */


namespace Konekt\AppShell\Tests\Unit;


use Illuminate\Support\Facades\DB;
use Konekt\AppShell\Settings\AvailableSettings;
use Konekt\AppShell\Settings\Backends\Database;
use Konekt\AppShell\Settings\SettingsManager;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Tests\Unit\Settings\MailchimpApiKey;
use Konekt\AppShell\Tests\Unit\Settings\UIColorScheme;

class SettingsManagerTest extends TestCase
{
    /** @var AvailableSettings */
    private $availableSettings;



    public function setUp()
    {
        parent::setUp();

        DB::table(Database::TABLE_NAME)->insert([
            'key'   => MailchimpApiKey::KEY,
            'value' => 'fghjkl'
        ]);
    }

    /**
     * @test
     * @dataProvider managerProvider
     */
    public function it_returns_individual_settings(SettingsManager $manager)
    {
        $this->assertEquals('fghjkl', $manager->get(MailchimpApiKey::KEY));
    }

    /**
     * @test
     * @dataProvider managerProvider
     */
    public function it_returns_settings_with_application_scope(SettingsManager $manager)
    {
        $this->assertCount(1, $manager->forApplication());

        $this->assertInstanceOf(MailchimpApiKey::class, $manager->forApplication()->first());
    }

    /**
     * @test
     * @dataProvider managerProvider
     */
    public function it_returns_settings_with_user_scope(SettingsManager $manager)
    {
        $this->assertCount(1, $manager->forUser());

        $this->assertInstanceOf(UIColorScheme::class, $manager->forUser()->first());
    }

    public function managerProvider()
    {
        return [
            [new SettingsManager($this->getAvailableSettings(), new Database())]
        ];
    }

    private function getAvailableSettings()
    {
        if (!$this->availableSettings) {
            $this->availableSettings = new AvailableSettings();
            $this->availableSettings->register(new MailchimpApiKey());
            $this->availableSettings->register(new UIColorScheme());
        }

        return $this->availableSettings;
    }
}
