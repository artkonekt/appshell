<?php

declare(strict_types=1);

/**
 * Contains the WidgetModifiersTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\WidgetModifiers;
use Konekt\AppShell\Widgets\Modifiers\Bool2Text;
use Konekt\AppShell\Widgets\Modifiers\Lowercase;
use Konekt\AppShell\Widgets\Modifiers\Uppercase;

class WidgetModifiersTest extends TestCase
{
    /** @test */
    public function it_creates_the_uppercase_modifier()
    {
        $this->assertInstanceOf(Uppercase::class, WidgetModifiers::make('uppercase'));
    }

    /** @test */
    public function the_uppercase_modifier_converts_passed_value_to_uppercase()
    {
        $modifier = WidgetModifiers::make('uppercase');
        $this->assertEquals('HOT BODIES', $modifier->handle('Hot bodies'));
    }

    /** @test */
    public function it_creates_the_lowercase_modifier()
    {
        $this->assertInstanceOf(Lowercase::class, WidgetModifiers::make('lowercase'));
    }

    /** @test */
    public function the_lowercase_modifier_converts_passed_value_to_lowercase()
    {
        $modifier = WidgetModifiers::make('lowercase');
        $this->assertEquals('hot bodies', $modifier->handle('Hot Bodies'));
    }

    /** @test */
    public function it_creates_the_bool2text_modifier()
    {
        $this->assertInstanceOf(Bool2Text::class, WidgetModifiers::make('bool2text'));
        $this->assertInstanceOf(Bool2Text::class, WidgetModifiers::make('bool2text:active,inactive'));
    }

    /** @test */
    public function bool_to_text_returns_true_and_false_as_default_texts_respectively()
    {
        $boolModifier = WidgetModifiers::make('bool2text');
        $this->assertEquals('true', $boolModifier->handle(true));
        $this->assertEquals('false', $boolModifier->handle(false));
        $this->assertEquals('true', $boolModifier->handle(1));
        $this->assertEquals('false', $boolModifier->handle(0));
        $this->assertEquals('true', $boolModifier->handle('yes'));
        $this->assertEquals('false', $boolModifier->handle(null));
    }

    /** @test */
    public function bool_to_text_texts_can_be_specified()
    {
        $modifier = WidgetModifiers::make('bool2text:yes,no');
        $this->assertEquals('yes', $modifier->handle(true));
        $this->assertEquals('no', $modifier->handle(false));
    }

    /** @test */
    public function bool_to_text_definition_spaces_get_trimmed()
    {
        $modifier = WidgetModifiers::make('bool2text : yes , no');
        $this->assertEquals('yes', $modifier->handle(true));
        $this->assertEquals('no', $modifier->handle(false));
    }

    /** @test */
    public function bool_to_text_handles_only_one_argument_passed()
    {
        $modifier = WidgetModifiers::make('bool2text:yes');
        $this->assertEquals('yes', $modifier->handle(true));
        $this->assertEquals('false', $modifier->handle(false));
    }

    /** @test */
    public function bool_to_text_empty_string_can_be_set()
    {
        $modifier = WidgetModifiers::make('bool2text:yes,');
        $this->assertEquals('yes', $modifier->handle(true));
        $this->assertEquals('', $modifier->handle(false));
    }

    /** @test */
    public function registry_exists_recognizes_the_patterns()
    {
        $this->assertTrue(WidgetModifiers::exists('bool2text:yes,'));
        $this->assertTrue(WidgetModifiers::exists('bool2text'));
        $this->assertTrue(WidgetModifiers::exists('bool2text:'));
        $this->assertTrue(WidgetModifiers::exists('bool2text:ja, nein'));
        $this->assertTrue(WidgetModifiers::exists('uppercase'));
        $this->assertTrue(WidgetModifiers::exists('lowercase'));
        $this->assertFalse(WidgetModifiers::exists('someBullshit'));
    }
}
