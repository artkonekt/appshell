<?php

declare(strict_types=1);

/**
 * Contains the WidgetModifier interface.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell\Contracts;

interface WidgetModifier
{
    public function handle($value): string;

    public static function create(array $arguments): WidgetModifier;
}
