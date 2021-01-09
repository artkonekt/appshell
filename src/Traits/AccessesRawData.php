<?php

declare(strict_types=1);

/**
 * Contains the AccessesRawData trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Traits;

trait AccessesRawData
{
    protected function getRawData($model, string $attribute): string
    {
        if (is_array($model)) {
            return (string) $model[$attribute] ?? '';
        }

        if (is_object($model)) {
            return (string) $model->{$attribute};
        }

        return '';
    }
}
