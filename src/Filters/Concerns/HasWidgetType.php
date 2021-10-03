<?php

declare(strict_types=1);

/**
 * Contains the HasWidgetType trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-20
 *
 */

namespace Konekt\AppShell\Filters\Concerns;

trait HasWidgetType
{
    private string $widgetType = 'select';

    public function displayAsSelect(): self
    {
        $this->widgetType = 'select';

        return $this;
    }

    public function displayAsMultiSelect(): self
    {
        $this->widgetType = 'multiselect';

        return $this;
    }

    public function displayAsSwitch(): self
    {
        $this->widgetType = 'switch';

        return $this;
    }

    public function displayAsCheckbox(): self
    {
        $this->widgetType = 'checkbox';

        return $this;
    }

    public function displayAsTextField(): self
    {
        $this->widgetType = 'text';

        return $this;
    }

    public function widgetType(): string
    {
        return $this->widgetType;
    }
}
