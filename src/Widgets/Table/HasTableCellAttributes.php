<?php

declare(strict_types=1);

/**
 * Contains the HasTableCellAttributes trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-08
 *
 */

namespace Konekt\AppShell\Widgets\Table;

trait HasTableCellAttributes
{
    public ?string $width;

    public ?string $valign;

    public ?int $colspan;

    public function tdAttributes(): string
    {
        $result = '';
        foreach ($this->getSpecifiedAttributes(['width', 'colspan', 'valign']) as $attr => $value) {
            $result .= " $attr=\"$value\"";
        }

        return $result;
    }

    private function parseTableCellAttributes(array $definition): void
    {
        $this->width = $definition['width'] ?? null;
        $this->valign = $definition['valign'] ?? null;
        $colspan = $definition['colspan'] ?? null;
        $this->colspan = null !== $colspan ? intval($colspan) : null;
    }

    private function getSpecifiedAttributes(array $attributes): array
    {
        $result = [];
        foreach ($attributes as $attribute) {
            if (isset($this->{$attribute}) && null !== $this->{$attribute}) {
                $result[$attribute] = $this->{$attribute};
            }
        }

        return $result;
    }
}
