<?php

declare(strict_types=1);

/**
 * Contains the Actions class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell\Widgets\Table;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;

class Actions implements Widget
{
    use RendersThemedWidget;
    use ResolvesSubstitutions;

    private array $actions;

    public function __construct(Theme $theme, array $actions)
    {
        $this->theme = $theme;
        $this->actions = $actions;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        return new static($theme, $options['actions'] ?? []);
    }

    public function render($data = null): string
    {
        $actions = [];
        foreach ($this->actions as $action => $params) {
            $actions[$action] = $params;
        }

        if (isset($actions['delete'])) {
            if (!isset($actions['delete']['confirm'])) {
                $actions['delete']['confirmation_text'] = __('Are you sure to delete this item?');
            } else {
                if (isset($actions['delete']['confirm']['params'])) {
                    foreach ($actions['delete']['confirm']['params'] as $name => $value) {
                        $actions['delete']['confirm']['params'][$name] = $this->resolveSubstitutions($value, $data);
                    }
                }
                $actions['delete']['confirmation_text'] = __($actions['delete']['confirm']['text'], $actions['delete']['confirm']['params']);
            }
            unset($actions['confirm']);//We only pass the flattened confirm_text value without all the sweat
        }

        return $this->renderViewFromTheme('table_actions', [
            'model' => $data,
            'actions' => $actions,
        ]);
    }
}
