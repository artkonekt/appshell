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
    protected function getRawData($model, string $attribute)
    {
        if (is_array($model)) {
            return $model[$attribute] ?? '';
        }

        if (is_object($model)) {
            if (Str::endsWith($attribute, '()')) {
                return call_user_func([$model, str_replace('()', '', $attribute)]);
            }
            if (Str::contains($attribute, '.')) {
                $parts = explode('.', $attribute);
                switch (count($parts)) {
                    case 2:
                        return $model->{$parts[0]}->{$parts[1]};
                    case 3:
                        return $model->{$parts[0]}->{$parts[1]}->{$parts[2]};
                    case 4:
                        return $model->{$parts[0]}->{$parts[1]}->{$parts[2]}->{$parts[2]};
                    default:
                        return ''; // Shrug
                }
            }
            return $model->{$attribute};
        }

        return '';
    }
}
