<?php
/**
 * Contains the AppShellSettingsBooter class.
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
use Konekt\AppShell\Theme\DefaultAppShellTheme;
use Konekt\AppShell\Themes;
use Konekt\AppShell\Traits\AccessesAppShellConfig;
use Konekt\Gears\Defaults\SimpleSetting;
use Konekt\Gears\Registry\SettingsRegistry;
use Konekt\Gears\UI\TreeBuilder;

class SettingsProvider extends ServiceProvider
{
    use AccessesAppShellConfig;

    /** @var SettingsRegistry $settingsRegistry */
    private $settingsRegistry;

    private $settingsTreeIsBuilt = false;

    public function register()
    {
        parent::register();

        $this->app->singleton('appshell.settings_tree_builder', function ($app) {
            return new TreeBuilder($app['gears.settings'], $app['gears.preferences']);
        });

        $this->app->bind('appshell.settings_tree', function ($app) {
            $this->buildSettingsTree();

            return $app['appshell.settings_tree_builder']->getTree();
        });
    }

    public function boot()
    {
        $this->settingsRegistry = $this->app['gears.settings_registry'];
        $this->bootUISettings();
        $this->bootDefaults();
    }

    protected function bootUISettings()
    {
        $this->settingsRegistry->add(new SimpleSetting('appshell.ui.name', $this->config('ui.name')));
        $this->settingsRegistry->add(new SimpleSetting('appshell.ui.logo_uri', $this->config('ui.logo_uri')));

        $this->settingsRegistry->add(new SimpleSetting('appshell.ui.theme',
            $this->config('ui.theme', DefaultAppShellTheme::ID), function () {
                return Themes::choices();
            })
        );
    }

    protected function bootDefaults()
    {
        $this->settingsRegistry->add(new SimpleSetting('appshell.default.country', null, function () {
            return ['' => '--'] + CountryProxy::all()->pluck('name', 'id')->all();
        }));
    }

    protected function buildSettingsTree()
    {
        if ($this->settingsTreeIsBuilt) {
            return;
        }

        /** @var TreeBuilder $settingsTreeBuilder */
        $settingsTreeBuilder = $this->app['appshell.settings_tree_builder'];

        $settingsTreeBuilder->addRootNode('general', __('General Settings'))
                            ->addChildNode('general', 'general_app', __('Application'))
                            ->addSettingItem('general_app', ['text', ['label' => __('Name')]],
                                'appshell.ui.name')
                            ->addSettingItem('general_app', ['select', ['label' => __('UI Theme')]],
                                'appshell.ui.theme');

        $settingsTreeBuilder->addChildNode('general', 'defaults', __('Defaults'))
                            ->addSettingItem('defaults',
                                ['select', ['label' => __('Default Country')]],
                                'appshell.default.country');

        $this->settingsTreeIsBuilt = true;
    }
}
