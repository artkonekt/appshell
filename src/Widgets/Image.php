<?php

declare(strict_types=1);

/**
 * Contains the Image class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-07-03
 *
 */

namespace Konekt\AppShell\Widgets;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;
use Konekt\AppShell\Widgets\Concerns\SupportsConditionalRendering;

class Image implements Widget
{
    use RendersThemedWidget;
    use ResolvesSubstitutions;
    use SupportsConditionalRendering;

    /** @var ?callable */
    private $fallback = null;

    private ?int $size = null;

    /** @var ?callable */
    private $tooltip = null;

    private ?string $style = null;

    private ?string $class = null;

    public function __construct(Theme $theme, callable $model)
    {
        $this->theme = $theme;
        $this->model = $model;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        $instance = new static($theme, self::makeCallable($options['model'] ?? '$model'));
        $instance->processRenderingConditions($options);
        if (isset($options['fallback'])) {
            $instance->fallback = self::makeCallable($options['fallback']);
        }

        if (isset($options['tooltip'])) {
            $instance->tooltip = self::makeCallable($options['tooltip']);
        }

        if (isset($options['size'])) {
            $instance->size = intval($options['size']);
        }

        if (isset($options['style'])) {
            $instance->style = $options['style'];
        }

        if (isset($options['class'])) {
            $instance->class = $options['class'];
        }

        return $instance;
    }

    public function render($data = null): string
    {
        if ($this->shouldNotRender($data)) {
            return '';
        }

        return $this->renderViewFromTheme('image', [
            'src' => call_user_func($this->model, $data, $this) ?: (null !== $this->fallback ? call_user_func($this->fallback, $data, $this) : null),
            'tooltip' => null !== $this->tooltip ? call_user_func($this->tooltip, $data, $this) : null,
            'size' => $this->size,
            'style' => $this->style,
            'class' => $this->class,
        ]);
    }
}
