<?php
/**
 * Contains the AssetLocation class.
 *
 * @copyright   Copyright (c) 2019 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2019-01-09
 *
 */

namespace Konekt\AppShell\Assets;

use Konekt\Enum\Enum;

class AssetLocation extends Enum
{
    public const HEADER = 'header';
    public const FOOTER = 'footer';
}
