<?php
/**
 * Contains the SettingsProvider class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-07
 *
 */

namespace Konekt\AppShell\Providers;

use Illuminate\Support\ServiceProvider;
use Konekt\Address\Models\CountryProxy;
use Konekt\AppShell\Settings\UiIconThemeSetting;
use Konekt\AppShell\Settings\UiLogoUriSetting;
use Konekt\AppShell\Settings\UiNameSetting;
use Konekt\AppShell\Settings\UiThemeSetting;
use Konekt\AppShell\Traits\AccessesAppShellConfig;
use Konekt\Gears\Defaults\SimpleSetting;
use Konekt\Gears\Registry\SettingsRegistry;
use Konekt\Gears\UI\TreeBuilder;

class SettingsProvider extends ServiceProvider
{
    use AccessesAppShellConfig;

    private SettingsRegistry $settingsRegistry;

    private bool $settingsTreeIsBuilt = false;

    public function register()
    {
        $this->app->singleton(
            'appshell.settings_tree_builder',
            function ($app) {
                $instance = new TreeBuilder($app['gears.settings'], $app['gears.preferences']);
                $this->buildSettingsTree($instance);

                return $instance;
            }
        );

        $this->app->bind(
            'appshell.settings_tree',
            function ($app) {
                return $app['appshell.settings_tree_builder']->getTree();
            }
        );
    }

    public function boot()
    {
        $this->settingsRegistry = $this->app['gears.settings_registry'];
        $this->bootUISettings();
        $this->bootDefaults();
    }

    protected function bootUISettings()
    {
        $this->settingsRegistry->add(new UiNameSetting());
        $this->settingsRegistry->add(new UiLogoUriSetting());
        $this->settingsRegistry->add(new UiThemeSetting());
        $this->settingsRegistry->add(new UiIconThemeSetting());
    }

    protected function bootDefaults()
    {
        $this->settingsRegistry->add(
            new SimpleSetting(
                'appshell.default.country',
                null,
                function () {
                    return ['' => '--'] + CountryProxy::all()->pluck('name', 'id')->all();
                }
            )
        );
    }

    protected function buildSettingsTree(TreeBuilder $ui)
    {
        if ($this->settingsTreeIsBuilt) {
            return;
        }

        $ui->addRootNode('general', __('General Settings'))
           ->addChildNode('general', 'general_app', __('Application'))
           ->addSettingItem(
               'general_app',
               ['text', ['label' => __('Name')]],
               UiNameSetting::KEY
           )
           ->addSettingItem(
               'general_app',
               ['select', ['label' => __('UI Theme')]],
               UiThemeSetting::KEY
           )
           ->addSettingItem(
               'general_app',
               ['select', ['label' => __('Icon Theme')]],
               UiIconThemeSetting::KEY
           )
           ->addSettingItem(
               'general_app',
               ['text', ['label' => __('Logo Image URI')]],
               UiLogoUriSetting::KEY
           );

        $ui->addChildNode('general', 'defaults', __('Defaults'))
           ->addSettingItem(
               'defaults',
               ['select', ['label' => __('Default Country')]],
               'appshell.default.country'
           );

        $this->settingsTreeIsBuilt = true;
    }
}
