<?php
/**
 * Contains the Stylesheet class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-10-30
 *
 */

namespace Konekt\AppShell\Assets;

class Stylesheet extends BaseAsset
{
    protected $tag = 'link';

    protected $urlAttribute = 'href';

    protected $defaultAttributes = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];
}
