<?php

declare(strict_types=1);

/**
 * Contains the Filter class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Widgets;

use Illuminate\Support\Collection;
use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;

class Filter implements Widget
{
    use RendersThemedWidget;

    protected string $id;

    private FilterType $type;

    private ?iterable $options = null;

    private string $title;

    public function __construct(Theme $theme, string $id, FilterType $type, string $title = null)
    {
        $this->theme = $theme;
        $this->id = $id;
        $this->type = $type;
        $this->title = $title ?? $id;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        $instance = new static(
            $theme,
            $options['id'],
            FilterType::create($options['type'] ?? FilterType::defaultValue()),
            $options['title'] ?? null,
        );

        if (isset($options['options'])) {
            $opts = $options['options'];
            if (is_array($opts)) {
                if (is_callable($opts['call'] ?? null)) {
                    $values = call_user_func_array($opts['call'], $opts['args'] ?? []);
                    if (isset($opts['pluck'])) {
                        $values = $values->pluck($opts['pluck'][1], $opts['pluck'][0]);
                    }
                    $instance->setOptions($values);
                } else {
                    $instance->setOptions($opts);
                }
            }
        }

        return $instance;
    }

    public function setOptions(iterable $options): void
    {
        $this->options = $options;

        if ($options instanceof Collection) {
            $this->options = $options->all();
        }
    }

    public function render($data = null): string
    {
        return $this->renderViewFromTheme('filter', [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type->value(),
            'options' => $this->options,
        ]);
    }
}
