<?php

declare(strict_types=1);

/**
 * Contains the FiltersTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Tests\Unit\Filters;

use Konekt\AppShell\Contracts\Filter;
use Konekt\AppShell\Exceptions\NonExistentFilterException;
use Konekt\AppShell\Filters\ActiveFilter;
use Konekt\AppShell\Filters\Filters;
use Konekt\AppShell\Filters\Generic\ExactMatch;
use Konekt\AppShell\Filters\Generic\ExactMatchMultiple;
use Konekt\AppShell\Filters\Generic\PartialMatch;
use Konekt\AppShell\Tests\Dummies\SomeFilter;
use Konekt\AppShell\Tests\TestCase;
use stdClass;

class FiltersTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Filters::class, new Filters());
    }

    /** @test */
    public function it_can_be_counted()
    {
        $filters = new Filters(new SomeFilter());

        $this->assertCount(1, $filters);
    }

    /** @test */
    public function it_can_be_counted_with_khm_dotdotdot_the_count_function()
    {
        $filters = new Filters(new SomeFilter());

        $this->assertEquals(1, count($filters));
    }

    /** @test */
    public function it_can_be_iterated_through()
    {
        $filters = new Filters(
            $name = new SomeFilter('name'),
            $active = new SomeFilter('is_active')
        );

        $result = [];
        foreach ($filters as $id => $filter) {
            $result[$id] = $filter;
        }

        $this->assertArrayHasKey('name', $result);
        $this->assertSame($name, $result['name']);
        $this->assertArrayHasKey('is_active', $result);
        $this->assertSame($active, $result['is_active']);
    }

    /** @test */
    public function filters_can_be_accessed_by_id()
    {
        $filters = new Filters($orbit = new SomeFilter('orbit'));

        $this->assertSame($orbit, $filters->get('orbit'));
    }

    /** @test */
    public function filters_can_be_activated()
    {
        $filters = new Filters();
        $filters
            ->addFilter(new SomeFilter('status'))
            ->addFilter(new SomeFilter('assignee'))
            ->addFilter(new SomeFilter('project_id'));

        $filters
            ->activate('status', ['open', 'pending'])
            ->activate('assignee', 'Giovanni Gatto');

        $this->assertCount(2, $filters->activeOnes());
    }

    /** @test */
    public function activating_an_inactive_filter_throws_an_exception()
    {
        $this->expectException(NonExistentFilterException::class);

        (new Filters(new SomeFilter()))->activate('I do not exist', 'yeah');
    }

    /** @test */
    public function filters_can_be_deactivated()
    {
        $filters = new Filters();
        $filters
            ->addFilter(new SomeFilter('type'))
            ->addFilter(new SomeFilter('project_id'));

        $filters->activate('type', ['bug']);

        $this->assertCount(1, $filters->activeOnes());

        $filters->deactivate('type');

        $this->assertCount(0, $filters->activeOnes());
    }

    /** @test */
    public function active_filter_terms_can_be_retrieved()
    {
        $filters = new Filters(new SomeFilter('year'), new SomeFilter('project'));
        $filters
            ->activate('year', 2021)
            ->activate('project', 'Martian Settlement');

        $year = $filters->activeOne('year');
        $this->assertInstanceOf(ActiveFilter::class, $year);
        $this->assertEquals(2021, $year->criteria());

        $project = $filters->activeOne('project');
        $this->assertInstanceOf(ActiveFilter::class, $project);
        $this->assertEquals('Martian Settlement', $project->criteria());
    }

    /** @test */
    public function the_factory_method_accepts_an_array_of_filter_object_instances()
    {
        $filters = Filters::make([
            $asd = new SomeFilter('asd'),
            $qwe = new SomeFilter('qwe'),
        ]);

        $this->assertInstanceOf(Filters::class, $filters);
        $this->assertCount(2, $filters);

        $this->assertSame($asd, $filters->get('asd'));
        $this->assertSame($qwe, $filters->get('qwe'));
    }

    /** @test */
    public function the_factory_method_accepts_a_plain_array_of_filter_id_strings()
    {
        $filters = Filters::make(['type', 'status']);

        $this->assertInstanceOf(Filters::class, $filters);
        $this->assertCount(2, $filters);

        $this->assertInstanceOf(Filter::class, $filters->get('type'));
        $this->assertInstanceOf(Filter::class, $filters->get('status'));
    }

    /** @test */
    public function the_factory_returns_exact_match_if_unspecified()
    {
        $filters = Filters::make(['state']);

        $this->assertInstanceOf(ExactMatch::class, $filters->get('state'));
    }

    /** @test */
    public function the_factory_method_accepts_a_list_of_filter_arrays_containing_filter_id_key_values()
    {
        $filters = Filters::make([
            ['id' => 'type'],
            ['id' => 'status'],
        ]);

        $this->assertInstanceOf(Filters::class, $filters);
        $this->assertCount(2, $filters);

        $this->assertInstanceOf(Filter::class, $filters->get('type'));
        $this->assertInstanceOf(Filter::class, $filters->get('status'));
    }

    /** @test */
    public function the_factory_method_accepts_a_hashmap_of_filter_arrays()
    {
        $filters = Filters::make([
            'type' => [],
            'status' => [],
        ]);

        $this->assertInstanceOf(Filters::class, $filters);
        $this->assertCount(2, $filters);

        $this->assertInstanceOf(Filter::class, $filters->get('type'));
        $this->assertInstanceOf(Filter::class, $filters->get('status'));
    }

    /** @test */
    public function the_filter_type_classname_can_be_passed_to_the_factory_method()
    {
        $filters = Filters::make([
            [
                'id' => 'roles',
                'type' => ExactMatchMultiple::class
            ],
            [
                'id' => 'status',
                'type' => ExactMatch::class
            ],
            'subject' => [
                'type' => PartialMatch::class
            ],
        ]);

        $this->assertInstanceOf(ExactMatchMultiple::class, $filters->get('roles'));
        $this->assertInstanceOf(ExactMatch::class, $filters->get('status'));
        $this->assertInstanceOf(PartialMatch::class, $filters->get('subject'));
    }
}
