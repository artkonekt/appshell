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
