<?php
/**
 * Contains the Script class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-10-30
 *
 */

namespace Konekt\AppShell\Assets;

class Script extends BaseAsset
{
    protected $tag = 'script';

    protected $urlAttribute = 'src';

    protected $selfClosing = false;
}
