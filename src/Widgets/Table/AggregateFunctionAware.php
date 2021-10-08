<?php

declare(strict_types=1);

/**
 * Contains the AggregateFunctionAware trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-08
 *
 */

namespace Konekt\AppShell\Widgets\Table;


use Illuminate\Support\Str;

trait AggregateFunctionAware
{
    private static array $aggregateMethods = ['sum', 'avg'];

    private function isAggregateMethodDef(string $definition): bool
    {
        foreach (self::$aggregateMethods as $method) {
            if (Str::startsWith($definition, '$model.' . "$method(")) {
                return true;
            }
        }

        return false;
    }

    private function getAggregateMethodName(string $definition): ?string
    {
        foreach (self::$aggregateMethods as $method) {
            if (Str::startsWith($definition, '$model.' . "$method(")) {
                return $method;
            }
        }

        return null;
    }

    private function getAggregateMethodParams(string $definition): ?array
    {
        $params = Str::remove('$model.' . $this->getAggregateMethodName($definition) . '(', $definition);
        $params = trim(Str::replaceLast(')', '', $params));

        if (empty($params)) {
            return null;
        }

        $result = explode(',', $params);
        array_walk($result, fn($param) => trim($param));

        return $result;
    }
}
