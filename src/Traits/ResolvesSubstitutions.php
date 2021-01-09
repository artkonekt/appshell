<?php

declare(strict_types=1);

/**
 * Contains the ResolvesSubstitutions class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Traits;

use Illuminate\Support\Str;
use Konekt\AppShell\Contracts\Widget;

trait ResolvesSubstitutions
{
    use AccessesRawData;

    private static function makeCallable($definition): callable
    {
        if (is_string($definition)) {
            return function ($data, Widget $widget) use ($definition) {
                return $widget->resolveSubstitutions($definition, $data);
            };
        }

        if (is_array($definition)) {
            if (array_key_exists('route', $definition)) {
                return function ($data, Widget $widget) use ($definition) {
                    return route($definition['route'], $widget->getParams($definition, $data));
                };
            } elseif (array_key_exists('path', $definition)) {
                return function ($data, Widget $widget) use ($definition) {
                    return url($definition['path'], $widget->getParams($definition, $data));
                };
            }
        }

        if (is_callable($definition)) {
            return $definition;
        }
    }

    protected function getParams(array $definition, $data): array
    {
        $parameters = [];

        foreach ($definition['parameters'] ?? [] as $parameter) {
            $parameters[] = $this->resolveSubstitutions($parameter, $data);
        }

        return $parameters;
    }

    protected function resolveSubstitutions(string $parameter, $model)
    {
        if ('$model' === $parameter) {
            return $model;
        }

        if (Str::startsWith($parameter, '$model.')) {
            $tokens = explode('.', $parameter);

            return $this->getRawData($model, $tokens[1]);
        }

        return $parameter;
    }
}
