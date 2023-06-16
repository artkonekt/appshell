<?php

declare(strict_types=1);

/**
 * Contains the CreateAction class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-06-16
 *
 */

namespace Konekt\AppShell\Components;

use Konekt\AppShell\Models\ResourceAction;
use LogicException;

class CreateAction extends BaseComponent
{
    public function __construct(
        public ?string $icon = '+',
        public ?string $route = null,
        public ?string $url = null,
        public ?string $modelName = null,
        public ?string $buttonText = null,
        public ?string $permission = null,
    ) {
        if (is_null($this->permission) && is_null($this->modelName)) {
            throw new LogicException('The x-appshell::create-action component requires at least one of the `permission` or the `model-name` parameters to be set');
        }

        $this->buttonText = $buttonText ?? ($this->modelName ? __('New :object', ['object' => __($this->modelName)]) : __('Create new'));
        $this->url = $url ?? (str_ends_with($this->route, '.create') ? route($this->route) : route("$route.create"));
        $this->permission = $permission ?? $this->aclMap()->permissionFor($this->modelName, ResourceAction::CREATE);
    }
}
