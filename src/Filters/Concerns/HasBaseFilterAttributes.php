<?php

declare(strict_types=1);

/**
 * Contains the HasBaseFilterAttributes trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Filters\Concerns;

trait HasBaseFilterAttributes
{
    private string $id;

    private ?array $possibleValues;

    private ?string $label = null;

    private ?string $placeholder = null;

    public function id(): string
    {
        return $this->id;
    }

    public function possibleValues($context = null): ?array
    {
        if (null === $this->possibleValues && method_exists($this, 'loadPossibleValues')) {
            $this->possibleValues = $this->loadPossibleValues($context);
        }

        return $this->possibleValues;
    }

    public function label(): string
    {
        return $this->label ?? $this->id;
    }

    public function placeholder(): ?string
    {
        return $this->placeholder;
    }
}
