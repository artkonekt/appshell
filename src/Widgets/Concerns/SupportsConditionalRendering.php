<?php

declare(strict_types=1);

/**
 * Contains the SupportConditionalRendering trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-10
 *
 */

namespace Konekt\AppShell\Widgets\Concerns;

use Konekt\AppShell\Traits\ResolvesSubstitutions;

trait SupportsConditionalRendering
{
    use ResolvesSubstitutions;

    /** @var string|callable|null */
    protected $renderingCondition = null;

    protected function setRenderingCondition($condition): void
    {
        $this->renderingCondition = $condition;
    }

    protected function shouldNotRender($data): bool
    {
        if (null === $this->renderingCondition) {
            return false;
        }

        return !$this->evaluateRenderingConditon($data);
    }

    private function evaluateRenderingConditon($data)
    {
        if (is_string($this->renderingCondition)) {
            return $this->resolveSubstitutions($this->renderingCondition, $data);
        } elseif (is_callable($this->renderingCondition)) {
            return call_user_func($this->renderingCondition, $data);
        }

        return true;
    }
}
