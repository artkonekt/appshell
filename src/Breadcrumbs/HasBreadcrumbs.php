<?php
/**
 * Contains the HasBreadcrumbs trait.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-23
 *
 */

namespace Konekt\AppShell\Breadcrumbs;

trait HasBreadcrumbs
{
    /**
     * Loads definitions from breadcrumbs file in case it's enabled in the config
     *
     * @return bool
     */
    public function loadBreadcrumbs()
    {
        if (!$this->config('breadcrumbs')) {
            return false;
        }

        $file = sprintf(
            '%s/%s/%s',
            $this->basePath,
            $this->convention->routesFolder(),
            'breadcrumbs.php'
        );

        if (file_exists($file)) {
            require $file;
        }
    }
}
