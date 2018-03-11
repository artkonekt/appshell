<?php
/**
 * Contains the SettingsFacadeTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-11
 *
 */


namespace Konekt\AppShell\Tests\Feature;


use Konekt\AppShell\Tests\TestCase;

class SettingsFacadeTest extends TestCase
{
    /**
     * @test
     */
    public function facade_is_registered()
    {
        $this->assertNull(\Settings::get('non_existent_key'));
    }
}
