<?php
/**
 * Contains the MailchimpApiKey setting test class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-25
 *
 */


namespace Konekt\AppShell\Tests\Unit\Settings;


use Konekt\AppShell\Contracts\Setting;
use Konekt\AppShell\Contracts\SettingScope as SettingScopeContract;
use Konekt\AppShell\Models\SettingScope;

class MailchimpApiKey implements Setting
{
    private $scope;

    public function key()
    {
        return 'mailchimp.api_key';
    }

    public function scope(): SettingScopeContract
    {
        if (is_null($this->scope)) {
            $this->scope = SettingScope::APPLICATION();
        }

        return $this->scope;
    }

    public function default()
    {
        return null;
    }


    public function permission()
    {
        return null;
    }

    public function role()
    {
        return null;
    }

    public function options()
    {
        return null;
    }

    public function syncWithConfig()
    {
        return true;
    }
}
