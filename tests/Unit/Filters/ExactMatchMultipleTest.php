<?php

declare(strict_types=1);

/**
 * Contains the ExactMatchMultipleTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Tests\Unit\Filters;

use Konekt\AppShell\Filters\Generic\ExactMatchMultiple;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Tests\TestCase;
use Konekt\User\Models\UserType;

class ExactMatchMultipleTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(ExactMatchMultiple::class, new ExactMatchMultiple('hey'));
    }

    /** @test */
    public function id_can_be_assigned()
    {
        $filter = new ExactMatchMultiple('hey');
        $this->assertEquals('hey', $filter->id());
    }

    /** @test */
    public function the_possible_values_field_is_nullable()
    {
        $filter = new ExactMatchMultiple('hey');
        $this->assertNull($filter->possibleValues());
    }

    /** @test */
    public function possible_values_can_be_specified()
    {
        $filter = new ExactMatchMultiple('hey', null, ['boo', 'moo']);
        $this->assertEquals(['boo', 'moo'], $filter->possibleValues());
    }

    /** @test */
    public function the_label_defaults_to_the_id_if_unspecified()
    {
        $filter = new ExactMatchMultiple('status');

        $this->assertEquals('status', $filter->label());
    }

    /** @test */
    public function the_label_can_be_specified()
    {
        $filter = new ExactMatchMultiple('status', 'Project Status');

        $this->assertEquals('Project Status', $filter->label());
    }

    /** @test */
    public function the_placeholder_is_null_by_default()
    {
        $filter = new ExactMatchMultiple('status');

        $this->assertNull($filter->placeholder());
    }

    /** @test */
    public function the_placeholder_can_be_specified()
    {
        $filter = new ExactMatchMultiple('status');
        $filter->setPlaceholder('Select Status');

        $this->assertEquals('Select Status', $filter->placeholder());
    }

    /** @test */
    public function it_allows_multiple_values()
    {
        $this->assertTrue(
            (new ExactMatchMultiple('project_id'))->allowsMultipleValues()
        );
    }

    /** @test */
    public function it_can_be_applied_to_a_query_builder_instance()
    {
        $query = User::query();
        $filter = new ExactMatchMultiple('type');

        $filter->apply($query, [UserType::CLIENT, UserType::API]);

        $whereClause = $query->getQuery()->wheres[0];
        $this->assertEquals('type', $whereClause['column'] );
        $this->assertEquals('In', $whereClause['type'] );
        $this->assertEquals([UserType::CLIENT, UserType::API], $whereClause['values'] );
    }
}
