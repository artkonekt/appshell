<?php
/**
 * Contains the PreferencesProvider class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-07
 *
 */

namespace Konekt\AppShell\Providers;

use Illuminate\Support\ServiceProvider;
use Konekt\AppShell\Preferences\DateFormatPreference;
use Konekt\AppShell\Preferences\DateTimeFormatPreference;
use Konekt\AppShell\Preferences\QuickLinksPreference;
use Konekt\AppShell\Preferences\TimeFormatPreference;
use Konekt\Gears\Registry\PreferencesRegistry;
use Konekt\Gears\UI\TreeBuilder;

class PreferencesProvider extends ServiceProvider
{
    private PreferencesRegistry $preferencesRegistry;

    private bool $preferencesTreeIsBuilt = false;

    public function register()
    {
        parent::register();

        $this->app->singleton('appshell.preferences_tree_builder', function ($app) {
            $instance = new TreeBuilder($app['gears.settings'], $app['gears.preferences']);
            $this->buildPreferencesTree($instance);

            return $instance;
        });

        $this->app->bind('appshell.preferences_tree', function ($app) {
            return $app['appshell.preferences_tree_builder']->getTree();
        });
    }

    public function boot()
    {
        $this->preferencesRegistry = $this->app['gears.preferences_registry'];
        $this->bootDateTimeFormats();
    }

    protected function bootDateTimeFormats()
    {
        $this->preferencesRegistry->add(new DateFormatPreference());
        $this->preferencesRegistry->add(new DateTimeFormatPreference());
        $this->preferencesRegistry->add(new TimeFormatPreference());
        $this->preferencesRegistry->add(new QuickLinksPreference());
    }

    protected function buildPreferencesTree(TreeBuilder $ui)
    {
        if ($this->preferencesTreeIsBuilt) {
            return;
        }

        $ui->addRootNode('general', __('General Settings'), 100)
           ->addChildNode('general', 'defaults', __('Defaults'))
           ->addPreferenceItem(
               'defaults',
               ['select', ['label' => __('Date Format')]],
               DateFormatPreference::KEY
           )
           ->addPreferenceItem(
               'defaults',
               ['select', ['label' => __('DateTime Format')]],
               DateTimeFormatPreference::KEY
           )
           ->addPreferenceItem(
               'defaults',
               ['select', ['label' => __('Time Format')]],
               TimeFormatPreference::KEY
           );

        $this->preferencesTreeIsBuilt = true;
    }
}
