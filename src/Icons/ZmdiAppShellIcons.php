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

use Konekt\Customer\Models\CustomerType;
use Konekt\Customer\Models\CustomerTypeProxy;

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
        $this->registerCustomerTypeIcons();
    }

    private function registerCustomerTypeIcons()
    {
        $this->iconMapper->registerEnumIcons(
            CustomerTypeProxy::enumClass(),
            [
                CustomerType::ORGANIZATION => 'city',
                CustomerType::INDIVIDUAL   => 'account'
            ]
        );
    }
}
