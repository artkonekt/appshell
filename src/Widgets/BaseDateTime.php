<?php

declare(strict_types=1);

/**
 * Contains the BaseDateTime class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Widgets;

use DateTimeInterface;
use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Widgets;

abstract class BaseDateTime extends BaseModifiedText
{
    public static function create(Theme $theme, array $options = []): Widget
    {
        $modifier = static::modifierMethodName();
        if (isset($options['unknown'])) {
            $modifier .= ':' . $options['unknown'];
        }

        return new static(
            $theme,
            Widgets::make(
                'text',
                array_merge($options, ['modifier' => $modifier])
            )
        );
    }

    public function render($data = null): string
    {
        return parent::render($this->processDateTime($data));
    }

    private function processDateTime($data = null)
    {
        if ($data instanceof DateTimeInterface) {
            $data = $data->format('Y-m-d H:i:s');
        }

        return $data;
    }
}
