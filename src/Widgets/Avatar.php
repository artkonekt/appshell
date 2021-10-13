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

    /** @var callable */
    private $model;

    public function __construct(Theme $theme, callable $model)
    {
        $this->theme = $theme;
        $this->model = $model;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        $instance = new static($theme, self::makeCallable($options['model'] ?? '$model'));

        $instance->processRenderingConditions($options);

        return $instance;
    }

    public function render($data = null): string
    {
        if ($this->shouldNotRender($data)) {
            return '';
        }

        return $this->renderViewFromTheme('avatar', [
            'data' => call_user_func($this->model, $data, $this),
        ]);
    }
}
