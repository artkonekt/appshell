<?php
/**
 * Contains the ZmdiAppShellIcons class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-02
 *
 */


namespace Konekt\AppShell\Icons;


use Konekt\Client\Models\ClientType;
use Konekt\Client\Models\ClientTypeProxy;

class ZmdiAppShellIcons
{
    /**
     * @var EnumIconMapper
     */
    protected $iconMapper;

    /**
     * ZmdiAppShellIcons constructor.
     *
     * @param $iconMapper
     */
    public function __construct($iconMapper)
    {
        $this->iconMapper = $iconMapper;
    }

    public function registerIcons()
    {
        $this->registerClientTypeIcons();
    }

    private function registerClientTypeIcons()
    {
        $this->iconMapper->registerEnumIcons(
            ClientTypeProxy::enumClass(),
            [
                ClientType::ORGANIZATION => 'city',
                ClientType::INDIVIDUAL   => 'account'
            ]
        );
    }

}