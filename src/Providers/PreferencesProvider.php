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

use Carbon\Laravel\ServiceProvider;
use Konekt\AppShell\Preferences\DateFormatPreference;
use Konekt\AppShell\Preferences\DateTimeFormatPreference;
use Konekt\AppShell\Preferences\QuickLinksPreference;
use Konekt\AppShell\Preferences\TimeFormatPreference;
use Konekt\Gears\Registry\PreferencesRegistry;
use Konekt\Gears\UI\TreeBuilder;

class PreferencesProvider extends ServiceProvider
{
    /** @var PreferencesRegistry $preferencesRegistry */
    private $preferencesRegistry;

    private $preferencesTreeIsBuilt = false;

    public function register()
    {
        parent::register();

        $this->app->singleton('appshell.preferences_tree_builder', function ($app) {
            return new TreeBuilder($app['gears.settings'], $app['gears.preferences']);
        });

        $this->app->bind('appshell.preferences_tree', function ($app) {
            $this->buildPreferencesTree();

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

    protected function buildPreferencesTree()
    {
        if ($this->preferencesTreeIsBuilt) {
            return;
        }

        /** @var TreeBuilder $ui */
        $ui = $this->app['appshell.preferences_tree_builder'];

        $ui->addRootNode('general', __('General Settings'), 100)
           ->addChildNode('general', 'defaults', __('Defaults'))
           ->addPreferenceItem('defaults', ['select', ['label' => __('Date Format')]],
               DateTimeFormatPreference::KEY)
           ->addPreferenceItem('defaults', ['select', ['label' => __('DateTime Format')]],
               DateTimeFormatPreference::KEY)
           ->addPreferenceItem('defaults', ['select', ['label' => __('Time Format')]],
               TimeFormatPreference::KEY);

        $this->preferencesTreeIsBuilt = true;
    }
}
