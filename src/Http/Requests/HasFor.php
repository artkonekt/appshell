<?php
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
    /**
     * @inheritdoc
     */
    public function getFor()
    {
        $id  = $this->forId;
        $for = $this->for;

        if ($id && $for) {
            $modelClass = concord()->model(concord()->short($for));

            return $modelClass::find($id);
        }

        return null;
    }

    /**
     * @inheritDoc
     */
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
            'for'   => ['sometimes', Rule::in($this->allowedFor)],
            'forId' => 'required_with:for'
        ];
    }
}
