<?php

declare(strict_types=1);

/**
 * Contains the DateTimeWidgetTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Carbon\Carbon;
use Konekt\Address\Models\Person;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShell3Theme;
use Konekt\AppShell\Widgets\ShowDate;
use Konekt\AppShell\Widgets\ShowDateTime;
use Konekt\AppShell\Widgets\ShowTime;
use Konekt\Gears\Facades\Preferences;

class DateTimeWidgetTest extends TestCase
{
    /** @test */
    public function it_can_render_a_datetime_object()
    {
        $widget = ShowDateTime::create(new AppShell3Theme());
        $output = trim($widget->render(\DateTime::createFromFormat('Y-m-d H:i:s', '2021-04-21 11:27:35')));

        $this->assertEquals('2021-04-21 11:27', $output);
    }

    /** @test */
    public function it_can_render_a_date()
    {
        $widget = ShowDate::create(new AppShell3Theme());
        $output = trim($widget->render(\DateTime::createFromFormat('Y-m-d H:i:s', '2021-04-21 11:27:35')));

        $this->assertEquals('2021-04-21', $output);
    }

    /** @test */
    public function it_can_render_a_time()
    {
        $widget = ShowTime::create(new AppShell3Theme());
        $output = trim($widget->render(\DateTime::createFromFormat('Y-m-d H:i:s', '2021-04-21 11:27:35')));

        $this->assertEquals('11:27', $output);
    }

    /** @test */
    public function it_can_render_a_property_of_the_model()
    {
        $widget = ShowDateTime::create(new AppShell3Theme(), ['text' => '$model.created_at']);
        $now = Carbon::now();
        $person = Person::create(['firstname' => 'Johnny', 'lastname' => 'Macaroni']);
        $output = trim($widget->render($person));

        $this->assertEquals($now->format(Preferences::get('appshell.ui.datetime_format')), $output);
    }

    /** @test */
    public function the_unknown_date_text_is_a_dash_by_default()
    {
        $widget = ShowDateTime::create(new AppShell3Theme());
        $output = trim($widget->render(null));

        $this->assertEquals('-', $output);
    }

    /** @test */
    public function the_unknown_date_text_can_be_specified()
    {
        $widget = ShowDateTime::create(new AppShell3Theme(), ['unknown' => 'never']);
        $output = trim($widget->render(null));

        $this->assertEquals('never', $output);
    }
}
