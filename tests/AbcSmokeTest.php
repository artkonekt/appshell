<?php
/**
 * Contains the AbcSmokeTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-07-02
 *
 */

namespace Konekt\AppShell\Tests;

use PHPUnit\Framework\TestCase;

class AbcSmokeTest extends TestCase
{
    const MIN_PHP_VERSION = '7.2.0';

    /**
     * Very Basic smoke test case for testing against parse errors, etc
     *
     * @test
     */
    public function smoke()
    {
        $this->assertTrue(true);
    }

    /**
     * Test for minimum PHP version
     *
     * @depends smoke
     * @test
     */
    public function php_version_satisfies_requirements()
    {
        $this->assertFalse(version_compare(PHP_VERSION, self::MIN_PHP_VERSION, '<'),
            'PHP version ' . self::MIN_PHP_VERSION . ' or greater is required but only '
            . PHP_VERSION . ' found.');
    }
}
