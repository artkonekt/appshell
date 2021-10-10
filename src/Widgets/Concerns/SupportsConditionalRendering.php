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
    private $renderingCondition = null;

    private $negateRenderingCondition = false;

    protected function processRenderingConditions(array $definiton): void
    {
        if (isset($definiton['onlyIf'])) {
            $this->setRenderingCondition($definiton['onlyIf']);
        } elseif (isset($definiton['onlyIfNot'])) {
            $this->setRenderingCondition($definiton['onlyIfNot'], true);
        }
    }

    protected function setRenderingCondition($condition, bool $negate = false): void
    {
        $this->renderingCondition = $condition;
        $this->negateRenderingCondition = $negate;
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
            $result = $this->resolveSubstitutions($this->renderingCondition, $data);
        } elseif (is_callable($this->renderingCondition)) {
            $result = call_user_func($this->renderingCondition, $data);
        } else {
            $result = true;
        }

        return (bool) ($this->negateRenderingCondition ? !$result : $result);
    }
}
