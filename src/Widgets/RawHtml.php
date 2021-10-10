<?php

declare(strict_types=1);

/**
 * Contains the RawHtml class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-10
 *
 */

namespace Konekt\AppShell\Widgets;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;
use Konekt\AppShell\Widgets\Concerns\HasModifier;
use Konekt\AppShell\Widgets\Concerns\SupportsConditionalRendering;

class RawHtml implements Widget
{
    use RendersThemedWidget;
    use ResolvesSubstitutions;
    use SupportsConditionalRendering;
    use HasModifier;

    /** @var callable */
    private $html;

    public function __construct(Theme $theme, callable $html)
    {
        $this->theme = $theme;
        $this->html = $html;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        $html = self::makeCallable($options['html'] ?? '$model');
        $instance = new static($theme, $html);

        if (isset($options['modifier'])) {
            $instance->setModifier($options['modifier']);
        }

        if (isset($options['onlyIf'])) {
            $instance->setRenderingCondition($options['onlyIf']);
        }

        return $instance;
    }

    public function render($data = null): string
    {
        if ($this->shouldNotRender($data)) {
            return '';
        }

        $html = $this->html;

        return $this->modify($html($data, $this));
    }
}
