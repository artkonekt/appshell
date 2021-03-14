<?php

declare(strict_types=1);

/**
 * Contains the WidgetFilterDefinitionTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\WidgetFilters;
use Konekt\AppShell\Widgets\Filters\Bool2Text;
use Konekt\AppShell\Widgets\Filters\Lowercase;
use Konekt\AppShell\Widgets\Filters\Uppercase;

class WidgetFiltersTest extends TestCase
{
    /** @test */
    public function it_creates_the_uppercase_filter()
    {
        $this->assertInstanceOf(Uppercase::class, WidgetFilters::make('uppercase'));
    }

    /** @test */
    public function the_uppercase_filter_converts_passed_value_to_uppercase()
    {
        $filter = WidgetFilters::make('uppercase');
        $this->assertEquals('HOT BODIES', $filter->handle('Hot bodies'));
    }

    /** @test */
    public function it_creates_the_lowercase_filter()
    {
        $this->assertInstanceOf(Lowercase::class, WidgetFilters::make('lowercase'));
    }

    /** @test */
    public function the_lowercase_filter_converts_passed_value_to_lowercase()
    {
        $filter = WidgetFilters::make('lowercase');
        $this->assertEquals('hot bodies', $filter->handle('Hot Bodies'));
    }

    /** @test */
    public function it_creates_the_bool2text_filter()
    {
        $this->assertInstanceOf(Bool2Text::class, WidgetFilters::make('bool2text'));
        $this->assertInstanceOf(Bool2Text::class, WidgetFilters::make('bool2text:active,inactive'));
    }

    /** @test */
    public function bool_to_text_returns_true_and_false_as_default_texts_respectively()
    {
        $filter = WidgetFilters::make('bool2text');
        $this->assertEquals('true', $filter->handle(true));
        $this->assertEquals('false', $filter->handle(false));
        $this->assertEquals('true', $filter->handle(1));
        $this->assertEquals('false', $filter->handle(0));
        $this->assertEquals('true', $filter->handle('yes'));
        $this->assertEquals('false', $filter->handle(null));
    }

    /** @test */
    public function bool_to_text_texts_can_be_specified()
    {
        $filter = WidgetFilters::make('bool2text:yes,no');
        $this->assertEquals('yes', $filter->handle(true));
        $this->assertEquals('no', $filter->handle(false));
    }

    /** @test */
    public function bool_to_text_definition_spaces_get_trimmed()
    {
        $filter = WidgetFilters::make('bool2text : yes , no');
        $this->assertEquals('yes', $filter->handle(true));
        $this->assertEquals('no', $filter->handle(false));
    }

    /** @test */
    public function bool_to_text_handles_only_one_argument_passed()
    {
        $filter = WidgetFilters::make('bool2text:yes');
        $this->assertEquals('yes', $filter->handle(true));
        $this->assertEquals('false', $filter->handle(false));
    }

    /** @test */
    public function bool_to_text_empty_string_can_be_set()
    {
        $filter = WidgetFilters::make('bool2text:yes,');
        $this->assertEquals('yes', $filter->handle(true));
        $this->assertEquals('', $filter->handle(false));
    }

    /** @test */
    public function registry_exists_recognizes_the_patterns()
    {
        $this->assertTrue(WidgetFilters::exists('bool2text:yes,'));
        $this->assertTrue(WidgetFilters::exists('bool2text'));
        $this->assertTrue(WidgetFilters::exists('bool2text:'));
        $this->assertTrue(WidgetFilters::exists('bool2text:ja, nein'));
        $this->assertTrue(WidgetFilters::exists('uppercase'));
        $this->assertTrue(WidgetFilters::exists('lowercase'));
        $this->assertFalse(WidgetFilters::exists('someBullshit'));
    }
}
