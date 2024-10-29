<?php

declare(strict_types=1);

/**
 * Contains the HasFor trait.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-02
 *
 */

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait HasFor
{
    protected static array $extendedHasForDefinitions = [];

    public static function overrideHasForDefinition(string $short, string $class): void
    {
        static::$extendedHasForDefinitions[$short] = $class;
    }

    public static function addHasForDefinition(string $short, string $class): void
    {
        static::$extendedHasForDefinitions[$short] = $class;
    }

    public function getFor()
    {
        $id = $this->forId;
        $for = $this->for;

        if ($id && $for) {
            $modelClass = static::$extendedHasForDefinitions[$for] ?? null;
            if (null === $modelClass && null !== $contractClass = concord()->short($for)) {
                $modelClass = concord()->model($contractClass);
            }

            return $modelClass ? $modelClass::find($id) : null;
        }

        return null;
    }

    public function getForRelationName()
    {
        $for = $this->for;
        if ($for) {
            return Str::camel(Str::plural($for));
        }

        return null;
    }

    protected function getForRules(): array
    {
        if (!property_exists($this, 'allowedFor') || !is_array($this->allowedFor)) {
            throw new \LogicException('The allowedFor property must be an array containing the allowed entity short names');
        }

        return [
            'for' => ['sometimes', Rule::in(array_merge($this->allowedFor, array_keys(static::$extendedHasForDefinitions)))],
            'forId' => 'required_with:for'
        ];
    }
}
