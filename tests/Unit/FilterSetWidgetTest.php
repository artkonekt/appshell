<?php

declare(strict_types=1);

/**
 * Contains the FilterSetWidgetTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Filters\Filters;
use Konekt\AppShell\Tests\Dummies\SomeFilter;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShellTheme;
use Konekt\AppShell\Widgets\FilterSet;

class FilterSetWidgetTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $widget = new FilterSet(new AppShellTheme(), '', new Filters());

        $this->assertInstanceOf(FilterSet::class, $widget);
    }

    /** @test */
    public function it_can_be_instantiated_with_the_factory_method_without_any_filters()
    {
        $widget = FilterSet::create(new AppShellTheme(), ['route' => '']);

        $this->assertInstanceOf(FilterSet::class, $widget);
    }

    /** @test */
    public function it_renders_a_form_with_the_route_as_action()
    {
        $widget = new FilterSet(new AppShellTheme(), 'appshell.user.index', new Filters());

        $html = $widget->render();
        $this->assertStringContainsString('<form', $html);
        $this->assertStringContainsString('action="' . route('appshell.user.index'), $html);
    }

    /** @test */
    public function an_array_of_filter_objects_can_be_passed_to_the_constructor()
    {
        $widget = new FilterSet(
            new AppShellTheme(),
            'appshell.user.index',
            new Filters(new SomeFilter('beer_type'))
        );

        $this->assertInstanceOf(FilterSet::class, $widget);
        $html = $widget->render();
//        $this->assertStringContainsString('<form', $html);
//        $this->assertStringContainsString('action="' . route('appshell.user.index') , $html);
    }
}
