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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Konekt\AppShell\Tests\Dummies\BirdCage;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShellTheme;
use Konekt\AppShell\Widgets\Table;

class TableWidgetTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Route::get('/table-test-user/{user}', ['as' => 'test.table-user.show']);
    }

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

    /** @test */
    public function it_can_render_an_avatar_widget()
    {
        $table = new Table(new AppShellTheme(), [
            'id',
            'name' => [
                'widget' => [
                    'type' => 'avatar',
                ],
            ]
        ]);
        $user1 = new \stdClass();
        $user1->id = 1;
        $user1->email = 'x@y.com';
        $md5_1 = md5($user1->email);

        $user2 = new \stdClass();
        $user2->id = 2;
        $user2->email = 'xyz@xyz.com';
        $md5_2 = md5($user2->email);

        $html = $table->render(collect([$user1, $user2]));

        $this->assertStringContainsString('<td><img src="', $html);
        $this->assertStringContainsString($md5_1, $html);
        $this->assertStringContainsString($md5_2, $html);
    }

    /** @test */
    public function it_can_render_an_avatar_widget_with_link()
    {
        $table = new Table(new AppShellTheme(), [
            'id',
            'user' => [
                'width' => '66px',
                'widget' => [
                    'type' => 'avatar',
                    'model' => '$model.user',
                    'tooltip' => '$model.user.email',
                    'size' => 42,
                    'url' => [
                        'route' => 'test.table-user.show',
                        'parameters' => ['$model.user.id'],
                    ],
                ],
            ],
        ]);
        $user1 = new \stdClass();
        $user1->id = 977;
        $user1->email = 'x@y.com';
        $task1 = new \stdClass();
        $task1->id = 5;
        $task1->user = $user1;

        $user2 = new \stdClass();
        $user2->id = 603;
        $user2->email = 'xyz@xyz.com';
        $task2 = new \stdClass();
        $task2->id = 6;
        $task2->user = $user2;

        $html = $table->render(collect([$task1, $task2]));

        $this->assertStringContainsString('<a href="http://localhost/table-test-user/977', $html);
        $this->assertStringContainsString('<a href="http://localhost/table-test-user/603', $html);
    }

    /** @test */
    public function it_can_render_a_raw_html_widget()
    {
        $table = new Table(new AppShellTheme(), [
            'name' => [
                'widget' => [
                    'type' => 'raw_html',
                    'html' => '<div id="user_$model.id"><a href="$model.github">$model.name</a></div>',
                ],
            ]
        ]);
        $html = $table->render(collect([
            ['id' => 1, 'name' => 'Giovanni Gatto', 'github' => 'https://github.com/giovanni-gatto'],
            ['id' => 2, 'name' => 'Mr. Fritz Teufel', 'github' => 'https://github.com/fritz-teufel'],
        ]));

        $this->assertStringContainsString('<td><div id="user_1"><a href="https://github.com/giovanni-gatto">Giovanni Gatto</a></div>', $html);
        $this->assertStringContainsString('<td><div id="user_2"><a href="https://github.com/fritz-teufel">Mr. Fritz Teufel</a></div>', $html);
    }

    /** @test */
    public function it_can_render_the_columns_subfield_as_a_text()
    {
        $table = new Table(new AppShellTheme(), [
            'id',
            'parrot' => [
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.parrot.name',
                ]
            ],
            'link' => [
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.parrot.link',
                ]
            ],
        ]);
        $cages = [new BirdCage('Gyurri', 'george')];

        $this->assertStringContainsString('<td>2021', $table->render($cages));
        $this->assertStringContainsString('<td>Gyurri', $table->render($cages));
        $this->assertStringContainsString('<td>george', $table->render($cages));
    }

    /** @test */
    public function columns_can_be_hidden()
    {
        config(['hide_the_col' => true]);

        $table = new Table(new AppShellTheme(), [
            'id',
            'parrot' => [
                'hideIf' => fn () => (bool) config('hide_the_col'),
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.parrot.name',
                ]
            ],
            'link' => [
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.parrot.link',
                ]
            ],
        ]);
        $cages = [new BirdCage('Gyurri', 'george')];

        $this->assertStringNotContainsString('<th >parrot', $table->render($cages));
        $this->assertStringNotContainsString('<td>Gyurri', $table->render($cages));
    }

    /** @test */
    public function it_can_render_a_footer()
    {
        $table = new Table(new AppShellTheme(), ['id', 'name'], ['footer' => [true, true]]);
        $html = $table->render();

        $this->assertStringContainsString('<tfoot>', $html);
        $this->assertStringContainsString('<td></td>', $html);
        $this->assertStringContainsString('</tfoot>', $html);
    }

    /** @test */
    public function it_can_render_text_into_footer_columns()
    {
        $table = new Table(new AppShellTheme(), ['id', 'name'], ['footer' => ['Total', 0]]);
        $html = $table->render();

        $this->assertStringContainsString('<tfoot>', $html);
        $this->assertStringContainsString('<td>Total</td>', $html);
        $this->assertStringContainsString('<td>0</td>', $html);
        $this->assertStringContainsString('</tfoot>', $html);
    }

    /** @test */
    public function it_can_render_colspan_into_footer_columns()
    {
        $table = new Table(new AppShellTheme(), ['id', 'name'], ['footer' =>
            [
                ['text' => 'This is a final text', 'colspan' => 2],
            ],
        ]);
        $html = $table->render();

        $this->assertStringContainsString('<tfoot>', $html);
        $this->assertStringContainsString('<td colspan="2">This is a final text</td>', $html);
        $this->assertStringContainsString('</tfoot>', $html);
    }

    /** @test */
    public function it_can_render_a_sum_of_a_column_in_the_footer_without_widget()
    {
        $table = new Table(new AppShellTheme(), ['price'], ['footer' =>
            [
                ['text' => '$model.sum(price)'],
            ],
        ]);

        $html = $table->render([['price' => 320], ['price' => 210], ['price' => 7]]);

        $this->assertStringContainsString('<td>537</td>', $html);
    }

    /** @test */
    public function it_can_render_a_sum_of_a_column_in_the_footer_using_a_widget()
    {
        $table = new Table(new AppShellTheme(), ['price'], ['footer' =>
            [
                ['text' => '$model.sum(price)', 'widget' => ['type' => 'text']],
            ],
        ]);

        $html = $table->render([['price' => 55], ['price' => 21], ['price' => 3]]);

        $this->assertStringContainsString('<td>79</td>', $html);
    }

    /** @test */
    public function it_can_render_multiple_footer_columns()
    {
        $table = new Table(new AppShellTheme(), ['id', 'name'], ['footer' =>
            [
                ['text' => 'COL1'],
                ['text' => 'COL2'],
            ],
        ]);
        $html = $table->render();

        $this->assertStringContainsString('<tfoot>', $html);
        $this->assertStringContainsString('<td>COL1</td>', $html);
        $this->assertStringContainsString('<td>COL2</td>', $html);
        $this->assertStringContainsString('</tfoot>', $html);
    }

    /** @test */
    public function it_can_render_row_attributes()
    {
        $table = new Table(new AppShellTheme(), ['id', 'name'], ['rowAttributes' => ['x-show' => '!hidden']]);
        $html = $table->render([['id' => 1, 'name' => 'Joe']]);

        $this->assertStringContainsString('<tr x-show="!hidden"', $html);
    }

    /** @test */
    public function it_can_render_conditional_row_attributes()
    {
        $table = new Table(
            new AppShellTheme(),
            ['id', 'name'],
            ['rowAttributes' => ['x-show' => ['value' => '!hidden', 'onlyIf' => fn ($model) => 'Jeff' === $model['name']]]]
        );

        $html = $table->render([
            ['id' => 1, 'name' => 'Joe'],
            ['id' => 2, 'name' => 'Jeff'],
            ['id' => 3, 'name' => 'Jane'],
        ]);

        $this->assertEquals(1, Str::substrCount($html, '<tr x-show="!hidden"'));
    }
}
