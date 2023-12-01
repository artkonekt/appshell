<?php

declare(strict_types=1);
/**
 * Contains the Theme interface.
 *
 * @copyright   Copyright (c) 2019 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2019-02-24
 *
 */

namespace Konekt\AppShell\Contracts;

use Konekt\Extend\Contracts\Registerable;

interface Theme extends Registerable
{
    public const COMPONENT_NAMESPACE = 'Konekt\\AppShell\\Components';

    public function themeColorToHex(?string $themeColorName): string;

    public function hexToThemeColor(string $hexColor): ?string;

    public function layout(string $variant): string;

    public function viewNamespace(): string;
}
