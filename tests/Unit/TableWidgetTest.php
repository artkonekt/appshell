<?php

declare(strict_types=1);

/**
 * Contains the TableWidgetTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShellTheme;
use Konekt\AppShell\Widgets\Table;

class TableWidgetTest extends TestCase
{
    /** @test */
    public function it_can_render_a_basic_table()
    {
        $table = new Table(new AppShellTheme());
        $html = $table->render();

        $this->assertIsString($html);
        $this->assertStringContainsString('<table', $html);
    }

    /** @test */
    public function columns_can_be_defined_for_the_table()
    {
        $table = new Table(new AppShellTheme(), ['id', 'name']);
        $html = $table->render();

        $this->assertStringContainsString('<th >id', $html);
        $this->assertStringContainsString('<th >name', $html);
    }

    /** @test */
    public function id_and_column_can_be_defined_on_columns()
    {
        $table = new Table(new AppShellTheme(), ['id' => ['title' => '#'], 'name' => ['title' => 'Name']]);
        $html = $table->render();

        $this->assertStringContainsString('<th >#', $html);
        $this->assertStringContainsString('<th >Name', $html);
    }

    /** @test */
    public function data_can_be_passed_to_the_table()
    {
        $table = new Table(new AppShellTheme(), ['id', 'name']);
        $html = $table->render(collect([
            ['id' => 1, 'name' => 'Giovanni Gatto'],
            ['id' => 2, 'name' => 'Mr. Fritz Teufel'],
        ]));

        $this->assertStringContainsString('<td>1', $html);
        $this->assertStringContainsString('<td>Giovanni Gatto', $html);
        $this->assertStringContainsString('<td>2', $html);
        $this->assertStringContainsString('<td>Mr. Fritz Teufel', $html);
    }

    /** @test */
    public function it_can_render_a_link_widget()
    {
        $table = new Table(new AppShellTheme(), [
            'id',
            'name' => [
                'widget' => [
                    'type' => 'link',
                    'text' => '$model.name',
                    'url' => '$model.github',
                ],
            ]
        ]);
        $html = $table->render(collect([
            ['id' => 1, 'name' => 'Giovanni Gatto', 'github' => 'https://github.com/giovanni-gatto'],
            ['id' => 2, 'name' => 'Mr. Fritz Teufel', 'github' => 'https://github.com/fritz-teufel'],
        ]));

        $this->assertStringContainsString('<td><a href="https://github.com/giovanni-gatto"', $html);
        $this->assertStringContainsString('>Giovanni Gatto</a>', $html);
        $this->assertStringContainsString('<td><a href="https://github.com/fritz-teufel"', $html);
        $this->assertStringContainsString('Mr. Fritz Teufel</a>', $html);
    }
}
