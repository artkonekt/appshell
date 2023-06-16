<?php

declare(strict_types=1);

/**
 * Contains the StandardActions class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-06-16
 *
 */

namespace Konekt\AppShell\Components;

use Illuminate\Support\Str;
use Konekt\AppShell\Models\ResourceAction;

class StandardActions extends BaseComponent
{
    public function __construct(
        public object $model,
        public string $name = '',
        public ?string $route = null,
        public ?string $editUrl = null,
        public ?string $deleteUrl = null,
        public ?string $modelName = null,
        public ?string $editButtonText = null,
        public ?string $deleteButtonTitle = null,
        public ?string $deleteConfirmationText = null,
        public ?string $editPermission = null,
        public ?string $deletePermission = null,
    ) {
        $this->modelName = $modelName ?? shorten($model::class);
        $this->editButtonText = $editButtonText ?? __('Edit');
        $this->deleteButtonTitle = $deleteButtonTitle ?? __('Delete the :object', ['object' => __($this->modelName)]);
        $this->deleteConfirmationText = $deleteConfirmationText ?? __('Delete the :name :object?', ['name' => $this->name, 'object' => __($this->modelName)]);
        $this->editUrl = $editUrl ?? route("$route.edit", $this->model);
        $this->deleteUrl = $deleteUrl ?? route("$route.destroy", $this->model);

        if (is_null($this->editPermission)) {
            $this->editPermission = $this->aclMap()->permissionFor($this->modelName, ResourceAction::EDIT);
        }
        if (is_null($this->deletePermission)) {
            $this->deletePermission = $this->aclMap()->permissionFor($this->modelName, ResourceAction::DESTROY);
        }
    }
}
