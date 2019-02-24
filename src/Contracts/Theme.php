<?php
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

interface Theme
{
    public function getName(): string;

    public function semanticColorToHex(string $semanticColor): string;
}
