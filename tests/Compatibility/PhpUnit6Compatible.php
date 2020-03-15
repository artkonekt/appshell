<?php
/**
 * Contains the PhpUnit6Compatible trait.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-15
 *
 */

namespace Konekt\AppShell\Tests\Compatibility;

trait PhpUnit6Compatible
{
    public function __call($name, $arguments)
    {
        if ('assertStringContainsString' === $name) {
            self::assertContains(...$arguments);
        }
    }
}
