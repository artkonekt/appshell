<?php

declare(strict_types=1);

/**
 * Contains the MissingUiFileException class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Exceptions;

use RuntimeException;

class MissingUiFileException extends RuntimeException
{
    public function __construct(string $ui, array $paths)
    {
        parent::__construct(
            "The UI `$ui` could not be loaded from the following paths: " . implode(' | ', $paths)
        );
    }
}
