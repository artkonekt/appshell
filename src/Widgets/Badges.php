<?php

declare(strict_types=1);

/**
 * Contains the Badges class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell\Widgets;

use Illuminate\Support\Arr;
use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;
use Konekt\AppShell\Widgets;

class Badges implements Widget
{
    use RendersThemedWidget;
    use ResolvesSubstitutions;

    protected Badge $badge;

    protected string $itemsField;

    public function __construct(Theme $theme, Badge $badge, string $itemsField)
    {
        $this->theme = $theme;
        $this->badge = $badge;
        $this->itemsField = $itemsField;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        return new static(
            $theme,
            Widgets::make('badge', Arr::except($options, 'items'), $theme),
            $options['items'] ?? '$model'
        );
    }

    public function render($data = null): string
    {
        $source = $this->resolveSubstitutions($this->itemsField, $data);

        if (!is_iterable($source)) {
            return '';
        }

        $result = '';
        foreach ($source as $item) {
            $result .= $this->badge->render($item) . ' ';
        }

        return $result;
    }
}
