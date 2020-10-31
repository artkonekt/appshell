<?php

declare(strict_types=1);

/**
 * Contains the BootsAppShellMenu trait.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-19
 *
 */

namespace Konekt\AppShell\Providers;

use Konekt\AppShell\Traits\AccessesAppShellConfig;
use Konekt\Menu\Facades\Menu;

trait BootsAppShellMenu
{
    public function bootAppShellMenus()
    {
        foreach ($this->config('menu') as $name => $config) {
            Menu::create($name, $config);
        }

        // Add default menu items to sidebar
        if ($appshellMenu = Menu::get('appshell')) {
            // CRM Group
            $crm = $appshellMenu->addItem('crm_group', __('CRM'));

            $crm
                ->addSubItem('customers', __('Customers'), ['route' => 'appshell.customer.index'])
                ->data('icon', 'customers')
                ->activateOnUrls($this->routeWildcard('appshell.customer.index'))
                ->allowIfUserCan('list customers');

            // Settings Group
            $settings = $appshellMenu->addItem('settings_group', __('Settings'));

            $settings
                ->addSubItem('users', __('Users'), ['route' => 'appshell.user.index'])
                ->data('icon', 'users')
                ->activateOnUrls($this->routeWildcard('appshell.user.index'))
                ->allowIfUserCan('list users');
            $settings
                ->addSubItem('roles', __('Permissions'), ['route' => 'appshell.role.index'])
                ->data('icon', 'security')
                ->activateOnUrls($this->routeWildcard('appshell.role.index'))
                ->allowIfUserCan('list roles');
            $settings
                ->addSubItem('settings', __('Settings'), ['route' => 'appshell.settings.index'])
                ->data('icon', 'settings')
                ->allowIfUserCan('list settings');
        }
    }

    private function routeWildcard(string $route): string
    {
        if (0 === strlen($path = parse_url(route($route), PHP_URL_PATH))) {
            return '';
        }

        if ('/' === $path[0]) {
            $path = substr($path, 1);
        }

        return "$path*";
    }
}
