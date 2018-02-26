<?php
/**
 * Contains the SettingsManager class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-26
 *
 */


namespace Konekt\AppShell\Settings;


class SettingsManager
{
    /**
     * @var AvailableSettings
     */
    private $availableSettings;

    public function __construct(AvailableSettings $availableSettings)
    {
        $this->availableSettings = $availableSettings;
    }

}
