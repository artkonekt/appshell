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

        // There's exactly one model and nothing else in the parameter
        // This way the data type of the given field/method remains
        // intact. preg_replace_callback converts them to string
        if (preg_match('/^\$model\.[a-zA-Z0-9()_]+$/', $parameter)) {
            $tokens = explode('.', $parameter);

            return $this->getRawData($model, $tokens[1]);
        }

        if (Str::contains($parameter, '$model.')) {
            return preg_replace_callback(
                '/\$model\.([a-zA-Z0-9()_]+)/',
                fn($matches) => $this->getRawData($model, $matches[1]),
                $parameter
            );
        }

        return $parameter;
    }

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
}
