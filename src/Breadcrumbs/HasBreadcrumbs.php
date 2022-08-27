<?php

declare(strict_types=1);

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
     */
    public function loadBreadcrumbs(): void
    {
        if (!$this->config('breadcrumbs')) {
            return;
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
