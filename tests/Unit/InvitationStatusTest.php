<?php

declare(strict_types=1);

/**
 * Contains the InvitationStatusTest class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-11-23
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Contracts\ThemeColored;
use Konekt\AppShell\Models\InvitationStatus;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\ThemeColor;

class InvitationStatusTest extends TestCase
{
    /** @test */
    public function it_is_a_colored_enum()
    {
        $this->assertInstanceOf(ThemeColored::class, InvitationStatus::ACTIVE());
    }

    /** @test */
    public function active_status_has_success_color()
    {
        $this->assertEquals(ThemeColor::SUCCESS(), InvitationStatus::ACTIVE()->color());
    }

    /** @test */
    public function expired_status_has_warning_color()
    {
        $this->assertEquals(ThemeColor::WARNING(), InvitationStatus::EXPIRED()->color());
    }

    /** @test */
    public function utilized_status_has_info_color()
    {
        $this->assertEquals(ThemeColor::INFO(), InvitationStatus::UTILIZED()->color());
    }

    /** @test */
    public function invalid_status_has_danger_color()
    {
        $this->assertEquals(ThemeColor::DANGER(), InvitationStatus::INVALID()->color());
    }
}
