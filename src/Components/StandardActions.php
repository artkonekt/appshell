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
        public ?string $editRole = null,
        public ?string $deleteRole = null,
    ) {
        $this->modelName = $modelName ?? shorten($model::class);
        $this->editButtonText = $editButtonText ?? __('Edit');
        $this->deleteButtonTitle = $deleteButtonTitle ?? __('Delete the :object', ['object' => $this->modelName]);
        $this->deleteConfirmationText = $deleteConfirmationText ?? __('Delete the :name :object?', ['name' => $this->name, 'object' => $this->modelName]);
        $this->editUrl = $editUrl ?? route("$route.edit", $this->model);
        $this->deleteUrl = $deleteUrl ?? route("$route.destroy", $this->model);
        $this->editRole = $editRole ?? 'edit ' . Str::plural($this->modelName);
        $this->deleteRole = $deleteRole ?? 'delete ' . Str::plural($this->modelName);
    }
}
