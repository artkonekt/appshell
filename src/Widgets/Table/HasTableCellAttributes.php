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

    public ?string $align;

    public ?int $colspan;

    private string $inlineStyle = '';

    public function tdAttributes(): string
    {
        $result = '';
        foreach ($this->getSpecifiedAttributes(['width', 'colspan', 'valign']) as $attr => $value) {
            $result .= " $attr=\"$value\"";
        }

        return $result;
    }

    public function inlineStyle(): string
    {
        return $this->inlineStyle;
    }

    public function hasInlineStyle(): bool
    {
        return !empty($this->inlineStyle);
    }

    private function parseTableCellAttributes(array $definition): void
    {
        $this->width = $definition['width'] ?? null;
        $this->valign = $definition['valign'] ?? null;
        $this->align = $definition['align'] ?? null;
        $colspan = $definition['colspan'] ?? null;
        $this->inlineStyle .= $this->toCssRule($definition, 'align', 'text-align');
        $this->inlineStyle .= $this->toCssRule($definition, 'valign', 'vertical-align');
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

    private function toCssRule(array $def, string $key, string $cssKey = null): string
    {
        if (!isset($def[$key])) {
            return '';
        }

        return ($cssKey ?? $key) . ':' . $def[$key] . ';';
    }
}
