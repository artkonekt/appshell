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

use Illuminate\Support\Str;

trait AccessesRawData
{
    protected function getRawData($model, string $attributes)
    {
        $result = $model;

        foreach (explode('.', $attributes) as $attribute) {
            $result = match (true) {
                is_array($result) => $result[$attribute],
                is_object($result) => Str::endsWith($attribute, '()') ? call_user_func([$result, str_replace('()', '', $attribute)]) : $result->{$attribute},
                is_null($result) => null,
            };
        }

        return $result ?? '';
    }
}
