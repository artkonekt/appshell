<?php
/**
 * Contains the SettingsBackendFactoryTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-12
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Settings\BackendFactory;
use Konekt\AppShell\Settings\Backends\Database;
use Konekt\AppShell\Tests\Unit\Backend\AnotherSettingsBackend;
use TypeError;

class SettingsBackendFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_an_instance_of_the_built_in_drivers_based_on_short_string()
    {
        $backend = BackendFactory::create('database');

        $this->assertInstanceOf(Database::class, $backend);
    }

    /**
     * @test
     */
    public function it_creates_an_instance_of_the_built_in_drivers_based_on_fqcn()
    {
        $backend = BackendFactory::create(AnotherSettingsBackend::class);

        $this->assertInstanceOf(AnotherSettingsBackend::class, $backend);
    }

    /**
     * @test
     */
    public function it_throws_an_invalid_argument_exception_if_the_passed_short_string_does_not_exists()
    {
        $this->expectException(\InvalidArgumentException::class);

        BackendFactory::create('bitcoin');
    }

    /**
     * @test
     */
    public function it_throws_an_invalid_argument_exception_if_the_passed_class_does_not_exists()
    {
        $this->expectException(\InvalidArgumentException::class);

        BackendFactory::create('\\Nonexsisting\\Dumb\\Class');
    }

    /**
     * @test
     */
    public function it_throws_a_type_error_if_passing_a_non_settings_backend_class()
    {
        $this->expectException(TypeError::class);

        BackendFactory::create(self::class);
    }
}