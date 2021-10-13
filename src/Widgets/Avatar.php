<?php

declare(strict_types=1);

/**
 * Contains the Avatar class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-13
 *
 */

namespace Konekt\AppShell\Widgets;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;
use Konekt\AppShell\Widgets\Concerns\SupportsConditionalRendering;

class Avatar implements Widget
{
    use RendersThemedWidget;
    use ResolvesSubstitutions;
    use SupportsConditionalRendering;

    private const DEFAULT_AVATAR_SIZE = 50;

    /** @var callable */
    private $model;

    /** @var ?callable */
    private $tooltip = null;

    private ?int $size = null;

    public function __construct(Theme $theme, callable $model)
    {
        $this->theme = $theme;
        $this->model = $model;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        $instance = new static($theme, self::makeCallable($options['model'] ?? '$model'));
        $instance->processRenderingConditions($options);
        if (isset($options['tooltip'])) {
            $instance->tooltip = self::makeCallable($options['tooltip']);
        }

        if (isset($options['size'])) {
            $instance->size = intval($options['size']);
        }

        return $instance;
    }

    public function render($data = null): string
    {
        if ($this->shouldNotRender($data)) {
            return '';
        }

        return $this->renderViewFromTheme('avatar', [
            'data' => call_user_func($this->model, $data, $this),
            'tooltip' => null !== $this->tooltip ? call_user_func($this->tooltip, $data, $this) : null,
            'size' => $this->size ?? self::DEFAULT_AVATAR_SIZE,
        ]);
    }
}
