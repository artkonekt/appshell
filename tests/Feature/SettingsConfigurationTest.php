<?php
/**
 * Contains the SettingsConfigurationTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-11
 *
 */


namespace Konekt\AppShell\Tests\Feature;


use Konekt\AppShell\Settings\SettingsManager;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Tests\Unit\Settings\MailchimpApiKey;
use Konekt\AppShell\Tests\Unit\Settings\UIColorScheme;

class SettingsConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function setting_classes_can_be_defined_in_configuration()
    {
        /** @var SettingsManager $settingsService */
        $settingsService = $this->app->make('appshell.settings');

        $this->assertCount(2, $settingsService->available());
        $this->assertEquals(UIColorScheme::DEFAULT, $settingsService->get('ui.color_scheme'));
    }

    /**
     * @inheritdoc
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('konekt.app_shell.settings.settings', [
            UIColorScheme::class,
            MailchimpApiKey::class
        ]);
    }
}
